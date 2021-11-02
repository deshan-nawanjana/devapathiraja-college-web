var type = DNJS.url.getData().parameters.id;
var file = "", odat = "", ndat = "";
var make, list, edit, tray;

var mdls = {
	"events"  : ['text', 'snap', 'link'],
	"albums"  : ['snap'],
	"notices" : ['text', 'snap', 'link'],
	"news" : ['text', 'snap', 'link']
}

window.addEventListener('load', function(){
	make = id('make');
	list = id('list');
	edit = id('edit');
	tray = id('tray');
	loadList();
	mdls[type.split('.')[0]].forEach(function(e){
		id('opt_' + e).style.display = 'inline-block';
	});
	make.addEventListener('click', makeItem);
});

function getToday() {
	var tmp = new Date();
	var out = '';
	out += `${tmp.getFullYear()}-`;
	out += `${DNJS.string.lead(tmp.getMonth() + 1, 2, '0')}-`;
	out += `${DNJS.string.lead(tmp.getDate(), 2, '0')}`;
	return out;
}

function loadList() {
	DNJS.ajax.parse(`engine.php?list=${type}`, function(resp){
		var html = '';
		resp.reverse().forEach(function(item){
			var css = "";
			if(item.id == file) { css = "litm-open"; }
			html += `<li class="list-item" onclick="openFile(this.lang)" id="${css}" lang="${item.id}">`;
			html += `<div class="litm-name">${item.title}</div>`;
			html += `<div class="litm-date">${item.date}</div>`;
			html += `</li>`;
		});
		list.innerHTML = html;
	});
}

function makeItem() {
	if(JSON.stringify(odat) != JSON.stringify(ndat)) {
		if(!confirm('Unsaved data will lost')) { return; }
	}
	odat = ""; ndat = "";
	var newId = DNJS.event.randomId();
	DNJS.ajax.send(`engine.php?make=${type}&id=${newId}&date=${getToday()}`, function(resp){
		console.log(resp);
		file = newId;
		loadList();
		openFile(file);
	});
}

function openFile(item) {
	if(JSON.stringify(odat) != JSON.stringify(ndat)) {
		if(!confirm('Unsaved data will lost')) { return; }
	}
	id('edit').style.display = 'block';
	file = item;
	DNJS.ajax.parse(`engine.php?open=${type}&id=${file}`, function(resp){

		odat = JSON.parse(JSON.stringify(resp));
		ndat = JSON.parse(JSON.stringify(resp));

		load_edit();

		Array.from(cl('list-item')).forEach(function(e){
			if(e.lang != file) {
				e.removeAttribute('id');
			} else {
				e.setAttribute('id', 'litm-open');
			}
		});
		
	});
}

function load_edit() {
	id('tray').innerHTML = '';
	id('name').value = odat.title;
	id('date').value = odat.date;
	odat.body.forEach(function(opt){
		new_opt(opt.type, opt.data);
	});
	if(odat.body.length == 0) {
		id('name').focus();
		id('name').select();
	}
}

function new_opt(otyp, data = "") {
	if(file == "") { return; }
	var e = document.createElement('div');
	var x = '';
	e.setAttribute('class', 'itm');
	e.setAttribute('lang', otyp);
	x += `<div class="itm-box">`;
	if(otyp == 'text') {
		x += `<textarea class="itm-text" placeholder="Pharagraph here...">${data}</textarea>`;
	}
	if(otyp == 'snap') {
		var idata = data;
		if(idata == "") { idata = "bin/thumb.jpg" }
		e.setAttribute('class', 'itm');
		x += `<input type="file" class="itm-file" onchange="upload(this)" title="Change File">`;
		x += `<img class="itm-snap" src="${idata}">`;
	}
	if(otyp == 'link') {
		e.setAttribute('class', 'itm itm-sml');
		x += `<input type="text" class="itm-link" placeholder="Link here..." value="${data}">`;
	}
	x += `</div>`;
	x += `<div class="lst-opt">`;
	x += `<div class="opt-btn mvup" onclick="opt_mvup(this)" title="Move Up">&#60194;</div>`;
	x += `<div class="opt-btn mvdw" onclick="opt_mvdw(this)" title="Move Down">&#60182;</div>`;
	x += `<div class="opt-btn" onclick="opt_rmve(this)" title="Remove">&#60499;</div>`;
	x += `</div>`;
	e.innerHTML = x;
	tray.append(e);
	if(otyp == 'snap' && data == "") {
		e.getElementsByTagName('input')[0].click();
	}
}

