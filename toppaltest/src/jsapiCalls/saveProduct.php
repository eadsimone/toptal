<?php

include '../functions.php';
require_once '../helpers/product_helper.php';

/*to validate from server side*/
$error='';
$counter=0;
if(isset($_POST['productType'])) {
	if ($_POST['productType']=='add-product-ecommerce'){
	    if(!isset($_POST['quantity']) || $_POST['quantity']==''){
	        $error.=' Quantity';
	        $counter++;
	    }
	    if(!isset($_POST['price']) || $_POST['price']==''){
	        if($counter!=0){$error.=', Price';}else{$error.='Price';}
	        $counter++;
	    }
	
	    if($counter!=0){
	        if($counter==1){
	            echo json_encode(Array('responseCode' => 999, 'responseText' => 'The '.$error.' is required'));
	        }else{
	            echo json_encode(Array('responseCode' => 999, 'responseText' => 'The '.$error.' are required'));
	        }
	
	        exit;
	    }
	} else if ($_POST['productType']=='add-product-link-out') {
		if($_POST['urlLink'] == "") {
			echo json_encode(Array('responseCode' => 999, 'responseText' => 'The link url is required'));
			exit();
		}
	}
}

if(isset($_POST['thankyouPageUrl']) && ($_POST['thankyouPageUrl']!='')){

    if (!preg_match('/^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i',$_POST['thankyouPageUrl'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
        exit;
    }
}
//elseif($_POST['thankyouPageUrl']==''){
//    echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
//    exit;
//}




function jsonReplazator($json, $vars)
{
    foreach ( $vars as $label => $value) {
        $json = str_replace("{{" . $label . "}}", $value, $json);
    }
    return $json;
}

function createNewLeadgen(
    $data, $variables,
    $leadGenType,
    $postUrl,
    $thankyouPageHeadline = null,
    $thankyouPageDescription = null,
    $thankyouPageUrl = null,
    $thankyouPageImage = null,
    $form_destination_url = null,
    $form_first_name = null,
    $form_last_name = null,
    $form_phone_number = null,
    $form_zipcode = null,
    $form_email_address = null ){


    $formFieldArray = array(
        "form_destination_url" => $form_destination_url,
        "form_first_name" => $form_first_name,
        "form_last_name" => $form_last_name,
        "form_phone_number" => $form_phone_number,
        "form_zipcode" => $form_zipcode,
        "form_email_address" => $form_email_address
    );

    $formfields = array();
    foreach($formFieldArray as $key => $value) {
        $formFieldEntry['fieldName'] = $key;
        $formFieldEntry['fieldValue'] = $value;
        $formfields[] = $formFieldEntry;
    }

    
    $itemVariant = array(
        "typeName" => "lead_gen_variant",
        "large" => array (
            "typeName" => "image",
            "url" => $variables['image']
        ),
        "medium" => array (
            "typeName" => "image",
            "url" => $variables['image']
        ),
        "thumb" => array (
            "typeName" => "image",
            "url" => $variables['image']
        ),
        "leadGenType" => $leadGenType,
        "postUrl" => $postUrl,
        "formFields" => $formfields,
        "default" => "true"
    );

    $response = Array();
    $response['thankyouPageHeadline'] = $data['thankyouPageHeadline'];
    $response['thankyouPageDescription'] = $data['thankyouPageDescription'];
    if($thankyouPageImage) {
        $response['thankyouPageImage']['typeName'] = 'image';
        $response['thankyouPageImage']['url'] = $thankyouPageImage;
    }
    $response['thankyouPageUrl'] = $data['thankyouPageUrl'];
    $response['itemVariants'][] = $itemVariant;

    return $response;
}

function createProductLeadGen()
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'lead_gen',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    ));

    $leadGenOptions = createNewLeadgen(
        $_POST,
        json_decode($default, TRUE),
        "HOST_AND_POST",
        "http://www.cinsay.com/",
        "--Enter the Thank You Headline--",
        "--Enter the Thank You Description--",
        "http://www.cinsay.com/thanks",
        "http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg",
        "http://www.cinsay.com",
        "first_name_field",
        "last_name_field",
        "phone_number_field",
        "zip_field",
        "email_field" );

    $response = json_encode(array_merge(json_decode($default, TRUE), $leadGenOptions));

    return $response;
}

