<?php
require 'header.php';
?>
<div id="layout">
	<div id="main">
		<div class="archives">
			<? if($options['ishtml']) { ?>
			<? foreach($archivedb as $y => $arr) {?>
			<ul>
			<div class="fixed"></div>
			<h2 class="year"><?=$y?>年</h2>
			<? foreach($arr as $m => $artnum){?>
			<li><a href="<?=$options['url']?>/times/<?=$y?>/<?=$m?>"><?=$m?>月</a> (<?=$artnum?>)</li>
			<? } ?>
			</ul>
			<? } ?>
			<? } else {?>
			<? foreach($archivedb as $y => $arr) {?>
			<ul>
			<div class="fixed"></div>
			<h2 class="year"><?=$y?>年</h2>
			<? foreach($arr as $m => $artnum){?>
			<li><a href="<?=$options['url']?>/index.php?action=times&y=<?=$y?>&m=<?=$m?>"><?=$m?>月</a> (<?=$artnum?>)</li>
			<? } ?>
			</ul>
			<? } ?>
			<? } ?>
		</div>
	</div>
	<?php require 'sidebar.php' ?>
	<div class="fixed"></div>
</div>
<?php require 'footer.php' ?>