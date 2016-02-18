<?php
$db->connect($dbhost, $dbusername, $dbpassword);
$db->select_db($dbname);
mysql_query("SET NAMES 'utf8'");
?>