<?php
if($a == 'tblist') {
	$pur_page = 15;
	$maxshowpage = 10;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if(!empty($page)) {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$total = $statisticscache['tbnum'];
	$tbdb = array();
	$sql = "select t.id as tbid,t.url,t.title,t.blogname,t.excerpt,t.artid,t.ipaddress,t.updatetime,a.title as arttitle,a.cateid,a.cateurl,a.htmlurl from ".$tablepre."trackbacks t left join ".$tablepre."articles a on t.artid=a.id order by t.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($tb = $db->fetch_array($query)) {
		$tb['updatetime'] = gmdate('Y-m-d H:i:s', $tb['updatetime'] + $options['timeoffset']*3600);
		$html_url = get_html_url($tb['cateid'], $tb['cateurl'], $tb['artid'], $tb['htmlurl']);
		$tb['artpageurl'] = $html_url['pageurl'];
		$tb['excerpt'] = ubb($tb['excerpt']);
		$tbdb[] = $tb;
	}
	$page= multipage($pur_page, $page, '?module=trackbacks&', $maxshowpage, $total);
}
if($a == 'operator') {
	$action = $_POST['action'];
	if($action == 'delete') {
		$tbid = $_POST['tbid'];
		$artid = $_POST['artid'];
		if(empty($_POST['tbid']) or !is_array($_POST['tbid'])) {
			message('请选中要删除的引用！', 'admin.php?m=trackbacks&a=tblist');
		} else {
			foreach($tbid as $tbid=>$value) {
				$db->query("delete from ".$tablepre."trackbacks where id='".intval($tbid)."'");
			}
			foreach($artid as $artid=>$value) {
				$strsql = "select id from ".$tablepre."trackbacks where artid=".$artid;
				$tbnum = $db->num_rows($db->query($strsql));
				$db->query("update ".$tablepre."articles set tbnum='".$tbnum."' where id=".$artid);	
			}
			statistics_recache();
			echo "<script>location.href='admin.php?m=trackbacks&a=tblist';</script>";
		}
	}
	if($action == 'deleteall') {
		$db->query("delete from ".$tablepre."trackbacks where 1");
		$db->query("update ".$tablepre."articles set tbnum = 0 where 1");
		statistics_recache();
		message('引用数据表已经清空！', 'admin.php?m=trackbacks&a=tblist');
	}
}
?>