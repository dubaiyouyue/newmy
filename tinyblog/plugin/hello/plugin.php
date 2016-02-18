<?php
function say_hello() {
	global $username;
	echo '<div style="float:left;margin-left:0px;color:#fff;padding-left:5px;padding-right:5px;line-height:30px;background-color:#e47e00;text-align:center">Hello<strong> '.$username.'</strong> This is a plugin demo!</div>';
}
$this->add_action('PLUGIN_DEMO', 'say_hello');
?>