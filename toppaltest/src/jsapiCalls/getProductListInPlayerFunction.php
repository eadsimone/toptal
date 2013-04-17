<?php
/*{
    "allProducts": [
        {
            "typeName": "ecomm",
            "name": "BuyMeThis",
            "description": "Buy a new thing!",
            "image": "http://devcdn.cinsay.edgesuite.net/stag/transcoded/8183c0f5-f151-4999-9b12-39702ed8dfec/thumb-1357602180146.jpg",
            "guid": "3be2c2c9-4856-43ec-8d11-b136dc61f13c"
        }
    ]
}*/

//include '../functions.php';


function get_video_stream_standar_definition($videostream_array){

    foreach( $videostream_array as $key => $value ){
        if($value['format'] == "Standard Definition"){
            $previewStream=$value['urlProgressiveDownload'];
        }elseif(!isset($value['format'])){
            $previewStream = $value['youtubeVideoId'];
        }

    }

    return $previewStream;
}


function return_new_json($json,&$product_inplayer_array){

    $product_inplayer_array=array();
    $resp_obj=$json["responseObject"];

    $allproductlist=array();

    foreach( $resp_obj as $k => $v ){

        $products=$v["items"];

        if (!empty($products)) {
            foreach( $products as $key => $value ){

                $gui = $value["guid"];
                $typename = $value['typeName'];
                $description = $value['description'];
                $img = $value["defaultItemVariant"]['thumb']['url'];
                $name = $value['name'];

                $product_inplayer_array[]=$gui;

                $product=array(
                    "typeName"=>$typename,
                    "name"=>$name,
                    "description"=>$description,
                    "image"=>$img,
                    "guid"=>$gui
                );
                $allproductlist[]=$product;
            }

        }
    }



    $new_data = array("allProducts" => array_reverse($allproductlist));

    return json_encode($new_data);
}

$pro_inplayer_array= array();

//fixed data
//$playerGuid = "7904ebeb-11a2-4de1-9b58-9aec121c1a9a";//int for (jgarrett02142012tax@cinsaydev.com / abc123)
//$json = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'],$playerGuid);

$json = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']);

$data = json_decode($json,true);