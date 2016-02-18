<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="comment">
		<? foreach($commentdb as $comment){
			$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
		?>
		<div class="comment-box <?=$thisbg?>">
			<div class="comment-about">
			作者：<?=$comment['username']?>
			</div>
			<div class="comment-content">
			<?=$comment['content']?>
			</div>
			<div class="comment-data">
			<span>文章：<a href="<?=$comment['artpageurl']?>"><?=$comment['arttitle']?></a></span>&nbsp;&nbsp;<span>发表时间：<?=$comment['commenttime']?></span>&nbsp;&nbsp;
			</div>
		</div>
		<? } ?>
		</div>
		<div class="page">
			<? if($page != '')?>
			<?=$page?>
		</div>
	</div>
	<?php
	require 'sidebar.php';
	?>
	<div class="fixed"></div>
</div>
<?php
	require 'footer.php';
?>