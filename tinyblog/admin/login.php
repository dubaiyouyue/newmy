<?php
session_start();
if($a == 'logout') {
	list($userid, $password) = $_COOKIE['tbs_user'] ? explode("\t", authcode($_COOKIE['tbs_user'], 'DECODE')) : array('', '');
	$userid = intval($userid);
	setcookie('tbs_user', '', '-1');
	unset($userid, $password, $username, $flag);
	message('成功退出系统！', 'index.php?module=login');
}
?>