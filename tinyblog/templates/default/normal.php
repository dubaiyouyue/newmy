<?php
	require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="viewmode">浏览模式: 标准 | <a href="<?=$options['url']?>/index.php?viewmode=list">列表</a></div>
		<?
		foreach($articledb as $article) {
		if ($article['istop'] == 1) {
		?>
		<div class="post">
			<h2 class="post-title"><a href="<?=$article['pageurl']?>"><?=$article['title']?></a></h2>
			<p class="post-data">
				<span>作者：<?=$article['username']?></span>
				<span>发布时间：<?=$article['updatetime']?></span>
				<span>分类：<a href="<?=$article['cateurl']?>"><?=$article['catename']?></a></span> 
<?php if($article['commentnum']) {?> <a href="<?=$article['pageurl']?>"><?=$article['commentnum']?> Comments</a><? } else {?> <a href="<?=$article['pageurl']?>">No Comments</a><? } ?>
			</p>
			<div class="post-content">
			<?=$article['contentshow']?>
			</div>
		</div>
		<?
		} elseif ($article['istop'] == 0) {
		?>
		<div class="post">
			<h2 class="post-title"><a href="<?=$article['pageurl']?>"><?=$article['title']?></a></h2>
			<p class="post-data">
				<span>作者：<?=$article['username']?></span>
				<span>发布时间：<?=$article['updatetime']?></span>
				<span>分类：<a href="<?=$article['cateurl']?>"><?=$article['catename']?></a></span> 
<?php if($article['commentnum']) {?> <a href="<?=$article['pageurl']?>"><?=$article['commentnum']?> Comments</a><? } else {?> <a href="<?=$article['pageurl']?>">No Comments</a><? } ?>
			</p>
			<div class="post-content">
			<?=$article['contentshow']?>
			</div>
		</div>
		<?
		} }
		?>
		<div class="page">
		<? if($page != '') ?>
		<?=$page?>
		<div class="fixed"></div>
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