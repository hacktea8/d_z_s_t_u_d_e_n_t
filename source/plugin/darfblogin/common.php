<?php

if(!defined('IN_DISCUZ')) {
        exit('Access Denied');
}

$provider = 'fb';

if($provider=='fb') {
	$IDENTIFIER = 'darfblogin';
	$CHECKEU = 'a4b53CjEgL4Wd2TCXBkQoy3TohLotxIv6JNJV8YBn6rrB02tYm4b37trAxa5gKwNZshX2NBeSHTYVx43xAnLXg';
	$APPLYEU = '3187szqzEHeCV8YRcr/hFGISVfBhryh8MzTTfQ+/p9pVr0SyelhWQdRV3k1ulCRCkfB75GQWLKCT3BqW34vCvQ';
	$AUTHURL = 'http://fb.ap.rdevhost.com/auth1.php';
	$HELPURL = 'http://fb.ap.rdevhost.com/help.php';
} else if($provider=='yh') {
	$IDENTIFIER = 'daryhlogin';
	$CHECKEU = 'd829QbhkRX6oguL9J0CfIWJs0IQqxY5B19TCpBXiILdgeGNw2ccz4xVf0s0k2tLNAsQVd8Aw6B8dkOr5UV329A';
	$APPLYEU = '73e2QgFpMKWeTbZ3XmaEpQxkwOIEKsf18sV5pUhg8SHZlplYGrCsShWibyVCMqfdBTOb4rB7qtXsE5I6QGabtg';
	$AUTHURL = 'http://yh.ap.rdevhost.com/auth1.php';
	$HELPURL = 'http://yh.ap.rdevhost.com/help.php';
} else if($provider=='g') {
	$IDENTIFIER = 'darglogin';
	$CHECKEU = '0ed0yzFIa8yqttexhzBn3a86gNNtzLXf6lTc29XhF2qH8xTRji54Cff86GL9oRE0pUvuWca9AbF6CuKtP8Vq';
	$APPLYEU = '73a8k6nLPylfhJKLpdMa1OFkoHLnd8knnD1pAyAJFCptJSuifPC2Cwtce4DW98h0eQRlhr77EigfIfuHTzOZ';
	$AUTHURL = 'http://g.ap.rdevhost.com/auth1.php';
	$HELPURL = 'http://g.ap.rdevhost.com/help.php';
}

?>
