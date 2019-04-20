<?php
$head_login = ' active';
$container_login = ' show active';
$head_cadastro = '';
$container_cadastro = '';

$user_invalido = '';
$senha_invalida = '';
$user_or_pass_error = 'none;';
$pass_not_equal = 'none;';

$user_invalido_cadastro = '';
$senha_invalida_cadastro = '';
$user_or_pass_error = 'none;';
$pass_not_equal = 'none;';
$user_existe = 'none;';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(array_key_exists('cadastro', $_GET)) {

		$head_login = '';
		$container_login = '';
		$head_cadastro = ' active';
		$container_cadastro = ' show active';

		$r = cadastrar_usuario();
		switch($r) {
			case 1: // login inválido
				$user_invalido_cadastro = ' is-invalid';
			break;
			case 2: // senha inválida
				$senha_invalida_cadastro = ' is-invalid';
			break;
			case 3: // a senhas não conferem
				$pass_not_equal = 'block;';
			break;
			case 4: // usuário já existe
				$user_existe = 'block;';
			break;
			default:
				session_start();
				$_SESSION['logado'] = 'S';
				header('location: index.php');
			break;
	
		}

	} else {
		$r = checarLogin();
		switch($r) {
			case 1: // login inválido
				$user_invalido = ' is-invalid';
			break;
			case 2: // senha inválida
				$senha_invalida = ' is-invalid';
			break;
			case 3: // user ou senha não existe no banco
				$user_or_pass_error = 'block;';
			break;
			default:
				session_start();
				$_SESSION['logado'] = 'S';
				header('location: index.php');
				exit;
			break;

		}
	}
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
function cadastrar_usuario() {
	if(!isset($_POST['nome']) || $_POST['nome'] === '') return 1;
	if(!isset($_POST['senha']) || $_POST['senha'] === '') return 2;
	if($_POST['senha'] !== $_POST['senhaConfirm']) return 3;

	$lista = lerListaUsers();

	foreach($lista as $user) {
		if($user['nome'] === $_POST['nome'])
			return 4;
	}

	$new = ['nome' => $_POST['nome'], 'senha' => $_POST['senha']];

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
function checarLogin() {
	/*
		Se não foram fornecidos usuário ou senha ou se algum deles estiver vazio ''
		retorne falso
	*/
	if(!isset($_POST['nameLogin']) || $_POST['nameLogin'] === '') return 1;
	if(!isset($_POST['senhaLogin']) || $_POST['senhaLogin'] === '') return 2;

	$nome = $_POST['nameLogin'];
	$senha = $_POST['senhaLogin'];
	$lista = lerListaUsers();

	foreach($lista as $user) {
		if($user['nome'] === $nome && $user['senha'] === $senha)
			return 0;
	}
	return 3;
}

?>