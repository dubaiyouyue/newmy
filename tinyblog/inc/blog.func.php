<?php
function calendar() {
	global $options;
	require TBS_ROOT.'cache/cache_calendar.php';
	$datesarr = array();
	$datesarr = $calendarcache;
	$calendar = '';

	//先判断是否指定了一个年份和月份，没有则根据当前的年和月份显示
	$reqdate = isset($_GET['reqdate']) ? $_GET['reqdate'] : ''; 
	if($reqdate == '') { 
		$pyear = gmdate("Y"); 
		$pmonth = gmdate("m"); 
		$currentdate = gmdate("Y-m-d"); 
	} else { 
		$reqdatestrs = explode("-",$reqdate ); 
		$pyear = $reqdatestrs['0']; 
		$pmonth = $reqdatestrs['1']; 
		$currentdate = $reqdate; 
	} 
 	//生成日历显示的表格头内容 
	$prem = gmdate("Y-m-d", mktime(0, 0, 0, $pmonth - 1, 1, $pyear) + $options['timeoffset'] * 3600);
	$nextm = gmdate("Y-m-d", mktime(0, 0, 0, $pmonth + 1, 1, $pyear) + $options['timeoffset'] * 3600);
 
	//获得要显示月份的第一天为周几 
	$nunmonthstart = gmdate('w', mktime(0, 0, 0, $pmonth, 1, $pyear) + $options['timeoffset'] * 3600); 
	//获得要显示月份一共有多少天 
	$nunmonthend = gmdate('t', mktime(0, 0, 0, $pmonth, 1, $pyear) + $options['timeoffset'] * 3600); 
	//判断显示日历需要用几行表格来显示（每行显示7天） 
	if($nunmonthstart + $nunmonthend < 36) { 
		$maxi = 36; 
	} else { 
		$maxi = 43; 
	} 
	//循环生成表格并显示 
	for($i = 1; $i < $maxi; $i++ ) {
		$iv = $i - $nunmonthstart; 
		if($iv < 10) {
			$iv = '0'.$iv;
		}
		if($i > $nunmonthstart && $i <= $nunmonthend + $nunmonthstart) { 
			$datetmp = $pyear.'-'.$pmonth.'-'.$iv;
			if(in_array($datetmp, $datesarr)) {
				if($options['ishtml']) {
					$calendar .= "<td class=\"linkdate\" align=center><a href=".$options['url']."/times/".$pyear."/".$pmonth."/".$iv.">".$iv."</a></td>";
				} else {
					$calendar .= "<td class=\"linkdate\" align=center><a href=".$options['url']."/index.php?action=times&y=".$pyear."&m=".$pmonth."&d=".$iv.">".$iv."</a></td>";
				}
			} elseif($iv == gmdate('d') && gmdate('m') == $pmonth && gmdate('Y') == $pyear) { 
				$calendar .= "<td class=\"currentdate\">".$iv."</td>"; 
			} else { 
				$calendar .= "<td class=\"otherdate\">".$iv."</td>"; 
			} 
		} else { 
    		$calendar .= "<td> </td>";  
		} 
 
		//如果能被7整除（每行显示7个）则输出一个换行 
		if($maxi == 36) {
			if($i % 7 == 0 && $i != 35) { 
				$calendar .= "</tr><tr align=center height=19>"; 
			}
		} elseif($maxi == 43) {
			if($i % 7 == 0 && $i != 42) { 
				$calendar .= "</tr><tr align=center height=19>"; 
			}
		}
	} 

	$calendar_arr = array();
	$calendar_arr['prem'] = $prem;
	$calendar_arr['nextm'] = $nextm;
	$calendar_arr['currentdate'] = $currentdate;
	$calendar_arr['calendar'] = $calendar;
	return $calendar_arr;
}
function highlight_tag($content, $tag, $url) {
	global $options;
	$tag = trim($tag);
	$content = preg_replace('/>([^<]*)'.$tag.'([^>]*)<([^>]*)([^a])>/i','>$1<a href="'."javascript:".'" tips="'.$tag.'" onclick=tagshow(this,"'.$url.'");return false;>'.htmlspecialchars($tag).'</a>$2<$3$4>',$content,1); 
	return $content;
}
function get_article($sql) {
	global $db, $tablepre, $options;
	$article = array();
	$query = $db->query($sql);
	$article = $db->fetch_array($query);
	if(!$article) {
		redirect('此文章不存在!', $options['url'].'/index.php');
	}
	$artid = $article['id'];
  	$article['artid'] = $article['id'];

	$html_url = get_html_url($article['cateid'], $article['cateurl'], $article['artid'], $article['htmlurl']);
	$article['cateurl'] = $html_url['cateurl'];
	$article['pageurl'] = $html_url['pageurl'];
	
	if(trim($article['tags']) != '') {
		$tag_arr = get_tag_arr($article['tags']);
		$article['tags'] = $tag_arr;
	}
	
	$article['content'] = ubb($article['content']);
  	$article['updatetime'] = gmdate($options['articledateformat'], $article['updatetime'] + $options['timeoffset'] * 3600);
	
	$article['commentsubmiturl'] = $options['url'].'/post.php?a=commentpost';
	$article['checknumberurl'] = $options['url'].'/checknumber.php?a=shownumber';
	if($options['show_pre_next']) {
		$lastarticle = get_lastarticle($artid);
		$article['lastartrow'] = $lastarticle['lastartrow'];
		$article['lasttitle'] = $lastarticle['lasttitle'];
		$article['lastpageurl'] = $lastarticle['lastpageurl'];
		$nextarticle = get_nextarticle($artid);
		$article['nextartrow'] = $nextarticle['nextartrow'];
		$article['nexttitle'] = $nextarticle['nexttitle'];
		$article['nextpageurl'] = $nextarticle['nextpageurl'];
	}
	$article['tburl'] = $options['url'].'/trackback.php?tbid='.$artid;
			
	$articledb = $article;
	return $articledb;

}
function get_articles($sql) {
	global $db, $tablepre, $options;
	$query = $db->query($sql);
	while($article = $db->fetch_array($query)) {
		$artid = $article['id'];
  		$article['artid'] = $article['id'];
		
		$html_url = get_html_url($article['cateid'], $article['cateurl'], $article['artid'], $article['htmlurl']);
		$article['cateurl'] = $html_url['cateurl'];
		$article['pageurl'] = $html_url['pageurl'];
		
		$article['contentshow'] = ($article['abstract'] == '') ? $article['contentshow'] = ubb($article['content']) : $article['contentshow'] = ubb($article['abstract']);
		
		if(trim($article['tags']) != '') {
			$tag_arr = get_tag_arr($article['tags']);
			$article['tags'] = $tag_arr;
		}
		
  		$article['updatetime'] = gmdate($options['articledateformat'], $article['updatetime']+$options['timeoffset']*3600);

		$articledb[] = $article;
		
	}
	return $articledb;
}
function get_lastarticle($artid) {
	global $db, $tablepre, $options;
	$lastartsql = "select id,title,cateid,htmlurl,commentnum from ".$tablepre."articles where id>".$artid." limit 0,1";
	$lastartresult = $db->query($lastartsql);
	$lastartrow = $db->fetch_array($lastartresult);
	$lastarticle['lastartrow'] = $lastartrow;
	if($lastartrow) {
		$lastartid = $lastartrow['id'];
		$lastarticle['lasttitle'] = $lastartrow['title'];
		$lastcateid = $lastartrow['cateid'];
		$htmlurl = $lastartrow['htmlurl'];
		$lastarticle['lastpageurl'] = get_artpageurl($lastartid, $htmlurl);
	}
	return $lastarticle;
}
function get_nextarticle($artid) {
	global $db, $tablepre, $options;
	$nextartsql = "select id,title,cateid,htmlurl,commentnum from ".$tablepre."articles where id<".$artid." order by id desc limit 0,1";
	$nextartresult = $db->query($nextartsql);
	$nextartrow = $db->fetch_array($nextartresult);
	$nextarticle['nextartrow'] = $nextartrow;
	if($nextartrow) {
		$nextartid = $nextartrow['id'];
		$nextarticle['nexttitle'] = $nextartrow['title'];
		$nextcateid = $nextartrow['cateid'];
		$htmlurl = $nextartrow['htmlurl'];
		$nextarticle['nextpageurl'] = get_artpageurl($nextartid, $htmlurl);
	}
	return $nextarticle;
}
function get_comments($sql) {
	global $db, $options;
	$query = $db->query($sql);
  	while ($comment = $db->fetch_array($query)) {
		$comment['commenttime'] = gmdate($options['commentdateformat'], $comment['commenttime'] + $options['timeoffset'] * 3600);
		$comment['content'] = ubb($comment['content']);
		$commentdb[] = $comment;
   	}
	return $commentdb;
}
function get_tag_arr($tagstr) {
	global $options;
	$tag_arr_tmp = explode(',', trim($tagstr));
	foreach($tag_arr_tmp as $tag) {
		$tag = trim($tag);
		if($tag != '') {
			$tags['tagname'] = $tag;
			if($options['ishtml']) {
				$tags['tagurl'] = $options['url'].'/tag/'.urlencode($tag);
			} else {
				$tags['tagurl'] = $options['url'].'/index.php?action=tags&tagname='.urlencode($tag);
			}
		}
		$tag_arr[] = $tags;
	}
	return $tag_arr;
}
?>