function avisarErroAoInserir() {
	$('#mensagemLoadingInsert').css('display', 'none');
	$('#mensagemErroInsert').css('display', 'inline');
	return new Promise((resolve, reject) => {
		setTimeout(() => {
			$('#mensagemErroInsert').css('display', 'none');
			resolve();
		}, 2000);
	});
}

/*
	Preenche os dados da tarefa no modal e p abre para que o usuário possa editar
*/
function openEditar(infos) {
	$('#editNomeProjeto')[0].innerText = infos.nomeProjeto;
	$('#editData').val(infos.dataLimite.split('/').reverse().join('-'));
	$('#editTituloTarefa').val(infos.titulo);
	$('#editDesc').val(infos.descricao);
	$('#editResponsavel').val(infos.responsavel);
	$('input[name=status][value='+infos.status+']').prop("checked",true);

	cacheOldTitulo = infos.titulo;
	$('#editarModal').modal('show');
}

/*
	Preenche o container com uma mensagem de loading
*/
function renderizarLoading() {
	$('#root').empty();
	let loadingText = document.createElement("h1");
	loadingText.innerText = 'Loading...';
	$('#root')[0].appendChild(loadingText);
}

/*
	Preenche o container com uma mensagem de erro
*/
function renderizarErro(mensagem) {
	$('#root').empty();
	let erroTitle = document.createElement("h4");
	let erroText = document.createElement("p");
	erroTitle.innerText = 'Erro';
	erroText.innerText = mensagem;
	$('#root')[0].appendChild(erroTitle);
	$('#root')[0].appendChild(erroText);
}

/*
	Efetivamente renderiza os dados de forma organizada para o usuário
*/
function renderizar(dados) {
	$('#root').empty();
	for(let i = 0; i < dados.length; i++)
	$('#root')[0].appendChild(gerarProjetoDOM(dados[i]));
}

/*
	Gera um DOMNode (<div>) que contém todos os dados de um determinado projeto
*/
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
		containerTarefas.appendChild(gerarTarefaDOM(infos.tarefas[i], infos.nomeProjeto));
	}
	containerProjeto.appendChild(containerTarefas);

	return containerProjeto;
}

/*
	Gera um DOMNode (<div>) que representa e contém os dados da tarefa passada
*/
function gerarTarefaDOM(infos, nomeProjeto) {
	let containerTarefa = document.createElement("div");
	let classeCor = '';
	if(infos.status === 'afazer') classeCor = 'bg-danger';
	else if(infos.status === 'feito') classeCor = 'bg-secondary';
	else classeCor = 'bg-info';
	containerTarefa.className = 'card text-white '+classeCor+' mb-3 containerTarefa';

	let containerCardHead = document.createElement("div");
	containerCardHead.className = 'card-header';
	containerCardHead.style = 'cursor: pointer';
	containerCardHead.innerText = infos.dataLimite;
	containerCardHead.onclick = () => openEditar(Object.assign(infos, {nomeProjeto: nomeProjeto}));
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