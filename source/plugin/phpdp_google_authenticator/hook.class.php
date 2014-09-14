<?php
/**
 *     Google Authenticator
 *      $Id: hook.class.php$
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_phpdp_google_authenticator
{

    function global_phpdp_google_authenticator()
    {
        global $_G;
        if ($_G['uid'] and $_G['cookie']['ga_islogin']!=1) {
            if ($pga = DB::fetch_first("SELECT * FROM " . DB::table('phpdp_google_authenticator') .
                " WHERE uid='$_G[uid]'")) {
                if (!strstr($_G['gp_id'],'phpdp_google_authenticator') and CURSCRIPT!='member' and $_G['gp_mod']!='logging') {
                    header('Location: plugin.php?id=phpdp_google_authenticator:login');
                    exit;
                }
            } else {

                dsetcookie('ga_islogin', 0, $_G['timestamp'] - 3600);
            }
        } elseif(!$_G['uid'])dsetcookie('ga_islogin', 0, $_G['timestamp'] - 3600);
    }
    function global_usernav_extra3()
    {
        return '<a href="plugin.php?id=phpdp_google_authenticator:index"><img src="source/plugin/phpdp_google_authenticator/template/ga.png" width="15" height="15" align="absmiddle"> '.lang('plugin/phpdp_google_authenticator','hook_1').'</a> <span class="pipe">|</span> ';
    }
}
class plugin_phpdp_google_authenticator_member extends
    plugin_phpdp_google_authenticator
{
}
class plugin_phpdp_google_authenticator_forum extends
    plugin_phpdp_google_authenticator
{
}
class plugin_phpdp_google_authenticator_home extends
    plugin_phpdp_google_authenticator
{
}
class plugin_phpdp_google_authenticator_group extends
    plugin_phpdp_google_authenticator
{
}
?>