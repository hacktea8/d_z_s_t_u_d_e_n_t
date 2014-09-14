<?php
/**
 *     Google Authenticator
 *      $Id: index.inc.php$
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (empty($_G['uid']))showmessage('to_login', '', array(), array('login' => true));
$pga = DB::fetch_first("SELECT * FROM " . DB::table('phpdp_google_authenticator') . " WHERE uid='$_G[uid]'");
include template('phpdp_google_authenticator:index');
?>