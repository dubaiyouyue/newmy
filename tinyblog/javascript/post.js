function addquote(obj, strAuthor) {
	var text = $(obj).innerHTML;
	text = text.replace(/alt\=(\"|)([^\"\s]*)(\"|)/g,"> $2 <");
	text = text.replace(/\<[^\<\>]+\>/g,"\n");
	text = text.replace(/ +/g," ");
	text = text.replace(/\n+/g,"\n");
	text = text.replace(/^\n*/gm,"");
	text = text.replace(/^\s*/gm,"");
	text = text.replace(/\n*$/gm,"");
	text = text.replace(/\s*$/gm,"");
	text = text.replace(/&lt;/g,"<");
	text = text.replace(/&gt;/g,">");
	text = text.replace(/&nbsp;&nbsp;/g,"  ");
	text = text.replace(/&amp;/g,"&");
	$("content").value += "[quote="+strAuthor+"]"+text+"[/quote]";
	$("content").focus();
}
function showStyle(tag, msg) {
	var o = $(tag);
	o.style.display = 'block';
	o.style.cssFloat = 'left';
	o.style.background = '#006600';
	o.style.width = '795px';
	o.style.padding = '5px';
	o.style.margin = '0 auto';
	o.style.marginLeft = '0px';
	o.style.marginBottom = '10px';
	o.style.fontSize = '12px';
	o.style.textAlign = 'center';
	o.style.color = '#fff';
	$(tag).innerHTML = msg;
	setTimeout("hiddenTag()", 2000);
}
function hiddenTag() {
	$('tips').style.display = 'none';
}
function checkArticleForm() {
	if(document.form1.title.value == "") {
		showStyle('tips', '文章标题不能为空');
		document.form1.title.focus();
		return false;
	}
	if(document.form1.content.value == "") {
		showStyle('tips', '文章内容不能为空');
		document.form1.content.focus();
		return false;
	}
	return true;
}
function checkUserForm() {
	if(document.userForm.username.value == "") {
		showStyle('tips', '用户名不能为空');
		document.userForm.username.focus();
		return false;
	}
	if(document.userForm.password.value == "") {
		showStyle('tips', '密码不能为空');
		document.userForm.password.focus();
		return false;
	}
	if(document.userForm.email.value == "") {
		showStyle('tips', 'Email不能为空');
		document.userForm.email.focus();
		return false;
	}
	return true;
}
function checkAll(form) {
  	for(var i=0; i<form.elements.length; i++) {
    	var e = form.elements[i];
    	if(e.name != 'chkall')
       		e.checked = form.chkall.checked;
    }
}
function showMore(id) {
  	if($(id).style.display == 'none') {
		$(id).style.display = 'block';
	} else {
		$(id).style.display = 'none';
	}
}
function checkCategoryForm() {
	if (document.form1.catename.value == "") {
		showStyle('tips', '分类名称不能为空');
		document.form1.catename.focus();
		return false;
	}
	return true;
}
//文章搜索
function funcSearch() {
    $(function(){
        var key = $("#sysIdSearch").val();
        location.href="index.php?key="+encodeURIComponent(key);
    });
}
//文章搜索回车提交
$(function() {
    $("#sysIdSearch").live('keydown',function(e){
        var e = e || window.event;
        if(e.keyCode==13){
            var key = $("#sysIdSearch").val();
            location.href="index.php?key="+encodeURIComponent(key);
        }
    });
});