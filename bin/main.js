function swtlang(k) {
	document.getElementsByClassName('ntcdat')[1 - k].style.display = 'none';
	document.getElementsByClassName('ntcdat')[k].style.display = 'inherit';
}

function urlgo(obj) {
	location = obj.lang;
}