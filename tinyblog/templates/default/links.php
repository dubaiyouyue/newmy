<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="links">	
		<? foreach($linkdb as $link) {?> 
			<a href="<?=$link['url']?>"><?=$link['webname']?></a>
		<? } ?>
		</div>
		<div class="page">
			<? if($page != '')?>
			<?=$page?>
		</div>
	</div>
	<?php require 'sidebar.php' ?>
	<div class="fixed"></div>
</div>
<?php require 'footer.php' ?>