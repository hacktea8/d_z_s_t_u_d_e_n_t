<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function postdata($eu, $data) {
	global $IDENTIFIER;
	if(!preg_match('/^http/i', $eu)) $eu = authcode($eu, 'DECODE', $IDENTIFIER);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 25);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $eu);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('DAR: OK'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	$result = @curl_exec($ch);
	curl_close($ch);
	return($result);
}

?>