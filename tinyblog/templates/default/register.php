<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div id="reg">
			<form action="?module=register&action=checkreg" method="post">
			<div class="rows"><h3 class="stitle">用户名:</h3>
			<input type="text" class="text" name="username" style="width:300px" /></div>
			<div class="rows"><h3 class="stitle">密码:</h3>
			<input type="text" class="text" name="password" style="width:300px" /></div>
			<div class="rows"><h3 class="stitle">确认密码:</h3>
			<input type="text" class="text" name="password2" style="width:300px" /></div>
			<div class="rows"><h3 class="stitle">邮箱地址:</h3>
			<input type="text" class="text" name="email" style="width:300px" /></div>
			<div class="rows"><h3 class="stitle">博客地址:</h3>
			<input type="text" class="text" name="homepage" style="width:300px" /></div>
			<?php if($options['open_seccode']){?>
			<div class="rows"><h3 class="stitle">验证码:</h3>
			<input type="text" class="text" name="seccode" style="width:300px" /> <img id="seccode" class="codeimg" src="inc/seccode.php?a=showseccode" alt="单击图片换张图片" border="0" onclick="this.src='inc/seccode.php?a=showseccode&update=' + Math.random()" /></div>
			<?php } ?>
			<div class="rows"><input class="submit" type=submit value=" 提 交 " name=submit></div>
			</form>
		</div>
	</div>
	<?php require 'sidebar.php'?>
	<div class="fixed"></div>
</div>
<?php require 'footer.php'?>