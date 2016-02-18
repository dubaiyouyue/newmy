<?php
function get_real_size($size) {
	$kb = 1024;
	$mb = 1024 * $kb;
	$gb = 1024 * $mb;
	$tb = 1024 * $gb;
	if($size < $kb) {
		return $size.' Byte';
	} elseif ($size < $mb){
		return round($size/$kb,2).' KB';
	} elseif ($size < $gb){
		return round($size/$mb,2).' MB';
	} elseif ($size < $tb){
		return round($size/$gb,2).' GB';
	} else {
		return round($size/$tb,2).' TB';
	}
}
function dir_list($dir) {
	if($dir[strlen($dir)-1] != '/') {
		$dir .= '/';
	}
	if(!is_dir($dir)) {
		return array();
	}
	$dir_handle  = opendir($dir);
	$dir_objects = array();
	while($object = readdir($dir_handle)) {
		if(!in_array($object, array('.', '..'))) {
			$filename = $dir.$object;
			$file_object = array(
				'name' => iconv('gb2312', 'UTF-8', $object),
				'size' => get_real_size(filesize($filename)),
				'type' => filetype($filename),
				'time' => date("d F Y H:i:s", filemtime($filename))
			);
			$dir_objects[] = $file_object;
		}
	}
	return $dir_objects;
}
function get_pripath($path) {
	$path = str_replace('\\', '/', $path);
	$dir_arr = explode('/', trim($path, '/'));
	$dir_len = count($dir_arr);
	$pripath = '';
	for($i = 0; $i < $dir_len - 1; $i++) {
		if($pripath == '') {
			$pripath .= $dir_arr[$i];
		} else {
			$pripath .= '/'.$dir_arr[$i];
		}
	}
	$pripath .= '/';
	return $pripath;
}
?>