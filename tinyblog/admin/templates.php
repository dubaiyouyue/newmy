<?php
$current_file_info = "templates/".$templatename."/template_info.php";
if(file_exists($current_file_info)) {
	require $current_file_info;
	$current_template_info = $template_info;
} else {
	$current_template_info = array(
			'error' => '没有发现模板信息文件template_info.php');
}

$dir = 'templates';
$dir_arr = array();
$dir_arr = getdirdb($dir);
foreach($dir_arr as $dir) {
	$info_arr = array();
	$templates['templatename'] = $dir;
	$templates['pic'] = 'templates/'.$dir.'/template.png';
	$file_info = 'templates/'.$dir.'/template_info.php';
	if(file_exists($file_info)) {
		require $file_info;
		$templates['template_info'] = $template_info;
	} else {
		$templates['template_info'] = array(
			'error' => '没有发现模板信息文件template_info.php');
	}
	$templatedb[] = $templates;
}

if ($a == 'template_set') {
	$templatename = $_GET['templatename'];
	
	$contents = "<?php\r\n";
	$contents .= "\t"."$"."templatename = '".$templatename."';\n";
	$contents .= "?>";
	
	$file = 'cache/cache_templates.php';
	writetofile($file, $contents);
	message('模板设置成功！', 'admin.php?m=templates');
}
?>