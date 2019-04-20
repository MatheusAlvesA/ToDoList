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
		if(r.ok) {
			//TODO
		} else {
			//TODO
		}
	} catch(err) {
		//TODO
	}

}