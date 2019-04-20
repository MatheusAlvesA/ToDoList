var serverUrl = '/api_login.php';
// Event Listeners
$('#formLogin').submit(function () {
	logar();
	return false;
});
$('#formCadastro').submit(function () {
	cadastrar();
	return false;
});

async function logar() {
	let corpoReq = JSON.stringify({
		'nome': $('#nameLogin').val(),
		'senha': $('#senhaLogin').val()
	});
	let r = null;
	try {
		r = await fetch(serverUrl, { method: "POST", body: corpoReq });
		let json = await r.json();
		if(json.ok) {
			window.location = "/index.php";
		} else {
			mostrarMensagemErroLogin(json.erro);
		}
	} catch(err) {
		mostrarMensagemErroLogin('Falha na conexão com o servidor');
	}

}

async function cadastrar() {
	let corpoReq = JSON.stringify({
		'nome': $('#nome').val(),
		'senha': $('#senha').val(),
		'senhaConfirm': $('#senhaConfirm').val()
	});
	let r = null;
	try {
		r = await fetch(serverUrl+'/?cadastro', { method: "POST", body: corpoReq });
		let json = await r.json();
		if(json.ok) {
			window.location = "/index.php";
		} else {
			mostrarMensagemErroCadastro(json.erro);
		}
	} catch(err) {
		mostrarMensagemErroCadastro('Falha na conexão com o servidor');
	}
}

var mostrandoMensagemErroLogin = false;
function mostrarMensagemErroLogin(mensagem) {
	if(mostrandoMensagemErroLogin) return false;
	mostrandoMensagemErroLogin = true;

	$("#mensagemErroLogin").html(mensagem);
	$("#mensagemErroLogin").css('display', 'block');

	setTimeout(() => { // Mostrando mensagem de erro
		mostrandoMensagemErroLogin = false;
		$("#mensagemErroLogin").css('display', 'none');
	}, 3000); // 3 Segundos

	return true;
}

var mostrandoMensagemErroCadastro = false;
function mostrarMensagemErroCadastro(mensagem) {
	if(mostrandoMensagemErroCadastro) return false;
	mostrandoMensagemErroCadastro = true;

	$("#mensagemErroCadastro").html(mensagem);
	$("#mensagemErroCadastro").css('display', 'block');

	setTimeout(() => { // Mostrando mensagem de erro
		mostrandoMensagemErroCadastro = false;
		$("#mensagemErroCadastro").css('display', 'none');
	}, 3000); // 3 Segundos

	return true;
}