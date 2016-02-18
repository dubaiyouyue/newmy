<?php
if($a == 'userlist') {
	$userdb = array();
	$flag = isset($_GET['flag']) ? $_GET['flag'] : '';
	$pur_page = 15;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if($page != '') {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$total = $statisticscache['usernum'];
	
	if($flag == 1) {
		$sql = "select * from ".$tablepre."users where flag = 1 order by flag desc, id desc limit ".$start_limit.",".$pur_page;
	} else {
		$sql = "select * from ".$tablepre."users order by flag desc, id desc limit ".$start_limit.",".$pur_page;
	}
	$query = $db->query($sql);
	while($user = $db->fetch_array($query)){
		$user['userid'] = $user['id'];
		if($user['flag'] == 1) {
			$user['flag'] = '管理员';
		} else {
			$user['flag'] = '注册用户';
		}
		$userdb[] = $user;
	}
	$page = multipage($pur_page, $page, "admin.php?m=users&a=userlist&flag=".$flag."&", $maxshowpage, $total);
}

if($a == 'useredit') {
	$user = array();
	$userid = intval($_GET['userid']);
	$sql = "select id,username,password,flag,email,homepage from ".$tablepre."users where id=".$userid;
	$query = $db->query($sql);
	$user = $db->fetch_array($query);		
	$user['userid'] = $user['id'];
}
		
if($a == 'usersave') {
	$username = addslashes(htmlspecialchars($_POST['username']));
	$flag = intval($_POST['flag']);
	$password = addslashes(htmlspecialchars($_POST['password']));
	$password2 = addslashes(htmlspecialchars($_POST['password2']));
	$email = addslashes(htmlspecialchars($_POST['email']));
	$homepage = addslashes(htmlspecialchars($_POST['homepage']));
	if($username == '') {
		message('用户名不能为空！', 'admin.php?m=users&a=useradd');
	} elseif ($password == '') {
		message('请输入密码！', 'admin.php?m=users&a=useradd');
	} elseif ($password != $password2) {
		message('您两次输入的密码不一致！', 'admin.php?m=users&a=useradd');
	} elseif ($email == '') {
		message('Email不能为空！', 'admin.php?m=users&a=useradd');
	} elseif (!check_email($email)) {
		message('Email格式不正确！', 'admin.php?m=users&a=useradd');
	} elseif ($homepage != '') {
		if(!check_weburl($homepage)) {
			message('网址格式不正确！', 'admin.php?m=users&a=useradd');
		}
	}
	$password = md5($password);
	$db->query("insert into ".$tablepre."users (username,password,email,homepage,flag) values ('$username','$password','$email','$homepage','$flag')");
	statistics_recache();
	message('用户添加成功！', 'admin.php?m=users&a=userlist');
}

if($a == 'usereditsave') {
	$userid = intval($_POST['userid']);
	$username = addslashes(htmlspecialchars($_POST['username']));
	$flag = addslashes(htmlspecialchars($_POST['flag']));
	$password = addslashes(htmlspecialchars($_POST['password']));
	$password2 = addslashes(htmlspecialchars($_POST['password2']));
	$email = addslashes(htmlspecialchars($_POST['email']));
	$homepage = addslashes(htmlspecialchars($_POST['homepage']));
	if($username == '') {
		message('用户名不能为空！', 'admin.php?m=users&a=userlist');
	} elseif ($password != $password2) {
		message('您两次输入的密码不一致！', 'admin.php?m=users&a=userlist');
	} elseif ($email == '') {
		message('Email不能为空！', 'admin.php?m=users&a=userlist');
	} elseif (!check_email($email)) {
		message('Email格式不正确！', 'admin.php?m=users&a=userlist');
	} elseif ($homepage != '') {
		if(!check_weburl($homepage)) {
			message('网址格式不正确！', 'admin.php?m=users&a=userlist');
		}
	}
	if($password == '') {
		$sql = "update ".$tablepre."users set username='$username',flag='$flag',email='$email',homepage='$homepage' where id=".$userid;
	} else {
		$password = md5($password);
		$sql = "update ".$tablepre."users set username='$username',flag='$flag',password='$password',email='$email',homepage='$homepage' where id=".$userid;
	}
	$db->query($sql);
	statistics_recache();
	message('编辑成功！', 'admin.php?m=users&a=userlist');
}

if($a == 'userdel') {
	$userid = intval($_GET['userid']);
 	$sql = "delete from ".$tablepre."users where id=".$userid;
 	$db->query($sql);
	statistics_recache();
 	message('删除成功！', 'admin.php?m=users&a=userlist');
}
?>