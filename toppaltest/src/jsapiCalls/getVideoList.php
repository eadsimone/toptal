<?php

/*{
    "allVideos": [
        {
            "typeName": "video",
            "title": "Video Name Example",
            "description": "somthing here",
            "image": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/thumb-1357602180146.jpg",
            "previewStream": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-med.mp4",
            "guid": "3be2c2c9-4856-43ec-8d11-b136dc61f13c"
        }
    ]
}*/
include '../functions.php';

function return_new_json($json){

    $resp_data=$json['responseObject'];
    
    $videoList = array();

    foreach( $resp_data as $k => $v ){
    	
    	$video = array(
    			"typeName" => $v['typeName'],
    			"title" => $v['title'],
    			"description" => $v['description'],
    			"image" => $v["posterImage"]['url'],
    			"previewStream" => null,
    			"youtubeVideoId" => null,
    			"guid" => $v['guid']
    	);

    	$videoStream = $v["videoStreams"];
    	foreach($videoStream as $key => $value) {
    		if($value['typeName'] == "native_video_stream") {
	    		if($value['format'] == "Standard Definition") {
	    			$video['previewStream'] = $value['urlProgressiveDownload'];
	    		}
    		} else if($value['typeName'] == "youtube_video_stream") {
    			$video['youtubeVideoId'] = $value['youtubeVideoId'];
    		}
    	}

    	$videoList[] = $video;

    }
    
	$new_data = array("allVideos" => array_reverse($videoList));

	return json_encode($new_data);
}

$json = ServicebusGetVideoList( $_SESSION['SSMData']['clientGuid']);
$data = json_decode($json, true);

echo return_new_json($data);


