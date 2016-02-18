function addAttachToEditor(str) {
	document.form1.content.value += str;
}
function addToList(filename, value, attachID) {
	var msg = parent.document.getElementById("msgList");
	var dl = parent.document.createElement("dl");
	var dt = parent.document.createElement("dt");
	var dd = parent.document.createElement("dd");
	
	msg.insertBefore(dl, msg.firstChild);
	dl.id = 'attach_' + attachID;
	dl.appendChild(dt);
	dl.appendChild(dd);
	
	dt.innerHTML = filename;
	dd.innerHTML = "<a href=javascript:addAttachToEditor('" + value + "');>插入</a> , <a href=javascript:delAttach('" + attachID + "');>删除</a>";
	dl.innerHTML += '<div class="fixed"></div>';
}