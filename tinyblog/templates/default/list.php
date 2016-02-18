<?php
	require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="viewmode">浏览模式: <a href="<?=$options['url']?>/index.php?viewmode=normal">标准</a> | 列表</div>
		<?
		foreach($articledb as $article) {
		if ($article['istop'] == 1) {
		?>
		<div class="list-post">
			<div class="list-post-title">
				<h2><a href="<?=$article['pageurl']?>"><?=$article['title']?></a></h2>
				<span class="list-post-data"> <?=$article['viewnum']?> | <?=$article['commentnum']?> | <?=$article['username']?> | <a href="<?=$article['cateurl']?>"><?=$article['catename']?></a> | <? if($article['tags']){?> <? foreach($article['tags'] as $tag){?><a title="<?=$tag['tagname']?>" href="<?=$tag['tagurl']?>"><?=$tag['tagname']?></a>&nbsp;<? } }?></span> 
			</div>
		</div>
		<?
		} elseif ($article['istop'] == 0) {
		?>
		<div class="list-post">
			<div class="list-post-title">
				<h2><a href="<?=$article['pageurl']?>"><?=$article['title']?></a></h2>
				<span class="list-post-data"> <?=$article['viewnum']?> | <?=$article['commentnum']?> | <?=$article['username']?> | <a href="<?=$article['cateurl']?>"><?=$article['catename']?></a> | <? if($article['tags']){?> <? foreach($article['tags'] as $tag){?><a title="<?=$tag['tagname']?>" href="<?=$tag['tagurl']?>"><?=$tag['tagname']?></a>&nbsp;<? } }?></span> 
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