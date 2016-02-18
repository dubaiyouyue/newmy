<?php
function authcode($string, $operation = 'ENCODE') {
	$string = $operation == 'DECODE' ? base64_decode($string) : base64_encode($string);
	return $string;
}
function char($string) {
	$string = htmlspecialchars(addslashes(trim($string)));
	return $string;
}
function check_email($email) {
	if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$", $email)) {   
		return false;
	}
	return true;     
}
function check_weburl($weburl) {     
	if(!ereg("^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $weburl)) {
		return false;
	}     
	return true; 
}
function cutstr($string, $length, $dot = '...') {
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	$n = $tn = $noc = 0;
	while($n < strlen($string)) {
		$t = ord($string[$n]);
		if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
			$tn = 1; $n++; $noc++;
		} elseif (194 <= $t && $t <= 223) {
			$tn = 2; $n += 2; $noc += 2;
		} elseif (224 <= $t && $t < 239) {
			$tn = 3; $n += 3; $noc += 2;
		} elseif (240 <= $t && $t <= 247) {
			$tn = 4; $n += 4; $noc += 2;
		} elseif (248 <= $t && $t <= 251) {
			$tn = 5; $n += 5; $noc += 2;
		} elseif ($t == 252 || $t == 253) {
			$tn = 6; $n += 6; $noc += 2;
		} else {
			$n++;
		}
		if($noc >= $length) {
			break;
		}
	}
	if($noc > $length) {
		$n -= $tn;
	}
	$strcut = substr($string, 0, $n);
	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut;
}
function fileext($filename) {
	return substr(strrchr($filename, '.'), 1);
}
function getdirdb($dir) {
	if(!is_dir($dir)) {
		echo '目录参数不正确！';
		exit();
	}
	$dh = opendir($dir) or die('不能打开此目录！');
	while($file = readdir($dh)) {
		if($file == '.' or $file == '..' or $file == 'admin') {
			continue;
		} else {
			$dir_arr[] = $file;
		}
	}
	closedir($dh);
	return $dir_arr;
}
function getip() {
	if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
		$ipaddr = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
	} elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) {
		$ipaddr = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
	} elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) {
		$ipaddr = $HTTP_SERVER_VARS["REMOTE_ADDR"];
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
		$ipaddr = getenv("HTTP_X_FORWARDED_FOR");
	} elseif (getenv("HTTP_CLIENT_IP")) {
		$ipaddr = getenv("HTTP_CLIENT_IP");
	} elseif (getenv("REMOTE_ADDR")) {
		$ipaddr = getenv("REMOTE_ADDR");
	} else {
		$ipaddr = "Unknown IP!";
	}
	return $ipaddr;
}
function geturl() {
	$thisdir = dirname($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
	$thisdir = ($thisdir == '\\') ? '' : $thisdir;
	$hosturl = $_SERVER['HTTP_HOST'];
	$url = 'http://'.$hosturl.$thisdir;
	return $url;
}
function gethostdir() {
	$thisdir = dirname($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
	$thisdir = ($thisdir == '\\') ? '' : $thisdir;
	$dir = substr($thisdir, 0, -7);
	return $dir;
}
function message($message, $pageurl) {
	global $options;
	$message = $message;
	$pageurl = $pageurl;
	require_once template('message', 'admin', '');
	exit();
}
function multipage($pur_page, $page, $url, $maxshowpage, $total) {
	if ($total > $pur_page) {
		if(is_int($total/$pur_page)) {
			$endpage = intval($total / $pur_page);
		} else {
			$endpage = intval($total / $pur_page) + 1;
		}
	} elseif ($total < $pur_page || $total == $pur_page) {
		$endpage = 1;
	}
	$multipage = "<a class=records>Records:".$total."</a>";
	$multipage .= "<a class=pageinfo>".$page."/".$endpage."</a>";
	$multipage .= "<a class=first href=".$url."page=1>«</a>";
	if (($page == '') || $page==1) {
		$multipage .= "<a>‹</a>";
	} else {
		$multipage .= "<a href=".$url."page=".($page-1).">‹"."</a>";
	}
	
	if($page == '') {
		$page = 1;
	}
	$fromtmp = $page - $maxshowpage;
	$totmp = $page + $maxshowpage;
	$from = $fromtmp <= 1 ? 1: $fromtmp;
	$to = $totmp >= $endpage ? $endpage : $totmp;
	for($i = $from;$i <= $to;$i++) {
		if($page == $i) {
			$multipage .= "<a class=currentpage href=".$url."page=".$i.">".$i."</a>";
		} else {
			$multipage .= "<a href=".$url."page=".$i.">".$i."</a>";
		}
	}
	if($page == $endpage) {
		$multipage .= "<a>›</a>";
	} else {
		$multipage .= "<a href=".$url."page=".($page+1).">›"."</a>";
	}
	$multipage .= "<a class=last href=".$url."page=".$endpage.">»</a>";
	return $multipage;
}
function htmlpage($pur_page, $page, $url, $maxshowpage, $total) {
	if ($total > $pur_page) {
		if(is_int($total/$pur_page)) {
			$endpage = intval($total / $pur_page);
		} else {
			$endpage = intval($total / $pur_page) + 1;
		}
	} elseif ($total < $pur_page || $total == $pur_page) {
		$endpage = 1;
	}
	$htmlpage = "<a class=records>Records:".$total."</a>";
	$htmlpage .= "<a class=pageinfo>".$page."/".$endpage."</a>";
	$htmlpage .= "<a class=first href=".$url."1>«</a>";
	if(($page == '') || $page==1) {
		$htmlpage .= "<a>‹</a>";
	} else {
		$htmlpage .= "<a href=".$url.($page-1).">‹"."</a>";
	}
	if($page == '') {
		$page = 1;
	}
	$fromtmp = $page - $maxshowpage;
	$totmp = $page + $maxshowpage;
	$from = $fromtmp <= 1 ? 1: $fromtmp;
	$to = $totmp >= $endpage ? $endpage : $totmp;
	for($i = $from;$i <= $to;$i++) {
		if($page == $i) {
			$htmlpage .= "<a class=currentpage href=".$url.$i.">".$i."</a>";
		} else {
			$htmlpage .= "<a href=".$url.$i.">".$i."</a>";
		}
	}
	if($page == $endpage) {
		$htmlpage .= "<a>›</a>";
	} else {
		$htmlpage .= "<a href=".$url.($page+1).">›"."</a>";
	}
	$htmlpage .= "<a class=last href=".$url.$endpage.">»</a>";
	return $htmlpage;
}
function htmlpage_index($pur_page, $page, $url, $maxshowpage, $total) {
	if ($total > $pur_page) {
		if(is_int($total/$pur_page)) {
			$endpage = intval($total / $pur_page);
		} else {
			$endpage = intval($total / $pur_page) + 1;
		}
	} elseif ($total < $pur_page || $total == $pur_page) {
		$endpage = 1;
	}
	$htmlpage = "<a class=records>Records:".$total."</a>";
	$htmlpage .= "<a class=pageinfo>".$page."/".$endpage."</a>";
	$htmlpage .= "<a class=first href=".$url."page/1>«</a>";
	if(($page == '') || $page == 1) {
		$htmlpage .= "<a>‹</a>";
	} else {
		$htmlpage .= "<a href=".$url."page/".($page-1).">‹"."</a>";
	}
	if($page == '') {
		$page = 1;
	}
	$fromtmp = $page - $maxshowpage;
	$totmp = $page + $maxshowpage;
	$from = $fromtmp <= 1 ? 1: $fromtmp;
	$to = $totmp >= $endpage ? $endpage : $totmp;
	for($i = $from; $i <= $to; $i++) {
		if($page == $i){
			$htmlpage .= "<a class=currentpage href=".$url."page/".$i.">".$i."</a>";
		} else {
			$htmlpage .= "<a href=".$url."page/".$i.">".$i."</a>";
		}
	}
	if($page == $endpage) {
		$htmlpage .= "<a>›</a>";
	} else {
		$htmlpage .= "<a href=".$url."page/".($page+1).">›"."</a>";
	}
	$htmlpage .= "<a class=last href=".$url."page/".$endpage.">»</a>";
	return $htmlpage;
}
function random($length) {
	$hash = 'tbs-';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
function generatecode($length = 6) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
	$code = '';
	while (strlen($code) < $length) {
		$code .= $chars[mt_rand(0,strlen($chars))];
	}
	return $code;
}
function redirect($message, $pageurl) {
	global $options, $templatename;
	$message = $message;
	$pageurl = $pageurl;
	require_once template('redirect', $templatename, '');
	exit();
}
function sendtrackback($url, $data) {
	$uinfo = parse_url($url);
	if($uinfo['query']) {
		$data .= '&'.$uinfo['query'];
	}
	if(!$fp = @fsockopen($uinfo['host'], ($uinfo['port'] ? $uinfo['port'] : '80'), $errno, $errstr, 3)) {
		return false;
	}
	fputs($fp, "POST ".$uinfo['path']." HTTP/1.1\r\n");
	fputs($fp, "Host: ".$uinfo['host']."\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ".strlen($data)."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $data);
	$http_response = '';
	while(!feof($fp)) {
		$http_response .= fgets($fp, 128);
	}
	@fclose($fp);
	list($http_headers, $http_content) = explode('\r\n\r\n', $http_response);
	return $http_response;
}
function sn_stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $value) {
			$string[$key] = sn_stripslashes($value);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}
function highlight_code($code) {
	$code = str_replace("&nbsp;&nbsp;&nbsp;", "&nbsp;&nbsp;", $code);
	$code = str_replace("&nbsp;&nbsp;", "&nbsp;", $code);
	$code = str_replace("&nbsp;", "\t", $code);
	$code = str_replace("&quot;", '"', $code);
	$code = str_replace("<br>", "", $code);
	$code = str_replace("<br />", "", $code);
	$code = str_replace("&gt;", ">", $code);
	$code = str_replace("&lt;", "<", $code);
	$code = highlight_string($code, true);
	$code = explode("<br />", $code);
	foreach ($code as $line => $syntax) {
		$code_str .= $syntax;
	}
	return $code_str;
}
function ubb($string) {
	$string = htmlspecialchars($string);
	$string = preg_replace("/\ /", "&nbsp;", $string);
    $string = preg_replace("/\t/", "&nbsp;&nbsp;&nbsp;&nbsp;", $string);
	$string = preg_replace("/\r?\n/",'<br />', $string);
	/*$string = preg_replace("/(^|[^=\]])(http|https|ftp)(:\/\/[\!-;\=\?-\~]+)/si", "\\1<a href=\"\\2\\3\" target=_blank>\\2\\3</a>", $string);
	$string = preg_replace("/(^|[^=\]\/])(www\.[\!-;\=\?-\~]+)/si", "\\1<a href=\"http://\\2\" target=_blank>\\2</a>", $string);*/
	$string = preg_replace("/\[url](.*?)\[\/url]/i", '<a href="$1" target=_blank >$1</a>', $string);
	$string = preg_replace("/\[url=(.*?)](.*?)\[\/url]/i", '<a href="$1" target=_blank >$2</a>', $string);
	$string = preg_replace("/\[email](.*?)\[\/email]/i", '<a href="mailto:$1">$1</a>',$string);
	$string = preg_replace("/\[email=(.*?)](.*?)\[\/email]/i", '<a href="mailto:$1">$2</a>', $string);
	$string = preg_replace("/\[img](.*?)\[\/img]/i", '<img class="postimg" src="$1" />', $string);
	$string = preg_replace("/\[attach](.*?)\[\/attach]/i", '<a href="$1" target=_blank >$1</a>', $string);
	$string = preg_replace("/\[attach=(.*?)](.*?)\[\/attach]/i", '<a href="$1" target=_blank >$2</a>', $string);
	$string = preg_replace("/\[b](.*?)\[\/b]/is", '<strong>$1</strong>', $string);
	$string = preg_replace("/\[i](.*?)\[\/i]/is", '<em>$1</em>', $string);
	$string = preg_replace("/\[u](.*?)\[\/u]/is", '<u>$1</u>', $string);
	$string = preg_replace("/\[del](.*?)\[\/del]/is", '<del>$1</del>', $string);
	$string = preg_replace("/\[code](.*?)\[\/code]/is", '<code>$1</code>', $string);
	$string = preg_replace("/\[color=(.*?)](.*?)\[\/color]/is", '<font color="$1">$2</font>', $string);
	$match = array("/(\[red\])(.*)(\[\/red\])/iU",
                   "/(\[blue\])(.*)(\[\/blue\])/iU",
                   "/(\[green\])(.*)(\[\/green\])/iU");
    $replace = array("<span style=\"color:red;\">\\2</span>",
                     "<span style=\"color:blue;\">\\2</span>",
                     "<span style=\"color:green;\">\\2</span>");
    $string = preg_replace($match, $replace, $string);
	$match = array("/(\[center\])(.*)(\[\/center\])/iU",
                   "/(\[left\])(.*)(\[\/left\])/iU",
                   "/(\[right\])(.*)(\[\/right\])/iU");
    $replace = array("<div style=\"text-align:center;\">\\2</div>",
                     "<div style=\"text-align:left;\">\\2</div>",
                     "<div style=\"text-align:right;\">\\2</div>");
    $string = preg_replace($match, $replace, $string);
	$string = preg_replace("/\[size=(.*?)](.*?)\[\/size]/is", '<font size="$1">$2</font>', $string);
	$string = preg_replace("/\[font=(.*?)](.*?)\[\/font]/is", '<font face="$1">$2</font>', $string);
	$string = preg_replace("/\[quote=(.*?)\]\s*(.+?)\s*\[\/quote\]/is", "<div style=\"font-weight: bold\">引用 \\1 说过的话:</div><div class=\"quote\">\\2</div>", $string);
	$string = preg_replace("/(\[flash=(.*),(.*)\])(.*)(\[\/flash\])/iU", 
        "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" "
        ."codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\""
        ."width=\"\\2\" height=\"\\3\">"
        ."<param name=\"movie\" value=\"\\4\" />"
        ."<param name=\"quality\" value=\"high\" />"
        ."<param name=\"wmode\" value=\"Opaque\">"
        ."<embed src=\"\\4\" width=\"\\2\" height=\"\\3\" quality=\"high\" "
        ."type=\"application/x-shockwave-flash\" "
        ."wmode=\"Opaque\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed></object>", $string);
	return $string;
}
function writetofile($objfile, $contents) {
	if(is_file($objfile)) {
    	chmod($objfile, 0777);
	}
	if($fp = fopen($objfile, w)) {
		fwrite($fp, $contents, strlen($contents));
		fclose($fp);
	}
}
function get_artpageurl($artid, $htmlurl) {
	global $options;
	if($options['ishtml'] == 1) {
		if($htmlurl == '') {
			if($options['selfartsuffix'] != '') {
				$artpageurl = $options['url'].'/'.$options['artdir'].'/'.$artid.'.'.$options['selfartsuffix'];
			} elseif($options['artsuffix'] != '0') {
				$artpageurl = $options['url'].'/'.$options['artdir'].'/'.$artid.'.'.$options['artsuffix'];
			} else {
				$artpageurl = $options['url'].'/'.$options['artdir'].'/'.$artid;
			}
		} else {
			$artpageurl = $options['url'].'/'.$options['artdir'].'/'.$htmlurl;
		}
	} else {
		$artpageurl = $options['url'].'/article.php?id='.$artid;
	}
	return $artpageurl;
}
function get_html_url($cateid, $cateurl, $artid, $htmlurl) {
	global $options;
	if($options['ishtml'] == 1) {
		if($cateurl == '') {
			$html_url['cateurl'] = $options['url'].'/'.$options['catedir'].'/'.$cateid;
		} else {
			$html_url['cateurl'] = $options['url'].'/'.$options['catedir'].'/'.$cateurl;
		}
		if($htmlurl == '') {
			if($options['selfartsuffix'] != '') {
				$html_url['pageurl'] = $options['url'].'/'.$options['artdir'].'/'.$artid.'.'.$options['selfartsuffix'];
			} elseif($options['artsuffix'] != '0') {
					$html_url['pageurl'] = $options['url'].'/'.$options['artdir'].'/'.$artid.'.'.$options['artsuffix'];
			} else {
					$html_url['pageurl'] = $options['url'].'/'.$options['artdir'].'/'.$artid;
			}
		} else {
			$html_url['pageurl'] = $options['url'].'/'.$options['artdir'].'/'.$htmlurl;
		}
	} else {
		$html_url['cateurl'] = $options['url'].'/index.php?action=category&cateid='.$cateid;
		$html_url['pageurl'] = $options['url'].'/article.php?id='.$artid;
	}
	return $html_url;
}
?>