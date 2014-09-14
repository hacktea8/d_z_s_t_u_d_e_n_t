<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'common.php';

loaducenter();
                                                       
//get parameter
if(!isset($_GET['code']) || empty($_GET['code'])) exit("ERR:NODATA");
parse_str(authcode($_GET['code'], 'DECODE', UC_KEY), $get);
if(empty($get)) exit("ERR\tREQUEST");
if(empty($get['email']) || !preg_match('/.+@.+\..+/', $get['email'])) exit("ERR\tNOPARAM");
$email = $get['email'];

//check user
include_once UC_ROOT.'./model/base.php';
$modelbase = new base();
$modelbase->load('user');
if(!$_ENV['user'] || !method_exists($_ENV['user'], 'get_user_by_email')) exit("ERR\tNOLIB");
$user = $_ENV['user']->get_user_by_email($email);
if(!$user || !$user['uid']) exit("ERR\tNOUSER");

//check member
$member = C::t('common_member')->fetch($user['uid'], 0, 1);
if(!is_array($member) || !$member['uid'] || !$member['username']) exit("ERR\tNOMEMBER");
if(substr($member['username'], -3)=='@FB') exit("ERR\tUSERNAME:Facebook");
if(substr($member['username'], -2)=='@Y') exit("ERR\tUSERNAME:Yahoo");
if(substr($member['username'], -2)=='@G') exit("ERR\tUSERNAME:Google");
if( ($member['groupid']>=10 || in_array($member['groupid'], array(1,2,3))) && $member['adminid']>=0 && $member['status']>=0 ) {
	echo "OK\t{$member['uid']}\t{$member['username']}";
} else {
	echo "ERR\tSTATUS:{$member['groupid']},{$member['adminid']},{$member['status']}";
}

?>
