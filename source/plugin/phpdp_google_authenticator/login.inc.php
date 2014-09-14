<?php
/**
 *     Google Authenticator
 *      $Id: login.inc.php$
 */
if (empty($_G['uid']))showmessage('to_login', '', array(), array('login' => true));
$pga = DB::fetch_first("SELECT * FROM " . DB::table('phpdp_google_authenticator') .
            " WHERE uid='$_G[uid]'");
            if ($_G['gp_check']){
            if ($_G['gp_code']){
            $my_code = trim($_G['gp_code']);
            $my_info = file_get_contents("http://google-authenticator.phpdp.com/?_t=check&secret={$pga[secret]}&code={$my_code}");
            if ($my_info == 'Ok') {
                                dsetcookie('ga_islogin', 1);
                                showmessage(lang('plugin/phpdp_google_authenticator','binding_5'),'plugin.php?id=phpdp_google_authenticator:index',array(), array('showdialog' => true, 'locationtime' => true));

            } else {
                dsetcookie('ga_islogin', -1);
                showmessage(lang('plugin/phpdp_google_authenticator','binding_2'));
            }
                exit;
            } else {
                showmessage(lang('plugin/phpdp_google_authenticator','binding_1'));
            }
            }
            if (!$pga or $_G['cookie']['ga_islogin']==1){
                
		include template('phpdp_google_authenticator:index');
            } else {
                
		include template('phpdp_google_authenticator:login');
            }
?>