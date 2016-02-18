<?php
class db {
	var $connstring;
	var $querynum = 0;
	function connect($dbhost, $dbusername, $dbpassword) {
		$this->connstring = mysql_connect($dbhost, $dbusername, $dbpassword) or die($this->halt('can not connect to database！'));
		return $this->connstring;
	}
	function select_db($dbname) {
		mysql_select_db($dbname) or die ($this->halt('unknown database！'));
	}
	function query($querystring) {
		$result = mysql_query($querystring, $this->connstring);
		if(!$result) {
			$this->halt('query faile！', $querystring);	
		}
		$this->querynum ++;
		return $result;
	}
	function fetch_array($result) {
		$record = mysql_fetch_array($result);
		return $record;
	}
	function num_fields($result) {
		$fields = mysql_num_fields($result);
		return $fields;
	}
	function num_rows($result) {
		$rows = mysql_num_rows($result);
		return $rows;
	}
	function insert_id() {
		$insertid = mysql_insert_id();
		return $insertid;
	}
	function rows_count($sql) {
		$result = $this->query($sql);
		$rowsnum = $this->num_rows($result);
		return $rowsnum;
	}
	function free_result($query){
		$query = mysql_free_result($query);
		return $query;
	}
	function getversion() {
		return mysql_get_server_info($this->connstring);
	}
	function fetch_all($sql, &$arr) {
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
	}
	function halt($msg = '', $sql = '') {
		$output = '<div style="font-size:11px;font-family:Verdana;"><strong>msg:</strong> '.$msg.'<br /><strong>sql:</strong> '.$sql.'<br /><strong>errno:</strong> '.mysql_errno().'<br /><strong>error:</strong> '.mysql_error().'</div>';
		exit($output);
	}
}
$db = new db();
?>