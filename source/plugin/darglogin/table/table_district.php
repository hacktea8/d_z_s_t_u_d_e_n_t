<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_district extends table_common_district {

	public function get_resideprovince_by_ip($ip) {
		require_once libfile('function/misc');
		$location = cutstr(str_replace('- ', '', convertip($ip)), 4, '');
		if(!empty($location)) {
			$district = DB::fetch_first('SELECT * FROM %t WHERE level=1 AND (usetype&2>0) AND name LIKE %s', array($this->_table, $location.'%'));
			if(!empty($district)) return($district['name']);
		}
		return(NULL);
	}
}
