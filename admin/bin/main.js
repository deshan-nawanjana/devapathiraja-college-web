function opn(obj) {
	id('frame').src = `editor?id=${obj.lang}&t=${Date.now()}`;
	id('frame').contentWindow.postMessage("", "*");
}

function chk() {
	id('frame').contentWindow.postMessage("", "*");
}

window.addEventListener('message', function(e){
	if(e.data == "") { return; }
	Array.from(cl('btn')).forEach(function(b){
		if(b.lang == e.data) {
			b.setAttribute('id', 'opn');
		} else {
			b.removeAttribute('id');
		}
	});
});

function logout() {
	DNJS.ajax.send('login.php?logout=1', function(e){
		if(e == 'LOGOUT_OK') {
			location = location;
		}
	})
}

function option() {
	id('frame').src = `options.php`;
}

window.addEventListener('load', function(){
	cl('btn')[0].click();
});