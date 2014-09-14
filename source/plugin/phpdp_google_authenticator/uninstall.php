<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_phpdp_google_authenticator`;
EOF;
runquery($sql);
$finish = TRUE;

?>