<?php

	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

	session_start();
	if($_SESSION['logado'] !== 'S') {
		session_destroy();
		http_response_code(403); // Acesso Negado
		exit;
	}

	$dados = json_decode(file_get_contents('dados.json'), true);
 
	if($_SERVER['REQUEST_METHOD'] === 'GET') {
		echo json_encode($dados);
		exit;
	} else if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$entrada = json_decode( file_get_contents('php://input'), true );
		$index = projetoExiste($entrada['nomeProjeto'], $dados);

		if($index === -1) { // Esse é um novo projeto
			$novo = ['nomeProjeto' => $entrada['nomeProjeto'], 'tarefas' => []];

			unset($entrada['nomeProjeto']);
			$entrada['status'] = 'afazer';
			array_push($novo['tarefas'], $entrada);

			array_push($dados, $novo);

		} else { // Esse projeto já existe
			// Se o nome da tarefa já está sendo usado
			if(tarefaExiste($entrada['titulo'], $dados[$index]['tarefas']) !== -1) {
				http_response_code(400); // Bad Request
				exit;
			}
			unset($entrada['nomeProjeto']);
			$entrada['status'] = 'afazer';
			array_push($dados[$index]['tarefas'], $entrada);
		}

		file_put_contents('dados.json', json_encode($dados));
	} else if($_SERVER['REQUEST_METHOD'] === 'PUT') {
		$entrada = json_decode( file_get_contents('php://input'), true );
		$index = projetoExiste($entrada['nomeProjeto'], $dados);

		if($index === -1) {
			http_response_code(404);
			exit;
		} else {
			$iTarefa = tarefaExiste($entrada['oldTitulo'], $dados[$index]['tarefas']);
			if($iTarefa === -1) {
				http_response_code(404);
				exit;
			}
			unset($entrada['nomeProjeto']);
			unset($entrada['oldTitulo']);
			unset($dados[$index]['tarefas'][$iTarefa]);
			array_push($dados[$index]['tarefas'], $entrada);
			$dados[$index]['tarefas'] = array_values($dados[$index]['tarefas']);

			file_put_contents('dados.json', json_encode($dados));
		}
	} else if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
		$index = projetoExiste($_GET['nomeProjeto'], $dados);

		if($index === -1) {
			http_response_code(404);
			exit;
		} else {
			$iTarefa = tarefaExiste($_GET['titulo'], $dados[$index]['tarefas']);
			if($iTarefa === -1) {
				http_response_code(404);
				exit;
			}

			unset($dados[$index]['tarefas'][$iTarefa]);
			$dados[$index]['tarefas'] = array_values($dados[$index]['tarefas']);
			// Se esse projeto não possue mais tarefas
			if(count($dados[$index]['tarefas']) <= 0) {
				unset($dados[$index]); // Delete ele
			}

			file_put_contents('dados.json', json_encode($dados));
		}
	}

	function tarefaExiste($nome, $tarefas) {
		for($i = 0; $i < count($tarefas); $i++) {
			if($tarefas[$i]['titulo'] === $nome) {
				return $i;
			}
		}
		return -1;
	}

	function projetoExiste($nome, $dados) {
		for($i = 0; $i < count($dados); $i++) {
			if($dados[$i]['nomeProjeto'] === $nome) {
				return $i;
			}
		}
		return -1;
	}

?>