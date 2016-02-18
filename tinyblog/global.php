<?php
require 'inc/common.inc.php';

require TBS_ROOT.'cache/cache_statistics.php';
require TBS_ROOT.'cache/cache_recentart.php';
require TBS_ROOT.'cache/cache_recentcomment.php';
require TBS_ROOT.'cache/cache_categories.php';
require TBS_ROOT.'cache/cache_recentlink.php';
require TBS_ROOT.'cache/cache_archives.php';

require TBS_ROOT.'cache/cache_templates.php';

require TBS_ROOT.'inc/blog.func.php';

if($options['close_blog']) {
	require template('close', $templatename);
	exit();
}
if($options['iscompress'] == 1 && extension_loaded('zlib')) {
	ob_start('ob_gzhandler');
}

$viewmode = $_GET['viewmode'] ? $_GET['viewmode'] : $_COOKIE['viewmode'];
$viewmode = in_array($viewmode, array('normal', 'list')) ? $viewmode : $options['viewmode'];
if (!in_array($_COOKIE['viewmode'], array('normal', 'list')) || $viewmode != $_COOKIE['viewmode']) {
	setcookie('viewmode', $viewmode, mktime() + $options['timeoffset'] * 3600 + 2592000, '/', '', '0');
}
if($viewmode == 'normal') {
	$artshownum = $options['normalnum'];
	$templatefile = 'normal';
} elseif ($viewmode == 'list') {
	$artshownum = $options['listnum'];
	$templatefile = 'list';
}

$blog_title = $options['blog_title'];
$keywords = $options['blog_keywords'];
$description = $options['blog_description'];

$calendar = calendar();
?>