<?php
if($a == 'attach_db') {
	$pur_page = 15;
	$maxshowpage = 4;
	$page = intval(isset($_GET['page']) ? $_GET['page'] : '');
	if($page != '') {
		$start_limit = ($page - 1) * $pur_page;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$total = $statisticscache['attachnum'];
	$artdb = array();
	$sql = "select at.id as attachid,at.artid,at.truefilename,at.filename,at.path,at.filesize,at.filetype,at.uploadtime,ar.title from ".$tablepre."attach at left join ".$tablepre."articles ar on at.artid = ar.id order by at.id desc limit ".$start_limit.",".$pur_page;
	$query = $db->query($sql);
	while($attach = $db->fetch_array($query)) {
		$attach['uploadtime'] = gmdate("Y-m-d", $article['uploadtime'] + $options['timeoffset']*3600);
		$attach['filesize'] = get_real_size($attach['filesize']);
		$attachdb[] = $attach;
	}
	$page = multipage($pur_page, $page, "admin.php?m=attachment&a=attach_db&", $maxshowpage, $total);
}
if($a == 'operator') {
	$action = $_POST['action'];
	if($action == 'delete') {
 		$attachid = $_POST['attachid'];
 		if (empty($_POST['attachid']) || !is_array($_POST['attachid'])) {
        	message('请选中要操作的附件！', 'admin.php?m=attachment&a=attach_db');
    	} else {
   			foreach($attachid as $aid=>$value) {
				$query = $db->query("select path from ".$tablepre."attach where id='".intval($aid)."'");
				$attach = $db->fetch_array($query);
				$path = $attach['path'];
				unlink($path);
       			$db->query("delete from ".$tablepre."attach where id='".intval($aid)."'");
   			}
			statistics_recache();
			message('已经删除选中的附件！', 'admin.php?m=attachment&a=attach_db');
 		}
	}
}
if($a == 'operator2') {
	$action = $_POST['action'];
	if($action == 'delete') {
 		$attach = $_POST['attachname'];
		$dir = $_POST['dir'];
 		if (empty($_POST['attachname']) || !is_array($_POST['attachname'])) {
        	message('请选中要操作的附件！', 'admin.php?m=attachment&a=attach_file&dir='.$dir);
    	} else {
   			foreach($attach as $key=>$value) {
				unlink($key);
   			}
			statistics_recache();
			message('已经删除选中的附件！', 'admin.php?m=attachment&a=attach_file&dir='.$dir);
 		}
	}
}
if($a == 'attach_file') {
	$options['attach_path'] = TBS_ROOT.$options['attach_path'];
	$dir = isset($_GET['dir']) ? $_GET['dir'] : $options['attach_path'];
	$pre_dir = get_pripath($dir);
	$dir_arr = dir_list($dir);
}
?>