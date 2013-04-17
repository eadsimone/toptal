<?php
/*
//desired result
{
    "video":{
        "length": 0,
        "typeName": "video",
        "description": "Just a panda",
        "sortOrder": null,
        "externalVideoId": "1",
        "title": "FirstVid",
        "posterImage": {
            "typeName": "image",
            "description": null,
            "url": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/videoposter-1357600427234.jpg",
            "thumbUrl": null,
            "name": "videoposter",
            "id": "37196",
            "creationTime": 1357600428000,
            "modificationTime": 1357600428000,
            "guid": "0c2d276f-c638-41d9-89d9-64ad7cc7b055"
        },
        "thumbImage": {
            "typeName": "image",
            "description": null,
            "url": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/videothumb-1357600426485.jpg",
            "thumbUrl": null,
            "name": "videothumb",
            "id": "37197",
            "creationTime": 1357600428000,
            "modificationTime": 1357600428000,
            "guid": "bde52a1d-4be4-4357-9b1b-f5d895eaa635"
        },
        "videoStreams": [
            {
                "typeName": "native_video_stream",
                "format": "Standard Definition",
                "urlProgressiveDownload": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-med.mp4",
                "urlRtmpStream": "rtmp://prodcdnhd.cinsay.edgesuite.net/ondemand/mp4:stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-med.mp4",
                "urlHttpLiveStream": "http://cp67851.edgefcs.net/i/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-,med,.mp4.csmil/master.m3u8",
                "transcodingComplete": true,
                "bandwidth": "600",
                "referenceId": "14921958",
                "transcodingMediaId": null,
                "originalUrl": null,
                "isAkamai": false,
                "name": null,
                "id": "18316",
                "creationTime": 1357600429000,
                "modificationTime": 1357601348000,
                "guid": "287d56d0-fa9f-4455-ad66-940830dc64b8"
            },
            {
                "typeName": "native_video_stream",
                "format": "Mobile",
                "urlProgressiveDownload": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-lo.mp4",
                "urlRtmpStream": "rtmp://prodcdnhd.cinsay.edgesuite.net/ondemand/mp4:stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-lo.mp4",
                "urlHttpLiveStream": "http://cp67851.edgefcs.net/i/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-,lo,.mp4.csmil/master.m3u8",
                "transcodingComplete": true,
                "bandwidth": "400",
                "referenceId": "14921958",
                "transcodingMediaId": null,
                "originalUrl": null,
                "isAkamai": false,
                "name": null,
                "id": "18315",
                "creationTime": 1357600429000,
                "modificationTime": 1357601347000,
                "guid": "edb0be08-e18f-40e8-b724-95735b0690d2"
            },
            {
                "typeName": "native_video_stream",
                "format": "Hi Definition",
                "urlProgressiveDownload": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-hi.mp4",
                "urlRtmpStream": "rtmp://prodcdnhd.cinsay.edgesuite.net/ondemand/mp4:stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-hi.mp4",
                "urlHttpLiveStream": "http://cp67851.edgefcs.net/i/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-,hi,.mp4.csmil/master.m3u8",
                "transcodingComplete": true,
                "bandwidth": "1600",
                "referenceId": "14921958",
                "transcodingMediaId": null,
                "originalUrl": null,
                "isAkamai": false,
                "name": null,
                "id": "18317",
                "creationTime": 1357600429000,
                "modificationTime": 1357601349000,
                "guid": "9d45d5a8-e32c-4d08-b9e4-b280ddde9107"
            },
            {
                "typeName": "native_video_stream",
                "format": "original",
                "urlProgressiveDownload": "http://devcinsay.s3.amazonaws.com/stag/8183c0f5-f151-4999-9b12-39702ed8dfec/originals/74fb08d1-b6ba-4dcb-872d-2154b1982a78-original.flv",
                "urlRtmpStream": null,
                "urlHttpLiveStream": null,
                "transcodingComplete": false,
                "bandwidth": null,
                "referenceId": null,
                "transcodingMediaId": null,
                "originalUrl": null,
                "isAkamai": false,
                "name": null,
                "id": "18318",
                "creationTime": 1357600429000,
                "modificationTime": 1357600429000,
                "guid": "89ced2f0-c984-479f-ab2b-ef4da0921702"
            }
        ],
        "streams": null,
        "images": null,
        "synopsis": null,
        "videoItems": null,
        "assetStatus": "ACTIVE",
        "name": null,
        "id": "8869",
        "creationTime": 1357600428000,
        "modificationTime": 1357600429000,
        "guid": "ba8619d3-fe95-4c46-808c-75342d787b0c"
    }
}
*/

include '../functions.php';


function return_new_json($json){

	$resp_data=$json['responseObject'];
	
	//blank out client instances
	unset($resp_data[0]['client']);
	
	//set video urls
	foreach($resp_data[0]['videoStreams'] as $vStream) {
		if(isset($vStream['format']) && ($vStream['format'] == "original")) {
			$resp_data[0]['originalVideo'] = $vStream['urlProgressiveDownload'];
		} else if(isset($vStream['format']) && ($vStream['format'] == "Standard Definition")) {
			$resp_data[0]['previewVideo'] = $vStream['urlProgressiveDownload'];
		} else if(!isset($vStream['format'])) {
			if(isset($vStream['youtubeVideoId'])){
				$resp_data[0]['youtubeVideo'] = $vStream['youtubeVideoId'];
			}
		}
	}
		
	if($resp_data[0]['assetStatus'] == "ACTIVE") {
		$resp_data[0]['isActive'] = true;
	} else {
		$resp_data[0]['isActive'] = false;
	}
	
	return json_encode($resp_data[0]);

}


$json = ServicebusGetVideo( $_SESSION['SSMData']['clientGuid'], $_GET['vGuid']);
//die($json);
$data = json_decode($json,true);

echo return_new_json($data);

// echo "<pre>";
// print_r(return_new_json($obj));
// echo "</pre>";
