<?php
switch($a) {
	case 'cache_categories':
		categories_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_archives':
		archives_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_recentart':
		recentart_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_recentcomment':
		recentcomment_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_statistics':
		statistics_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_calendar':
		calendar_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'cache_recentlink':
		recentlink_recache();
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'updatetags':
		$query = $db->query("select id from ".$tablepre."articles");
		while ($rs = $db->fetch_array($query)){
			$tagsarr = array();
			$artid = $rs['id'];
			$sql = "select * from ".$tablepre."tags where artid=".$artid;
			$resulttag = $db->query($sql);
			$tagsnum = $db->num_rows($resulttag);
			if ($tagsnum>0){
    			$i = 0;
    			while($rows = $db->fetch_array($resulttag)) {
     				$tagsarr[$i] = $rows['tag'];//连接Tags
     				$i++;
    			}
    			$tags = implode(',', $tagsarr);
			} else {
				$tags = '';
			}
			$db->query("update ".$tablepre."articles set tags='".$tags."' where id=".$artid);
   		}
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'updatecommentnum':
		$query = $db->query("select id from ".$tablepre."articles");
		while ($rs = $db->fetch_array($query)) {
			$artid = $rs['id'];
			$strsql = "select id from ".$tablepre."comments where artid=".$artid;
			$commentnum = $db->num_rows($db->query($strsql));
			$db->query("update ".$tablepre."articles set commentnum='".$commentnum."' where id=".$artid);
		}
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
	case 'updatetbnum':
		$query = $db->query("select id from ".$tablepre."articles");
		while ($rs = $db->fetch_array($query)) {
			$artid = $rs['id'];
			$strsql = "select id from ".$tablepre."trackbacks WHERE artid=".$artid;
			$tbnum = $db->num_rows($db->query($strsql));
			$db->query("update ".$tablepre."articles set tbnum='".$tbnum."' where id=".$artid);
		}
		echo "<script>location.href='admin.php?m=datas';</script>";
		break;
}
?>