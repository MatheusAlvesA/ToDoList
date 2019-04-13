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

?>

<!DOCTYPE html>
<html>
<head>
	<title>ToDo List</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="main.css">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <b class="navbar-brand">Todo List</b>
    </nav>

    <main role="main" class="container-fluid">

    <div class="row">
      	<div class="col-12 col-md-4 offset-md-4" id="containerGeralLogin">

		<div class="card" id="cardLogin">
			<div class="card-header">

				<ul class="nav nav-tabs card-header-tabs">
				<li class="nav-item">
					<a class="nav-link<?php echo $head_login;?>" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link<?php echo $head_cadastro;?>" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="false">Cadastro</a>
				</li>
				</ul>

			</div>

			<div class="card-body">

				<div class="tab-content">
					<div class="tab-pane fade<?php echo $container_login;?>" id="login" role="tabpanel" aria-labelledby="login-tab">
						<form action="/login.php" method="post">
							<div class="form-group">
								<label for="nameLogin">Nome de usuário</label>
								<input type="text"
										class="form-control<?php echo $user_invalido;?>"
										id="nameLogin"
										name="nameLogin"
										placeholder="Insira o Nome de usuário"
								/>
								<div class="invalid-feedback">
									Nome de usuário inválido
								</div>
							</div>
							<div class="form-group">
								<label for="senhaLogin">Senha</label>
								<input type="password"
										class="form-control<?php echo $senha_invalida;?>"
										id="senhaLogin"
										name="senhaLogin"
										placeholder="Insira a Senha"
								/>
								<div class="invalid-feedback">
									Senha inválida
								</div>
							</div>
							<p style="color: red; display: <?php echo $user_or_pass_error;?>">Usuário ou senha incorretos!</p>
							<button type="submit" class="btn btn-primary">Logar</button>
						</form>
					</div>
					<div class="tab-pane fade<?php echo $container_cadastro;?>" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
						<form action="/login.php?cadastro" method="post">
							<div class="form-group">
								<label for="nome">Nome de usuário</label>
								<input type="text"
										class="form-control<?php echo $user_invalido_cadastro;?>"
										id="nome"
										name="nome"
										placeholder="Insira o Nome de usuário"
								/>
								<div class="invalid-feedback">
									Nome de usuário inválido
								</div>
							</div>
							<div class="form-group">
								<label for="senha">Senha</label>
								<input type="password"
										class="form-control<?php echo $senha_invalida_cadastro;?>"
										id="senha"
										name="senha"
										placeholder="Insira a Senha"
								/>
								<div class="invalid-feedback">
									Senha inválida
								</div>
							</div>
							<div class="form-group">
								<label for="senhaConfirm">Confirme a senha</label>
								<input type="password"
										class="form-control"
										id="senhaConfirm"
										name="senhaConfirm"
										placeholder="Repita a senha"
								/>
							</div>
							<p style="color: red; display: <?php echo $pass_not_equal;?>">As senhas não conferem!</p>
							<p style="color: red; display: <?php echo $user_existe;?>">Este nome de usuário já está sendo usado!</p>
							<button type="submit" class="btn btn-primary">Cadastrar-se</button>
						</form>
					</div>
				</div>

			</div>
		</div>

    </div>

	</main>

</body>
</html>

<?php
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