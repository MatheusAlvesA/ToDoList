<?php
	session_start();
	if($_SESSION['logado'] === 'S') {
		header('location: index.php');
		exit;
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
					<a class="nav-link active" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#cadastro" role="tab" aria-controls="cadastro" aria-selected="false">Cadastro</a>
				</li>
				</ul>

			</div>

			<div class="card-body">

				<div class="tab-content">
					<div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
						<form id="formLogin">
							<div class="form-group">
								<label for="nameLogin">Nome de usuário</label>
								<input type="text"
										class="form-control"
										id="nameLogin"
										name="nameLogin"
										placeholder="Insira o Nome de usuário"
								/>
							</div>
							<div class="form-group">
								<label for="senhaLogin">Senha</label>
								<input type="password"
										class="form-control"
										id="senhaLogin"
										name="senhaLogin"
										placeholder="Insira a Senha"
								/>
							</div>
							<p  id='mensagemErroLogin' style="color: red; display: none"></p>
							<button type="submit" class="btn btn-primary">Logar</button>
						</form>
					</div>
					<div class="tab-pane fade" id="cadastro" role="tabpanel" aria-labelledby="cadastro-tab">
						<form id="formCadastro">
							<div class="form-group">
								<label for="nome">Nome de usuário</label>
								<input type="text"
										class="form-control"
										id="nome"
										name="nome"
										placeholder="Insira o Nome de usuário"
								/>
							</div>
							<div class="form-group">
								<label for="senha">Senha</label>
								<input type="password"
										class="form-control"
										id="senha"
										name="senha"
										placeholder="Insira a Senha"
								/>
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
							<p id="mensagemErroCadastro" style="color: red; display: none"></p>
							<button type="submit" class="btn btn-primary">Cadastrar-se</button>
						</form>
					</div>
				</div>

			</div>
		</div>

	</div>
	</div>

	</main>

	<script type="text/javascript" src="login.js"></script>
</body>
</html>