function createProductEcomm($isAdd = TRUE)
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'ecomm',
        'name'          => trim($_POST['productName']),
        'description'   => trim($_POST['productDescription']),
    ));

    $variantsJSON =
        '{
            "typeName": "ecomm_variant",
            "name": "{{name}}",
            "description": "Ecomm Variant",
            "thumb": {
                "typeName": "image",
                "url": "{{image}}"
                "id": ""
            },
            "medium": {
                "typeName": "image",
                "url": "{{image}}"
                "id": ""
            },
            "large": {
                "typeName": "image",
                "url": "{{image}}"
                "id": ""
            },
            "price": "{{price}}",
            "quantity": {{quantity}},
            "weight": {{weight}},
            "sku"   : "{{sku}}"
        }';

    $default = json_decode($default, true);

    if(isset($_POST['options']) && is_array($_POST['options'])) {
    	$options = $_POST['options'];
    	$variant = array();
    	
    	for($i = 0; $i < count($options['name']); $i++) {
    		$variantTemplate = $variantsJSON;
    		$variant['name'] = $options['name'][$i];
    		$variant['sku'] = $options['sku'][$i];
    	    $variant['price'] = $options['price'][$i];
    		$variant['quantity'] = $options['quantity'][$i];
    	    $variant['weight'] = $options['weight'][$i];
            $variant['image'] = $_POST['image'];
            // $variant['image'] = 'http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg';

    	    if($variant['sku'] == "") {
    	    	$variant['sku'] = 'pwo_' . $i . "_" . mktime(TRUE);
    	    }
    	    if($variant['quantity'] == "") {
    	    	$variant['quantity'] = 0;
    	    }
    	    if($variant['weight'] == "") {
    	    	$variant['weight'] = 0;
    	    }
    	    
    	    foreach($variant as $key => $value) {
    	    	$variantTemplate = str_replace("{{" . $key . "}}", $value, $variantTemplate);
    	    }
    	    
    	    $default['itemVariants'][] = json_decode($variantTemplate, true);

    	}
    	
    } else {
    
	    $ecommVariants = jsonReplazator($variantsJSON, Array(
	    	'name'		=> 'Ecomm Variant',
            'typeName'  => 'ecomm_variant',
            'image'     => $_POST['image'],
	        'quantity'  => $_POST['quantity'],
	        'price'     => $_POST['price'],
	        'weight'    => $_POST['weight'],
	        'sku'       => (isset($_POST['sku']) && $_POST['sku'] != '') ? $_POST['sku'] : 'ecomm_'.mktime(TRUE)
	    ));

        // 	        'image'     => 'http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg',
        $default['itemVariants'][] = json_decode($ecommVariants, true) !== NULL ? json_decode($ecommVariants, true) : Array();
    }

    return json_encode($default);

}


function returnDefaultVars($replaceVars = Array())
{
    $defaultVars =
        '{
        "typeName": "{{typeName}}",
        "name": "{{name}}",
        "description": "{{description}}",
        "image"     :  "",
        "assetStatus": "ACTIVE"
    }';
    //"http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg",
    return jsonReplazator($defaultVars, $replaceVars);
}

function createNewDonation($data, $variables, $donationType) {

    $itemVariant = '
	        {
	            "typeName": "donation_variant",
	            "description": "{{name}} {{iterator}}",
	            "externalProductId": null,
	            "default": "false",
	            "thumb": {
	                "typeName": "image",
	                "url": ""
	            },
	            "medium": {
	                "typeName": "image",
	                "url": ""
	            },
	            "large": {
	                "typeName": "image",
	                "url": ""
	            },
	            "name": "donation {{name}} {{iterator}}",
	            "amount": {{amount}}
	        }
			';

    $itemVariant = str_replace("{{name}}", $variables['name'], $itemVariant);
    $itemVariant = str_replace("", $variables['image'], $itemVariant);


    $response = Array();

    if(isset($_POST['donationAmonuts'])) {
        for($i = 0; $i < count($_POST['donationAmonuts']); $i++) {
            $iVariant = $itemVariant;
            $iVariant = str_replace("{{amount}}", $_POST['donationAmonuts'][$i], $iVariant);
            $iVariant = str_replace("{{iterator}}", $i, $iVariant);
            $itemVariantData = json_decode($iVariant, true);
            if($i == 0) {
                $itemVariantData['default'] = "true";
            }
            $response['itemVariants'][] = $itemVariantData;
        }
    }


    $response['introPageHeadline'] = isset($data['introPageHeadline']) ? $data['introPageHeadline'] : '';
    $response['introPageDescription'] = isset($data['disclaimer']) ? $data['disclaimer'] : '';
    $response['thankyouPageHeadline'] = isset($data['thankYouPageHeadline']) ? $data['thankYouPageHeadline'] : '';
    $response['thankyouPageDescription'] = isset($data['thankYouPageDescription']) ? $data['thankYouPageDescription'] : '';
    if(isset($data['thankyouPageImage'])) {
        $response['thankyouPageImage']['typeName'] = 'image';
        $response['thankyouPageImage']['url'] = $data['thankyouPageImage'];
    }
    $response['thankyouPageUrl'] = isset($data['thankYouPageUrl']) ? $data['thankYouPageUrl'] : '';
    $response['donationType'] = isset($donationType) ? $donationType : '' ;
    $response['donationDisclaimerText'] = isset($data['disclaimer']) ? $data['disclaimer']: '';

    return $response;
}

function createProductDonation()
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'donation',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    ));

    $donationOptions = createNewDonation(
        $_POST,
        json_decode($default, TRUE),
        $donationType = "GENERAL");

    $response = json_encode(array_merge(json_decode($default, TRUE), $donationOptions));

    return $response;
}

