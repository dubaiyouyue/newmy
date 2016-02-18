<?php
if($action == '') {
	$blog_title = '登陆'.' - '.$options['blog_title'];
} elseif($action == 'checklogin') {
	session_start();
	$username = char($_POST['username']);
	$password = md5($_POST['password']);
	$seccode = $_POST['seccode'];
	if($seccode != $_SESSION['seccode']) {
		unset($_SESSION['seccode']);
		redirect('验证码不正确！', '?module=login');
	} else {
		$sql = "select id,username,password,flag from ".$tablepre."users where username='$username'";
 		$query = $db->query($sql);
		$user = $db->fetch_array($query);
		if($user["password"] != $password) {
			redirect('您的密码不正确，请重新输入！', '?module=login');
		} elseif ($user['username'] && $user['password'] == $password) {
			$username = $user['username'];
			$password = $user['password'];
			$flag = $user['flag'];
			$userid = $user['id'];
			setcookie('tbs_user', authcode("$userid\t$password"), mktime()+$options['timeoffset']*3600+2592000);
			redirect('登录成功！', 'index.php');
   	 	}
	}
} elseif($action == 'logout') {
	list($userid, $password) = $_COOKIE['tbs_user'] ? explode("\t", authcode($_COOKIE['tbs_user'], 'DECODE')) : array('', '');
	$userid = intval($userid);
	setcookie('tbs_user', '', '-1');
	unset($userid, $password, $username, $flag);
	redirect('已经成功退出系统！', 'index.php');
}
?>