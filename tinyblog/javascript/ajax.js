function tagShow(o, url) {
	var xmlhttp;
    try{
        xmlhttp = new XMLHttpRequest();
    } catch(e) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	tag = o.getAttribute("tips");
	
	ajax_div.style.display = 'block';
	ajax_div.style.left = o.offsetLeft + o.offsetWidth + "px";
	ajax_div.style.top = o.offsetTop + "px";
	
	//创建请求结果处理程序
    xmlhttp.onreadystatechange = function() {
		if(4 == xmlhttp.readyState) {
			if(200 == xmlhttp.status) {
				//document.getElementsByTagName("ajax_div").innerHTML = xmlhttp.responseText;
				//d.innerHTML = xmlhttp.responseText;
				document.getElementById("ajax_div").innerHTML = xmlhttp.responseText;
				
			} else {
				alert("error");
			}
		}
	}
	//打开连接，true表示异步提交
    xmlhttp.open("post",url + "/javascript.php?action=getart_bytag"+"&r="+Math.random(),true);
    //当方法为post时需要如下设置http头
    xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    //发送数据
    xmlhttp.send("tag="+tag);
	
	hideTags(o);
}
function hideTags(o) {
	if(o.parentNode.firstChild.className == "ajax_div")
		o.parentNode.removeChild(o.parentNode.firstChild);
}
function delAttach(attachID) {
	var xmlhttp;
    try{
        xmlhttp = new XMLHttpRequest();
    } catch(e) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	xmlhttp.onreadystatechange = function() {
		if(4 == xmlhttp.readyState) {
			if(200 == xmlhttp.status) {
				//document.getElementsByTagName("ajax_div").innerHTML = xmlhttp.responseText;
				//d.innerHTML = xmlhttp.responseText;
				document.getElementById("attach_" + attachID).style.display = "none";	
			} else {
				alert("error");
			}
		}
	}
    xmlhttp.open("post", "admin.php?m=articles&a=delAttach"+"&r="+Math.random(), true);
    xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xmlhttp.send("id="+attachID);
}