<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="tb">
		<? foreach($tbdb as $tb){
		$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
		?>
		<div class="tb-box <?=$thisbg?>">
			<div class="tb-title">
			<a href="<?=$tb['url']?>"><?=$tb['title']?></a>
			</div>
			<div class="tb-about">
			来源:<?=$tb['blogname']?>
			</div>
			<div class="tb-content">
			<?=$tb['excerpt']?>
			</div>
			<div class="tb-data">
			<span>文章：<a href="<?=$tb['artpageurl']?>"><?=$tb['arttitle']?></a></span>&nbsp;&nbsp;<span>发表时间：<?=$tb['updatetime']?></span>&nbsp;&nbsp;
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