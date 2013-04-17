<?php 
/*
{
    "socialMedia": [
	    {
	      "title":"facebook",
	      "description":"Facebook social network",
	      "image":"http://prodcdn.cinsay.edgesuite.net/cdn/transcoded/static/social/facebook_48x48.png"
	    },
	    {
	      "title":"myspace",
	      "description":"Myspace social network",
	      "image":"http://prodcdn.cinsay.edgesuite.net/cdn/transcoded/static/social/myspace_48x48.png"
	    },
	    {
	      "title":"twitter",
	      "description":"Twitter social network",
	      "image":"http://prodcdn.cinsay.edgesuite.net/cdn/transcoded/static/social/twitter_48x48.png"
	    }
    ]
}
*/

include '../functions.php';

function return_new_json($json,$dataplayer){

	$resp_data=$json['responseObject'];
    $dataplayer=$dataplayer['responseObject'][0];

	$socialMediaList = array();

	foreach( $resp_data as $k => $v ){
		 
		$socialNetwork = array(
				"title" => $v['mediaTitle'],
				"description" => $v['mediaDescr'],
				"image" => $v['mediaLargePath']
		);

		$socialMediaList[] = $socialNetwork;

	}

    if($dataplayer['publishedToMarketplace']){
        $mkchecked='checked="checked"';
    }else{
        $mkchecked='';
    }

    $config = getAppConfig();

    $markeplace= array(
        "publishedToMarketplace" => $dataplayer['publishedToMarketplace'],
        "marketPlaceSeoUrlSuffix" => $dataplayer['marketplaceSeoUrlSuffix'],
        "checked" => $mkchecked,
        "userKeywords" => $dataplayer['userKeywords'],
    	"playerUrl" => $config['marketplaceBaseUrl'] . "c/" . $_SESSION['SSMData']['clientGuid'] . "/" . $_GET['pGuid']
    );

	$new_data = array("socialMedia" => $socialMediaList,"marketPlace"=>$markeplace);

	return json_encode($new_data);
}

$json = ServicebusGetSocialMediaList( $_SESSION['SSMData']['clientGuid']);
$data = json_decode($json, true);

$jsonplayer = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']);

$dataplayer = json_decode($jsonplayer,true);

echo return_new_json($data,$dataplayer);

//include './getMarketplaceCategories.php';

exit;
//echo "<pre>";
//print_r(return_new_json($obj));
//echo "</pre>";


