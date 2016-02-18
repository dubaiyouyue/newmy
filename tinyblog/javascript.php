<?php
require 'global.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if($action == 'getart_bytag') {
	$tag = char($_POST['tag']);
	$html = '<div class=divtop><span class=closediv><a href="javascript:;" onclick="$(\'ajax_div\').style.display=\'none\';">关闭</a></span><span class=title>相关文章</span></div>';
	$html .= "<ul>";
	$relate = $db->query("select artid from ".$tablepre."tags where tag = '$tag'");
	if($relate) {
		while($relate_rows = $db->fetch_array($relate)) {
			if(!in_array($relate_rows['artid'], $relate_artid_arr)) {
				$relate_artid_arr[] = $relate_rows['artid'];
			}
		}
		foreach($relate_artid_arr as $relate_artid) {
			$relate_sql = "select * from ".$tablepre."articles where id='$relate_artid' limit 0,10";
			$relate_art = get_article($relate_sql);
			$html .= "<li>·<a href=".$relate_art['pageurl'].">".$relate_art['title']."</a></li>";
		}
	} else {
		$html .= "<li>·没有相关文章！</li>";
	}
	$html .= "</ul>";
	echo $html;
}
if($_GET['a'] == 'showtbkey') {
	$artid = intval($_GET['artid']);
	$now = getdate(mktime() + $options['timeoffset']*3600);
	$keyvalue = intval($now['minutes']/10)*$artid;
	echo "document.write('".$keyvalue."');\r\n";
}
?>