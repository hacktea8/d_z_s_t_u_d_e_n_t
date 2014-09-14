<?php
/**
 *     Google Authenticator
 *      $Id: binding.inc.php$
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (empty($_G['uid']))showmessage('to_login', '', array(), array('login' => true));
$pga = DB::fetch_first("SELECT * FROM " . DB::table('phpdp_google_authenticator') . " WHERE uid='$_G[uid]'");
if (!empty($_G['gp_check']) and !$pga){
    $my_code = trim($_G['gp_code']);
    $my_secret = trim($_G['gp_secret']);
    if (!$my_code or !$my_secret)showmessage(lang('plugin/phpdp_google_authenticator','binding_1'));
$my_info = file_get_contents("http://google-authenticator.phpdp.com/?_t=check&secret={$my_secret}&code={$my_code}");
if ($my_info=='Ok'){
    DB::insert('phpdp_google_authenticator',array('uid'=>$_G['uid'],'email'=>$_G['member']['email'],'secret'=>$my_secret,'time'=>$_G['timestamp']));
    showmessage(lang('plugin/phpdp_google_authenticator','binding_3'),'plugin.php?id=phpdp_google_authenticator:index',array(), array('showdialog' => true, 'locationtime' => true));
    } else {
    showmessage(lang('plugin/phpdp_google_authenticator','binding_2'));
    }
    } elseif (!empty($_G['gp_unbd']) and $pga){
    $my_code = trim($_G['gp_code']);
    if (!$my_code)showmessage(lang('plugin/phpdp_google_authenticator','binding_1'));
        $my_info = file_get_contents("http://google-authenticator.phpdp.com/?_t=check&secret={$pga[secret]}&code={$my_code}");
        if ($my_info=='Ok'){
    DB::delete('phpdp_google_authenticator',array('uid'=>$_G['uid']));
    showmessage(lang('plugin/phpdp_google_authenticator','binding_4'),'plugin.php?id=phpdp_google_authenticator:index',array(), array('showdialog' => true, 'locationtime' => true));
    } else {
    showmessage(lang('plugin/phpdp_google_authenticator','binding_2'));
    }
    }
$my_name = ucwords($_G['member']['email']);
$my_secret = file_get_contents("http://google-authenticator.phpdp.com/?_t=secret&name={$my_name}");
if (!empty($_G['gp_un'])){
		include template('phpdp_google_authenticator:unbinding');
        } else {
		include template('phpdp_google_authenticator:binding');
        }
?>