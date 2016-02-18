<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TinyBlog安装程序</title>
<style>
html {
	overflow-y: scroll; 
	height: 100%;
	margin-bottom: 0.1em;
}
* {
	padding: 0;
	margin: 0;
}
img {
	border: 0;
}
a:link, a:visited {
	text-decoration: none; 
	color: #333333;
}
a:hover, a:active {
	color: #333333;
}
body {
	line-height: 18px;
	font-size:12px;
	color: #333333;
	margin: 0;
	padding: 0;
	text-align: left;
	font-family: Verdana,Helvetica,Arial,sans-serif;
	font-family:"Lucida Grande","Lucida Sans Unicode","Lucida Sans",Helvetica,Arial,sans-serif;
}
.fixed {
	clear:both;
}
h1 {
	font-size:16px;
}
#header, #layout, #footer{
	margin:0 auto;
	width:600px;
}
#header {
	width:600px;
	height:40px;
}
#logo {
	margin-top:20px;
	float:left;
	width:200px;
}
#layout {
	margin-top:10px;
}
.nav {
	border:#e2c822 solid 1px;
	background-color:#feffcf;
	padding-top:5px;
	padding-bottom:5px;
	padding-left:10px;
	margin-bottom:10px;
}
.content {
	border:#e6e6e6 solid 1px;
	background-color:#f7f7f7;
	padding-top:10px;
	padding-left:10px;
	padding-bottom:10px;
}
.content2 {
	border:#e6e6e6 solid 1px;
	background-color:#f7f7f7;
	padding-top:10px;
	padding-left:10px;
	padding-bottom:10px;
	margin-top:10px;
}
.submit {
	padding-top:10px;
}
.text {
	border: #ccc 1px solid; 
	padding: 2px; 
	font-family:"Lucida Grande","Lucida Sans Unicode","Lucida Sans",Helvetica,Arial,sans-serif;
}
.button { 
	border:1px solid; 
	margin:3px 0;  
	padding:4px 5px 1px; 
	border-color:#efefef #666 #666 #efefef; 
	background:#f7f7f7; 
	vertical-align:middle; 
}
#footer {
	margin-top:10px;
	height:40px;
	margin-bottom:0px;
}
.about {
	float:left;
	margin-top:10px;
	margin-left:20px;
}
</style>
<script language="JavaScript">
function checkAdmin()
{
	if (document.AdminForm.username.value=="")
    {
		alert("请输入用户名！");
		document.AdminForm.username.focus();
		return false;
	}
	if (document.AdminForm.password.value=="")
    {
		alert("请输入密码！");
		document.AdminForm.password.focus();
		return false;
	}
	if (document.AdminForm.password2.value=="")
    {
		alert("请再次输入密码！");
		document.AdminForm.password2.focus();
		return false;
	}
	if (document.AdminForm.password.value!=document.AdminForm.password2.value)
    {
		alert("两次输入的密码不一致！");
		document.AdminForm.password.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body>
<?php
error_reporting(0);
require_once '../inc/db.class.php';
$dbcharset = 'utf8';
$action = isset($_GET['action']) ? $_GET['action'] : '';
?>
<div id="header">
	<div id="logo"><h1>TinyBlog系统安装程序</h1></div>
	<div class="fixed"></div>
</div>
<div id="layout">
	<?php
	if($action == '') {
	?>
	<div class="nav"><strong>›› 当前位置</strong>：TinyBlog用户许可协议</div>
	<div class="main">
		<form action="?action=step1" method="post">
		<div class="content">
		<p>版权所有 (c) 2008-2011，<a href="http://www.1212.me">Tiny's Blog</a>
	  	保留所有权利。<br />
	  	感谢您选择TinyBlog博客系统...</p>
	  	<p>要使用本软件,首先必须遵守如下协议：</p>
	  	<p>1、不得使用本软件发表任何违法得政治言论。<br />
	    2、本软件为开源软件,任何人可以修改TinyBlog的源代码,但请保留本系统版权链接。<br />
	      3、未经许可不得把本软件用于任何商业用途。<br />
	        <br />
	        关于本协议得最终解释权归<a href="http://www.1212.me">www.1212.me</a>所有！  
	        <br />
	    </p>
		</div>
		<div class="submit">
		<input class="button" type="submit" value="同  意" />
		</div>
		</form>
	</div>
	<?php
	} elseif($action == 'step1') {
		$filedir_arr = array("cache/","cache/cache_setting.php","cache/cache_templates.php","inc/","upload/","upload/attach/");
		$filedb = array();
		foreach($filedir_arr as $filedir) {
			if($flag = is_writable('../'.$filedir)) {
				$file_arr['dir'] = $filedir;
				$file_arr['state'] = $flag;
			} else {
				$file_arr['dir'] = $filedir;
				$file_arr['state'] = 0;
			}
			$filedb[] = $file_arr;
		}
	?>
	<div class="nav"><strong>›› 当前位置</strong>：检查系统配置</div>
	<div class="main">
		<form action="?action=step3" method="post">
		<div class="content">
		如果您使用非 WINNT 系统请修改以下属性<br />
	  	<strong>./cache</strong> 目录 777； <br />
	  	<strong>./cache/cache_setting.php</strong> 文件 777； <br />
	  	<strong>./cache/cache_template.php</strong> 文件 777； <br />
	  	<strong>./inc</strong> 目录 777；<br />
	  	<strong>./upfiles</strong> 目录 777；<br />
	  	<strong>./upfiles/photo</strong> 目录 777；<br />
	 	<strong>./upfiles/attach</strong> 目录 777；
		</div>
		<div class="content2">
		<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
		<tr>
		<td style="border-bottom:#e6e6e6 solid 1px;padding:5px;"><strong>目录文件</strong></td>
		<td style="border-bottom:#e6e6e6 solid 1px;padding:5px;"><strong>所需状态</strong></td>
		<td style="border-bottom:#e6e6e6 solid 1px;padding:5px;"><strong>当前状态</strong></td>
		</tr>
		<?php
		foreach($filedb as $key=>$value) {
		?>
		<tr>
		<td style="padding:5px;"><strong><?php echo $value['dir'];?></strong></td>
		<td style="padding:5px;">可写</td>
		<td style="padding:5px;">
		<?php
		if($value['state']) {
			echo '可  写';
		} else {
			echo '不可写';
		}
		?>
		</td>
		</tr>
		<?php
		}
		?>
		</table>
		</div>
		<div class="submit">
		<input class="button" type="submit" value="下一步" />
		</div>
		</form>
	</div>
	<?php
	} elseif($action == 'step3') {
	?>
	<div class="nav"><strong>›› 当前位置</strong>：数据库配置</div>
	<div class="main">
		<form action="?action=step4" method="post">
		<div class="content">
		<table width="90%" align="center" cellpadding="5">
		<tr>
		<td><div align="right">数据库服务器</div></td>
		<td><input class="text" type="text" name="dbhost" value="localhost" size="30" /> 一般是 localhost</td>
		</tr>
		<tr>
		<td><div align="right">数据库用户名</div></td>
		<td><input class="text" type="text" name="dbusername" value="root" size="30" /></td>
		</tr>
		<tr>
		<td><div align="right">数据库密码</div></td>
		<td><input class="text" type="text" name="dbpassword" size="30" /></td>
		</tr>
		<tr>
		<td><div align="right">数据库名称</div></td>
		<td><input class="text" type="text" name="dbname" size="30" /></td>
		</tr>
		<tr>
		<td><div align="right">数据表前缀</div></td>
		<td><input class="text" type="text" name="tablepre" size="30" /> 不填则默认是 tbs_</td>
		</tr>
		</table>
		</div>
		<div class="submit">
		<input class="button" type="submit" value="下一步" />
		</div>
		</form>
	</div>
	<?php
	} elseif ($action == 'step4') {
	?>
	<div class="nav"><strong>›› 当前位置</strong>：配置信息写入、数据库安装</div>
	<div class="main">
		<div class="content">
		<?php
		$dbhost = $_POST['dbhost'];
		$dbusername = $_POST['dbusername'];
		$dbpassword = $_POST['dbpassword'];
		$tablepre = $_POST['tablepre'];
		if(empty($tablepre)) {
			$tablepre = 'tbs_';
		}
		$dbname = $_POST["dbname"];
		$db->connect($dbhost,$dbusername,$dbpassword);
		$db->select_db($dbname);
		$file = "../inc/db.config.php";
    	if (file_exists($file)){
      		@chmod ($file, 0777);
    	}

    	$fp = fopen($file,w);
    	$filecontent = "<?php
/********** 数据库主机名或IP **********/
\$dbhost = '$dbhost';
/********** 数据库用户名 **********/
\$dbusername = '$dbusername';
/********** 数据库密码 **********/
\$dbpassword = '$dbpassword';
/********** 数据库名 **********/
\$dbname = '$dbname';	
/********** 数据库名 **********/
\$tablepre = '$tablepre';
?>";
    	fwrite($fp,$filecontent,strlen($filecontent));
    	fclose($fp);
	
		$sqlfile="install.sql";
		$fp = fopen($sqlfile, 'rb');
		$sql = fread($fp, 2048000);
		fclose($fp);
		runquery($sql);	
		?>
		</div>
		<div class="submit">
		<form action="?action=step5" method="post"><input class="button" type="submit" value="下一步" /></form>
		</div>
	</div>
	<?php
	} elseif($action == 'step5') {
	?>
	<div class="nav"><strong>›› 当前位置</strong>：管理员信息</div>
	<div class="main">
		<form name="AdminForm" action="?action=add_admin" method="post" onSubmit="return checkAdmin()">
		<div class="content">
		<table width="90%" align="center" cellpadding="5">
		<tr>
		<td><div align="right">用户名</div></td>
		<td><input class="text" type="text" name="username" size="30" /></td>
		</tr>
		<tr>
		<td><div align="right">密码</div></td>
		<td><input class="text" type="text" name="password" size="30" /></td>
		</tr>
		<tr>
		<td><div align="right">确定</div></td>
		<td><input class="text" type="text" name="password2" size="30" /></td>
		</tr>
		</table>
		</div>
		<div class="submit">
		<input class="button" type="submit" value="完成安装" />
		</div>
		</form>
	</div>
	<?php
	} elseif($action == 'add_admin') {
	?>
	<div class="nav"><strong>›› 当前位置</strong>：管理员信息写入、配置信息写入</div>
	<div class="main">
		<div class="content">
		<?php
		require '../inc/db.config.php';
		require '../inc/db.conn.php';
 		$username = $_POST['username'];
 		$password = md5($_POST['password']);
 		$sql = "insert into ".$tablepre."users (username,password,email,homepage,flag) values ('$username','$password','phpangel@126.com','http://www.1212.me','1')";
 		$db->query($sql);
		echo '用户添加成功！<br>';
		echo '初始化信息！<br>';
		$db->query("insert into ".$tablepre."categories (id,catename,cateurl,cateorder) values ('1','默认分类','','0')");
		$updatetime = time();
		$db->query("insert into ".$tablepre."articles (id,istop,cateid,catename,cateurl,username,title,htmlurl,abstract,content,tags,commentnum,tbnum,viewnum,updatetime) values ('1','0','1','默认分类','','$username','欢迎使用TinyBlog博客系统！','','如果您看到这篇文章,表示您的blog已经安装成功.','如果您看到这篇文章,表示您的blog已经安装成功!','TinyBlog','1','0','0','$updatetime')");
		$commenttime = time();
		$db->query("insert into ".$tablepre."comments (id,artid,username,homepage,content,status,ipaddress,commenttime) values ('1','1','phpangel','http://www.1212.me',' 欢迎来到TinyBlog的世界！','approved','127.0.0.1','$commenttime')");
		$db->query("insert into ".$tablepre."tags (id,tag,artid) values ('1','TinyBlog','1')");
		echo '初始化OK！<br>';
		echo "系统正在更新缓存信息...<br>";
		if (!defined('TBS_ROOT')){
    		define('TBS_ROOT', substr(dirname(__FILE__), 0, -7));
		}
		require '../inc/global.func.php';
		require '../inc/cache.func.php';
		$options = array();
		$options['url'] = addslashes(substr(geturl(), 0, -8));
		$options['blog_title'] = addslashes('your\'s blog');
		$options['blog_name'] = addslashes('your\'s blog');
		$options['blog_description'] = addslashes('your\'s description!');
		$options['blog_keywords'] = addslashes('your\'s keywords');
		$options['viewmode'] = 'normal';
		$options['normalnum'] = '10';
		$options['listnum'] = '60';
		$options['show_pre_next'] = '0';
		$options['show_relate'] = '0';
		$options['relatenum'] = '10';
		$options['commentsnum'] = '10';
		$options['articlecommentsnum'] = '10';
		$options['recentarticlelistnum'] = '10';
		$options['recentcommentlistnum'] = '10';
		$options['recentarticlecharnum'] = '30';
		$options['recentcommentcharnum'] = '30';
		$options['recentlinklistnum'] = '10';
		$options['recentlinkcharnum'] = '30';
		$options['tbnum'] = '10';
		$options['istb'] = '1';
		$options['catedir'] = 'category';
		$options['artdir'] = 'archives';
		$options['artsuffix'] = 'html';
		$options['selfartsuffix'] = 'action';
		$options['linknum'] = '30';
		$options['ishtml'] = '0';
		$options['iscompress'] = '1';
		$options['timeoffset'] = '8';
		$options['articledateformat'] = 'Y-m-d, H:i:s';
		$options['commentdateformat'] = 'Y-m-d, H:i:s';
		$options['tbdateformat'] = 'Y-m-d, H:i:s';
		$options['show_calendar'] = '1';
		$options['show_categories'] = '1';
		$options['show_archives'] = '1';
		$options['show_recentcomments'] = '1';
		$options['show_recentarticles'] = '1';
		$options['show_statistics'] = '1';
		$options['show_links'] = '1';
		$options['commentseccode'] = '1';
		$options['need_approve'] = '0';
		$options['show_comment'] = '1';
		$options['close_comment'] = '0';
		$options['close_guestcomment'] = '0';
		$options['close_blog'] = '0';
		$options['close_reason'] = '博客关闭中！';
		$options['close_reg'] = '0';
		$options['ban_user'] = 'phpangel,TinyBlog,tinyblog,tiny,5dcc,test,操你妈,rinima,日你妈,鸡,鸭';
		$options['attach_path'] = 'upload/attach/';
		$options['attach_type'] = 'jpg,gif,bmp,png,rar,zip,exe';
		$contents = "<?php\r\n";
		$contents .= "\$options = array(\r\n";
		foreach($options as $key => $val) {
			$db->query("insert ".$tablepre."settings set title = '$key', value = '$val'");
			$contents .="\t'".$key."' => '".$val."',\n";
		}
		$contents .= ");";
		$contents .= "?>";
		
		$file = '../cache/cache_setting.php';
		
		if (file_exists($file)){
			@chmod ($file, 0777);
		}
		$fp = fopen($file, w);
		fwrite($fp, $contents, strlen($contents));
		fclose($fp);
		include TBS_ROOT.'cache/cache_setting.php';
		calendar_recache(); 
		archives_recache();
		categories_recache();
		recentart_recache();
		recentcomment_recache();
		recentlink_recache();
		statistics_recache();
		echo "cache_setting更新成功！<br>";
		echo "cache_categories更新成功！<br>";
		echo "cache_recentart更新成功！<br>";
		echo "cache_recentlink更新成功！<br>";
		echo "cache_recentcomment更新成功！<br>";
		echo "cache_statistics更新成功！<br>";
		echo "cache_calendar更新成功！<br>";
		echo "<div width=100% align=center>安装完成 >> <a href=\"../index.php\"> 进入首页</a> <a href=\"../index.php?module=login\"> 进入后台</a><div>";
		?>
		</div>
	</div>
	<?php
	}
	?>
</div>
<div id="footer">
	<div class="about">Copyright &copy; | Powered by <a href="http://www.1212.me/">TinyBlog</a></div>
	<div class="fixed"></div>
</div>
</body>
</html>
<?php
function runquery($sql) {
	global $dbcharset,$tablepre,$db;
	$sql = str_replace("\r", "\n", str_replace(' tbs_', ' '.$tablepre, $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query){
		$queries = explode("\n", trim($query));
		foreach($queries as $query){
			$ret[$num] .= $query[0] == '#' || $query[0].$query[1] == '--' ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
				echo '创建表 '.$name.' ... <font color="#0000EE">成功</font><br />';
				$db->query(createtable($query,$dbcharset));
			}else{
				$db->query($query);
			}
		}
	}
}
function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
}
?>