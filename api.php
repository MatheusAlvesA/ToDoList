<?php

	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

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
			unset($entrada['nomeProjeto']);
			$entrada['status'] = 'afazer';
			array_push($dados[$index]['tarefas'], $entrada);
		}

		file_put_contents('dados.json', json_encode($dados));
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