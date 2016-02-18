<?php
include 'common.inc.php';
include 'cache_setting.php';
$query = $db->query("select id, username, password, flag from ".$tablepre."users where id = ".$userid);
$user = $db->fetch_array($query);
if($password != $user['password'] || $flag == 0) {
	message('非法登陆', '../login.php');
	exit();
}
?>
<link rel="stylesheet" href="../templates/admin/style.css" type="text/css" />
<script type="text/javascript" src="../javascript/attachment.js"></script>
<style>
body {
	background:#f9f9f9;
	margin:0px;
	padding:0px;
}  
.error a {
	color:#FF0000;
}   
.error a:link {
	color:#FF0000;
} 
.error a:hover {
	color:#FF0000;
}
.error a:visited {
	color:#FF0000;
}
.text2 {
	width:500px;
	border:#dfdfdf solid 1px;
}
</style>
<body leftmargin="0" topmargin="0">
<div id="msgList"></div>
<?php
if($_GET['action'] == 'attach') {
	$artid = intval($_GET['artid']);	
?>
<form name=form action="upload.php?do=up" method=post enctype=multipart/form-data><input type="hidden" name="MAX_FILE_SIZE" value="5000000"><input type="hidden" name="artid" value="<?=$artid?>">
<input type=file name=uploadfile class="text2">
<input type=submit name=submit class="submit" value="上 传">
</form>
<? } ?>
</body>
</html>
<?php
if($_GET['do'] == 'up') {
	$artid = intval($_POST['artid']);
	$uploaddir = '../'.$options['attach_path'];
   	$filetype = explode(',', $options['attach_type']); 
	$ban_upfile_type = explode(',', $sys_config['ban_upfile_type']); 
	$upfilename = $_FILES['uploadfile']['name'];
	$upfiletype = strtolower(fileext($upfilename));
	if(in_array($upfiletype, $ban_upfile_type)) {
		echo $upfiletype.'文件类型为系统默认限制上传类型,可手动修改sys.config.php';
		echo '&nbsp;&nbsp;<span class=error><a href=upload.php?action=attach&artid='.$artid.'>点击返回</a></span>';
	} else {
		if(!in_array($upfiletype, $filetype)) {
			$text = implode(',', $filetype);
			echo '您只能上传以下类型文件: '.$text;
			echo '&nbsp;&nbsp;<span class=error><a href=upload.php?action=attach&artid='.$artid.'>点击返回</a></span>';
		} else {
			$filename = explode('.', $upfilename);
			$filename['0'] = random(10);
			$uploadfile = $uploaddir.implode('.', $filename);
			
			if(!move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadfile)) {  
				echo '上传出现异常!';
				echo '&nbsp;&nbsp;<span class=error><a href=upload.php?action=attach&artid='.$artid.'>点击返回</a></span>';
			} else {
				$uploadfile = str_replace('../', '', $uploadfile);
				$path = addslashes(TBS_ROOT).$uploadfile;
				$filesize = $_FILES['uploadfile']['size'];
				//写入数据库
				$uploadtime = time();
				$db->query("insert into ".$tablepre."attach (artid, truefilename, filename, path, filesize, filetype, uploadtime) values ('$artid', '$upfilename',  '$uploadfile','$path','$filesize','$upfiletype','$uploadtime')");
				$attachid = $db->insert_id();
				
				$type1 = array('jpg', 'gif', 'bmp', 'png');
				$type2 = array('rar', 'zip', 'exe');
				if(in_array($upfiletype, $type1)) {
					$value = "[img]".$options['url'].'/'.$uploadfile."[/img]";
	?>
					<script language="javascript">
					addToList('<?=$upfilename?>', '<?=$value?>', '<?=$attachid?>');
					</script>
	<?php
				} else {
					$value = "附件：[attach=".$options['url'].'/'.$uploadfile."]".$uploadfile."[/attach]";
	?>
					<script language="javascript">
					addToList('<?=$upfilename?>', '<?=$value?>', '<?=$attachid?>');
					</script>
	<?php
				}
				echo '上传成功！';
				echo '&nbsp;&nbsp;<span class=error><a href=upload.php?action=attach&artid='.$artid.'>点击返回</a></span>';
			}
		}
	}
}
?>