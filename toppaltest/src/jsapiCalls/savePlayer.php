<?php
include '../functions.php';
include './MarketPlace.php';
/*Begin,Validation Server side*/
if(!isset($_POST['player_name']) || $_POST['player_name']=='') {
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field name is empty'));
    exit;
}elseif($_POST['player_name']!=''){
//    if (!preg_match('/^[a-zA-Z0-9+&-][a-zA-Z0-9\s+&-]{0,}[a-zA-Z0-9+&-]$/',$_POST['player_name'])) {
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid player name without white space at beginning and end.'));
//        exit;
//    }
    $spchar=array('[','@',']','{','}','#','$','^','&','(',')','<','>');
    foreach($spchar as $value){

        if(strstr($_POST['player_name'], $value)!=false){
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid player name.'));
            exit;
        }
    }
//    if (preg_match('/^[@#$^&()_<>]$/',$_POST['player_name'])) {
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid player name.'));
//        exit;
//    }
}
if(ctype_space($_POST['player_name'])) {
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field name only contain whitespace'));
    exit;
}


if(isset($_POST['affiliatetrackingurl']) && ($_POST['affiliatetrackingurl']!='')){
    if (!preg_match('/^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i',$_POST['affiliatetrackingurl'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
        exit;
    }
}
if(isset($_POST['thankyoulink']) && ($_POST['thankyoulink']!='')){
    if (!preg_match('/^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i',$_POST['thankyoulink'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
        exit;
    }
}
if(isset($_POST['endvideolink']) && ($_POST['endvideolink']!='')){
    if (!preg_match('/^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i',$_POST['endvideolink'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
        exit;
    }
}

//if(($_POST['affiliatetrackingurl']=='') || ($_POST['thankyoulink']=='')||($_POST['endvideolink']=='')){
//    echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
//    exit;
//}




//note:it is on ui side but is not working
if(isset($_POST['keywordbox'])&&($_POST['keywordbox']!='')){
    $keywords=$_POST['keywordbox'];
    $keywordList = explode(',',$keywords);
    for($i = 0; $i < count($keywordList); $i++) {
        $keyword = trim($keywordList[$i]);
        if (strlen($keyword) > 20) {
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please, enter 20 or less characters for each keyword. The keywords must be separated by commas'));
            exit;
        }
    }
}

//note:it is on ui side but is not working
if(isset($_POST['limit-selected-categories'])&&($_POST['limit-selected-categories']!='')){
if(isset($_POST['selected-categories-id-list'])){
$categories_array=explode(",",$_POST['selected-categories-id-list']);
$numberofcategories=count($categories_array);
    if($_POST['limit-selected-categories']<$numberofcategories){
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'The  categories limit was exceeded'));
        exit;
    }
    }
}
//note:it is on ui side but is not working
if(isset($_POST['marketplaceSeoUrlSuffix'])&&($_POST['marketplaceSeoUrlSuffix']!='')){

    if (!preg_match('/^[a-zA-Z0-9_-]+$/',$_POST['marketplaceSeoUrlSuffix'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.'));
        exit;
    }
}


$json = json_decode(ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']), true);

$player = $json['responseObject'][0];

//remove crap we don't need
unset($player['client']);
unset($player['store']);
unset($player['items']); //we don't need to push these base since we'll specify ids
unset($player['videos']); //we don't need to push these base since we'll specify ids

//set variables
$namewoutspace=trim($_POST['player_name']);
$player['name'] =strip_tags($namewoutspace);
$player['description'] = strip_tags($_POST['player_description']);
$player['shareMessage'] = $_POST['share_message'];



if(isset($_POST['marketplaceSeoUrlSuffix'])) {
    $player['marketplaceSeoUrlSuffix'] = $_POST['marketplaceSeoUrlSuffix'];
}
if(isset($_POST['marketplaceonoff'])) {
    $player['userKeywords'] = cleanupUserKeywordsFromParams($_POST['keywordbox']);
}

if((isset($_POST['marketplaceonoff'])) && ($_POST['marketplaceonoff'] == "true")) {
    $player['publishedToMarketplace'] = true;
} else {
    $player['publishedToMarketplace'] = false;
}


if((isset($_POST['is_active'])) && ($_POST['is_active'] == "on")) {
    $player['assetStatus'] = "ACTIVE";
} else {
    $player['assetStatus'] = "INACTIVE";
}
$player['playerConfiguration']['affiliateTrackingUrl'] = $_POST['affiliatetrackingurl'];
$player['playerConfiguration']['buyNowText'] = $_POST['buynowtext'];
$player['playerConfiguration']['takeActionText'] = $_POST['takeactiontext'];
$player['purchaseRedirectUrl'] = $_POST['thankyoulink'];
$player['endOfPlayRedirectUrl'] = $_POST['endvideolink'];
$player['playerConfiguration']['locale'] = $_POST['player_locale'];
//$player['playerConfiguration']['defaultFlowBackgroundImage'] = $_POST['flowbackgroundimage'];

if(isset($_POST['product'])){
    $player['itemIds'] = $_POST['product'];
}
if(isset($_POST['media'])){
    $player['videoIds'] = $_POST['media'];
}

//for palyer categories
$json = ServicebusGetMarketplaceCategories( $_SESSION['SSMData']['clientGuid'],false);
$serviceBusCategories = $json;
$data = json_decode($json);
$mkpsecond=new MarketPlace($data);

$player['playerCategories'] =  $mkpsecond->getPlayerCategoriesForDataFromParams($_POST['selected-categories-id-list']);


// echo "|||GET||| " . print_r($_GET, true);
// echo "|||POST||| " . print_r($_POST, true);

$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $_SESSION['SSMData']['clientGuid'].'","requestObject":' . json_encode($player) .',"params":null}';
$sb_path = "/api/cms/players/createorupdate";

$response = ServicebusRequest($sb_path, $orig_data);

//echo print_r($response, true);
echo $response;