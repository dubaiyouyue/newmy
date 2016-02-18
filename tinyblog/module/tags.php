<?php
$blog_title = '标签'.' - '.$options['blog_title'];
$sql = "select id, tag, artid from ".$tablepre."tags";
$query = $db->query($sql);
$tag_arr = array();
while($tagdb = $db->fetch_array($query)) {
	$tag = trim($tagdb['tag']);
	if(!in_array($tag, $tag_arr)) {
		$tag_arr[] = $tag;
	}
}
$taglist = '';
foreach($tag_arr as $tag) {
	$tagnum = $db->num_rows($db->query("select id from ".$tablepre."tags where tag = '".$tag."'"));
	$tags['tagname'] = $tag;
	$tags['tagnum'] = $tagnum;
	if($options['ishtml']) {
		$tags['tagurl'] = $options['url'].'/tag/'.urlencode($tags['tagname']);
	} else {
		$tags['tagurl'] = $options['url'].'/index.php?action=tags&tagname='.urlencode($tags['tagname']);
	}
	$tagdb[] = $tags;
}
?>