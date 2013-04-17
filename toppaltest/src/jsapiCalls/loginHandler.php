<?php

$email = "";
$password = "";

if(isset($_POST['email'])) {
	$email = $_POST['email'];
}
if(isset($_POST['password'])) {
	$password = $_POST['password'];
}

if(isset($_POST['username'])) {
	//superadmin login
	$username = $_POST['username'];
	$SBResponse = ServicebusSuperAdminLogin($username, $email, $password);
} else {
	//normal login
	$SBResponse = ServicebusLogin($email, $password);
}

$responseData = json_decode($SBResponse, true);

if($responseData['responseCode'] == "1000") {
	 $_SESSION['SSMData']['clientGuid'] = $responseData['responseObject']['client']['guid'];
	 $_SESSION['SSMData']['timeStamp'] = time();
	 $_SESSION['SSMData']['storeGuid'] = $responseData['responseObject']['client']['storeIds'][0];
	 $_SESSION['SSMData']['userEmail'] = $responseData['responseObject']['email'];
}

if(!isset( $_SESSION['SSMData']['clientGuid'])) {
	 $_SESSION['SSMData']['error'] = 'Invalid email and password combination';
}

if(isset($_POST['originalUrl'])) {
	$url = $_POST['originalUrl'];
	$app->redirect("../" . $url);
} else {
	$app->redirect('../home');
}

