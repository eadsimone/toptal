<?php 
$loginError = "";
if(isset( $_SESSION['SSMData']['error'])) {
	$loginError =  $_SESSION['SSMData']['error'];
	unset( $_SESSION['SSMData']['error']);
}
echo $mustache->render('home/login',array('pageInfo' => $page, 'error' => $loginError));
echo "\n<!-- " . $GLOBALS['_SERVER']['BASE_URL'] . " -->";