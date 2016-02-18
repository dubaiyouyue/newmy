<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
<table class="tp_current" width="100%" cellspacing="0"><tr><td width="200" align="center"><a class="current_template_img"><img alt="当前在用模板" src="templates/<?=$templatename?>/template.png"></a></td>
<td class="tp_info">
<?php
foreach($current_template_info as $key=>$value) {
	echo '<strong>'.$key.':</strong> '.$value.'<br>';
}
?>
</td>
</tr></table>
<?php foreach($templatedb as $templates) { ?>
<table class="tp_list" cellspacing="0">
<tr><td width="200" align="center"><a class="template_img" href=admin.php?m=templates&a=template_set&templatename=<?=$templates['templatename']?>>
  <img alt="设为当前模板" src="<?=$templates['pic']?>"></a></td>
<td class="tp_info"><? foreach($templates['template_info'] as $key => $value){ 
echo '<strong>'.$key.':</strong> '.$value.'<br>';
} ?></td>
</tr>
</table>
<? } ?>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>