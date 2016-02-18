<?php
$blog_title = '归档'.' - '.$options['blog_title'];
$sql = "select updatetime from ".$tablepre."articles";
$query = $db->query($sql);
while($updatetime = $db->fetch_array($query)) {
	$updatetimedb[] = gmdate("Y-m", $updatetime['updatetime']);
}
$date_arr = array_count_values($updatetimedb);
unset($updatetimedb);
foreach($date_arr as $key => $value) {
	list($y, $m) = explode('-', $key);
	$archivedb[$y][$m] = $value;
}
?>