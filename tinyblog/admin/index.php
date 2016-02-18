<?php
function sizecount($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif ($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif ($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}
function getserverinfo() {
	global $db,$tablepre;
	$server['serverinfo'] = PHP_OS.' / PHP v'.PHP_VERSION;
	$server['serverinfo'] .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
	$server['mysqlversion'] = $db->getversion();
	$server['fileupload'] = ini_get('upload_max_filesize');
	$dbsize = 0;
	$query = $db->fetch_all("SHOW TABLE STATUS LIKE '$tablepre%'", $tables);
	foreach($tables as $table) {
		$dbsize += $table['Data_length'] + $table['Index_length'];
	}
	$server['dbsize'] = $dbsize ? sizecount($dbsize) : 'UnKnown';
	$server['magic_quote_gpc'] = get_magic_quotes_gpc() ? 'On' : 'Off';
	return $server;
}
function get_recentart() {
	global $db, $tablepre;
	$query = $db->query("select a.id as artid, a.title, a.updatetime, c.id as cateid, c.catename from ".$tablepre."articles a left join ".$tablepre."categories c on a.cateid = c.id order by a.id desc limit 0, 9");
	while($article = $db->fetch_array($query)) {
		$article['updatetime'] = date('Y-m-d', $article['updatetime']);
		$articledb[] = $article;
	}
	return $articledb;
}
$server = getserverinfo();
$articledb = get_recentart();
?>