function opt_rmve(obj) {
	obj.parentElement.parentElement.outerHTML = '';
}

function opt_mvup(obj) {
	obj = obj.parentElement.parentElement;
	var arr = Array.from(tray.getElementsByClassName('itm'));
	for(var i = 1; i < arr.length; i++) {
		if(arr[i] == obj) {
			var a = arr[i - 1];
			var b = arr[i];
			var x = a.cloneNode(true);
			var y = b.cloneNode(true);
			a.replaceWith(y);
			b.replaceWith(x);
		}
	}
}

function opt_mvdw(obj) {
	obj = obj.parentElement.parentElement;
	var arr = Array.from(tray.getElementsByClassName('itm'));
	for(var i = 0; i < arr.length - 1; i++) {
		if(arr[i] == obj) {
			var a = arr[i];
			var b = arr[i + 1];
			var x = a.cloneNode(true);
			var y = b.cloneNode(true);
			a.replaceWith(y);
			b.replaceWith(x);
		}
	}
}

window.addEventListener('click', upd_dat);
window.addEventListener('keyup', upd_dat);

function upd_dat() {
	if(ndat == "") { return; }
	ndat.title = id('name').value;
	ndat.date  = id('date').value;
	ndat.body = [];
	Array.from(tray.getElementsByClassName('itm')).forEach(function(e){
		if(e.getAttribute('lang') == 'text') {
			ndat.body.push({
				"type" : "text",
				"data" :  e.getElementsByTagName('textarea')[0].value
			});
		}
		if(e.getAttribute('lang') == 'snap') {
			ndat.body.push({
				"type" : "snap",
				"data" : e.getElementsByTagName('img')[0].getAttribute('src')
			});
		}
		if(e.getAttribute('lang') == 'link') {
			ndat.body.push({
				"type" : "link",
				"data" :  e.getElementsByTagName('input')[0].value
			});
		}
	});
}

function save() {
	DNJS.ajax.send(`engine.php?save=${type}&id=${file}`, {"data" : JSON.stringify(ndat)}, function(res){
		odat = JSON.parse(JSON.stringify(ndat));
		loadList();
	});
}

// close confirm
window.onbeforeunload = function(e) {
	if(JSON.stringify(odat) != JSON.stringify(ndat)) {
		conf(e);
	}
};

function conf(e) {
    e = e || window.event;
    // For IE and Firefox prior to version 4
    if(e) { e.returnValue = 'Sure?'; }
    // For Safari
    return 'Sure?';
}

function upload(obj) {
	var img = obj.files[0];
	var obj = obj.parentElement.getElementsByTagName('img')[0];
	obj.src = 'bin/upload.gif';
	var rid = DNJS.event.randomId();
	DNJS.file.upload(img, `engine.php?upload=${type}&id=${file}&name=${rid}`,
		function(data) { obj.src = `data/${type}/${file}/${rid}`; upd_dat(); }
	);
	upd_dat();
}

function undo() {
	if(file == "") { return; }
	if(JSON.stringify(odat) != JSON.stringify(ndat)) {
		if(confirm('Clear changes?')) {
			ndat = JSON.parse(JSON.stringify(odat));
			load_edit();
		}
	}
}

function delt() {
	if(file == "") { return; }
	if(confirm('Sure to delete?')) {
		id('edit').style.display = 'none';
		DNJS.ajax.send(`engine.php?delete=${type}&id=${file}`, function(res){
			file = "";
			odat = "";
			ndat = "";
			loadList();
		});
	}
}


window.addEventListener('message', function(){
	parent.postMessage(type, "*");
});

















