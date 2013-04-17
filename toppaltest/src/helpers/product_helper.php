<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 25/02/13
 * Time: 12:55
 * To change this template use File | Settings | File Templates.
 */


function getArrayByProduct($productType, $sbJSON, $pGuid = null)
{
    $type = '';
    $response = Array();

    $idProduct =  isset($sbJSON['responseObject'][0]['id']) ? $sbJSON['responseObject'][0]['id'] : '';

    switch ($productType) {
        case 'lead_gen' :


            $type = 'leadGen';
            $response = Array(
                "product" => Array(
                    "leadGen" => Array(
                        "productID" => $idProduct,
                        "pGuid"     => $pGuid,
                        "image" => isset($sbJSON['responseObject'][0]['defaultItemVariant']['large']['url']) ? $sbJSON['responseObject'][0]['defaultItemVariant']['large']['url'] : '',
                        "name" => isset($sbJSON['responseObject'][0]['name']) ? $sbJSON['responseObject'][0]['name'] : '',
                        "description" => isset($sbJSON['responseObject'][0]['description']) ? $sbJSON['responseObject'][0]['description'] : '',
                        "active" =>  isset($sbJSON['responseObject'][0]['active']) ? $sbJSON['responseObject'][0]['active'] : '',
                        "formURL"=> isset($sbJSON['responseObject'][0]['thankyouPageUrl']) ? $sbJSON['responseObject'][0]['thankyouPageUrl'] : '',
                        "firstName"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][0]['fieldValue']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][0]['fieldValue'] : '',
                        "formEmail"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][1]['fieldValue']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][1]['fieldValue'] : '',
                        "lastName"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][2]['fieldValue']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][2]['fieldValue'] : '',
                        "zip"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][3]['fieldValue']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][3]['fieldValue'] : '',
                        "phoneNumber"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][4]['fieldValue']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['formFields'][4]['fieldValue']: '',
                        'thankyouPageDescription'   => isset($sbJSON['responseObject'][0]['thankyouPageDescription']) ? $sbJSON['responseObject'][0]['thankyouPageDescription'] : '',
                        'thankyouPageHeadline'      => isset($sbJSON['responseObject'][0]['thankyouPageHeadline']) ? $sbJSON['responseObject'][0]['thankyouPageHeadline'] : '',
                        'thankyouPageUrl'           => isset($sbJSON['responseObject'][0]['thankyouPageHeadline']) ? $sbJSON['responseObject'][0]['thankyouPageUrl'] : '',
                        "delivery_method"=> Array(
                            "options"=> Array(
                                Array(
                                    "label" => "Standard Lead",
                                    "value" => "STANDARD_LEA"
                                ),
                                Array(
                                    "label" => "Host and Post",
                                    "value" => "HOST_AND_POST"
                                ),
                                Array(
                                    "label" => "Host and Post Two Part",
                                    "value" => "HOST_AND_POST_TWO_PART"
                                )
                            )
                        )
                    )
                )
            );


            foreach ($response['product']['leadGen']['delivery_method']['options'] as $index => $lead) {
if (isset($sbJSON['responseObject'][0]['itemVariants'][0]['leadGenType'])){
                if($lead['value'] == $sbJSON['responseObject'][0]['itemVariants'][0]['leadGenType']) {
                    $response['product']['leadGen']['delivery_method']['options'][$index]['selected'] = 'selected';
                    break;
                }
}
            }

            if($sbJSON['responseObject'][0]['assetStatus'] == "ACTIVE") {
            	$response['product']['leadGen']['active'] = true;
            } else {
            	$response['product']['leadGen']['active'] = false;
            }
            break;

        case 'linkoff':

            $type = 'linkOut';
            $response = Array(
                "product" => Array(
                    "linkOut" => Array(
                        "productID" => $idProduct,
                        "pGuid"     => $pGuid,
                        "image" => isset($sbJSON['responseObject'][0]['defaultItemVariant']['large']['url']) ? $sbJSON['responseObject'][0]['defaultItemVariant']['large']['url'] : '',
                        "name" => isset($sbJSON['responseObject'][0]['name']) ? $sbJSON['responseObject'][0]['name'] : '',
                        "description" => isset($sbJSON['responseObject'][0]['description']) ? $sbJSON['responseObject'][0]['description'] : '',
                        "active" =>  isset($sbJSON['responseObject'][0]['active']) ? $sbJSON['responseObject'][0]['active'] : '',
                        "URL"=> isset($sbJSON['responseObject'][0]['itemVariants'][0]['url']) ? $sbJSON['responseObject'][0]['itemVariants'][0]['url'] : ''
                    )
                )
            );
            if($sbJSON['responseObject'][0]['assetStatus'] == "ACTIVE") {
            	$response['product']['linkOut']['active'] = true;
            } else {
            	$response['product']['linkOut']['active'] = false;
            }
            break;
        case 'donation':
            $type = 'donation';
            $amounts = Array();

            if(isset($sbJSON['responseObject'][0]['itemVariants'])) {
                foreach ( $sbJSON['responseObject'][0]['itemVariants'] as $iVariant) {
                    $amounts[] = number_format($iVariant['amount'], 2);
                }
            }

            $response = Array(
                "product" => Array(
                    "donation" => Array(
                        "productID" => $idProduct,
                        "pGuid"     => $pGuid,
                        "image" => isset($sbJSON['responseObject'][0]['defaultItemVariant']['large']['url']) ? $sbJSON['responseObject'][0]['defaultItemVariant']['large']['url'] : '',
                        "name" => isset($sbJSON['responseObject'][0]['name']) ? $sbJSON['responseObject'][0]['name'] : '',
                        "description" => isset($sbJSON['responseObject'][0]['description']) ? $sbJSON['responseObject'][0]['description'] : '',
                        "active" =>  isset($sbJSON['responseObject'][0]['active']) ? $sbJSON['responseObject'][0]['active'] : '',
                        "thankyouPageDescription"=> isset($sbJSON['responseObject'][0]['thankyouPageDescription']) ? $sbJSON['responseObject'][0]['thankyouPageDescription'] : '',
                        "thankyouPageHeadline"=> isset($sbJSON['responseObject'][0]['thankyouPageHeadline']) ? $sbJSON['responseObject'][0]['thankyouPageHeadline'] : '',
                        "introPageDescription"=> isset($sbJSON['responseObject'][0]['introPageDescription']) ? $sbJSON['responseObject'][0]['introPageDescription'] : '',
                        "donationDisclaimerText"=> isset($sbJSON['responseObject'][0]['donationDisclaimerText']) ? $sbJSON['responseObject'][0]['donationDisclaimerText'] : '',
                        "introPageHeadline"=> isset($sbJSON['responseObject'][0]['introPageHeadline']) ? $sbJSON['responseObject'][0]['introPageHeadline'] : '',
                        "thankyouPageUrl"=> isset($sbJSON['responseObject'][0]['thankyouPageUrl']) ? $sbJSON['responseObject'][0]['thankyouPageUrl'] : '',
                        "donationType"=> Array(
                            'options' => Array(
                                Array(
                                    'label' => 'General',
                                    'value' => '***'
                                ),
                                Array(
                                    'label'     => 'Political',
                                    'value'     => '***',
                                    'selected'  => true
                                )
                            )
                        ),
                        'amounts' => $amounts
                    )
                )
            );
            if($sbJSON['responseObject'][0]['assetStatus'] == "ACTIVE") {
            	$response['product']['donation']['active'] = true;
            } else {
            	$response['product']['donation']['active'] = false;
            }
            break;
        case 'ecomm':

            $type = 'eCommerce';
            
            $ecomm_price = 0;
            $ecomm_weight = 0; 
            $ecomm_quantity = 0;
            $ecomm_sku = '';
            
            if(isset($sbJSON['responseObject'][0]['defaultItemVariant'])) {
            	$defaultItemVariant = $sbJSON['responseObject'][0]['defaultItemVariant'];
            	$ecomm_price = $defaultItemVariant['price'];
            	$ecomm_weight = $defaultItemVariant['weight'];
            	$ecomm_quantity = $defaultItemVariant['quantity'];
            	$ecomm_sku = $defaultItemVariant['sku'];
            }
            
            $response = Array(
                "product" => Array(
                    "eCommerce" => Array(
                        "productID" => $idProduct,
                        "pGuid"     => $pGuid,
                        "image" => isset($sbJSON['responseObject'][0]['defaultItemVariant']['large']['url']) ? $sbJSON['responseObject'][0]['defaultItemVariant']['large']['url'] : '',
                        "name" => isset($sbJSON['responseObject'][0]['name']) ? $sbJSON['responseObject'][0]['name'] : '',
                        "description" => isset($sbJSON['responseObject'][0]['description']) ? $sbJSON['responseObject'][0]['description'] :'',
                        "active" =>  isset($sbJSON['responseObject'][0]['active']) ? $sbJSON['responseObject'][0]['active'] : '',
                        "price"=> number_format($ecomm_price, 2),
                        "weight"=> number_format($ecomm_weight, 2),
                        'cost'  => '***',
                        'quantity' => number_format($ecomm_quantity, 0),
                        'sku'       => $ecomm_sku,
                        'notifyAmount' => '***'
                    )
                )
            );
            if($sbJSON['responseObject'][0]['assetStatus'] == "ACTIVE") {
            	$response['product']['eCommerce']['active'] = true;
            } else {
            	$response['product']['eCommerce']['active'] = false;
            }
            break;
        case 'productWithOptions':
            $type = 'productWithOptions';
            $response = Array(
                "product" => Array(
                    "productWithOptions" => Array(
                        "productID" => $idProduct,
                        "pGuid"     => $pGuid,
                        "name" => isset($sbJSON['responseObject'][0]['name']) ? $sbJSON['responseObject'][0]['name'] : '',
                        "description" => isset($sbJSON['responseObject'][0]['description']) ? $sbJSON['responseObject'][0]['description']: ''
                    )
                )
            );
            $response['product']['productWithOptions']['variants'] = $sbJSON['responseObject'][0]['itemVariants'];
            if($sbJSON['responseObject'][0]['assetStatus'] == "ACTIVE") {
            	$response['product']['productWithOptions']['active'] = true;
            } else {
            	$response['product']['productWithOptions']['active'] = false;
            }
            break;
    } //SWTICH END

    $response["productType"] = Array(
        "options"=> Array(
            Array(
                "label"=> "eCommerce",
                "value"=> "eCommerce"
            ),
            Array(
                "label"=> "Lead Generation",
                "value"=> "leadGen"
            ),
            Array(
                "label"=> "Donation",
                "value"=> "donation"
            ),
            Array(
                "label"=> "Link Out",
                "value"=> "linkOut"
            ),
            Array(
                "label"=> "Product With Options",
                "value"=> "productWithOptions"
            )
        ),
        "value" => $type
    );

    return $response;
}

