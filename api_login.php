<?php
header('content-type: application/json');
header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(array_key_exists('cadastro', $_GET)) {
		$dados = null;
		try {
			$dados = json_decode( file_get_contents('php://input'), true );
		} catch(Exception $erro) {
			http_response_code(400); // Bad Request
			echo json_encode([
				'ok' => false,
				'erro' => 'Corpo da requisição inválido'
			]);
			exit;
		}

		$r = cadastrar_usuario($dados);
		switch($r) {
			case 1: // login inválido
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Login inválido'
				]);
				exit;
			break;
			case 2: // senha inválida
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Senha inválida'
				]);
				exit;
			break;
			case 3: // a senhas não conferem
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'As senhas não conferem'
				]);
				exit;
			break;
			case 4: // usuário já existe
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Usuário já existe'
				]);
				exit;
			break;
			default:
				session_start();
				$_SESSION['logado'] = 'S';
				echo json_encode([
					'ok' => true
				]);
				exit;
			break;
	
		}

	} else { // Requisição de login
		$dados = null;
		try {
			$dados = json_decode( file_get_contents('php://input'), true );
		} catch(Exception $erro) {
			http_response_code(400); // Bad Request
			echo json_encode([
				'ok' => false,
				'erro' => 'Corpo da requisição inválido'
			]);
			exit;
		}

		$r = checarLogin($dados);
		switch($r) {
			case 1: // login inválido
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Login inválido'
				]);
				exit;
			break;
			case 2: // senha inválida
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Senha inválida'
				]);
				exit;
			break;
			case 3: // user ou senha não existe no banco
				http_response_code(400); // Bad Request
				echo json_encode([
					'ok' => false,
					'erro' => 'Usuário ou senha não conferem'
				]);
				exit;
			break;
			default:
				session_start();
				$_SESSION['logado'] = 'S';
				echo json_encode([
					'ok' => true
				]);
				exit;
			break;
		}
	}
} else { // Usando um método http que não é POST
	http_response_code(400); // Bad Request
	echo json_encode([
		'ok' => false,
		'erro' => 'Método HTTP inválido'
	]);
	exit;
}

// ZONA DE FUNÇÕES DE LOGIN E CADASTRO

/*
 Esta função cadastra um novo usuário enviado pelo post

 retorna 0 se o usuário foi cadastrado
 retorna 1 se o nome é inválido
 retorna 2 se a senha é inválida
 retorna 3 se a senha a a confirmação da senha não conferem
 retorna 4 se o nome de usuário já está sendo usado
*/
function cadastrar_usuario($dados) {
	if(!isset($dados['nome']) || $dados['nome'] === '') return 1;
	if(!isset($dados['senha']) || $dados['senha'] === '') return 2;
	if($dados['senha'] !== $dados['senhaConfirm']) return 3;

	$lista = lerListaUsers();

	foreach($lista as $user) {
		if($user['nome'] === $dados['nome'])
			return 4;
	}

	$new = ['nome' => $dados['nome'], 'senha' => $dados['senha']];

	array_push($lista, $new);

	gravarUsers($lista);

	return 0;
}

function gravarUsers($lista) {
	return file_put_contents('users.json', json_encode($lista));
}

function lerListaUsers() {
	return json_decode(file_get_contents('users.json'), true);
}

/*
	Esta fução checa se o usuário e senha fornecidos no POST
	são válidos e se existem no banco de dados

	retorna 0 se estiver tudo ok
	retorna 1 se o login é inválido
	retorna 2 se a senha é inválida
	retorna 3 se essa combinação de usuário e senha não existe no banco
*/
function checarLogin($dados) {
	/*
		Se não foram fornecidos usuário ou senha ou se algum deles estiver vazio ''
		retorne erro
	*/
	if(!isset($dados['nome']) || $dados['nome'] === '') return 1;
	if(!isset($dados['senha']) || $dados['senha'] === '') return 2;

	$nome = $dados['nome'];
	$senha = $dados['senha'];
	$lista = lerListaUsers();

	foreach($lista as $user) {
		if($user['nome'] === $nome && $user['senha'] === $senha)
			return 0;
	}
	return 3;
}

?>