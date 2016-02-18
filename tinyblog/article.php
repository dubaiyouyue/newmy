<?php
require 'global.php';

$artid = intval($_GET['id']);
$htmlurl = char($_GET['htmlurl']);
if($artid) {
	$where = " id='$artid'";
} elseif ($htmlurl) {
	$where = " htmlurl='$htmlurl'";
} else {
	redirect('缺少参数', 'index.php');
}	
$sql = "select * from ".$tablepre."articles where ".$where;
$article = get_article($sql);
$sql = "update ".$tablepre."articles set viewnum = viewnum + 1 where id=".$article['artid'];
$db->query($sql);
$blog_title = $article['title'].' - '.$options['blog_title'];
$keywords = $article['keywords'] != '' ? $article['keywords'] : $article['title'];	
$commentdb = array();

$pur_page = $options['articlecommentsnum'];
$maxshowpage = 4;
$curr_page = intval(isset($_GET['page']) ? $_GET['page'] : '');
if(!empty($curr_page)) {
	$start_limit = ($curr_page - 1) * $pur_page;
} else {
	$start_limit = 0;
	$curr_page = 1;
}
$sql = "select id from ".$tablepre."comments where artid=".$article['artid']." and status='approved'";
$total = $db->num_rows($db->query($sql));
if($total > 0) {
	if($total > 0) {
		$sql = "select * from ".$tablepre."comments where artid=".$article['artid']." and status='approved' order by id limit ".$start_limit.",".$pur_page;
		$commentdb = get_comments($sql);
	}
	$pageurl = get_artpageurl($article['artid'], $article['htmlurl']);
	if($options['ishtml'] == 1) {
		$page = htmlpage($pur_page, $curr_page, $pageurl.'/', $maxshowpage, $total);
	} else {
		$page = multipage($pur_page, $curr_page, 'article.php?id='.$article['artid'].'&', $maxshowpage, $total);
	}
}

if($options['show_relate']) {
	if($article['tags'] != '') {
		$relate_artdb = get_relate_art($article['tags']);
	}
}

$mtime = explode(' ', microtime());
$totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);

include template('article', $templatename);

function get_relate_art($tag_arr) {
	global $db, $tablepre, $options;
	$i = 0;
	$relate_artid_arr = array();
	foreach($tag_arr as $tag) {
		if($tag['tagname'] != '') {
			$relate = $db->query("select artid from ".$tablepre."tags where tag = '$tag[tagname]'");
			while($relate_rows = $db->fetch_array($relate)) {
				if(!in_array($relate_rows['artid'], $relate_artid_arr)) {
					$relate_artid_arr[] = $relate_rows['artid'];
				}
			}
		}
	}
	$relate_artdb = array();
	$relate_art = array();
	foreach($relate_artid_arr as $relate_artid) {
		if($i < $options['relatenum']) {
			$relate_sql = "select * from ".$tablepre."articles where id='$relate_artid'";
			$relate_art = get_article($relate_sql);
			$relate_artdb[] = $relate_art;
		}
		$i++;
	}
	return $relate_artdb;
}
?>