function return_new_json_product_list($json, $returnDataEncoded = TRUE){

    $resp_obj=$json["responseObject"];

    $allpoduct=array();

    /*$new_json='{
    "allProducts": [';*/

    foreach( $resp_obj as $key => $value ){

       if(isset($value["guid"])) {
        	$product['guid'] = $value["guid"];
        }

        if(isset($value['typeName'])) {
        	$product['typeName'] = $value['typeName'];
        }

		if(isset($value['description'])) {
			$product['description'] = $value['description'];
        }

        if(isset($value["defaultItemVariant"]['medium']['url'])) {
        	$product['image'] = $value["defaultItemVariant"]['medium']['url'];
        }

        if(isset($value['name'])) {
        	$product['name'] = $value['name'];
        }
        
        if(isset($value['sku'])) {
        	$product['sku'] = $value['sku'];
        }

        $allpoduct[]=$product;

        /*$new_json.=']]';
        return $new_json;*/
    }
    $new_data = array("allProducts" => array_reverse($allpoduct));

    if($returnDataEncoded === TRUE) {
        return json_encode($new_data);
    } else {
        return $new_data;
    }

}


function canISaveProduct($productList, $productData, $isEdit)
{
    foreach ($productList['allProducts'] AS $product) {
        if( trim($product['name']) == trim($productData->name) ) {
            return Array(
                'success' => FALSE,
                'responseText' => 'Name Duplicated'
            );
            break;
        }
    }

    return Array(
        'success' => TRUE,
        'responseText' => 'no problem'
    );

}