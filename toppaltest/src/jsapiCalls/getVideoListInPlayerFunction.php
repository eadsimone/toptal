<?php
/*
{
    "allVideos": [
        {
            "typeName": "video",
            "name": "Video Name Example",
            "description": "somthing here",
            "image": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/thumb-1357602180146.jpg",
            "previewStream": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/ba8619d3-fe95-4c46-808c-75342d787b0c-428453-med.mp4",
            "guid": "3be2c2c9-4856-43ec-8d11-b136dc61f13c"
        }
    ]
}*/


function get_video_stream_standar_definition($videostream_array){

    foreach( $videostream_array as $key => $value ){
        if(isset($value['format'])) {
            if($value['format'] == "Standard Definition") {
                //$previewStream=$value['urlProgressiveDownload'];
                //$video['previewStream']=$value['urlProgressiveDownload'];
                $video[0]='previewStream';
                $video[1]= $value['urlProgressiveDownload'];
            }
        } else {
            $video[0]='youtubeVideoId';
            $video[1]= $value['youtubeVideoId'];
        }

    }
    return $video;
}


function return_new_json($json,&$video_inplayer_ar){

    $video_inplayer_ar=array();

    $resp_obj=$json["responseObject"];

    $videoList = array();

    foreach( $resp_obj as $k => $v ){

        $videos=$v["videos"];


        if (!empty($videos)) {
            foreach( $videos as $key => $value ){

                $gui = $value["guid"];
                $typename = $value['typeName'];
                $description = $value['description'];
                $img = $value["posterImage"]['url'];
                $name = $value['name'];
                //$previewStream = $value['urlProgressiveDownload'];
                $previewStream = get_video_stream_standar_definition($value["videoStreams"]);


                $video_inplayer_ar[]=$gui;

                $video=array(
                    "typeName"=>$typename,
                    "name"=>$name,
                    "description"=>$description,
                    "image"=>$img,
                    "previewStream" => null,
                    "youtubeVideoId" => null,
                    "guid"=>$gui
                );

                $video[$previewStream[0]]=$previewStream[1];

                $videoList[] = $video;
            }
        }
    }

    $new_data = array("allVideos" => array_reverse($videoList));

        return json_encode($new_data);
}

$video_inplayer_array= array();
//$playerGuid = "753d8cda-481b-4e14-9826-9c139211be97";//int
//$playerGuid = "090f454d-04b3-4c66-8ea9-841a567b1516";//stag
//$json = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $playerGuid);

$json = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']);

$data = json_decode($json,true);
