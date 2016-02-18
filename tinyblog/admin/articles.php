<?php
if($a == 'artlist') {
	$cateoption = '';
	$sql = "select id,catename from ".$tablepre."categories order by id desc";    
	$query = $db->query($sql);    
	while($option = $db->fetch_array($query)) {  
		$cateoption .= '<option value='.$option['id'].'>';
		$cateoption .= $option['catename'];
		$cateoption .= '</option>';  
	}
	
	$do = $_GET['do'];
	
	$pur_page = 13;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if($page != '') {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$artdb = array();
	$sql = "select id as artid,title,cateid,catename,username,istop,commentnum,tbnum,updatetime from ".$tablepre."articles ";
	if($do == 'search') {
		$keywords = addslashes(isset($_POST['keywords']) ? $_POST['keywords'] : $_GET['keywords']);
		$cateid = addslashes(isset($_POST['cateid']) ? $_POST['cateid'] : $_GET['cateid']);
		if($cateid == 0) {
			$sql .= "where title like '%".$keywords."%' order by istop desc,id desc";
		} else {
			$sql .= "where title like '%".$keywords."%' and cateid = '$cateid' order by istop desc,id desc";
		}
	} else {
		$type = $_GET['type'];
		if($type == 'istop') {
			$sql .= "where istop = 1 order by id desc";
		} else {
			$sql .= "order by id desc";
		}	
	}
	$total = $db->rows_count($sql);
	$sql .= " limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($article = $db->fetch_array($query)) {
		$article['updatetime'] = gmdate("Y-m-d", $article['updatetime'] + $options['timeoffset']*3600);
		$article['istop'] == 1 ? $article['istop'] = '置顶' : $article['istop'] = '无';
		$artdb[] = $article;
	}
	$page = multipage($pur_page, $page, "admin.php?m=articles&a=artlist&do=".$do."&keywords=".$keywords."&cateid=".$cateid."&type=".$type."&", $maxshowpage, $total);
}
if($a == 'artadd') {
	$cateoption = '';
	$sql = "select id,catename from ".$tablepre."categories order by id desc";    
	$query = $db->query($sql);    
	while($option = $db->fetch_array($query)) {  
		$cateoption .= '<option value='.$option['id'].'>';
		$cateoption .= $option['catename'];
		$cateoption .= '</option>';  
	}
	$currenttime = time() + $options['timeoffset']*3600;
	$currenttime = date('Y-m-d-h-i-s', $currenttime);
	$currenttime_arr = explode('-', $currenttime);
	$year = $currenttime_arr['0'];
	$month = $currenttime_arr['1'];
	$day = $currenttime_arr['2'];
	$hour = $currenttime_arr['3'];
	$minute = $currenttime_arr['4'];
	$second = $currenttime_arr['5'];
	unset($currenttime_arr);
	
	$sql = "SHOW TABLE STATUS";
	$query = $db->query($sql);
	$table = $db->fetch_array($query);
	$nextid = $table['Auto_increment'];
	$artid = $nextid;
	$attachment = get_attachment($artid);
	
}
function get_attachment($artid) {
	global $db, $tablepre, $options;
	$sql = "select * from " .$tablepre."attach where artid = ".intval($artid);
	$query = $db->query($sql);
	while($attach = $db->fetch_array($query)) {
		$attach['value'] = "[img]".$options['url'].'/'.$attach['filename']."[/img]";
		$attachment[] = $attach;
	}
	return $attachment;
}
if($a == 'artsave') {
    $title = char($_POST['title']);
    $cateid = intval($_POST['cateid']);
	$sqlcate = "select id,catename,cateurl from ".$tablepre."categories where id=".$cateid;
	$query = $db->query($sqlcate);
	$cate = $db->fetch_array($query);
	$catename = $cate['catename'];
	$cateurl = $cate['cateurl'];

 	$istop = intval($_POST['istop']);
 	$tags = char($_POST['tags']);
	$htmlurl = char($_POST['htmlurl']);
 	$abstract = addslashes($_POST['abstract']);
 	$content = addslashes($_POST['content']);
	$ischangetime = intval($_POST['ischangetime']);
	if($ischangetime) {
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$hour = $_POST['hour'];
		$minute = $_POST['minute'];
		$second = $_POST['second'];
		$updatetime = mktime($hour, $minute, $second, $month, $day, $year);
		$updatetime -= $options['timeoffset']*3600;
	} else {
		$updatetime = time();
	}
 	$trackback = char($_POST['trackback']);
	$attachurl = char($_POST['attachurl']);
	
	if(trim($htmlurl) != '') {
		$sql = "select id from ".$tablepre."articles where htmlurl = '$htmlurl'";
		$query = $db->query($sql);
		if($db->num_rows($query) > 0){
			message('自定义链接名已经存在，请重新选择一个！', 'javascript:history.back();');
		}
	}
 	if($title == '') {
		message('标题不能为空', 'javascript:history.back();');
 	} elseif ($cateid == '') {
		message('分类不能为空', 'javascript:history.back();');
	} elseif ($content == '') {
		message('内容不能为空', 'javascript:history.back();');
	} else {
 		$sql = "insert into ".$tablepre."articles (istop,cateid,catename,cateurl,username,title,htmlurl,abstract,content,tags,commentnum,tbnum,viewnum,updatetime) values ('$istop','$cateid','$catename','$cateurl','$username','$title','$htmlurl','$abstract','$content','$tags','0','0','0','$updatetime')";
 		$db->query($sql);
 		$artid = $db->insert_id();
 	}
	if(trim($tags) != '') {
		$tags = trim($tags);
		$tag_arr = explode(',', $tags);
		foreach($tag_arr as $tag) {
			if(trim($tag) != '') {
				$tag = addslashes($tag);
				$sql  = "insert into ".$tablepre."tags (tag,artid) values ('$tag','$artid')";
				$db->query($sql);
			}
		}
	}
	if($trackback != '') {
		$pingurl = $trackback;
		$title = $title;
		$url = $options['url'];
		$blog_name = $options['blog_title'];
		if($abstract == '') {
			$excerpt = substr($content,0,255);
		} else {
			$excerpt = $abstract;
		}
		$data = 'url='.rawurlencode($url).'&title='.rawurlencode($title).'&blog_name='.rawurlencode($blog_name).'&excerpt='.rawurlencode($excerpt);
		$result = sendtrackback($pingurl, $data);
		if(strpos($result, 'error>1</error')) {
			$sendpacketmsg = '发送 Trackback 失败';
  		} else {
			$sendpacketmsg = '发送 Trackback 成功';
		} 
			echo $sendpacketmsg;
	}
	calendar_recache();
	archives_recache();
	statistics_recache();
	recentart_recache();
	categories_recache();

	message('发布文章成功！', 'admin.php?m=articles&a=artlist');
}
if($a == 'artedit') {
	$currenttime = time() + $options['timeoffset']*3600;
	$currenttime = date('Y-m-d-H-i-s', $currenttime);
	$currenttime_arr = explode('-', $currenttime);
	$year = $currenttime_arr['0'];
	$month = $currenttime_arr['1'];
	$day = $currenttime_arr['2'];
	$hour = $currenttime_arr['3'];
	$minute = $currenttime_arr['4'];
	$second = $currenttime_arr['5'];
	unset($currenttime_arr);
	$artid = intval($_GET['artid']);
    $sql = "select id as artid,istop,cateid,catename,title,htmlurl,abstract,content,tags,commentnum,tbnum,viewnum,updatetime from ".$tablepre."articles where id=".$artid;
    $query = $db->query($sql);
    $article = $db->fetch_array($query);
	$attachment = get_attachment($artid);
	
	$sql = "select * from ".$tablepre."categories order by id desc";
    $query = $db->query($sql);
	$cateoption = '';
    while($cate = $db->fetch_array($query)) {
		if($article['cateid'] == $cate['id']) {
			$cateoption .= '<option value='.$cate['id'].' selected>';
		}else{
			$cateoption .= '<option value='.$cate['id'].'>';
		}
		$cateoption .= $cate['catename'];
		$cateoption .= '</option>'; 
    }
}
if($a == 'arteditsave') {
	$artid = intval($_POST['artid']);
    $title = char($_POST['title']);
    $cateid = intval($_POST['cateid']);
	$sql = "select * from ".$tablepre."categories where id=".$cateid;
	$query = $db->query($sql);
	$cate = $db->fetch_array($query);
	$catename = $cate['catename'];
	$cateurl = $cate['cateurl'];
 	$istop = intval($_POST['istop']);
 	$tags = char($_POST['tags']);
	$htmlurl = char($_POST['htmlurl']);
 	$abstract = addslashes($_POST['abstract']);
 	$content = addslashes($_POST['content']);
 	$ischangetime = intval($_POST['ischangetime']);
	if($ischangetime) {
		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];
		$hour = $_POST['hour'];
		$minute = $_POST['minute'];
		$second = $_POST['second'];
		$updatetime = mktime($hour, $minute, $second, $month, $day, $year);
		$updatetime -= $options['timeoffset']*3600;
	} else {
		$updatetime = $_POST['updatetime'];
	}
 	$trackback = char($_POST['trackback']);
	if(trim($htmlurl) != ''){
		$sql = "select id from ".$tablepre."articles where htmlurl = '$htmlurl' and id <> ".$artid;
		$query = $db->query($sql);
		if($db->num_rows($query) > 0) {
			message('自定义链接名已经存在，请重新选择一个！', 'admin.php?m=articles&a=artedit&artid='.$artid);
		}
	}
 	if($title == '') {
		message('标题不能为空', 'javascript:history.back();');
 	} elseif ($cateid == '') {
		message('分类不能为空', 'javascript:history.back();');
	} elseif ($content == '') {
		message('内容不能为空', 'javascript:history.back();');
	} else {
		$sql = "delete from ".$tablepre."tags where artid=".$artid;
 		$db->query($sql);
		if(trim($tags) != '') {
			$tagsarr = explode(',',$tags);
 			$tagsnum = count($tagsarr);
 			for($i = 0; $i < $tagsnum; $i++){
				$tag = addslashes($tagsarr[$i]);
  				$sql = "insert into ".$tablepre."tags (tag,artid) values ('$tag','$artid')";
  				$db->query($sql);
 			}
		}
		$sql = "update ".$tablepre."articles set istop='$istop',cateid='$cateid',catename='$catename',cateurl='$cateurl',username='$username',title='$title',htmlurl='$htmlurl',abstract='$abstract',content='$content',tags='$tags',updatetime='$updatetime' where id=".$artid;
 		$db->query($sql);
 	}
	calendar_recache();
	archives_recache();
	recentart_recache();
	categories_recache();
	message('文章修改成功！', 'admin.php?m=articles&a=artlist');
}
if($a == 'operator') {
	$action = $_POST['action'];
	if($action == 'delete') {
 		$artid = $_POST['artid'];
 		if (empty($_POST['artid']) || !is_array($_POST['artid'])) {
        	message('请选中要操作的文章！', 'admin.php?m=articles&a=artlist');
    	} else {
   			foreach($artid as $articleid=>$value) {
       			$db->query("delete from ".$tablepre."articles where id='".intval($articleid)."'");
	   			$db->query("delete from ".$tablepre."tags where artid='".intval($articleid)."'");
				$db->query("delete from ".$tablepre."comments where artid='".intval($articleid)."'");
   			}
			calendar_recache();
			archives_recache();
			recentart_recache();
			statistics_recache();
			categories_recache();
			message('已经删除选中的文章！', 'admin.php?m=articles&a=artlist');
 		}
	}
	if($action == 'deleteall') {
		$db->query("delete from ".$tablepre."articles where 1");
		calendar_recache();
		archives_recache();
		recentart_recache();
		statistics_recache();
		categories_recache();
		message('文章数据表已经清空！','admin.php?m=articles&a=artlist');
	}
	if($action == 'settop') {
 		$artid = $_POST['artid'];
 		if (empty($_POST['artid']) or !is_array($_POST['artid'])) {
			message('请选中要操作的文章！', 'admin.php?m=articles&a=artlist');
    	} else {
   			foreach($artid as $articleid=>$value) {
       			$db->query("update ".$tablepre."articles set istop=1 where id='".intval($articleid)."'");
   			}
			message('文章置顶成功！', 'admin.php?m=articles&a=artlist');
 		}
	}
	if($action == 'nosettop') {
 		$artid = $_POST['artid'];
 		if (empty($_POST['artid']) or !is_array($_POST['artid'])) {
        	message('请选中要操作的文章！', 'admin.php?m=articles&a=artlist');
    	} else {
   			foreach($artid as $articleid=>$value) {
       			$db->query("update ".$tablepre."articles set istop = 0 where id='".intval($articleid)."'");
   			}
			message('取消置顶成功！', 'admin.php?m=articles&a=artlist');
 		}
	}
	if($action == 'move') {
		$cateoption = $artidstr = '';
		$sql = "select * from ".$tablepre."categories order by id desc";
    	$result = $db->query($sql); 
    	while($rows = $db->fetch_array($result)) {
			$cateoption .= '<option value='.$rows['id'].'>';
			$cateoption .= $rows['catename'];
			$cateoption .= '</option>'; 
    	}
	
		$artid = $_POST['artid'];
	
		foreach($artid as $articleid=>$value) {
			$artidstr .= $articleid.",";	
		}
 		if (empty($_POST['artid']) or !is_array($_POST['artid'])) {
        	message('请选中要操作的文章！', 'admin.php?m=articles&a=artlist');
    	}
	}
	if($action == 'moveart') {
		$artidstr = $_POST['artidstr'];
		$artidarr = explode(',',$artidstr);
		$cateid = $_POST['cateid'];
		$query = $db->query("select catename,cateurl from ".$tablepre."categories where id=".$cateid);
		$cate = $db->fetch_array($query);
		$catename = $cate['catename'];
		foreach($artidarr as $artidvalue) {
       		$db->query("update ".$tablepre."articles set cateid='$cateid',catename='$catename',cateurl='$cateurl' where id='".intval($artidvalue)."'");
		}
		recentart_recache();
		categories_recache();
		message('文章移动成功！', 'admin.php?m=articles&a=artlist');	
	}
}
if($a == 'delAttach') {
	$id = intval($_POST['id']);
	$db->query("delete from ".$tablepre."attach where id='".intval($id)."'");
}
?>