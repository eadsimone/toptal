<?php 
$loginError = "";
if(isset( $_SESSION['SSMData']['error'])) {
	$loginError =  $_SESSION['SSMData']['error'];
	unset( $_SESSION['SSMData']['error']);
}
echo $mustache->render('home/superadmin',array('pageInfo' => $page, 'error' => $loginError));