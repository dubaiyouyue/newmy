function $(id) {
	return document.getElementById(id);
}
function runCode(obj) {
	var winname = window.open('', "_blank", '');
	winname.document.open('text/html', 'replace');
	winname.opener = null;
	winname.document.write(obj.value);
	winname.document.close();
}
function saveCode(obj) {
	var winname = window.open('', '_blank', 'top=10000');
	winname.document.open('text/html', 'replace');
	winname.document.write(obj.value);
	winname.document.execCommand('saveas','','code.htm');
	winname.close();
}