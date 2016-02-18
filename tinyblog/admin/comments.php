<?php
if($a == 'commentlist') {
	$do = $_GET['do'];
	$keywords = char($_POST['keywords']);
	$pur_page = 6;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if(!empty($page)) {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	
	$commentdb = array();
	$sql = "select id from ".$tablepre."comments";
	$all = $db->rows_count($sql);
	$sql = "select id from ".$tablepre."comments where status = 'approved'";
	$approved = $db->rows_count($sql);
	$sql = "select id from ".$tablepre."comments where status = 'waiting'";
	$wating = $db->rows_count($sql);
	
	$sql = "select c.id as commentid,c.artid,c.username,c.homepage,c.content,c.status,c.ipaddress,c.commenttime,a.title as arttitle,a.cateid,a.cateurl,a.htmlurl from ".$tablepre."comments c left join ".$tablepre."articles a on c.artid=a.id ";
		
	if($keywords != '') {
		$sql .= "where c.content like '%".$keywords."%' ";
	} elseif($do == 'approved') {
		$sql .= "where c.status = 'approved' ";
		$approved = $db->rows_count($sql);
	} elseif($do == 'waiting') {
		$sql .= "where c.status = 'waiting' ";
		$wating = $db->rows_count($sql);
	}
	$total = $db->rows_count($sql);
	$sql .= "order by c.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	
	while($comment = $db->fetch_array($query)) {
		$comment['commenttime'] = gmdate("Y-m-d", $comment['commenttime'] + $options['timeoffset'] * 3600);
		$html_url = get_html_url($comment['cateid'], $comment['cateurl'], $comment['artid'], $comment['htmlurl']);
		$comment['artpageurl'] = $html_url['pageurl'];
		$comment['content'] = ubb($comment['content']);
		$commentdb[] = $comment;
	}
	$page = multipage($pur_page, $page, "admin.php?m=comments&a=commentlist&", $maxshowpage, $total);
}
if($a == 'commentedit') {
	$commentid = intval($_GET['id']);
	$sql = "select * from ".$tablepre."comments where id=".$commentid;
	$query = $db->query($sql);
	$comment = $db->fetch_array($query);
}
if($a == 'commenteditsave') {
	$comment = $_POST['comment'];
	$sql = "update ".$tablepre."comments set username='$comment[username]', homepage='$comment[homepage]', content='$comment[content]' where id='$comment[id]'";
	$query = $db->query($sql);
	message('修改成功！', 'admin.php?m=comments&a=commentlist');
}
if($a == 'operator') {
	$action = $_POST['action'];
	if($action == 'approved') {
		$commentid = $_POST['commentid'];
		if(empty($_POST['commentid']) or !is_array($_POST['commentid'])) {
        	echo "<script language=JavaScript>alert('请选中要通过审核的评论！');";
        	echo "javascript:history.go(-1)</script>";
    	} else {
   			foreach($commentid as $commentid=>$value) {
       			$db->query("update ".$tablepre."comments set status='approved' where id='".intval($commentid)."'");
   			}
			recentcomment_recache();
			statistics_recache();
			message('评论已经通过审核！', 'admin.php?m=comments&a=commentlist');
 		}
	}
	if($action == 'wating') {
		$commentid = $_POST['commentid'];
		if(empty($_POST['commentid']) or !is_array($_POST['commentid'])) {
        	echo "<script language=JavaScript>alert('请选中评论！');";
        	echo "javascript:history.go(-1)</script>";
    	} else {
   			foreach($commentid as $commentid=>$value) {
       			$db->query("update ".$tablepre."comments set status='wating' where id='".intval($commentid)."'");
   			}
			recentcomment_recache();
			statistics_recache();
			message('评论状态已经设置为待审核中！', 'admin.php?m=comments&a=commentlist');
 		}
	}
	if($action == 'delete') {
		$commentid = $_POST['commentid'];
		$artid = $_POST['artid'];
 		if(empty($_POST['commentid']) or !is_array($_POST['commentid'])) {
        	echo "<script language=JavaScript>alert('请选中要删除的评论！');";
        	echo "javascript:history.go(-1)</script>";
    	} else {
   			foreach($commentid as $commentid=>$value) {
       			$db->query("delete from ".$tablepre."comments where id='".intval($commentid)."'");
   			}
			foreach($artid as $artid=>$value) {
				$strsql = "select id from ".$tablepre."comments where artid=".$artid;
				$commentnum = $db->num_rows($db->query($strsql));
				$db->query("update ".$tablepre."articles set commentnum='".$commentnum."' where id=".$artid);	
			}
			recentcomment_recache();
			statistics_recache();
			message('已经删除选中的评论！', 'admin.php?m=comments&a=commentlist');
 		}
	}
	if($action == 'deleteall') {
		$db->query("delete from ".$tablepre."comments where 1");
		recentcomment_recache();
		statistics_recache();
		message('评论数据表已经清空！', 'admin.php?m=comments&a=commentlist');
	}
}
if($a == 'del') {
	$commentid = intval($_GET['id']);
	$db->query("delete from ".$tablepre."comments where id='".$commentid."'");
	recentcomment_recache();
	statistics_recache();
	message('此评论已经删除！', 'admin.php?m=comments&a=commentlist');
}
if($a == 'approved') {
	$commentid = intval($_GET['id']);
	$db->query("update ".$tablepre."comments set status='approved' where id='".intval($commentid)."'");
	recentcomment_recache();
	statistics_recache();
	message('评论已经通过审核！', 'admin.php?m=comments&a=commentlist');
}
if($a == 'waiting') {
	$commentid = intval($_GET['id']);
	$db->query("update ".$tablepre."comments set status='waiting' where id='".intval($commentid)."'");
	recentcomment_recache();
	statistics_recache();
	message('评论状态已经设置为待审核中！', 'admin.php?m=comments&a=commentlist');
}
?>