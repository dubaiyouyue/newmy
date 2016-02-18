<?php
if($a == '') {
	$type = $_GET['type'];
	require TBS_ROOT.'cache/cache_setting.php';
}
if($a == 'updatesetting') {
	$type = $_GET['type'];
	$options = $_POST['options'];

	if(isset($options['catedir']) && trim($options['catedir']) == '') {
		$options['catedir'] = 'category';
	}
	if(isset($options['artdir']) && trim($options['artdir']) == '') {
		$options['artdir'] = 'archives';
	}
	foreach($options as $key => $val) {
		$db->query("replace into ".$tablepre."settings values ('".addslashes($key)."', '".addslashes($val)."')");
		
	}
	$query = $db->query("select * from ".$tablepre."settings");
	$contents = "<?php\r\n";
	$contents .= "\$options = array(\r\n";
	while($option = $db->fetch_array($query)) {
		$options[$option['title']] = $option['value'];
		$contents .="\t'".$option['title']."' => '".addslashes($option['value'])."',\n";
	}
	$contents .= ");";
	$contents .= "?>";
	
	$file = TBS_ROOT.'/cache/cache_setting.php';

	if (file_exists($file)) {
		@chmod ($file, 0777);
	}
	$fp = fopen($file, w);
	fwrite($fp, $contents, strlen($contents));
	fclose($fp);
	
	categories_recache();
	recentart_recache();
	recentcomment_recache();
	update_htaccess($options['catedir'], $options['artdir'], $options['artsuffix'], $options['selfartsuffix']);
	message('系统设置更新成功！', 'admin.php?m=setting&type='.$type);
}
function update_htaccess($catedir, $artdir, $artsuffix, $selfartsuffix) {
	$dir = dirname($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
	$dir = ($dir == '\\') ? '' : $dir;
	$content = "<IfModule mod_rewrite.c>\r\nRewriteEngine On\r\nRewriteBase ".$dir."\r\n";
	$content .= "RewriteCond %{REQUEST_FILENAME} -f [OR]\r\nRewriteCond %{REQUEST_FILENAME} -d\r\nRewriteRule ^.*$ - [S=15]\r\n";
	$content .= "RewriteRule ^page/([0-9]+)?/?$ index.php?page=$1 [QSA,L]\r\n";
	$content .= "RewriteRule ^".$catedir."/([0-9]+)/?([0-9]+)?/?$ index.php?action=category&cateid=$1&page=$2 [QSA,L]\r\n";
	$content .= "RewriteRule ^".$catedir."/([^/]+)/?([0-9]+)?/?$ index.php?action=category&cateurl=$1&page=$2 [QSA,L]\r\n";
	$content .= "RewriteRule ^module/(archives|tags|trackbacks|links|comments)/?$ index.php?module=$1 [QSA,L]\r\n";
	$content .= "RewriteRule ^module/(trackbacks|comments|links)/?([0-9]+)?/?$ index.php?module=$1&page=$2 [QSA,L]\r\n";
	if($selfartsuffix != '') {
		$content .= "RewriteRule ^".$artdir."/([0-9]+).".$selfartsuffix."/?([0-9]+)?/?$ article.php?id=$1&page=$2 [QSA,L]\r\n";
	} else {
		if($artsuffix != '0') {
			$content .= "RewriteRule ^".$artdir."/([0-9]+).".$artsuffix."/?([0-9]+)?/?$ article.php?id=$1&page=$2 [QSA,L]\r\n";
		} elseif($artsuffix == '0') {
			$content .= "RewriteRule ^".$artdir."/([0-9]+)/?([0-9]+)?/?$ article.php?id=$1&page=$2 [QSA,L]\r\n";
		}
	}
	$content .= "RewriteRule ^".$artdir."/([^/]+)/?([0-9]+)?/?$ article.php?htmlurl=$1&page=$2 [QSA,L]\r\n";
	$content .= "RewriteRule ^tag/([^/]+)/?([0-9]+)?/?$ index.php?action=tags&tagname=$1&page=$2 [QSA,L]\r\n";
	$content .= "RewriteRule ^times/([0-9]+)/?([0-9]+)?/?$ index.php?action=times&y=$1&m=$2 [QSA,L]\r\n";
	$content .= "RewriteRule ^times/([0-9]+)/?([0-9]+)/?page/?([0-9]+)?/?$ index.php?action=times&y=$1&m=$2&page=$3 [QSA,L]\r\n";
	$content .= "RewriteRule ^times/([0-9]+)/?([0-9]+)/?([0-9]+)?/?$ index.php?action=times&y=$1&m=$2&d=$3 [QSA,L]\r\n";
	$content .= "RewriteRule ^times/([0-9]+)/?([0-9]+)/?([0-9]+)/?page/?([0-9]+)?/?$ index.php?action=times&y=$1&m=$2&d=$3&page=$4 [QSA,L]\r\n";
	$content .= "</IfModule>";
	$file = TBS_ROOT.'./.htaccess';
	writetofile($file, $content);
}
?>