var serverUrl = '/api.php';
var cacheOldTitulo = '';
// Executando primeira consulta ao servidor
consultarServidor();

/*
	Essa função coloca o container principal em estado de loading
	até que o servidor dê retorno com os dados nescessários
*/
async function consultarServidor() {
	renderizarLoading();
	let dados = [];

	try {
		let r = await fetch(serverUrl);
		if(!r.ok) {
			renderizarErro('Falha interna no servidor');
			return;
		}
		dados = await r.json();
	} catch(err) {
		renderizarErro('Falha na conexão com o servidor');
		return;
	}

	dados = ordernarDados(dados);

	renderizar(dados);
}

function ordernarDados(dados) {
	for(let i = 0; i < dados.length; i++) {
		dados[i]['tarefas'].sort((a, b) => {
			let x,y = 0;
			switch(a.status) {
				case 'afazer':
					x = 0;
				break;
				case 'fazendo':
					x = 1;
				break;
				default:
					x = 2;
				break;
			}
			switch(b.status) {
				case 'afazer':
					y = 0;
				break;
				case 'fazendo':
					y = 1;
				break;
				default:
					y = 2;
				break;
			}

			return x-y;
		});
	}
	return dados;
}

/*
	Essa função solicita ao servidor que uma tarefa seja apagada
	e recarrega os dados ao finalizar
*/
async function apagarTarefa() {
	try {
		await fetch(serverUrl+'?nomeProjeto='+$('#editNomeProjeto')[0].innerText+
								'&titulo='+cacheOldTitulo,
		{ method: "DELETE" });
	} catch(err) {
		/* empty */
	}

	$('#mensagemLoadingedit').css('display', 'none');
	$('#editarModal').modal('hide')

	$('#editNomeProjeto')[0].innerText = '';
	$('#editData').val('');
	$('#editTituloTarefa').val('');
	$('#editDesc').val('');
	$('#editResponsavel').val('');

	consultarServidor();
}

/*
	Depois que os novos dados da tarefa tenham sido preenchidos, essa função
	empacota eles em um json e envia ao servidor via requisição HTTP(verbo PUT)
*/
async function editarTarefa() {
	let dados = {
		'nomeProjeto': $('#editNomeProjeto')[0].innerText,
		'dataLimite': $('#editData').val().split('-').reverse().join('/'),
		'titulo': $('#editTituloTarefa').val(),
		'oldTitulo': cacheOldTitulo,
		'descricao': $('#editDesc').val(),
		'responsavel': $('#editResponsavel').val(),
		'status': $('input[name=status]:checked', '#formEditar').val()
	};

	$('#mensagemLoadingedit').css('display', 'inline');

	try {
		await fetch(serverUrl, { method: "PUT", body: JSON.stringify(dados) });
	} catch(err) {
		/* empty */
	}

	$('#mensagemLoadingedit').css('display', 'none');
	$('#editarModal').modal('hide')

	$('#editNomeProjeto')[0].innerText = '',
	$('#editData').val(''),
	$('#editTituloTarefa').val(''),
	$('#editDesc').val(''),
	$('#editResponsavel').val('')

	consultarServidor();
}

/*
	Esta função recebe os dados preenchidos pelo usuário e os envia ao servidor
	empacotados em uma string JSON
*/
async function inserirTarefa() {
	let dados = {
		'nomeProjeto': $('#insertNomeProjeto').val(),
		'dataLimite': $('#insertData').val().split('-').reverse().join('/'),
		'titulo': $('#insertTituloTarefa').val(),
		'descricao': $('#insertDesc').val(),
		'responsavel': $('#insertResponsavel').val()
	};

	$('#mensagemLoadingInsert').css('display', 'inline');

	try {
		let r = await fetch(serverUrl, { method: "POST", body: JSON.stringify(dados) });
		if(!r.ok) {
			await avisarErroAoInserir();
		}
	} catch(err) {
		await avisarErroAoInserir();
	} finally {
		$('#mensagemLoadingInsert').css('display', 'none');
		$('#criarModal').modal('hide');
	
		$('#insertNomeProjeto').val('');
		$('#insertData').val('');
		$('#insertTituloTarefa').val('');
		$('#insertDesc').val('');
		$('#insertResponsavel').val('');
	
		consultarServidor();
	}
}

