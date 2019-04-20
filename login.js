var serverUrl = '/api_login.php';
// Event Listeners
$('#formLogin').submit(function () {
	logar();
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