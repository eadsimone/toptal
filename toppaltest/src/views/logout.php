<?php 
echo $mustache->render('home/logout',array('pageInfo' => $page));
//unset( $_SESSION['SSMData']);
session_destroy();
