<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>系统提示</title>
<style type="text/css">
*{margin:0;padding:0px}
body{background:#fff;color:#333;font:12px Verdana, Tahoma, sans-serif;text-align:center;margin:0 auto;}
a{text-decoration:none;color:#006600;padding:3px;}
a:hover{color:#006600;}
#msg{border-top:1px solid #e3e3e3;border-bottom:1px solid #e3e3e3;text-align:left;margin:10% auto; width:50%; background:#f1f1f1; padding:30px;}
#msgcontent {padding:20px 50px;}
#msgcontent p{text-align:center;margin-top:10px;padding:0}
</style>
</head>
<body>

<div id="msg">
	<div id="msgcontent">
		<strong><?=$message?></strong>
		<strong><a href="<?=$pageurl?>">« 返回</a></strong>
	</div>
</div>
<meta http-equiv="refresh" content="2;URL=<?=$pageurl?>">
</body>
</html>