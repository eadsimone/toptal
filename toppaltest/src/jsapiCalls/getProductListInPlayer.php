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

echo return_new_json($data,$pro_inplayer_array);


