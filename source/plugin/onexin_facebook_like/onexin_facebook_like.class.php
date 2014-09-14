<?php
/**
 * Facebook Share For Discuz!X 2.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_facebook_like
 * @module	   facebook_like 
 * @date	   2012-03-09
 * @author	   King
 * @copyright  Copyright (c) 2011 Onexin Platform Inc. (http://www.onexin.com)
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
	
/*
/-------------Step 1 - Get Like Button Code---------------------

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="http://www.onexin.com" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>

data-action="recommend"
data-colorscheme="dark"
data-font="arial"

/-------------Step 2 - Get Open Graph Tags---------------------
Open Graph types
http://developers.facebook.com/docs/opengraph#types

/-------------facebook share----------------------------------
http://www.facebook.com/sharer.php?u=<url to share>&t=<title of content>

*/	

class plugin_onexin_facebook_like {

	var $conf = array();
	var $isopen = FALSE;

	function plugin_onexin_facebook_like() {
		global $_G;		
		if(!isset($_G['cache']['plugin'])){
			loadcache('plugin');
		}
		$this->isopen = $_G['cache']['plugin']['onexin_facebook_like']['isopen'] ? TRUE : FALSE;
		if($this->isopen && !in_array($_GET['mod'], array('portalcp','spacecp','post'))){
			$this->conf = $_G['cache']['plugin']['onexin_facebook_like'];
		}
	}

	function global_footer() {
		global $_G;		
		
		if($this->conf['isopen']) {			
			$return = '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/'.$this->conf['locale'].'/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
		}		
		return $return;
	}	

	function global_cpnav_extra1() {
		global $_G;		
		
		if($this->conf['isopen'] && $this->conf['global_cpnav_extra1']) {		
			$return = '<div class="fb-like" data-href="'.$this->conf['siteurl'].'" data-send="'.$this->conf['send_button'].'" data-layout="button_count" data-width="120" data-show-faces="false" data-font="'.$this->conf['font'].'"></div>';
			return $return;			
		}
	}

	function global_cpnav_extra2() {
		global $_G;
		
		if($this->conf['isopen'] && $this->conf['global_cpnav_extra2']) {							
			$return = '<div class="fb-like" data-href="'.$this->conf['siteurl'].'" data-send="'.$this->conf['send_button'].'" data-layout="button_count" data-width="120" data-show-faces="false" data-font="'.$this->conf['font'].'"></div>';
			return $return;			
		}
	}
	
	//Like Button Code
	function flcode($fdata){	
	}
	
}

// forum
class plugin_onexin_facebook_like_forum extends plugin_onexin_facebook_like {
	
	function index_status_extra(){	
		$result = '';
		
		if($this->conf['isopen'] && $this->conf['index_status_extra']) {
			$result = '<div class="fb-like" data-send="'.$this->conf['send_button'].'" data-layout="'.$this->conf['layout_style'].'" data-width="'.$this->conf['width'].'" data-show-faces="'.$this->conf['show_faces'].'" data-font="'.$this->conf['font'].'"></div>';
		}
		return $result;	
	}
	
	function viewthread_title_extra_output() {
		global $_G, $postlist, $canonical;
		
		//Like Button Code
		$result = '';
		if($this->conf['isopen'] && $this->conf['viewthread_title_extra']) {
			$result = '<div class="fb-like" data-send="'.$this->conf['send_button'].'" data-layout="'.$this->conf['layout_style'].'" data-width="'.$this->conf['width'].'" data-show-faces="'.$this->conf['show_faces'].'" data-font="'.$this->conf['font'].'"></div>';			
		}
		return $result;			
		
	}

	function viewthread_posttop_output() {
		global $_G, $postlist;
		
		if(!$this->isopen || !$_G['uid']) return '';		
		
		//facebook like
		$result = array();
		$i = 1;
		foreach($postlist as $pid => $post) {
			if($this->conf['viewthread_posttop'] && $i <= $this->conf['floornum']) {
				$result[] = '<div class="fb-like" data-send="'.$this->conf['send_button'].'" data-layout="'.$this->conf['layout_style'].'" data-width="'.$this->conf['width'].'" data-show-faces="'.$this->conf['show_faces'].'" data-font="'.$this->conf['font'].'"></div>';
			}
			$i++;
		}
				
		return $result;
	}

	function viewthread_useraction_output() {
		global $_G, $thread;		
		$result = '';
		
		//facebook share
		if($this->conf['isopen'] && $this->conf['viewthread_useraction_fshare']) {
			if(@in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
				$canonical = rewriteoutput('forum_viewthread', 1, '', $thread['tid'], 1, '', '');
			} else {
				$canonical = 'forum.php?mod=viewthread&tid='.$thread['tid'];
			}
			$fsurl = 'http://www.facebook.com/sharer.php?u='.urlencode($_G['siteurl'].$canonical).'&t='.urlencode($_G['forum_thread']['subject']);
			$result .= '<a href="'.$fsurl.'" id="k_fb_share" target="_blank" ><i><img src="'.$_G['siteurl'].'source/plugin/onexin_facebook_like/res/ico_facebook.gif" alt="'.$this->conf['fb_share_word'].'" />'.$this->conf['fb_share_word'].'</i></a>';
		}
		return $result;
	}	

}

// home
class plugin_onexin_facebook_like_home extends plugin_onexin_facebook_like {

	function space_blog_title_output() {
		global $_G, $blog;		
		$result = '';
		
		if($this->conf['isopen'] && $this->conf['space_blog_title']) {
			$result = '<div class="fb-like" data-send="'.$this->conf['send_button'].'" data-layout="'.$this->conf['layout_style'].'" data-width="'.$this->conf['width'].'" data-show-faces="'.$this->conf['show_faces'].'" data-font="'.$this->conf['font'].'"></div>';
		}		
		return $result;
	}

}


// portal
class plugin_onexin_facebook_like_portal extends plugin_onexin_facebook_like {
	//view_share_method
}
	
	
?>