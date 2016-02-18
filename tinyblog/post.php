<?php
require_once 'global.php';
$a = $_GET['a'];
if($options['close_comment']) {
	redirect('评论功能已经关闭！', 'index.php');
} else {
	if($a == 'commentpost') {
		session_start();
		$artid = intval($_POST['artid']);
		$username = char($_POST['username']);
		$homepage = char($_POST['homepage']);
		$pageurl = char($_POST['pageurl']);
		$content = addslashes($_POST['content']);
		$number = trim($_POST['number']);
		$options['need_approve'] == 1 ? $status = 'waiting' : $status = 'approved';
		$ipaddress = addslashes(getip());
		if($username == '') {
			redirect('请输入您的名称！', $pageurl);
		}
		if($content == '') {
			redirect('请输入评论内容！', $pageurl);
		}
		if($options['commentseccode']) {
			if($number != $_SESSION['seccode'] || empty($number)){
				redirect('验证码不正确', $pageurl);
			}
		}
		$commenttime = mktime();
		$sql = "insert into ".$tablepre."comments (artid,username,homepage,content,status,ipaddress,commenttime) values ('$artid','$username','$homepage','$content','$status','$ipaddress','$commenttime')";
		$db->query($sql);
		$sql = "update ".$tablepre."articles set commentnum=commentnum+1 where id=".$artid;
		$db->query($sql);
	
		recentcomment_recache();
		redirect('评论发表成功!', $pageurl);
	}
}
?>