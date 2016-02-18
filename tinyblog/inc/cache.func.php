<?php
//重建日历缓存
function calendar_recache() {
	global $db, $tablepre;
	$date_arr = array();
	$sql = "select updatetime from ".$tablepre."articles";
	$query = $db->query($sql);
	while($calendar = $db->fetch_array($query)) {
		$updatetime = gmdate("Y-m-d", $calendar['updatetime']+$options['timeoffset']*3600);
		if(!in_array($updatetime, $date_arr)) {
			$date_arr[] = $updatetime;
		}
	}
	$contents = "<?php\r\n";
	$contents .= "\$calendarcache = array(\r\n";
	foreach($date_arr as $key => $date) {
		$contents .="\t'".$key."' => '".$date."',\n";
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_calendar.php';
	writetofile($file, $contents);
}
//重建archive缓存
function archives_recache() {
	global $db, $tablepre;
	$date_arr = array();
	$sql = "select updatetime from ".$tablepre."articles";
	$query = $db->query($sql);
	while($archive = $db->fetch_array($query)) {
		$updatetimedb[] = gmdate("Y-m", $archive['updatetime']+$options['timeoffset']*3600);
	}
	$date_arr = array_count_values($updatetimedb);
	unset($updatetimedb);
	$i = 0;
	$contents = "<?php\r\n";
	$contents .= "\$archivecache = array(\r\n";
	foreach($date_arr as $key=>$artnum) {
		list($y, $m) = explode('-', $key);
		$contents .= "\t'".$i."' => array(\n\t\t'y' => '".$y."',\n\t\t'm' => '".$m."',\n\t\t'artnum' => '".$artnum."',\n\t\t),\n";
		$i ++;
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_archives.php';
	writetofile($file, $contents);
}
//重建分类缓存
function categories_recache() {
	global $db, $tablepre, $options;
	$sql = "select * from ".$tablepre."categories order by cateorder desc";
	$query = $db->query($sql);
	$contents = "<?php\r\n";
	$contents .= "\$categroriescache = array(\r\n";
	while($cate = $db->fetch_array($query)) {
		$cateid = $cate['id'];
		$catename = $cate['catename'];
		$cateurl = $cate['cateurl'];
		$cateorder = $cate['cateorder'];
		if($options['ishtml'] == 1) {
			if($cate['cateurl'] == '') {
				$cateurl = $options['url'].'/'.$options['catedir'].'/'.$cateid;
			} else {
				$cateurl = $options['url'].'/'.$options['catedir'].'/'.$cateurl;
			}
		} else {
			$cateurl = $options['url'].'/index.php?action=category&cateid='.$cateid;
		}
		$totalsql = "select id from ".$tablepre."articles where cateid='$cateid'"; 
		$artnum = $db->rows_count($totalsql);
		
		$contents .= "\t'".$cateid."' => array(\n\t\t'cateid' => '".$cateid."',\n\t\t'cateorder' => '".$cateorder."',\n\t\t'catename' => '".$catename."',\n\t\t'artnum' => '".$artnum."',\n\t\t'cateurl' => '".$cateurl."',\n\t\t),\n";
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_categories.php';
	writetofile($file, $contents);
}
//最新文章
function recentart_recache() {
	global $db, $tablepre, $options;
	$query = $db->query("select id as artid, title, cateid, cateurl, htmlurl from ".$tablepre."articles order by id desc limit 0, ".$options['recentarticlelistnum']);
	$contents = "<?php\r\n";
	$contents .= "\$recentartcache = array(\r\n";
	while($article = $db->fetch_array($query)) {
		$article['title'] = addslashes(cutstr($article['title'], $options['recentarticlecharnum'],''));
		
		$html_url = get_html_url($article['cateid'], $article['cateurl'], $article['artid'], $article['htmlurl']);
		$article['pageurl'] = $html_url['pageurl'];
		
		$contents .="\t'".$article['artid']."' => array(\n\t\t'artid' => '".$article['artid']."',\n\t\t'pageurl' => '".$article['pageurl']."',\n\t\t'title' => '".$article['title']."',\n\t\t),\n";
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_recentart.php';
	writetofile($file, $contents);
}
//重建最新评论缓存
function recentcomment_recache() {
	global $db,$tablepre,$options;
	$query = $db->query("select c.id as commentid,c.artid,c.username,c.homepage,c.content,a.title,a.cateid,a.cateurl,a.htmlurl from ".$tablepre."comments c left join ".$tablepre."articles a on c.artid = a.id where c.status = 'approved' order by c.id desc limit 0,".$options['recentarticlelistnum']);
	$contents = "<?php\r\n";
	$contents .= "\$recentcommentcache = array(\r\n";
	while($comment = $db->fetch_array($query)) {
		$commentid = intval($comment['commentid']);
		$artid = intval($comment['artid']);
		$username = char($comment['username']);
		$homepage = char($comment['homepage']);
		$cateid = intval($comment['cateid']);
		$htmlurl = char($comment['htmlurl']);

		$html_url = get_html_url($cateid, $cateurl, $artid, $htmlurl);
		$pageurl = $html_url['pageurl'];
	
		$content = addslashes(cutstr($comment['content'], $options['recentarticlecharnum'],''));
		$contents .= "\t'".$commentid."' => array(\n\t\t'commentid' => '".$commentid."',\n\t\t'artid' => '".$artid."',\n\t\t'username' => '".$username."',\n\t\t'homepage' => '".$homepage."',\n\t\t'pageurl' => '".$pageurl."',\n\t\t'content' => '".$content."',\n\t\t),\n";
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_recentcomment.php';
	writetofile($file, $contents);
}
//链接缓存
function recentlink_recache() {
	global $db, $tablepre, $options;
	$query = $db->query("select id as linkid, webname, url, linkorder from ".$tablepre."links order by linkorder desc limit 0, ".$options['recentlinklistnum']);
	$contents = "<?php\r\n";
	$contents .= "\$recentlinkcache = array(\r\n";
	while($link = $db->fetch_array($query)) {
		$linkid = $link['linkid'];	
		$webname = addslashes(cutstr($link['webname'], $options['recentlinkcharnum'],''));
		$url = $link['url'];
		$contents .="\t'".$linkid."' => array(\n\t\t'linkid' => '".$linkid."',\n\t\t'webname' => '".$webname."',\n\t\t'url' => '".$url."',\n\t\t),\n";
	}
	$contents .= ");\r\n";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_recentlink.php';
	writetofile($file, $contents);
}
//重建统计信息缓存
function statistics_recache() {
	global $db,$tablepre;
	$catenum = $db->rows_count("select id from ".$tablepre."categories");
	$artnum = $db->rows_count("select id from ".$tablepre."articles");
	$commentnum = $db->rows_count("select id from ".$tablepre."comments");
	$linknum = $db->rows_count("select id from ".$tablepre."links");
	$tbnum = $db->rows_count("select id from ".$tablepre."trackbacks");
	$tagnum = $db->rows_count("select id from ".$tablepre."tags");
	$usernum = $db->rows_count("select id from ".$tablepre."users");
	$attachnum = $db->rows_count("select id from ".$tablepre."attach");
	$contents = "<?php\r\n";
	$contents .= "\$statisticscache = array(\r\n";
	$contents .= "\t'catenum' => '".$catenum."',\n\t'artnum' => '".$artnum."',\n\t'commentnum' => '".$commentnum."',\n\t'linknum' => '".$linknum."',\n\t'tbnum' => '".$tbnum."',\n\t'tagnum' => '".$tagnum."',\n\t'usernum' => '".$usernum."',\n\t'attachnum' => '".$attachnum."',\n";
	$contents .= ");";
	$contents .= "?>";
	
	$file = TBS_ROOT.'./cache/cache_statistics.php';
	writetofile($file, $contents);
}
?>