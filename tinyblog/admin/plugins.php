<?php
if($a == 'pluginlist') {
	$plugindb = $plugin->get_plugin();
}
if($a == 'activate') {
	$plugin_dir = $_GET['plugin'];
	$plugin->activate_plugin($plugin_dir);
	message('成功激活插件！', 'admin.php?m=plugins&a=pluginlist');
}
if($a == 'deactivate') {
	$plugin_dir = $_GET['plugin'];
	$plugin->deactivate_plugin($plugin_dir);
	message('插件已禁用！', 'admin.php?m=plugins&a=pluginlist');
}
?>