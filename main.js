var data = [{
	'nomeProjeto': 'ProjetoA',
	'tarefas': [{
		'dataLimite': '08/04/2018',
		'titulo': 'Tarefa 1',
		'descricao': 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
		'responsavel': 'Matheus Alves',
		'status': 'afazer'
	},{
		'dataLimite': '09/04/2018',
		'titulo': 'Tarefa 2',
		'descricao': 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
		'responsavel': 'Enzo Gabriel',
		'status': 'fazendo'
	},{
		'dataLimite': '10/04/2018',
		'titulo': 'Tarefa 3',
		'descricao': 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
		'responsavel': 'Julia Souza',
		'status': 'feito'
	}]
}];

renderizar(data);

function renderizar(dados) {
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