var page = 0;

function request_list() {
	DNJS.ajax.parse(`admin/ajax.php?list=${type}&page=${page}`, function(arr){
		if(arr.length == 0 && page == 0) { id('load').innerHTML = 'No Albums'; }
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
	html += `<div class="ntc" style="background-image: url(${getSanp(e.body)});">`;
	html += `<div class="ntcin">`;
	html += `<div class="ntclbl">${e.title}</div>`;
	html += `<div class="ntcdat">`;
	html += `<div class="ntcprg"><br>`;
	html += `<div class="ntcbtn" onclick="view(this.lang)" lang="${e.id}">View</div>`;
	html += `<br>Date : ${e.date}</div>`;
	html += `</div>`;
	html += `</div>`;
	html += `</div>`;
	id('ntcbox').innerHTML += html;
}

window.addEventListener('load', function(){
	var opn = DNJS.url.getData().parameters.id;
	if(opn) { view_notice(opn); return; }
	else {
		if(type.indexOf('opa') > -1) {
			id('title').innerHTML = 'DCOPA Albums';
		} else {
			id('title').innerHTML = 'All Albums';
		}
		request_list();
	}
});

function more() {
	request_list();
}

function getSanp(arr) {
	if(arr.length > 0) {
		return `admin/editor/${arr[0].data}`;
	}
	return "";
}

function view(nid) {
	if(type.indexOf('.') > -1) {
		location = `gallery.opa.php?id=` + nid;
	} else {
		location = `gallery.php?id=` + nid;
	}
}

function view_notice(nid) {
	DNJS.ajax.parse(`admin/ajax.php?post=${type}&ptid=${nid}`, function(e){
	id('title').innerHTML = 'Devapathiraja College';
		var html = '';
		html += `<h3 class="n_title">${e.title}</h3>`;
		html += `<p class="n_text"><b>Date : ${e.date}</b></p>`;
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
		id('ntcbox').innerHTML = html;
	});
}

function opnimg(obj) {
	window.open(obj.src);
}












































