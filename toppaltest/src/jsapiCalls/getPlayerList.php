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


function return_new_json($json){

    $resp_data=$json['responseObject'];
    
    $playerList = array();
    
    foreach( $resp_data as $key => $value ){
    	$player = array();
        if(isset($value['videos'][0])) {
        	$player['thumbSrc'] = $value['videos'][0]['thumbImage']['url'];
        }
        $player['title'] = shrinkText($value['name']);
        $player['guid'] = $value['guid'];
        $player['embedCode'] = $value['embedCode'];
        
        $playerList[] = $player;
        
    }



    $new_data = array("allPlayers" => array_reverse($playerList));
    
    return json_encode($new_data);

}

$json = ServicebusGetPlayerList( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);

echo return_new_json($data);

// echo "<pre>";
// print_r(return_new_json($obj));
// echo "</pre>";
