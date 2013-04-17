<?php
/*
{
	"allPlayers": [
	{
	"player": {
			"thumbSrc": "images/movie1.jpg",
        "title": "Best Player Ever!",
        "guid": "14eb98bc-99e4-4c47-922a-36db1737263f"
      }
    },
    {
	"player": {
	"thumbSrc": "images/movie2.jpg",
			"title": "Best Player Ever!",
			"guid": "14eb98bc-99e4-4c47-922a-36db1737263f"
      }
    }
  ]
}
*/

include '../functions.php';


function return_new_json(){
    
    $playerList = array();

    $totaluser=4;
    for( $i=0;$i<=$totaluser;$i++){
        $user = array();

        $user['firstname'] = 'firstname'.$i;
        $user['lastname'] = 'lastname'.$i;
        $user['login'] = 'login'.$i;
        $user['email'] = 'email'.$i.'@cinsay.com';
        $user['channel'] = 'General Motors'.$i;
        $user['guid'] = $i;

        $userList[] = $user;

    }



    $new_data = array("allUser" => array_reverse($userList));
    
    return json_encode($new_data);

}

//$json = ServicebusGetPlayerList( $_SESSION['SSMData']['clientGuid']);
//
//$data = json_decode($json,true);
$pp=return_new_json();
echo return_new_json();

// echo "<pre>";
// print_r(return_new_json($obj));
// echo "</pre>";
