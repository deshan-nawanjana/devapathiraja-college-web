var page = 0;

function request_list() {
	DNJS.ajax.parse(`admin/ajax.php?list=${type}&page=${page}`, function(arr){
		if(arr.length == 0 && page == 0) { id('load').innerHTML = 'No Events'; }
		if(arr.length == 0) { id('mre').outerHTML = ''; }
		else {
			if(id('mre')) { id('mre').style.display = 'block'; }
			if(arr.length < 5) { id('mre').outerHTML = ''; }
			arr.forEach(function(itm){
				build_item(itm);
			});
			id('load').outerHTML = '';
			page++;
		}
	});
}

function build_item(e) {
	var html = ``;
	html += `<div class="ntc ntce">`;
	html += `<div class="ntclbl">${e.title}</div>`;
	html += `<div class="ntcdat">`;
	html += `<div class="ntcprg">${getImg(e.body)} ${getPara(e.body)}<br>`;
	html += `<div class="ntcbtn" onclick="view(this.lang)" lang="${e.id}">View</div>`;
	html += `<br>Date : ${e.date}</div>`;
	html += `</div>`;
	html += `</div>`;
	id('ntcbox').innerHTML += html;
}

function getImg(arr) {
	var out = "";
	for(var i = 0; i < arr.length; i++) {
		if(arr[i].type == 'snap') {
			out = `<div class="ntcthb" style="background-image:url(admin/editor/${arr[i].data})"></div>`;
			break;
		}
	}
	return out;
}

window.addEventListener('load', function(){
	var opn = DNJS.url.getData().parameters.id;
	if(opn) { view_notice(opn); return; }
	else {
		id('title').innerHTML = 'All Events';
		request_list();
	}
});

function more() {
	request_list();
}

function getPara(arr) {
	var out = '';
	for(var i = 0; i < arr.length; i++) {
		if(arr[i].type == 'text' && out.length < 300) {
			out += arr[i].data;
		}
	}
	return out;
}

function view(nid) {
	if(type.indexOf('.') > -1) {
		location = 'events.opa.php?id=' + nid;
	} else {
		location = 'events.php?id=' + nid;
	}
}

function view_notice(nid) {
	DNJS.ajax.parse(`admin/ajax.php?post=${type}&ptid=${nid}`, function(e){
		id('title').innerHTML = 'Devapathiraja College';
		var html = '';
		html += `<h3 class="n_title">${e.title}</h3>`;
		e.body.forEach(function(i){
			if(i.type == 'text') {
				html += `<p class="n_text">${i.data}</p>`;
			}
			if(i.type == 'snap') {
				html += `<center><img class="n_snap" src="admin/editor/${i.data}" onclick="opnimg(this)"><center>`;
			}
			if(i.type == 'link') {
				html += `<a class="n_link" href="${i.data}" target="_blank">${i.data}</a>`;
			}
		});
		html += `<p class="n_text"><b>Date : ${e.date}</b></p>`;
		id('ntcbox').innerHTML = html;
	});
}

function opnimg(obj) {
	window.open(obj.src);
}