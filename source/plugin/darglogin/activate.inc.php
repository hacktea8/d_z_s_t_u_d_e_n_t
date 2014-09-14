<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'common.php';

loaducenter();

//get parameter
if(!isset($_GET['code']) || empty($_GET['code'])) exit("ERR:NODATA");
parse_str(authcode($_GET['code'], 'DECODE', UC_KEY), $get);
if(empty($get)) exit("ERR:REQUEST");
if(time()-$get['time']>3600) exit("ERR:EXPIRE");
if(empty($get['uid']) || empty($get['regip'])) exit("ERR:NOPARAM");
$uid = intval($get['uid']);

//check user
$user = uc_get_user($uid, 1);
if(!$user) exit("ERR:NOUSER");

//main
$profile = array();
if(isset($get['gender']) && preg_match('/^[12]$/', $get['gender'])) $profile['gender'] = $get['gender'];
if(isset($get['birthyear']) && preg_match('/^(19|20)\d{2}$/', $get['birthyear'])) $profile['birthyear'] = $get['birthyear'];
$province = C::t("#$IDENTIFIER#district")->get_resideprovince_by_ip($get['regip']);
if($province) $profile['resideprovince'] = $province;
$init_arr = array( 'credits' => explode(',', $_G['setting']['initcredits']), 'emailstatus' => 1, 'profile' => $profile );
C::t('common_member')->insert($uid, $user[1], md5(random(10)), $user[2], $get['regip'], $_G['setting']['newusergroupid'], $init_arr);

//credits
updatecreditbyaction('realemail', $uid);
if($_G['cache']['plugin'][$IDENTIFIER]['ectype'] && $_G['cache']['plugin'][$IDENTIFIER]['ecnumber']) {
	updatemembercount($uid, array('extcredits'.$_G['cache']['plugin'][$IDENTIFIER]['ectype']=>$_G['cache']['plugin'][$IDENTIFIER]['ecnumber']), true, 'RPR', $uid);
}
$fromuid = (!empty($get['fromuid']) && $_G['setting']['creditspolicy']['promotion_register'])? intval($get['fromuid']) : 0;
if($fromuid && getuserbyuid($fromuid)) updatecreditbyaction('promotion_register', $fromuid);

//update cache
require_once libfile('cache/userstats', 'function');
build_cache_userstats();

//ok
echo "OK";

?>