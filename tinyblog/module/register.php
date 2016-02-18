<?php
if($action == 'register') {
	if($options['close_reg']) {
		redirect('注册已经关闭！', 'index.php');
	} else {
		$blog_title = '注册'.' - '.$options['blog_title'];
	}
} elseif($action == 'checkreg') {
	$username = addslashes(htmlspecialchars($_POST['username']));
	$password = addslashes(htmlspecialchars($_POST['password']));
	$password2 = addslashes(htmlspecialchars($_POST['password2']));
	$email = addslashes(htmlspecialchars($_POST['email']));
	$homepage = addslashes(htmlspecialchars($_POST['homepage']));
	$seccode = addslashes(htmlspecialchars($_POST['seccode']));
	if($username == ''){
		redirect('用户名不能为空！', '?module=register&action=register');
	}elseif($password == ''){
		redirect('请输入密码！', '?module=register&action=register');
	}elseif($password != $password2){
		redirect('您两次输入的密码不一致！', '?module=register&action=register');
	}elseif($email == ''){
		redirect('Email不能为空！', '?module=register&action=register');
	}
	if($options['open_seccode']) {
		if($seccode == ''){
			redirect('验证码不能为空！', '?module=register&action=register');
		}
		if($seccode != $_SESSION['seccode']) {
			unset($_SESSION['seccode']);
			redirect('验证码不正确！', '?module=register&action=register');
		}
	}
	if(strlen($username) > 30) {
		redirect('用户名为空或者超过30字节.', '?module=register&action=register');
	}
	if(!check_email($email)) {
		redirect('email格式不正确.', '?module=register&action=register');
	}
	if($homepage != '') {
		if(!check_weburl($homepage)) {
			redirect('网址格式不正确.', '?module=register&action=register');
		}
	}
	if($options['ban_user']) {
		$options['ban_user'] = str_replace('，', ',', $options['ban_user']);
		$banname = explode(',', $options['ban_user']);
		foreach($banname as $value){
			if (strpos($username, $value) !== false){
				redirect('此用户名包含不可接受字符或被管理员屏蔽,请选择其它用户名.', '?module=register&action=register');
			}
		}
	}
	$name_key = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n",'#','$','(',')','%','@','+','?',';','^');
	foreach($name_key as $value) {
		if (strpos($username, $value) !== false){
			redirect('此用户名包含不可接受字符或被管理员屏蔽,请选择其它用户名.', '?module=register&action=register');
		}
	}
	$query = $db->query("select id from ".$tablepre."users where username = '$username'");
	$num = $db->num_rows($query);
	if($num) {
		redirect('此用户名已经存在，请重新注册！', '?module=register&action=register');
	}
	$password = md5($password);
	$db->query("insert into ".$tablepre."users (username,password,email,homepage,flag) values ('$username','$password','$email','$homepage','0')");
	statistics_recache();
	redirect('成功注册！', '?module=login&action=login');
}
?>