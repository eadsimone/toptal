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

include '../functions.php';
include './getProductListInPlayerFunction.php';

function is_inplayer($gui,$inplayer){
    foreach( $inplayer as $key => $value ){
    if($value==$gui)
        return true;
    }
        return false;
}

function not_in_player_new_json($json,$inplayer){

    $resp_obj=$json["responseObject"];

if (!is_array($resp_obj)) {
    $resp_obj = json_decode($resp_obj, true);
}

    $allproductlist=array();

    foreach( $resp_obj as $key => $value ){

        $guid = $value["guid"];
        $id = $value["id"];
        $typename = $value['typeName'];
        $description = $value['description'];
        $img = $value["defaultItemVariant"]['thumb']['url'];
        $name = $value['name'];

        if(!is_inplayer($guid,$inplayer)){
            $product=array(
                "typeName"=>$typename,
                "name"=>$name,
                "description"=>$description,
                "image"=>$img,
                "guid"=>$guid,
            	"id"=>$id
                );
            $allproductlist[]=$product;
    }
    }
    $new_data = array("allProducts" => array_reverse($allproductlist));

    return json_encode($new_data);

}

return_new_json($data,$pro_inplayer_array);

$json = ServicebusGetProductList( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);

//echo "<pre>" . prettyJSON(not_in_player_new_json($data,$pro_inplayer_array),true) . "</pre>";
echo not_in_player_new_json($data,$pro_inplayer_array);


