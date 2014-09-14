<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once 'common.php';

loadcache('plugin');

$siteid = $_G['cache']['plugin'][$IDENTIFIER]['siteid'];
$ver = $_G['setting']['plugins']['version'][$IDENTIFIER];

include template("$IDENTIFIER:help");

?>