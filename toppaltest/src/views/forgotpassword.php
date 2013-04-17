<?php 
if(SSMData('passwordReset') == "success") {
	echo $mustache->render('home/passwordresetsuccessful',array('pageInfo' => $page));
} else if(SSMData('passwordReset') == "failure") {
	echo $mustache->render('home/passwordreseterror',array('pageInfo' => $page));
} else {
	echo $mustache->render('home/forgotpassword',array('pageInfo' => $page));
}

unsetSSMData('passwordReset');
