<?php
class plugin_manager {
	public function __construct() {
		$plugins = $this->get_active_plugin();
		if($plugins) { 
			foreach($plugins as $plugin) {
				if (@file_exists('plugin/'.$plugin.'/plugin.php')) {
					include_once('plugin/'.$plugin.'/plugin.php'); 
				}
			}
		}
	}
	function get_plugin() {
		$plugin_dir = 'plugin';
		$plugin_dir_arr = getdirdb($plugin_dir);
		foreach($plugin_dir_arr as $plugin_dir) {
			$plugin_info_file = 'plugin/'.$plugin_dir.'/plugin_info.php';
			include($plugin_info_file);
			$plugin_info['plugin_dir'] =  $plugin_dir;
			$active_plugindb = $this->get_active_plugin();
			if(in_array($plugin_info['plugin_dir'], $active_plugindb)) {
				$plugin_info['plugin_state'] = '1';
			} else {
				$plugin_info['plugin_state'] = '0';
			}
			$plugindb[] = $plugin_info;
		}
		return $plugindb;
	}
	function get_active_plugin() {
		$active_plugin_cache = TBS_ROOT.'cache/cache_active_plugins.php';
		$active_plugin_string = implode('', file($active_plugin_cache));
		$active_plugin_array = unserialize($active_plugin_string);
		return $active_plugin_array;
	}
	function activate_plugin($plugin) {
		$active_plugin = array();
		$active_plugin = $this->get_active_plugin();
		if(!in_array($plugin, $active_plugin)) {
			array_push($active_plugin, $plugin);
		}
		$active_plugin_string = serialize($active_plugin);
		$file = TBS_ROOT.'cache/cache_active_plugins.php';
		writetofile($file, $active_plugin_string);
	}
	function deactivate_plugin($plugin) {
		$active_plugin = array();
		$new_active_plugin = array();
		$active_plugin = $this->get_active_plugin();
		foreach($active_plugin as $value) {
			if($plugin != $value) {
				array_push($new_active_plugin, $value);
			}
		}
		$active_plugin_string = serialize($new_active_plugin);
		$file = TBS_ROOT.'cache/cache_active_plugins.php';
		writetofile($file, $active_plugin_string);
	}
	function add_action($hook, $action) {
		global $hook_arr;
		if (!@in_array($action, $hook_arr[$hook])) {
			$hook_arr[$hook][] = $action;
		}
		return true;
	}
	function do_action($hook) {
		global $hook_arr;
		$args = array_slice(func_get_args(), 1);
		if (isset($hook_arr[$hook])){
			foreach ($hook_arr[$hook] as $function){
				$string = call_user_func_array($function, $args);
			}
		}
	}
}
$plugin = new plugin_manager;
?>