var data = [{
	'nomeProjeto': 'ProjetoA',
	'tarefas': [{
		'dataLimite': '08/04/2018',
		'titulo': 'Tarefa 1',
		'descricao': 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
		'responsavel': 'Matheus Alves'
	}]
}];

let dom = gerarProjetoDOM(data[0]);

$('#root')[0].appendChild(dom);

function gerarProjetoDOM(infos) {
	let containerProjeto = document.createElement("div");
	containerProjeto.className = 'containerProjeto';

	let tituloProjeto = document.createElement("h1");
	tituloProjeto.className = 'nomeProjeto';
	tituloProjeto.innerText = infos.nomeProjeto;
	containerProjeto.appendChild(tituloProjeto);

	for(let i = 0; i < infos.tarefas.length; i++) {
		containerProjeto.appendChild(gerarTarefaDOM(infos.tarefas[i]));
	}

	return containerProjeto;
}

function gerarTarefaDOM(infos) {
	let containerTarefa = document.createElement("div");
	containerTarefa.className = 'card text-white bg-primary mb-3 containerTarefa';

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