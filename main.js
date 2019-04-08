var serverUrl = 'https://todolistweb1.herokuapp.com/api.php';

consultarServidor();

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
	renderizar(dados);
}

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
		let r = await fetch(serverUrl, { method: "POST",	body: JSON.stringify(dados) });
	} catch(err) {
		/* empty */
	}

	$('#mensagemLoadingInsert').css('display', 'none');
	$('#criarModal').modal('hide')

	$('#insertNomeProjeto').val(''),
	$('#insertData').val(''),
	$('#insertTituloTarefa').val(''),
	$('#insertDesc').val(''),
	$('#insertResponsavel').val('')

	consultarServidor();
}

function renderizarLoading() {
	$('#root').empty();
	let loadingText = document.createElement("h1");
	loadingText.innerText = 'Loading...';
	$('#root')[0].appendChild(loadingText);
}

function renderizarErro(mensagem) {
	$('#root').empty();
	let erroTitle = document.createElement("h4");
	let erroText = document.createElement("p");
	erroTitle.innerText = 'Erro';
	erroText.innerText = mensagem;
	$('#root')[0].appendChild(erroTitle);
	$('#root')[0].appendChild(erroText);
}

function renderizar(dados) {
	$('#root').empty();
	for(let i = 0; i < dados.length; i++)
	$('#root')[0].appendChild(gerarProjetoDOM(dados[i]));
}

function gerarProjetoDOM(infos) {
	let containerProjeto = document.createElement("div");
	containerProjeto.className = 'containerProjeto';

	let tituloProjeto = document.createElement("h1");
	tituloProjeto.className = 'nomeProjeto';
	tituloProjeto.innerText = infos.nomeProjeto;
	containerProjeto.appendChild(tituloProjeto);

	let containerTarefas = document.createElement("div");
	containerTarefas.className = 'containerTarefas';
	for(let i = 0; i < infos.tarefas.length; i++) {
		containerTarefas.appendChild(gerarTarefaDOM(infos.tarefas[i]));
	}
	containerProjeto.appendChild(containerTarefas);

	return containerProjeto;
}

function gerarTarefaDOM(infos) {
	let containerTarefa = document.createElement("div");
	let classeCor = '';
	if(infos.status === 'afazer') classeCor = 'bg-danger';
	else if(infos.status === 'feito') classeCor = 'bg-secondary';
	else classeCor = 'bg-info';
	containerTarefa.className = 'card text-white '+classeCor+' mb-3 containerTarefa';

	let containerCardHead = document.createElement("div");
	containerCardHead.className = 'card-header';
	containerCardHead.innerText = infos.dataLimite;
	containerTarefa.appendChild(containerCardHead);

	let containerCardBody = document.createElement("div");
	containerCardBody.className = 'card-body';

	let cardTitle = document.createElement("h5");
	cardTitle.className = 'card-title';
	cardTitle.innerText = infos.titulo;
	containerCardBody.appendChild(cardTitle);

	let cardDescript = document.createElement("p");
	cardDescript.className = 'card-text';
	cardDescript.innerText = infos.descricao;
	containerCardBody.appendChild(cardDescript);

	let containerNomeRes = document.createElement("div");
	containerNomeRes.className = 'containerNomeResponsavel';
	let nomeRes = document.createElement("b");
	nomeRes.className = 'card-text';
	nomeRes.innerText = infos.responsavel;
	containerNomeRes.appendChild(nomeRes);
	containerCardBody.appendChild(containerNomeRes);

	containerTarefa.appendChild(containerCardBody);

	return containerTarefa;
}