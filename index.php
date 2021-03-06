<?php
	session_start();
	if($_SESSION['logado'] !== 'S') {
		session_destroy();
		header('location: login.php');
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
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbar">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#criarModal">Nova tarefa</button>
				</li>
				<li class="nav-item" style="margin-left: 5px">
					<a href="logout.php">
						<button type="button" class="btn btn-outline-secondary">Logout</button>
					</a>
				</li>
			</ul>
		</div>
    </nav>

    <main role="main" class="container-fluid">

      <div class="row">
      	<div id="root" class="col-12 col-md-10 offset-md-1">
      		<!-- Renderizado via Javascript -->
        </div>
      </div>

	</main>
	
	<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="editNomeProjeto"></h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form id="formEditar">
							<div class="form-group row">
								<label for="editTituloTarefa" class="col-sm-4 col-form-label">Título da Tarefa:</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" id="editTituloTarefa" />
								</div>
							</div>
							<div class="form-group row">
								<label for="editResponsavel" class="col-sm-4 col-form-label">Responsável:</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" id="editResponsavel" />
								</div>
							</div>
							<div class="form-group row">
								<label for="editData" class="col-sm-4 col-form-label">Data limite:</label>
								<div class="col-sm-8">
								  <input type="date" class="form-control" id="editData" />
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<textarea class="form-control" id="editDesc" placeholder="Descrição da tarefa"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="afazer">
									<label class="custom-control-label" for="customRadioInline1">A Fazer</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="fazendo">
									<label class="custom-control-label" for="customRadioInline2">Fazendo</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="customRadioInline3" name="status" class="custom-control-input" value="feito">
									<label class="custom-control-label" for="customRadioInline3">Feito</label>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger mr-auto" onclick="apagarTarefa()">Deletar</button>
					<span style="display: none; margin-right: auto;" id="mensagemLoadingedit">Salvando...</span>
					<button type="button" class="btn btn-primary" onclick="editarTarefa()">Salvar</button>
				</div>
			  </div>
			</div>
		</div>

	<div class="modal fade" id="criarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title">Inserir nova tarefa</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form>
						<div class="form-group row">
						  <label for="insertNomeProjeto" class="col-sm-5 col-form-label col-form-label-lg">Nome Projeto:</label>
						  <div class="col-sm-7">
							<input type="text" class="form-control form-control-lg" id="insertNomeProjeto" />
						  </div>
						</div>
						<div class="form-group row">
							<label for="insertTituloTarefa" class="col-sm-4 col-form-label">Título da Tarefa:</label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="insertTituloTarefa" />
							</div>
						</div>
						<div class="form-group row">
							<label for="insertResponsavel" class="col-sm-4 col-form-label">Responsável:</label>
							<div class="col-sm-8">
							  <input type="text" class="form-control" id="insertResponsavel" />
							</div>
						</div>
						<div class="form-group row">
							<label for="insertData" class="col-sm-4 col-form-label">Data limite:</label>
							<div class="col-sm-8">
							  <input type="date" class="form-control" id="insertData" />
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12">
								<textarea class="form-control" id="insertDesc" placeholder="Descrição da tarefa"></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<span style="display: none; margin-right: auto;" id="mensagemErroInsert">Falha ao inserir, verifique os dados</span>
				<span style="display: none; margin-right: auto;" id="mensagemLoadingInsert">Inserindo...</span>
				<button type="button" class="btn btn-primary" onclick="inserirTarefa()">Inserir</button>
			</div>
		  </div>
		</div>
	</div>

<script type="text/javascript" src="renderDOM.js"></script>
<script type="text/javascript" src="main.js"></script>
</body>
</html>