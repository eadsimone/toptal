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




function return_new_json($id){
    


    $totaluser=4;
    for( $i=0;$i<=$totaluser;$i++){
        if($i==$id){
        $user = array();

        $user['firstname'] = 'firstname'.$i;
        $user['lastname'] = 'lastname'.$i;
        $user['login'] = 'login'.$i;
        $user['email'] = 'email'.$i.'@cinsay.com';
//foreach channelPartnerGuid create select
            $user['channel'] =
            Array(
                Array('channelPartnerGuid' =>"123-456-780", "name" => "World Pay"),
                Array('value' =>"AK", "label" => "Alaska", "selected" => true),
                Array('value' =>"AS", "label" => "American Samoa")
            );

            //$user['channel'] = 'General Motors'.$i;
        $user['guid'] = $i;
        $i=$totaluser+1;
        }else{
            $user['firstname'] = '';
            $user['lastname'] = '';
            $user['login'] = '';
            $user['email'] = '';
            $user['channel'] =
                 Array(
                    Array('channelPartnerGuid' =>"123-456-780", "name" => "World Pay"),
                    Array('channelPartnerGuid' =>"999-456-78", "label" => "Chevrolet", ),
                    Array('channelPartnerGuid' =>"11222111", "label" => "Fiat")
                 );

            $user['guid'] = $i;
        }

    }



    $new_data = array("User" => array_reverse($user));
    
    return json_encode($new_data);

}
$id=$_SESSION['useradmin']['playerGuid'];

//$json = ServicebusGetPlayerList( $_SESSION['SSMData']['clientGuid']);
//
//$data = json_decode($json,true);
$pp=return_new_json($id);
echo return_new_json($id);

// echo "<pre>";
// print_r(return_new_json($obj));
// echo "</pre>";
