<?php
$blog_title = '链接'.' - '.$options['blog_title'];
$linkdb = array();
$pur_page = $options['linknum'];
$maxshowpage = 10;
$curr_page = intval(isset($_GET['page']) ? $_GET['page'] : '');
if($curr_page) {
	$start_limit = ($curr_page - 1) * $pur_page;
} else {
	$start_limit = 0;
	$curr_page = 1;
}
$total = $statisticscache['linknum'];
if($total > 0) {
	$sql = "select * from ".$tablepre."links order by linkorder desc,id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($link = $db->fetch_array($query)) {
		$link['linkid'] = $link['id'];
		$link['updatetime'] = gmdate("Y-m-d H:i:s", $link['updatetime'] + $options['timeoffset']*3600);
		$linkdb[] = $link;
	}
	if($options['ishtml'] == 1) {
		$page= htmlpage($pur_page, $curr_page, $options['url'].'/module/links/', $maxshowpage, $total);
	} else {
		$page = multipage($pur_page, $curr_page, '?module=links&', $maxshowpage, $total);
	}
}
?>