<?php

	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

	echo '[{
		"nomeProjeto": "ProjetoA",
		"tarefas": [{
			"dataLimite": "08/04/2018",
			"titulo": "Tarefa 1",
			"descricao": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
			"responsavel": "Matheus Alves",
			"status": "afazer"
		},{
			"dataLimite": "09/04/2018",
			"titulo": "Tarefa 2",
			"descricao": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
			"responsavel": "Enzo Gabriel",
			"status": "fazendo"
		},{
			"dataLimite": "10/04/2018",
			"titulo": "Tarefa 3",
			"descricao": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
			"responsavel": "Julia Souza",
			"status": "feito"
		}]
	}]';

?>