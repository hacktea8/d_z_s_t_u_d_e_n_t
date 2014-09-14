<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_darfbcomment_forum {

	function viewthread_bottom_output() {
		global $_G, $page;
		if($page!=1) return;
		$config = $_G['cache']['plugin']['darfbcomment'];
		$this->admins = trim($config['admins']);
		$this->numposts = intval($config['numposts']);
		$this->forums = (array)unserialize($config['forums']);
		$this->locale = trim($config['locale']);
		$this->orderby = $config['orderby'];
		$this->width = intval($config['width']);
		$this->delayload = $config['delayload'];
		$this->colorscheme = $config['colorscheme'];
		$this->fposition = $config['fposition'];
		$this->appid = trim($config['appid']);
		
		if(!in_array($_G['fid'], $this->forums)) return;
		if(empty($this->locale)) $this->locale = 'en_US';
		if($this->numposts<=0) $this->numposts = 1;
		
		if(preg_match('/^\d{5,}$/', $this->appid)) {
			$_G['setting']['seohead'] .= "<meta property=\"fb:app_id\" content=\"{$this->appid}\" />\n";
		}
		foreach(explode(',', $this->admins) as $item) {
			$admin = trim($item);
			if(preg_match('/^\d+$/', $admin)) {
				$_G['setting']['seohead'] .= "<meta property=\"fb:admins\" content=\"{$admin}\" />\n";
			}
		}
		include template('darfbcomment:forum');
		return($return);
	}
	
	function viewthread_postbottom() {
		$result[] = "<span id='darfbcomment_postbottom' style='visibility:hidden'></span>";
		return($result);
	}

	function viewthread_useraction() {
		$result = "<span id='darfbcomment_useraction' style='visibility:hidden'></span>";
		return($result);
	}

	function index_bottom_output() {
		global $_G;
		$config = $_G['cache']['plugin']['darfbcomment'];
		$this->admins = trim($config['admins']);
		$this->numposts = intval($config['numposts']);
		$this->locale = trim($config['locale']);
		$this->orderby = $config['orderby'];
		$this->width = intval($config['width']);
		$this->delayload = $config['delayload'];
		$this->colorscheme = $config['colorscheme'];
		$this->fiposition = $config['fiposition'];
		$this->appid = trim($config['appid']);

		if(empty($this->fiposition)) return;
		if(empty($this->locale)) $this->locale = 'en_US';
		if($this->numposts<=0) $this->numposts = 1;
		
		if(preg_match('/^\d{5,}$/', $this->appid)) {
			$_G['setting']['seohead'] .= "<meta property=\"fb:app_id\" content=\"{$this->appid}\" />\n";
		}
		foreach(explode(',', $this->admins) as $item) {
			$admin = trim($item);
			if(preg_match('/^\d+$/', $admin)) {
				$_G['setting']['seohead'] .= "<meta property=\"fb:admins\" content=\"{$admin}\" />\n";
			}
		}
		include template('darfbcomment:findex');
		return($return);
	}

}


class plugin_darfbcomment_portal {

	function view_article_side_top_output() {
		global $_G, $article;
		$config = $_G['cache']['plugin']['darfbcomment'];
		$this->admins = trim($config['admins']);
		$this->numposts = intval($config['numposts']);
		$this->locale = trim($config['locale']);
		$this->orderby = $config['orderby'];
		$this->width = intval($config['width']);
		$this->delayload = $config['delayload'];
		$this->colorscheme = $config['colorscheme'];
		$this->appid = trim($config['appid']);
		$this->aposition = $config['aposition'];
		$this->url = $_G['siteurl'].'portal.php?mod=view&aid='.$article['aid'];
		
		if(empty($this->aposition)) return;
		if(empty($this->locale)) $this->locale = 'en_US';
		if($this->numposts<=0) $this->numposts = 1;
		
		if(preg_match('/^\d{5,}$/', $this->appid)) {
			$_G['setting']['seohead'] .= "<meta property=\"fb:app_id\" content=\"{$this->appid}\" />\n";
		}
		foreach(explode(',', $this->admins) as $item) {
			$admin = trim($item);
			if(preg_match('/^\d+$/', $admin)) {
				$_G['setting']['seohead'] .= "<meta property=\"fb:admins\" content=\"{$admin}\" />\n";
			}
		}
		
		include template('darfbcomment:portal');
		return($return);
	}
	
}

?>