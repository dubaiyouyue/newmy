<?php
if($a == 'linklist') {
	$pur_page = 15;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if(!empty($page)) {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$total = $statisticscache['linknum'];
	$sql = "select id as linkid,webname,url,linkorder from ".$tablepre."links order by id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($link = $db->fetch_array($query)) {
		$linkdb[] = $link;
	}
	$page = multipage($pur_page, $page, 'admin.php?m=links&a=linklist&', $maxshowpage, $total);
}
if($a == 'linkorder') {
	$linkid = array();
	$linkorder = array();
	$linkid = $_POST['linkid'];
	$linkorder = $_POST['linkorder'];
	$len = count($linkid);
	for($i = 0; $i < $len; $i ++ ) {
		$db->query("update ".$tablepre."links set linkorder = '$linkorder[$i]' where id = ".$linkid[$i]);	
	}
	recentlink_recache();
	message('排序修改成功！', 'admin.php?m=links&a=linklist');
}
if($a == 'linkedit') {
	$link = array();
	$linkid = intval($_GET['linkid']);
	$sql = "select id as linkid,webname,url,linkorder from ".$tablepre."links where id = ".$linkid;
	$query = $db->query($sql);
	$link = $db->fetch_array($query);	
}	
if($a == 'linksave') {
	$webname = char($_POST['webname']);
	$url = char($_POST['url']);
	$linkorder  = char($_POST['linkorder']);
	if($webname == '') {
		message('链接名不能为空！', 'admin.php?m=links&a=linkadd');
	} elseif(strlen($webname) > 20) {
		message('链接名称不能超过20个字符！', 'admin.php?m=links&a=linkadd');
	} elseif(!check_weburl($url)) {
		message('链接地址格式错误', 'admin.php?m=links&a=linkadd');
	} else {
		$db->query("insert into ".$tablepre."links (webname,url,linkorder) values ('$webname','$url','$linkorder')");
		recentlink_recache();
		statistics_recache();
		message('链接添加成功！', 'admin.php?m=links&a=linklist');
	}
}
if($a == 'linkeditsave') {
	$linkid = intval($_POST['linkid']);
	$webname = char($_POST['webname']);
	$url = char($_POST['url']);
	$linkorder = char($_POST['linkorder']);
	if($webname == '') {
		message('链接名不能为空！', 'admin.php?m=links&a=linkedit&linkid='.$linkid);
	} elseif(strlen($webname) > 20) {
		message('链接名称不能超过20个字符！', 'admin.php?m=links&a=linkedit&linkid='.$linkid);
	} elseif(!check_weburl($url)) {
		message('链接地址格式错误', 'admin.php?m=links&a=linkedit&linkid='.$linkid);
	} else {
		$db->query("update ".$tablepre."links set webname='$webname',url='$url',linkorder='$linkorder' where id=".$linkid);
		recentlink_recache();
		message('链接修改成功！', 'admin.php?m=links&a=linklist');
	}
}
if($a == 'linkdel') {
	$linkid = $_GET['linkid'];
 	$sql = "delete from ".$tablepre."links where id = ".$linkid;
 	$db->query($sql);
	recentlink_recache();
	statistics_recache();
 	echo "<script language=javascript>";
 	echo "this.location.href='admin.php?m=links&a=linklist';</script>";
}
?>