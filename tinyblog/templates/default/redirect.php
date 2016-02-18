<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>系统提示</title>
<style type="text/css">
*{margin:0;padding:0px}
body{background:#fff;color:#333;font:14px Verdana, Tahoma, sans-serif;text-align:center;margin:0 auto;}
a{text-decoration:none;color:#29458C}
a:hover{text-decoration:underline;color:#444}
#msg{border:1px solid #efefef;text-align:left;margin:10% auto; width:50%; background:#fafafa}
#msgcontent {padding:20px 50px;}
#msgcontent p{text-align:center;margin-top:10px;padding:0;font-size:12px;}
</style>
</head>
<body>

<div id="msg">
	<div id="msgcontent">
		<?=$message?>
		<p><a href="<?=$pageurl?>">» 如果你不想等待或浏览器没有自动跳转请</a></p>
	</div>
</div>
<meta http-equiv="refresh" content="2;URL=<?=$pageurl?>">
</body>
</html>