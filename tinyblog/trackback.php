<?php
header('Content-type: text/xml');
require_once 'global.php';
$msg = 'trackback接受失败';
$istb = $options['istb'];
if($istb == 0) {
	exit();
} elseif ($istb == 1) {
	$tbkey = isset($_GET['tbkey']) ? $_GET['tbkey'] : $_POST['tbkey'];
	$artid = intval(isset($_GET['tbid']) ? $_GET['tbid'] : $_POST['tbid']);
	$now = getdate(mktime() + $options['timeoffset']*3600);
	$keyvalue = intval($now['minutes'] / 10) * $artid;
	if($tbkey != $keyvalue) {
		exit();
	} elseif ($tbkey == $keyvalue) {
		$ipaddress = addslashes(getip());
		$query = $db->query("select updatetime from ".$tablepre."trackbacks where ipaddress = '$ipaddress' order by id desc");
		$row = $db->fetch_array($query);
		$lasttime = $row['updatetime'];
		if((mktime() + $options['timeoffset']*3600 - $lasttime) < 300) {
			exit();//如果同一个ip当前发送时间与上次发送时间间隔小于5分钟则丢弃
		} else {
			$title = isset($_GET['title']) ? $_GET['title'] : $_POST['title'];
			$excerpt = addslashes(isset($_GET['excerpt']) ? $_GET['excerpt'] : $_POST['excerpt']);
			$url = addslashes(isset($_GET['url']) ? $_GET['url'] : $_POST['url']);
			$blogname = addslashes(isset($_GET['blog_name']) ? $_GET['blog_name'] : $_POST['blog_name']);
			$updatetime = mktime()+$options['timeoffset']*3600;
			if (!empty($artid) and !empty($title) and !empty($excerpt) and !empty($url) and !empty($blogname)) {
				$sql = "insert into ".$tablepre."trackbacks(url,title,blogname,excerpt,artid,ipaddress,updatetime) values ('$url','$title','$blogname','$excerpt','$artid','$ipaddress','$updatetime')";
				$result = $db->query($sql);
 				if(!$result) {
  					$error = 1;
 				} else {
  					$error = 0;
 				}
			} else {
 				$error = 1;
			}
			echo '<?xml version="1.0" encoding="utf-8"?>'; 
			if($error) { 
				echo '<response><error>1</error><message>'.$msg.'</message></response>'; 
			} else { 
				echo '<response><error>0</error></response>'; 
			}
		}
	}

}
?>