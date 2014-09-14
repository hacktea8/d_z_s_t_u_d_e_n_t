<?php
/**
 * Google Plusone For Discuz!X 2.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_google_1
 * @module	   google_1 
 * @date	   2012-03-09
 * @author	   King
 * @copyright  Copyright (c) 2012 Onexin Platform Inc. (http://www.onexin.com)
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

/*
/-------------Step 1 - Get Google Plusone Code---------------------
http://www.google.com/intl/zh-CN/webmasters/+1/button/

<!-- 将此标记放在您希望呈现 +1 按钮的位置 -->
<div class="g-plusone"></div>

<!-- 将此呈现调用放在适当的位置 -->
<script type="text/javascript">
  window.___gcfg = {lang: 'zh-CN'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

//--------------HTML5-valid +1 tag----------------------------------
<div class="g-plusone"></div>
<g:plusone></g:plusone>

//------------------------------------------------------------------
data-size="tall"			small|medium|normal|tall
data-annotation="inline"	'气泡' = '', 'none' = '无', '内嵌' = 'inline',
data-width="200"			120 ~ 450
*/

class plugin_onexin_google_1 {

	var $conf = array();
	var $isopen = FALSE;

	function plugin_onexin_google_1() {
		global $_G;
		
		if(!isset($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		$this->isopen = $_G['cache']['plugin']['onexin_google_1']['isopen'] ? TRUE : FALSE;
		if($this->isopen && !in_array($_GET['mod'], array('portalcp','spacecp','post'))){
			$this->conf = $_G['cache']['plugin']['onexin_google_1'];
		}
	}
	
	function pocode($pdata){
		$vtag = $this->conf['isvalidtag'] ? 'data-' : '';
$pocode = $this->conf['isvalidtag'] ? '<div class="g-plusone" ' : '<g:plusone ';
if($pdata['size']) $pocode .= $vtag.'size="'.$pdata['size'].'" ';
if($pdata['annotation']) $pocode .= $vtag.'annotation="'.$pdata['annotation'].'" ';
if($pdata['url']) $pocode .= $vtag.'href="'.$pdata['url'].'" ';
$pocode .= $this->conf['isvalidtag'] ? '></div>' : '></g:plusone>';
		return $pocode;
	}

	function global_footer() {
		global $_G;
		
		if(!$this->isopen) return '';
		
		$return = '';
		if($this->conf['issync']) {
			$return .= '<script type="text/javascript">';
			if($this->conf['plusone_lang']) $return .= 'window.___gcfg = {lang: \''.$this->conf['plusone_lang'].'\'};';			
			$return .= "
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = '".$this->conf['plusone_url']."';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();";
			$return .= '</script>';
		}else{
			$return .= '<script type="text/javascript" src="'.$this->conf['plusone_url'].'">{lang: \''.$this->conf['plusone_lang'].'\'}</script>';
		}
		
		return $return;
	}	

	function global_cpnav_extra1() {
		global $_G;
				
		if($this->conf['global_cpnav_extra1']) {
			$pdata = array(
				'url' => $this->conf['siteurl'],				
			);
			return $this->pocode($pdata);
		}
	}

	function global_cpnav_extra2() {
		global $_G;
				
		if($this->conf['global_cpnav_extra2']) {	
			$pdata = array(
				'url' => $this->conf['siteurl'],				
			);
			return $this->pocode($pdata);
		}
	}	

}

// forum
class plugin_onexin_google_1_forum extends plugin_onexin_google_1 {
	
	function index_status_extra(){
		global $_G;
		
		if($this->conf['index_status_extra']) {	
			$pdata = array(
				'size' => 'medium',
				'url' => $this->conf['siteurl'],				
			);
			return parent::pocode($pdata);
		}
	}

	function viewthread_title_extra_output() {
		global $_G, $thread;

		if($this->conf['viewthread_title_extra']) {
			if(@in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
				$canonical = rewriteoutput('forum_viewthread', 1, '', $thread['tid'], 1, '', '');
			} else {
				$canonical = 'forum.php?mod=viewthread&tid='.$thread['tid'];
			}
			$pdata = array(
				'size' => 'medium',
				'url' => $_G['siteurl'].$canonical,				
			);
			return parent::pocode($pdata);
		}
	}

	function viewthread_useraction_output() {
		global $_G, $thread;
		
		if($this->conf['viewthread_useraction']) {
			if(@in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
				$canonical = rewriteoutput('forum_viewthread', 1, '', $thread['tid'], 1, '', '');
			} else {
				$canonical = 'forum.php?mod=viewthread&tid='.$thread['tid'];
			}
			$pdata = array(
				'url' => $_G['siteurl'].$canonical,				
			);
			return parent::pocode($pdata);
		}
	}

}

// home
class plugin_onexin_google_1_home extends plugin_onexin_google_1 {

	function space_blog_title_output() {
		global $_G, $blog;

		if($this->conf['space_blog_title']) {
			if(@in_array('home_blog', $_G['setting']['rewritestatus'])) {
				$canonical = rewriteoutput('home_blog', 1, '', $blog['blogid'], 1, '', '');
			} else {
				$canonical = 'home.php?mod=space&uid='.$blog['uid'].'&do=blog&id='.$blog['blogid'];
			}
			$pdata = array(
				'url' => $_G['siteurl'].$canonical,				
			);
			return parent::pocode($pdata);
		}
	}

}

// portal
class plugin_onexin_google_1_portal extends plugin_onexin_google_1 {

}
	
?>