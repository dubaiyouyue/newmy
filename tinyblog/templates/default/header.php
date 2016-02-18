<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$blog_title?></title>
<meta name="description" content="<?=$description?>" />
<meta name="keywords" content="<?=$keywords?>" />
<link rel="stylesheet" href="<?=$options['url']?>/templates/default/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?=$options['url']?>/javascript/thumbs.js"></script>
<script type="text/javascript" src="<?=$options['url']?>/javascript/common.js"></script>
<script type="text/javascript">
window.onload=function(){ 
	fiximage('300x300');
}
</script>
</head>
<body>
<div id="header">
	<div id="logo"><h1><a href="<?=$options['url']?>" title="<?=$options['blog_name']?>"><?=$options['blog_name']?></a></h1></div>
	<div id="description"><?=$options['blog_description']?></div>
	<div id="search"><form action="?action=search" method="post"><input class="text" type="text" name="keywords" />&nbsp;<input class="submit" type="submit" value="搜索" /></form></div>
	<div class="menu">
		<ul>
		<? if($options['ishtml']) { ?>
		<li class="current"><a title="blog首页" href="<?=$options['url']?>/index.php">INDEX</a></li>
		<li><a title="标签云" href="<?=$options['url']?>/module/tags">TAGS</a></li>
		<li><a title="文章归档" href="<?=$options['url']?>/module/archives">ARCHIVES</a></li>
		<li><a title="文章引用" href="<?=$options['url']?>/module/trackbacks">TRACKBACKS</a></li>
		<li><a title="评论列表" href="<?=$options['url']?>/module/comments">COMMENTS</a></li>
		<li><a title="站点链接" href="<?=$options['url']?>/module/links">LINKS</a></li>
		<? } else { ?>
		<li class="current"><a title="blog首页" href="<?=$options['url']?>/index.php">INDEX</a></li>
		<li><a title="标签云" href="<?=$options['url']?>/?module=tags">TAGS</a></li>
		<li><a title="文章归档" href="<?=$options['url']?>/?module=archives">ARCHIVES</a></li>
		<li><a title="文章引用" href="<?=$options['url']?>/?module=trackbacks">TRACKBACKS</a></li>
		<li><a title="评论列表" href="<?=$options['url']?>/?module=comments">COMMENTS</a></li>
		<li><a title="站点链接" href="<?=$options['url']?>/?module=links">LINKS</a></li>
		<? } ?>
		</ul>
		<div class="fixed"></div>
	</div>
	<div class="fixed"></div>
</div>