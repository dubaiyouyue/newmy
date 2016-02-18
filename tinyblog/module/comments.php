<?php
$blog_title = '评论'.' - '.$options['blog_title'];
$tbdb = array();
$pur_page = 10;
$maxshowpage = 10;
$curr_page = intval(isset($_GET['page']) ? $_GET['page'] : '');
if($curr_page) {
	$start_limit = ($curr_page - 1) * $pur_page;
} else {
	$start_limit = 0;
	$curr_page = 1;
}
$sql = "select id from ".$tablepre."comments where status='approved'";
$total = $db->num_rows($db->query($sql));
if($total > 0) {
	$sql = "select c.id as commentid,c.artid,c.username,c.homepage,c.content,c.commenttime,a.title as arttitle,a.htmlurl from ".$tablepre."comments c left join ".$tablepre."articles a on c.artid=a.id where c.status='approved' order by c.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($comment = $db->fetch_array($query)) {
		$comment['commenttime'] = gmdate($options['commentdateformat'], $comment['commenttime'] + $options['timeoffset']*3600);
		$comment['artpageurl'] = get_artpageurl($comment['artid'], $comment['htmlurl']);
		$comment['content'] = ubb($comment['content']);
		$commentdb[] = $comment;
	}
	if($options['ishtml'] == 1) {
		$page= htmlpage($pur_page, $curr_page, $options['url'].'/module/comments/', $maxshowpage, $total);
	} else {
		$page= multipage($pur_page, $curr_page, '?module=comments&', $maxshowpage, $total);
	}
}
?>