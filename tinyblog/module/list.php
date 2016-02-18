<?php
$articledb = array();
$pur_page = $artshownum;
$maxshowpage = 4;
$curr_page = intval(isset($_GET['page']) ? $_GET['page'] : '');
if($curr_page) {
	$start_limit = ($curr_page - 1) * $pur_page;
} else {
	$start_limit = 0;
	$curr_page = 1;
}
if($action == '') {
	$total = $statisticscache['artnum'];
	$sql = "select * from ".$tablepre."articles order by istop desc,id desc limit ".$start_limit.",".$pur_page;
	$articledb = get_articles($sql);
	if($options['ishtml'] == 1) {
		$page = htmlpage_index($pur_page, $curr_page, $options['url'].'/', $maxshowpage, $total);
	} else {
		$page = multipage($pur_page, $curr_page, 'index.php?', $maxshowpage, $total);
	}
} elseif($action == 'category') {
	$cateid = intval(isset($_GET['cateid']) ? $_GET['cateid'] : '');
	$cateurl = char($_GET['cateurl']);
	if($cateid) {
		$where = " id='$cateid'";
	} elseif ($cateurl) {
		$where = " cateurl='$cateurl' limit 1";
	} else {
		redirect('缺少参数', 'index.php');
	}
	$sql = "select id,catename from ".$tablepre."categories where".$where;	
	$query = $db->query($sql);
	$cate = $db->fetch_array($query);
	if(!$cate) {
		redirect('此分类不存在!', $options['url'].'/index.php');
	}
	$cateid = $cate['id'];
	$catename = $cate['catename'];
	$keywords = $description = $blog_title = $catename.' - '.$options['blog_title'];
	$query = $db->query("select id from ".$tablepre."articles where cateid = ".$cateid);
	$total = $db->num_rows($query);
	$sql = "select * from ".$tablepre."articles where cateid = ".$cateid." order by istop desc,id desc limit ".$start_limit.",".$pur_page;
	$articledb = get_articles($sql);
	if($options['ishtml'] == 1) {
		if($cateurl == '') {
			$page = htmlpage($pur_page, $curr_page, $options['url'].'/'.$options['catedir'].'/'.$cateid.'/', $maxshowpage, $total);
		} else {
			$page = htmlpage($pur_page, $curr_page, $options['url'].'/'.$options['catedir'].'/'.$cateurl.'/', $maxshowpage, $total);
		}
	} else {
		$page = multipage($pur_page, $curr_page, 'index.php?action=category&cateid='.$cateid.'&', $maxshowpage, $total);
	}
} elseif($action == 'search') {
	$keywords = isset($_POST['keywords']) ? $_POST['keywords'] : $_GET['keywords'];
	$keywords = char($keywords);
	$total = $db->rows_count("select id from ".$tablepre."articles where title like '%".$keywords."%' or content like '%".$keywords."%'");
	if($total > 0) {
		$sql = "select * from ".$tablepre."articles where title like '%".$keywords."%' or content like '%".$keywords."%' order by istop desc,id desc limit ".$start_limit.",".$pur_page;
		$articledb = get_articles($sql);
		$page = multipage($pur_page, $curr_page, 'index.php?action=search&keywords='.$keywords.'&', $maxshowpage, $total);
	} else {
		redirect('没有您搜索的结果，请选择关键词重新搜索!', $options['url'].'/index.php');
	}
} elseif($action == 'times') {
	$y = char($_GET['y']);
   	$m = char($_GET['m']);
   	$d = char($_GET['d']);
	$monthdaynum = gmdate('t', mktime(0, 0, 0, $m, 1, $y));
	if($d == '') {
		$start_time = mktime(0, 0, 0, $m, 1, $y);
		$end_time = $start_time + $monthdaynum * 24 * 3600;
	} else {
		$start_time = mktime(0, 0, 0, $m, $d, $y);
		$end_time = $start_time + 24 * 3600;
	}
	$sql = "select id from ".$tablepre."articles where updatetime>='".$start_time."' and updatetime<='".$end_time."'";
   	$query = $db->query($sql);
	$total = $db->num_rows($query);
	if($total) {
		$sql = "select * from ".$tablepre."articles where updatetime>='".$start_time."' and updatetime<='".$end_time."' order by istop desc,id desc limit ".$start_limit.",".$pur_page;
		$articledb = get_articles($sql);
		if($options['ishtml']) {
			if($d != '') {
				$page = htmlpage($pur_page, $curr_page, $options['url'].'/times/'.$y.'/'.$m.'/'.$d.'/page/', $maxshowpage, $total);
			} else {
				$page = htmlpage($pur_page, $curr_page, $options['url'].'/times/'.$y.'/'.$m.'/page/', $maxshowpage, $total);
			}
		} else {
			$page = multipage($pur_page, $curr_page, 'index.php?action=times&y='.$y.'&m='.$m.'&d='.$d.'&', $maxshowpage, $total);
		}
	}
} elseif($action == 'tags') {
	$tagname = char(isset($_GET['tagname']) ? $_GET['tagname'] : '');
	$blog_title = $tagname.' - '.$options['blog_title'];
	$sql = "select artid from ".$tablepre."tags where tag='".$tagname."'";
   	$total = $db->rows_count($sql);
	$query = $db->query($sql);
	while ($article = $db->fetch_array($query)) {
		$artid = intval($article['artid']);
		$artid_arr[] = $artid;
	}
	$artid_str = implode(',', $artid_arr);
	$sql = "select * from ".$tablepre."articles where id in ($artid_str) limit ".$start_limit.",".$pur_page;
	$articledb = get_articles($sql);
	if($options['ishtml'] == 1) {
		$tagname = urlencode($tagname);
		$page = htmlpage($pur_page, $curr_page, $options['url'].'/tag/'.$tagname.'/', $maxshowpage, $total);
	} else {
		$page = multipage($pur_page, $curr_page, 'index.php?action=tags&tagname='.$tagname.'&', $maxshowpage, $total);
	}
}
?>