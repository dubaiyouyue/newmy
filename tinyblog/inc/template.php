<?php
function template($filename, $templatedir) {
	$templatefile = TBS_ROOT.'/templates/'.$templatedir.'/'.$filename.'.php';
	if(is_file($templatefile)) {
		return $templatefile;
	} else {
		return TBS_ROOT.'/templates/default/'.$filename.'.php';
	}
}
?>