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
require_once '../helpers/product_helper.php';

/*echo "<pre>" . prettyJSON(ServicebusGetProductList( $_SESSION['SSMData']['clientGuid']),true) . "</pre>";
echo"new json<br/>";*/

$json = ServicebusGetProductList( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);

echo return_new_json_product_list($data);