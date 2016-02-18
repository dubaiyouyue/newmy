<?php
if(!function_exists('file_put_contents')) {
	function file_put_contents($file, $string, $append = '') {
		$mode = $append == '' ? 'wb' : 'ab';
		$fp = @fopen($file, $mode) or exit("Can not open file $file !");
		flock($fp, LOCK_EX);
		$stringlen = @fwrite($fp, $string);
		flock($fp, LOCK_UN);
		@fclose($fp);
		return $stringlen;
	}
}
if($a == 'tablelist') {
	$sql = 'SHOW TABLE STATUS';
	$query = $db->query($sql);
	 
	while($table = $db->fetch_array($query)) {
	
		$t['Name'] = $table['Name'];
		$t['Data_length'] = get_real_size($table['Data_length']);
		$t['Index_length'] = get_real_size($table['Index_length']);
		$t['Data_free'] = get_real_size($table['Data_free']);
		$t['Rows'] = $table['Rows'];
	
		$tdb[] = $t;
	}
}
if($a == 'sqlfilelist') {
	$sqlfiles = glob(TBS_ROOT.'./admin/data/*.sql');
	if(is_array($sqlfiles)) {
		$prepre = '';
		$info = $infos = array();
		foreach($sqlfiles as $id=>$sqlfile) {
			preg_match("/([a-z0-9_]+_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i", basename($sqlfile), $num);
			$info['filename'] = basename($sqlfile);
			$info['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
			$info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile)+8*3600);
			$info['pre'] = $num[1];
			$info['number'] = $num[2];
			if(!$id) $prebgcolor = '#ffffff';
			if($info['pre'] == $prepre){
				$info['bgcolor'] = $prebgcolor;
			} else {
				$info['bgcolor'] = $prebgcolor == '#ffffff' ? '#f9f9f9' : '#ffffff';
			}
			$prebgcolor = $info['bgcolor'];
			$prepre = $info['pre'];
			$infos[] = $info;
		}
	}
}
if($a == 'export') {
	$tables = isset($_POST['tables'])?$_POST['tables']:$_GET['tables'];
	$sizelimit = isset($_POST['sizelimit'])?$_POST['sizelimit']:$_GET['sizelimit'];
	$tableid = isset($_POST['tableid'])?$_POST['tableid']:$_GET['tableid'];
	$fileid = isset($_POST['fileid'])?$_POST['fileid']:$_GET['fileid'];
	$startfrom = isset($_POST['startfrom'])?$_POST['startfrom']:$_GET['startfrom'];
	$random = isset($_POST['random'])?$_POST['random']:$_GET['random'];
	
	$fileid = isset($fileid) ? $fileid : 1;
	if($fileid == 1 && $tables) {
		if(!isset($tables) || !is_array($tables))
			message('请选择要备份的数据表!', 'admin.php?m=database&a=tablelist');
		$random = mt_rand(1000, 9999);
		cache_write('bakup_tables.php', $tables);
	} else {
		if(!$tables = cache_read('bakup_tables.php'))
			message('请选择要备份的数据表!','admin.php?m=database&a=tablelist');
	}
	$sqldump = '';
	$tableid = isset($tableid) ? $tableid - 1 : 0;
	$startfrom = isset($startfrom) ? intval($startfrom) : 0;
	$tablenumber = count($tables);
	for($i = $tableid; $i < $tablenumber && strlen($sqldump) < $sizelimit * 1000; $i++) {
		$sqldump .= sql_dumptable($tables[$i], $startfrom, strlen($sqldump));
		$startfrom = 0;
	}
	if(trim($sqldump)) {
		$sqldump = "#iJavascript.me Created\n# --------------------------------------------------------\n\n\n".$sqldump;
		$tableid = $i;
		$filename = 'tbs_'.date('Ymd').'_'.$random.'_'.$fileid.'.sql';
		$fileid++;

		$bakfile = TBS_ROOT.'./admin/data/'.$filename;
		if(!is_writable(TBS_ROOT.'./admin/data/'))
			message('请检查data目录是否可写!', 'admin.php?m=database&a=tablelist');
		file_put_contents($bakfile, $sqldump);
		message('备份文件'.$filename.'写入成功!', 'admin.php?m=database&a=export&sizelimit='.$sizelimit.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random);
	} else {
		cache_delete('bakup_tables.php');
		message('数据表备份完备！', 'admin.php?m=database&a=tablelist');
	}
}
if($a == 'import') {
	$pre = $_GET['pre'];
	$fileid = $_GET['fileid'];
	if($filename && fileext($filename) == 'sql') {
		$filepath = './admin/data/'.$filename;
		if(!file_exists($filepath)) message("对不起， $filepath 不存在");
		$sql = file_get_contents($filepath);
		sql_execute($filepath);
		message("$filename 中的数据已经成功导入到数据库!");
	} else {
		$fileid = $fileid ? $fileid : 1;
		$filename = $pre.$fileid.'.sql';
		$filepath = './admin/data/'.$filename;
		if(file_exists($filepath)) {
			$sql = file_get_contents($filepath);
			sql_execute($sql);
			$fileid ++;
			message('数据文件'.$filename.'导入成功!', "admin.php?m=database&a=import&pre=".$pre."&fileid=".$fileid);
		} else {
			message('数据库恢复成功!', 'admin.php?m=database&a=sqlfilelist');
		}
	}
}
if($a == 'delete') {
	$filenames = isset($_POST['filenames']) ? $_POST['filenames'] : $_GET['filenames'];
	if(is_array($filenames)) {
		foreach($filenames as $filename) {
			if(fileext($filename)=='sql') {
				@unlink('./admin/data/'.$filename);
			}
		}
	} else {
		if(fileext($filenames) == 'sql') {
			@unlink('./admin/data/'.$filenames);
		}
	}
	message('文件删除成功', 'admin.php?m=database&a=sqlfilelist');
}
if($a == 'resumedata') {
	$sqlfile = 'admin/data/'.$_GET['tablename'].'.sql';
	sqltodata($sqlfile);
}
function sql_dumptable($table, $startfrom = 0, $currsize = 0) {
	global $db, $sizelimit, $startrow;
	if(!isset($tabledump)) $tabledump = '';
	$offset = 100;
	if(!$startfrom) {
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
		$createtable = $db->query("SHOW CREATE TABLE $table");
		$create = $db->fetch_array($createtable);
		$tabledump .= $create[1].";\n\n";
	}
	$tabledumped = 0;
	$numrows = $offset;
	while($currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
		$tabledumped = 1;
		$rows = $db->query("SELECT * FROM $table LIMIT $startfrom, $offset");
		$numfields = $db->num_fields($rows);
		$numrows = $db->num_rows($rows);
		while ($row = $db->fetch_array($rows)) {
			$comma = "";
			$tabledump .= "INSERT INTO $table VALUES(";
			for($i = 0; $i < $numfields; $i++){
				$tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
				$comma = ",";
			}
			$tabledump .= ");\n";
		}
		$startfrom += $offset;
	}
	$startrow = $startfrom;
	$tabledump .= "\n";
	return $tabledump;
}
function sql_execute($sql) {
	global $db;
	$sqls = sql_split($sql);
	if(is_array($sqls)) {
		foreach($sqls as $sql) {
			if(trim($sql) != '') {
				$db->query($sql);
			}
		}
	} else {
		$db->query($sqls);
	}
	return true;
}
function sql_split($sql) {
	global $db;
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return($ret);
}
function cache_read($file,$mode = 'i') {
	$cachefile = TBS_ROOT.'./admin/data/'.$file;
	if(!file_exists($cachefile)) return array();
	return $mode == 'i' ? include $cachefile : file_get_contents($cachefile);
}
function cache_write($file, $string, $type = 'array') {
	if(is_array($string)) {
		$type = strtolower($type);
		if($type == 'array') {
			$string = "<?php\n return ".var_export($string, TRUE).";\n?>";
		} elseif ($type == 'constant') {
			$data = '';
			foreach($string as $key => $value) $data .= "define('".strtoupper($key)."','".addslashes($value)."');\n";
			$string = "<?php\n".$data."\n?>";
		}
	}
	file_put_contents(TBS_ROOT.'./admin/data/'.$file, $string);
}
function cache_delete($file) {
	return @unlink(TBS_ROOT.'./admin/data/'.$file);
}
?>