function createNewLinkoff ($data, $variables, $url) {

    $itemVariant = '
			        {
			            "typeName": "linkoff_variant",
			            "name": "LinkOff Variant",
			            "description": "LinkOff Variant Description",
			            "thumb": {
			                "typeName": "image",
			                "url": ""
			            },
			            "medium": {
			                "typeName": "image",
			                "url": ""
			            },
			            "large": {
			                "typeName": "image",
			                "url": ""
			            },
			            "default": "true",
			            "url": "{{url}}",
			            "linkOffType": "LINKOFF"
			        }
			';

    $itemVariant = str_replace("", $variables['image'], $itemVariant);
    $itemVariant = str_replace("{{url}}", $url, $itemVariant);

    $data['itemVariants'][] = json_decode($itemVariant, true);
    return $data;
}


function createProductLinkOut($isAdd = TRUE)
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'linkoff',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    	'image'   => $_POST['image']
    ));

    $linkOffOptions = createNewLinkoff(
        $_POST,
        json_decode($default, TRUE),
        $_POST['urlLink']
    );


    $response = json_encode(array_merge(json_decode($default, TRUE), $linkOffOptions));

    return $response;
}

$jsonProduct = NULL;
$productType = NULL;

$isEdit = FALSE;
$pguid = NULL;
//IS EDIT
if( isset($_POST['productType']) == FALSE && isset($_POST['pGuid']) == TRUE  && $_POST['pGuid'] != null) {
    $isEdit = TRUE;
    $SBactualProduct = json_decode(ServicebusGetProduct( $_SESSION['SSMData']['clientGuid'], $_POST['pGuid']), true);
    $productType = strtolower(trim($SBactualProduct['responseObject'][0]['typeName']));
    $pguid = $_POST['pGuid'];
} elseif( isset($_POST['productType']) == TRUE && isset($_POST['pGuid']) == FALSE ) {
    $productType = $_POST['productType'];
}

$prdID = isset($_POST['productID']) ? $_POST['productID'] : null;

switch ($productType) {

    case 'add-product-ecommerce':
    case 'ecomm':
    case 'add-product-with-options':
        $jsonProduct = createProductEcomm();
        break;

    case 'add-product-leadgen':
    case 'lead_gen':
        $jsonProduct  = createProductLeadGen();
        break;

    case 'add-product-donation':
    case 'donation':

        $jsonProduct  = createProductDonation();
        break;

    case 'add-product-link-out':
    case 'linkoff':

        $jsonProduct  = createProductLinkOut();
        break;
}



if($jsonProduct !== NULL) {

    if($pguid !== NULL) {

       // $prdInfo = json_decode(ServicebusGetProduct( $_SESSION['SSMData']['clientGuid'], $pguid), TRUE);
        $jsonProduct = json_decode($jsonProduct, TRUE);
        $jsonProduct['id'] = $prdID;
        $jsonProduct['image'] = $_POST['image'];
        $jsonProduct['itemVariants'][0]['thumb']['url'] = $_POST['image'];
        $jsonProduct['itemVariants'][0]['thumb']['id'] = $data['responseObject'][0]['itemVariants'][0]['thumb']['id'];
        $jsonProduct['itemVariants'][0]['medium']['url'] = $_POST['image'];
        $jsonProduct['itemVariants'][0]['medium']['id'] = $data['responseObject'][0]['itemVariants'][0]['medium']['id'];
        $jsonProduct['itemVariants'][0]['large']['url'] = $_POST['image'];
        $jsonProduct['itemVariants'][0]['large']['id'] = $data['responseObject'][0]['itemVariants'][0]['large']['id'];
        $jsonProduct = json_encode($jsonProduct);
//        echo '<pre style="text-align: left">';
//            if ( $jsonProduct ) print_r( $jsonProduct );
//            else echo var_dump( $jsonProduct );
//        echo '</pre><hr />';
//        die();
//        die();
    }

    $orig_data = '{"apiKey":"{{publicKey}}","clientId":"' .  $_SESSION['SSMData']['clientGuid'] . '","requestObject":' . $jsonProduct .',"params":null}';
    $sb_path = "/api/cms/items/createorupdate";

    //$response = ServicebusRequest($sb_path, $orig_data);

    /*
     * Partial Validation name duplicated
     */

    $json = ServicebusGetProductList( $_SESSION['SSMData']['clientGuid']);
    $data = json_decode($json,true);

    $productList = return_new_json_product_list($data, FALSE);

    $canIsaveProduct = canIsaveProduct($productList, json_decode($jsonProduct), $isEdit);

    if($canIsaveProduct['success'] === TRUE) {
        $response = ServicebusRequest($sb_path, $orig_data);
    } else {
        $response = json_encode(
            Array(
                'responseCode' => 2000,
                'responseObject' => Array(),
                'responseText' => $canIsaveProduct['responseText']
            )
        );
    }

    echo $response;
}

