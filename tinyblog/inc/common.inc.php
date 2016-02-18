<?php
error_reporting(0); 
header("content-type: text/html; charset=utf-8");

$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

define('IN_TBS', TRUE);
if(!defined('TBS_ROOT')) {
    define('TBS_ROOT', str_replace('\\', '/' , substr(dirname(__FILE__), 0, -3)));
}
require TBS_ROOT.'inc/sys.config.php';
require TBS_ROOT.'inc/plugin.php';
require TBS_ROOT.'cache/cache_setting.php';
require TBS_ROOT.'inc/db.config.php';
require TBS_ROOT.'inc/global.func.php';
require TBS_ROOT.'inc/template.php';
require TBS_ROOT.'inc/db.class.php';
require TBS_ROOT.'inc/db.conn.php';
require TBS_ROOT.'inc/cache.func.php';

$magic_quotes_gpc = get_magic_quotes_gpc();

if($magic_quotes_gpc) {
    $_GET = sn_stripslashes($_GET);
    $_POST = sn_stripslashes($_POST);
    $_COOKIE = sn_stripslashes($_COOKIE);
}

list($userid, $password) = $_COOKIE['tbs_user'] ? explode("\t", authcode($_COOKIE['tbs_user'], 'DECODE')) : array('', '');
$userid = intval($userid);
$query = $db->query("select id, username, password, homepage, flag from ".$tablepre."users where id = ".$userid);
$user = $db->fetch_array($query);
if($password == $user['password']) {
	$username = $user['username'];
	$homepage = $user['homepage'];
	$flag = $user['flag'];
}
?>