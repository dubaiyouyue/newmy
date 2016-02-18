<?
require 'header.php';
?>
<div id="layout">
<?
require 'sidebar.php';
?>
	<div id="main">
	<div id="tips" style="display:none"></div>
	<?php $plugin->do_action(PLUGIN_DEMO)?>
<? if ($a == 'pluginlist') { ?>
<table class="tb" cellspacing="0">
<form name="form1" action="admin.php?m=plugins&a=operator" method=post>
  <tr class="title">
    <td>名称</td>
    <td>描述</td>
	<td>版本</td>
	<td>作者</td>
	<td>操作</td>
</tr>
<? foreach ($plugindb as $plugin){
	$thisbg = isset($thisbg) && $thisbg == 'content' ? 'content2' : 'content';
?>
  <tr class="<?=$thisbg?>">
    <td width=200><?=$plugin['plugin_name']?></td>
    <td><?=$plugin['plugin_description']?></td>
	<td><?=$plugin['plugin_version']?></td>
	<td><a href="<?=$plugin['plugin_author_url']?>"><?=$plugin['plugin_author']?></a></td>
	<td><? if($plugin['plugin_state']){?><a href="admin.php?m=plugins&a=deactivate&plugin=<?=$plugin['plugin_dir']?>">禁用</a><? } elseif(!$plugin['plugin_state']) {?><a href="admin.php?m=plugins&a=activate&plugin=<?=$plugin['plugin_dir']?>">激活</a><? } ?> </td>
<? } ?>
</form>
</table>
<? } ?>
<table class="tb"><tr><td>插件程序尚不完整，尚未提供相关钩子接口，暂时无法使用，如熟悉插件机制的，可自行添加插件接口。</td></tr></table>
	</div>
	<div class="fixed"></div>
</div>
<?
require 'footer.php';
?>