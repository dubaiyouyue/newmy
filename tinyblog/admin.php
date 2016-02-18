<?php
require_once 'inc/common.inc.php';
require TBS_ROOT.'cache/cache_templates.php';
require TBS_ROOT.'cache/cache_statistics.php';
require TBS_ROOT.'inc/admin.func.php';

$query = $db->query("select id, username, password, flag from ".$tablepre."users where id = ".$userid);
$user = $db->fetch_array($query);
if($password != $user['password'] || $flag == 0) {
	message('非法登陆', 'index.php?module=login');
}

$m = isset($_GET['m']) ? $_GET['m'] : 'index';
$a = isset($_GET['a']) ? $_GET['a'] : '';
$menu = array(
	'0' => array(
		'm' => 'index',
		'a' => '',
		't' => '首页',
	),
	'1' => array(
		'm' => 'setting',
		'a' => '',
		't' => '设置',
	),
	'2' => array(
		'm' => 'categories',
		'a' => 'catelist',
		't' => '分类',
	),
	'3' => array(
		'm' => 'articles',
		'a' => 'artlist',
		't' => '文章',
	),
	'4' => array(
		'm' => 'comments',
		'a' => 'commentlist',
		't' => '评论',
	),
	'5' => array(
		'm' => 'tags',
		'a' => 'tagslist',
		't' => '标签',
	),
	'6' => array(
		'm' => 'trackbacks',
		'a' => 'tblist',
		't' => '引用',
	),
	'7' => array(
		'm' => 'templates',
		'a' => '',
		't' => '模板',
	),
	'8' => array(
		'm' => 'datas',
		'a' => '',
		't' => '数据',
	),
	'9' => array(
		'm' => 'database',
		'a' => 'tablelist',
		't' => '备份',
	),
	'10' => array(
		'm' => 'attachment',
		'a' => 'attach_db',
		't' => '附件',
	),
	'11' => array(
		'm' => 'users',
		'a' => 'userlist',
		't' => '用户',
	),
	'12' => array(
		'm' => 'links',
		'a' => 'linklist',
		't' => '链接',
	),
	'13' => array(
		'm' => 'plugins',
		'a' => 'pluginlist',
		't' => '插件',
	),
	'14' => array(
		'm' => 'login',
		'a' => 'logout',
		't' => '注销',
	),
);

if(in_array($m, array('login', 'index', 'setting', 'categories', 'articles', 'comments', 'tags', 'trackbacks', 'templates', 'datas', 'database', 'attachment', 'users', 'links', 'plugins'))) {
	if($m != '') {
		require 'admin/'.$m.'.php';
	}
} else {
	exit('非法引用模块！');
}

require template($m, 'admin');
?>