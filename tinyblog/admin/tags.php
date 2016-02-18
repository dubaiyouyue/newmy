<?php
if($a == 'tagslist') {
	$pur_page = 15;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if(!empty($page)) {
		$start_limit = ($page - 1) * $pur_page;
	}else{
		$start_limit = 0;
		$page = 1;
	}
	$total = $statisticscache['tagnum'];
	$tagdb = array();
	$sql="select t.id as tagid,t.tag,t.artid,a.title as arttitle,a.cateid,a.cateurl,a.htmlurl from ".$tablepre."tags t left join ".$tablepre."articles a on t.artid=a.id order by t.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($tag = $db->fetch_array($query)) {
		$html_url = get_html_url($tag['cateid'], $tag['cateurl'], $tag['artid'], $tag['htmlurl']);
		$tag['artpageurl'] = $html_url['pageurl'];
		$tagdb[] = $tag;
	}
	$page = multipage($pur_page, $page, 'admin.php?m=tags&a=tagslist&', $maxshowpage, $total);
}
if($a == 'operator') {
	$action = $_POST['action'];
	if($action == 'delete') {
		$tagid = $_POST['tagid'];
		$artid = $_POST['artid'];
		if(empty($_POST['tagid']) or !is_array($_POST['tagid'])) {
			message('请选中要删标签！', 'admin.php?m=tags&a=tagslist');
		} else {
			foreach($tagid as $tagid=>$value) {
				$db->query("delete from ".$tablepre."tags where id='".intval($tagid)."'");
			}
			//更新tags
			foreach($artid as $artid=>$value) {
				$tags = array();
				$strsql = "select * from ".$tablepre."tags where artid=".$artid;
				$result = $db->query($strsql);
				$tagsnum = $db->num_rows($result);
				if($tagsnum > 0) {
					$i = 0;
					while($rows = $db->fetch_array($result)) {
						$tagsarr[$i] = $rows['tag'];//连接Tags
						$i++;
					}
					$tags = implode(',', $tagsarr);
				} else {
					$tags = '';
				}
				$db->query("update ".$tablepre."articles set tags='".$tags."' where id='".intval($artid)."'");
			}
			statistics_recache();
  			message('选中的标签已经被删除！', 'admin.php?m=tags&a=tagslist');
		}
	}
	if($action == 'deleteall') {
		$db->query("delete from ".$tablepre."tags where 1");
		//更新tags
		$tags = '';
		$db->query("update ".$tablepre."articles set tags = '$tags' where 1");
		statistics_recache();
		message('标签数据表已经清空！', 'admin.php?m=tags&a=tagslist');
	}
}
?>