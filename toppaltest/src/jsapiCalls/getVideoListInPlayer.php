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

include '../functions.php';
include './getVideoListInPlayerFunction.php';

echo return_new_json($data,$video_inplayer_array);

