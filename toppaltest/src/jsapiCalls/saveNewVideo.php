<?php
/*
//desired result
{
    "id": null,
    "assetStatus": "ACTIVE",
    "typeName": "video",
    "thumbImage": {
        "typeName": "image",
        "url": "http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/thumb-1340895089606.jpg"
    },
    "posterImage": {
        "typeName": "image",
        "url": "http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg"
    },
    "title": "API Test Video",
    "videoStreams": [
        {
            "typeName": "native_video_stream",
            "id": null,
            "format": "original",
            "urlProgressiveDownload": "http://devcinsay.s3.amazonaws.com/qa/f847fd01-79b1-44e9-805b-c1b2be02353f/originals/20051210-w50s.flv"
        }
    ],
    "description": "Description"
}
*/

include '../functions.php';

/*to validate from server side*/
$error='';
$counter=0;
if(!isset($_POST['videoname']) || $_POST['videoname']==''){
   //// $error.=' Video Name';
   // $counter++;
}
if(!isset($_POST['thumbImage']) || $_POST['thumbImage']==''){
    if (isset($_POST['thumbImageUrl'])) {
        $_POST['thumbImage'] = $_POST['thumbImageUrl'];
    }
    //if($counter!=0){$error.=',thumbImageUrl';}else{$error.='thumbImageUrl';}
    //$counter++;
}
if(!isset($_POST['posterImage']) || $_POST['posterImage']=='' ){
    if (isset($_POST['posterImageUrl'])) {
        $_POST['posterImage'] = $_POST['posterImageUrl'];
    }
    //if($counter!=0){$error.=',posterImageUrl';}else{$error.='posterImageUrl';}
    //$counter++;
}
if($_POST['videosource']=="youtube"){
    //should be solve a issue w youtube
}elseif($_POST['videosource']=="upload"){
    if(!isset($_POST['originalVideoUrl']) || $_POST['originalVideoUrl']=='') {
        if($counter!=0){$error.=',originalVideoUrl';}else{$error.='originalVideoUrl';}
        $counter++;
    }
}
/**
if($counter!=0){
    if($counter==1){
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'The '.$error.' is required'));
    }else{
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'The '.$error.' are required'));
    }

    exit;
}
*/

$variables = array(
    'title' => $_POST['videoname'],
    'description' => $_POST['videodescription'],
    'thumbImageUrl' => $_POST['thumbImageUrl'],
    'posterImageUrl' => $_POST['posterImageUrl'],
    'originalVideoUrl' => $_POST['originalVideoUrl']
);

$json = '
{
    "id": null,
    "assetStatus": "ACTIVE",
    "typeName": "video",
    "thumbImage": {
        "typeName": "image",
        "url": "{{thumbImageUrl}}"
    },
    "posterImage": {
        "typeName": "image",
        "url": "{{posterImageUrl}}"
    },
    "title": "{{title}}",
    "videoStreams": [
        {
            "typeName": "native_video_stream",
            "id": null,
            "format": "original",
            "urlProgressiveDownload": "{{originalVideoUrl}}"
        }
    ],
    "description": "{{description}}"
}
';

foreach($variables as $key => $value) {
    $json = str_replace("{{" . $key . "}}", $value, $json);
}

//echo $json;
$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $_SESSION['SSMData']['clientGuid'].'","requestObject":' . $json .',"params":null}';
$sb_path = "/api/cms/videos/createorupdate";

$response = ServicebusRequest($sb_path, $orig_data);

echo $response;
return $response;