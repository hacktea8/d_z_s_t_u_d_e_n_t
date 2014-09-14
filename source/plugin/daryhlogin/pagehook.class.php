<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_daryhlogin {
	function __construct() {
		include 'common.php';
		global $_G;
		$this->identifier = $IDENTIFIER;
		$this->siteid = trim($_G['cache']['plugin'][$IDENTIFIER]['siteid']);
		$this->iconurl = trim($_G['cache']['plugin'][$IDENTIFIER]['iconurl']);
		$this->comment = trim($_G['cache']['plugin'][$IDENTIFIER]['comment']);
		$this->autobind = $_G['cache']['plugin'][$IDENTIFIER]['autobind'];
		$this->lang = trim($_G['cache']['plugin'][$IDENTIFIER]['lang']);
		$this->fromuid = (!empty($_G['cookie']['promotion']) && $_G['setting']['creditspolicy']['promotion_register'])? intval($_G['cookie']['promotion']) : 0;
		$this->extra = ($this->fromuid)? "&fromuid={$this->fromuid}" : '';
		$this->href = $AUTHURL.'?siteid='.$this->siteid.'&autobind='.$this->autobind.'&lang='.$this->lang.$this->extra;
		$this->showlogin = ($_G['uid'] || $_G['setting']['bbclosed'] || periodscheck('visitbanperiods', 0))? false : true;
	}
	function login_link() {
		return ($this->showlogin)? '<a href="'.$this->href.'" target="_top" rel="nofollow"><img src="'.$this->iconurl.'" class="vm" /></a>'."\n" : '';
	}
	function global_login_extra() {	
		return ($this->showlogin)? '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
			<p><a href="'.$this->href.'"><img src="'.$this->iconurl.'" class="vm" alt="Login" /></a></p>
			<p class="hm xg1" style="padding-top: 2px;">'.$this->comment.'</p>
			</div>' : '';
	}
	function global_login_text() {
		return $this->login_link();
	}
}

class plugin_daryhlogin_member extends plugin_daryhlogin {
	function logging_method() {
		return $this->login_link();
	}
	function register_logging_method() {
		return $this->login_link();
	}
	function logging_member() {
		if($_GET['action']=='login' && $_GET['loginsubmit'] && $_GET['password'] && $_GET['password']==md5('')) {
			showmessage('profile_passwd_illegal');
		}
	}
}

class mobileplugin_daryhlogin extends plugin_daryhlogin {
	function __construct() {
		parent::__construct();
		global $_G;
		$this->mobilelink = addslashes(trim($_G['cache']['plugin'][$this->identifier]['mobilelink']));
		$this->touchlink = addslashes(trim($_G['cache']['plugin'][$this->identifier]['touchlink']));
	}
	function global_footer_mobile() {
		if(!$this->showlogin) return '';
		if(!defined('CURSCRIPT') || CURSCRIPT!='forum') return;
		include template($this->identifier.':login');
		return $return;
	}
}

?>
