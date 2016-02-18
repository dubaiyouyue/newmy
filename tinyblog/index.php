<?php
require 'global.php';

$module = isset($_GET['module']) ? $_GET['module'] : 'list';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if(in_array($module, array('list', 'tags', 'archives', 'trackbacks', 'comments', 'links', 'login', 'register'))) {
	$modulefile = 'module/'.$module.'.php';
	if(is_file($modulefile)) {
		require $modulefile;
	} else {
		redirect('未发现模块文件，请确认所有文件是否齐全,或者重新上传', 'index.php');
	}
} else {
	redirect('非法引用模块', 'index.php');
}

$mtime = explode(' ', microtime());
$totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
	
if($module == 'list') {
	require template($templatefile, $templatename);
} else {
	require template($module, $templatename);
}
?>