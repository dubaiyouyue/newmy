<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div id="login">
			<form action="?module=login&action=checklogin" method="post">
			<div class="rows"><h3>用户:</h3>
			<input class="text" name="username" size="50" /></td></div>
			<div class="rows"><h3>密码:</h3>
			 <input class="text" name="password" size="50" /></div>
			<div class="rows"><h3>验证:</h3>
			<input class="text" name="seccode" size="50" /> <img id="seccode" class="codeimg" src="inc/seccode.php?a=showseccode" alt="单击图片换张图片" border="0" onclick="this.src='inc/seccode.php?a=showseccode&update=' + Math.random()" /></div>
			<div class="rows"><input class="submit" type=submit value=" 提 交 " name=submit></div>
			</form>
		</div>
	</div>
	<div id="sidebar">
		<div class="widget">
			<h3>其它</h3>
            <ul>
            <li class="last">
			<?php if($userid && $flag){ ?><a href="?module=login&action=logout">退出</a>  <a href="admin.php">进入后台</a> <?php }elseif($userid && $flag == 0){ ?> <a href="?module=login&action=logout">退出</a> <a href="index.php"><?=$username?></a><?php }else{ ?> <a href="?module=register&action=register">注册</a> <a href="?module=login">登陆</a><? } ?></li>
            <li><a href="http://validator.w3.org/check/referer">Valid XHTML</a></li>
            <li><a href="http://<?=$sys_config['official_site']?>"><?=$sys_config['soft_name']?> <?=$sys_config['version']?></a></li>
            </ul>
		</div>
	</div>
	<div class="fixed"></div>
</div>
<?php require 'footer.php'?>