<?php

$email = "";

if(isset($_POST['email'])) {
	$email = $_POST['email'];

	$SBResponse = ServicebusResetPassword($email);
	
	$responseData = json_decode($SBResponse, true);
	
	if($responseData['responseCode'] == "1000") {
		SSMData('passwordReset','success');
	} else {
		SSMData('passwordReset','failure');
	}
}

$app->redirect('../forgot_password');
