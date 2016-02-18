<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="tags">
			<?php foreach($tagdb as $tag) { ?>
			<span class="tag"><a href="<?=$tag['tagurl']?>"><?=$tag['tagname']?></a>[<?=$tag['tagnum']?>]</span>
			<? } ?>
		
		</div>
	</div>
	<?php require 'sidebar.php' ?>
	<div class="fixed"></div>
</div>
<?php require 'footer.php' ?>