<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control Center - <?=$options['blog_title']?></title>
<link rel="stylesheet" href="templates/admin/style.css" type="text/css" />
<link rel="stylesheet" href="templates/admin/editor.css" type="text/css" />
<script type="text/javascript" src="javascript/common.js"></script>
<script type="text/javascript" src="javascript/post.js"></script>
<script type="text/javascript" src="templates/admin/editor.js"></script>
<script type="text/javascript" src="javascript/attachment.js"></script>
<script type="text/javascript" src="javascript/ajax.js"></script>
</head>
<body>
<div id="header">
	<div id="logo">
	<h1><a href="<?=$options['url']?>"><?=$options['blog_name']?></a><a class="view" href="<?=$options['url']?>"><span>View Blog</span></a></h1>
	</div>
	<div id="user">Hello, <a href=""><?=$username?></a> | <a href="admin.php?m=login&a=logout">Log Out</a></div>
</div>