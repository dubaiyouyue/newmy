<?php
if($a == 'catelist') {
	$catedb = array();
	$sql = "select id as cateid,catename,cateurl,cateorder from ".$tablepre."categories order by id desc";
	$query = $db->query($sql);
	while($cate = $db->fetch_array($query)) {
		$catedb[] = $cate;
	}
}
if($a == 'cateorder') {
	$cateid = array();
	$cateorder = array();
	$cateid = $_POST['cateid'];
	$cateorder = $_POST['cateorder'];
	$len = count($cateid);
	for($i = 0; $i < $len; $i ++ ) {
		$db->query("update ".$tablepre."categories set cateorder = '$cateorder[$i]' where id = ".$cateid[$i]);	
	}
	message('分类排序修改成功！', 'admin.php?m=categories&a=catelist');
}
if($a == 'cateedit') {
	$catedb = array();
	$sql = "select id as cateid,catename,cateurl,cateorder from ".$tablepre."categories order by id desc";
	$query = $db->query($sql);
	while($cate = $db->fetch_array($query)) {
		$catedb[] = $cate;
	}
	$category = array();
	$cateid = intval($_GET['cateid']);
	$sql = "select id as cateid,catename,cateurl,cateorder from ".$tablepre."categories where id = ".$cateid;
	$query = $db->query($sql);
	$category = $db->fetch_array($query);	
}	
if($a == 'catesave') {
	$catename = char($_POST['catename']);
	$cateurl = char($_POST['cateurl']);
	$cateorder  = char($_POST['cateorder']);
	
	if(trim($cateurl) != '') {
		$sql = "select id from ".$tablepre."categories where cateurl = '$cateurl'";
		$query = $db->query($sql);
		if($db->num_rows($query) > 0){
			message('自定义链接名已经存在，请重新选择一个！', 'javascript:history.back();');
		}
	}
	
	if($catename == '') {
		message('分类名不能为空！', 'admin.php?m=categories&a=catelist');
	} elseif(strlen($catename) > 20) {
		message('分类名称不能超过20个字符！', 'admin.php?m=categories&a=catelist');
	} else {
		$db->query("insert into ".$tablepre."categories (catename,cateurl,cateorder) values ('$catename','$cateurl','$cateorder')");
		categories_recache();
		statistics_recache();
		message('分类添加成功！', 'admin.php?m=categories&a=catelist');
	}
}
if($a == 'cateeditsave') {
	$cateid = intval($_POST['cateid']);
	$catename = char($_POST['catename']);
	$cateurl = char($_POST['cateurl']);
	$cateorder = char($_POST['cateorder']);
	
	if(trim($cateurl) != ''){
		$sql = "select id from ".$tablepre."categories where cateurl = '$cateurl' and id <> ".$cateid;
		$query = $db->query($sql);
		if($db->num_rows($query) > 0) {
			message('自定义链接名已经存在，请重新选择一个！', 'admin.php?m=categories&a=cateedit&cateid='.$cateid);
		}
	}
	
	if($catename == '') {
		message('分类名不能为空！', 'admin.php?m=categories&a=cateadd');
	} else {
		$db->query("update ".$tablepre."categories set catename='$catename',cateurl='$cateurl',cateorder='$cateorder' where id=".$cateid);
		$db->query("update ".$tablepre."articles set catename='$catename',cateurl='$cateurl' where cateid = ".$cateid);
		categories_recache();
		message('分类修改成功！', 'admin.php?m=categories&a=catelist');
	}
}
if($a == 'catedel') {
	$cateid = $_GET['cateid'];
 	$sql = "delete from ".$tablepre."categories where id = ".$cateid;
 	$db->query($sql);
 	$sql = "delete from ".$tablepre."articles where cateid = ".$cateid;
 	$db->query($sql);
	calendar_recache();
	archives_recache();
	categories_recache();
	recentart_recache();
	statistics_recache();
 	echo "<script language=javascript>";
 	echo "this.location.href='admin.php?m=categories&a=catelist';</script>";
}
?>