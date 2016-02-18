<?php
$blog_title = '引用'.' - '.$options['blog_title'];
$tbdb = array();
$pur_page = $options['tbnum'];
$maxshowpage = 10;
$curr_page = intval(isset($_GET['page']) ? $_GET['page'] : '');
if($curr_page) {
	$start_limit = ($curr_page - 1) * $pur_page;
} else {
	$start_limit = 0;
	$curr_page = 1;
}
$total = $statisticscache['tbnum'];
/*
if($total > 0) {
	$sql = "select * from ".$tablepre."trackbacks order by  id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($tb = $db->fetch_array($query)) {
		$tb['tbid'] = $tb['id'];
		$tb['updatetime'] = gmdate($options['tbdatefromat'], $tb['updatetime'] + $options['timeoffset']*3600);
		$artid = $tb['artid'];
		$artsql = "select id,title,htmlurl from ".$tablepre."articles where id=".$artid;
		$artresult = $db->query($artsql);
		$artrow = $db->fetch_array($artresult);
		$tb['arttitle']	= $artrow['title'];
		$htmlurl = $artrow['htmlurl'];
		if($options['ishtml'] == 1) {
			if($htmlurl == '') {
				$tb['artpageurl'] = $options['url'].'/archives/'.$artrow['id'];
			} else {
				$tb['artpageurl'] = $options['url'].'/'.$htmlurl;
			}
		} else {
			$tb['artpageurl'] = $options['url'].'/article.php?id='.$artrow['id'];
		}
		$tbdb[] = $tb;
	}
	$page= multipage($pur_page, $curr_page, '?module=trackbacks&', $maxshowpage, $total);
}
*/
if($total > 0) {
	$sql = "select t.id as tbid,t.url,t.title,t.blogname,t.excerpt,t.artid,t.ipaddress,t.updatetime,a.title as arttitle,a.htmlurl from ".$tablepre."trackbacks t left join ".$tablepre."articles a on t.artid=a.id order by t.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($tb = $db->fetch_array($query)) {
		$tb['updatetime'] = gmdate($options['tbdatefromat'], $tb['updatetime'] + $options['timeoffset']*3600);
		$htmlurl = $tb['htmlurl'];
		if($options['ishtml'] == 1) {
			if($htmlurl == '') {
				$tb['artpageurl'] = $options['url'].'/archives/'.$tb['artid'];
			} else {
				$tb['artpageurl'] = $options['url'].'/'.$htmlurl;
			}
		} else {
			$tb['artpageurl'] = $options['url'].'/article.php?id='.$tb['artid'];
		}
		$tbdb[] = $tb;
	}
	if($options['ishtml'] == 1) {
		$page= htmlpage($pur_page, $curr_page, $options['url'].'/module/trackbacks/', $maxshowpage, $total);
	} else {
		$page= multipage($pur_page, $curr_page, '?module=trackbacks&', $maxshowpage, $total);
	}
}
?>