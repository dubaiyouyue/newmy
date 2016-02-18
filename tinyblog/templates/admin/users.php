<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<table class="tb" cellspacing="0"><tr><td><a href="admin.php?m=users&a=useradd"><strong>添加用户</strong></a>
<a href="admin.php?m=users&a=userlist&flag=1"><strong>管理员</strong></a></td></tr></table>
<? if ($a == 'userlist'){?>
<table class="tb" cellpadding="5" cellspacing="0">
  <tr class="title">
    <td>ID</td>
    <td>用户名</td>
	<td>用户组</td>
    <td>Email</td>
	<td>主页</td>
	<td>操作</td>
<? foreach($userdb as $user){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td width=35><?=$user['userid']?></td>
    <td><?=$user['username']?></td>
	<td><?=$user['flag']?></td>
    <td><?=$user['email']?></td>
	<td><?=$user['homepage']?></td>
    <td width=100><a href=admin.php?m=users&a=useredit&userid=<?=$user['userid']?>>编辑</a>  <a href=admin.php?m=users&a=userdel&userid=<?=$user['userid']?>>删除</a></td></tr>
<? } ?>	
</table>
<table class="tb2" cellspacing="0">
<tr><td><div id="pageview">
  <?=$page?>
</div></td></tr>
</table>
<? } ?>
<? if ($a == 'useradd'){ ?>
<table class="tb" cellspacing="0">
<form name="userForm" action=admin.php?m=users&a=usersave method=post onSubmit="return checkUserForm()">
<tr><td>
<ul>
<li><h3>Username</h3></li>
<li><input type="text" class="text" name="username" style="width:300px" /></li>
<li><h3>Type</h3></li>
<li><select name="flag">
<option value="0">普通用户</option>
<option value="1">管理员</option>
</select>
</li>
<li><h3>Password</h3></li>
<li><input type="text" class="text" name="password" style="width:300px" /></li>
<li>
<h3>Check Password</h3></li>
<li>
<input type="text" class="text" name="password2" style="width:300px" />
</li>
<li>
<h3>Email</h3></li>
<li>
<input type="text" class="text" name="email" style="width:300px" />
</li>
<li><h3>Homepage</h3></li>
<li><input type="text" class="text" name="homepage" style="width:300px" />
</li>
<li><input class="submit" type=submit value=" 提 交 " name=submit></li>
</ul>
</td></tr>
</form>
</table>
<? } ?>
<? if($a == 'useredit'){ ?>
<table class="tb" cellpadding="5" cellspacing="0">
<form name="userForm" action=admin.php?m=users&a=usereditsave method=post onSubmit="return checkUserForm()">
<tr><td><ul><li>
<h3>用户名称</h3></li>
<li><input class=text value="<?=$user['username']?>" name=username style="width:300px"><input type="hidden" name="userid" value="<?=$user['userid']?>">
</li>
<li>
<h3>Type</h3></li>
<li>
<select name="flag">
<option value="0" <? if($user['flag']){echo 'selected';}?>>普通用户</option>
<option value="1" <? if($user['flag']){echo 'selected';}?>>管理员</option>
</select>
</li><li>
<h3>Password</h3>
</li><li>
<input class=text name=password style="width:300px">
</li><li>
<h3>Check Password</h3>
</li><li>
<input class=text name=password2 style="width:300px">
<li>
<h3>Email</h3></li>
<li>
<input class=text value="<?=$user['email']?>" name=email style="width:300px">
</li><li>
<h3>Homepage</h3></li>
<li>
<input class=text value="<?=$user['homepage']?>" name=homepage style="width:300px">
</li><li><input class="submit" type=submit value=" 提 交 " name=submit></li></ul></td></tr>
</form>
</table>
<? } ?>	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>