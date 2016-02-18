<?php
ob_start();
require_once "global.php";
require_once "cache/cache_setting.php";
header("Content-Type: text/xml");	
$cateid = isset($_GET['cateid']) ? intval($_GET['cateid']) : '';
if($cateid != '') {
	$sql = "select catename from ".$tablepre."categories where id=".$cateid;	
	$query = $db->query($sql);
	$cate = $db->fetch_array($query);
	$catename = $cate['catename'];
	$blog_title = $catename.' - '.$options['blog_title'];
	$sql="select * from ".$tablepre."articles where cateid=".$cateid." order by id desc limit 0,10";
} else {
 	$sql="select * from ".$tablepre."articles order by id desc limit 0,10";
}
$query = $db->query($sql);

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<rss version=\"2.0\">\n";
echo "\t<channel>\n";
echo "\t\t<title>".$catename.' - '.$options['blog_name']."</title>\n";
echo "\t\t<link>".$options['url']."</link>\n";
echo "\t\t<copyright>Copyright (C) 2010 i171.me All Rights Reserved.</copyright>\n";
		 
$articledb = get_articles($sql);
foreach($articledb as $article) {
	echo "\t\t<item>\n";
	echo "\t\t\t<title>".$article['title']."</title>\n";				
	echo "\t\t\t<author>".$article['username']."</author>\n";				
	echo "\t\t\t<description><![CDATA[".$article['content']."]]></description>\n";				
	echo "\t\t\t<link>".$article['pageurl']."</link>\n";				
	echo "\t\t\t<pubDate>".$article['updatetime']."</pubDate>\n";			
	echo "\t\t</item>\n";
}
echo "\t</channel>\n";
echo "</rss>\n";

?>