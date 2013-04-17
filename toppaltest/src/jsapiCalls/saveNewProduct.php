<?php

include '../functions.php';

/*to validate from server side*/
$error='';
$counter=0;
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

if(!isset($_POST['urlLink']) || $_POST['urlLink']==''){
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'The URL is required'));
    exit;
}

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

    $data['thankyouPageHeadline'] = $thankyouPageHeadline;
    $data['thankyouPageDescription'] = $thankyouPageDescription;
    if($thankyouPageImage) {
        $data['thankyouPageImage']['typeName'] = 'image';
        $data['thankyouPageImage']['url'] = $thankyouPageImage;
    }
    $data['thankyouPageUrl'] = $thankyouPageUrl;
    $data['itemVariants'][] = $itemVariant;
    
    return $data;
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

function createProductEcomm()
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'ecomm',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    ));

    $variantsJSON =
        '{
            "typeName": "ecomm_variant",
            "name": "Ecomm Variant",
            "description": "Ecomm Variant",
            "thumb": {
                "typeName": "image",
                "url": "{{image}}"
            },
            "medium": {
                "typeName": "image",
                "url": "{{image}}"
            },
            "large": {
                "typeName": "image",
                "url": "{{image}}"
            },
            "price": "{{price}}",
            "quantity": {{quantity}},
            "weight": {{weight}}
        }';

    $ecommVariants = jsonReplazator($variantsJSON, Array(
        'image'     => 'http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg',
        'quantity'  => $_POST['quantity'],
        'price'     => $_POST['price'],
        'weight'    => $_POST['weight']
    ));

    $default = json_decode($default, true);
    $default['itemVariants'][] = json_decode($ecommVariants, true);

    return json_encode($default);

}


function returnDefaultVars($replaceVars = Array())
{
    $defaultVars =
    '{
        "typeName": "{{typeName}}",
        "name": "{{name}}",
        "description": "{{description}}",
        "image"     : "http://devcdn.cinsay.edgesuite.net/int/29a9fd08-2a65-4cd3-84a3-3bd2fd306df1/large-1340895091583.jpg",
        "assetStatus": "ACTIVE"
    }';

    return jsonReplazator($defaultVars, $replaceVars);
}

function createNewDonation($data, $variables,
                           $amounts = array(),
                           $introPageHeadline = null,
                           $introPageDescription = null,
                           $thankyouPageHeadline = null,
                           $thankyouPageDescription = null,
                           $thankyouPageImage = null,
                           $thankyouPageUrl = null,
                           $donationType,
                           $donationDisclaimerText = null) {

    $itemVariant = '
	        {
	            "typeName": "donation_variant",
	            "description": "{{name}} {{iterator}}",
	            "externalProductId": null,
	            "default": "false",
	            "thumb": {
	                "typeName": "image",
	                "url": "{{image}}"
	            },
	            "medium": {
	                "typeName": "image",
	                "url": "{{image}}"
	            },
	            "large": {
	                "typeName": "image",
	                "url": "{{image}}"
	            },
	            "name": "donation {{name}} {{iterator}}",
	            "amount": {{amount}}
	        }
			';

    $itemVariant = str_replace("{{name}}", $variables['name'], $itemVariant);
    $itemVariant = str_replace("{{image}}", $variables['image'], $itemVariant);
    for($i = 0; $i < count($amounts); $i++) {
        $iVariant = $itemVariant;
        $iVariant = str_replace("{{amount}}", $amounts[$i], $iVariant);
        $iVariant = str_replace("{{iterator}}", $i, $iVariant);
        $itemVariantData = json_decode($iVariant, true);
        if($i == 0) {
            $itemVariantData['default'] = "true";
        }
        $data['itemVariants'][] = $itemVariantData;
    }

    $data['introPageHeadline'] = $introPageHeadline;
    $data['introPageDescription'] = $introPageDescription;
    $data['thankyouPageHeadline'] = $thankyouPageHeadline;
    $data['thankyouPageDescription'] = $thankyouPageDescription;
    if($thankyouPageImage) {
        $data['thankyouPageImage']['typeName'] = 'image';
        $data['thankyouPageImage']['url'] = $thankyouPageImage;
    }
    $data['thankyouPageUrl'] = $thankyouPageUrl;
    $data['donationType'] = $donationType;
    $data['donationDisclaimerText'] = $donationDisclaimerText;

    return $data;
}

function createProductDonation()
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'donation',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    ));

    $donationOptions = createNewDonation(
        json_decode($_POST, TRUE),
        json_decode($default, TRUE),
        $amounts = array(11,12,13),
        $introPageHeadline = "iheadline",
        $introPageDescription = "description",
        $thankyouPageHeadline = "tyheadline",
        $thankyouPageDescription = "tydescription",
        $thankyouPageImage = "tyimage",
        $thankyouPageUrl = "tyurl",
        $donationType = "GENERAL",
        $donationDisclaimerText = "don't click here");

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
			                "url": "{{image}}"
			            },
			            "medium": {
			                "typeName": "image",
			                "url": "{{image}}"
			            },
			            "large": {
			                "typeName": "image",
			                "url": "{{image}}"
			            },
			            "default": "true",
			            "url": "{{url}}",
			            "linkOffType": "LINKOFF"
			        }
			';

    $itemVariant = str_replace("{{image}}", $variables['image'], $itemVariant);
    $itemVariant = str_replace("{{url}}", $url, $itemVariant);

    $data['itemVariants'][] = json_decode($itemVariant, true);
    return $data;
}


function createProductLinkOut()
{
    $default = returnDefaultVars(Array(
        'typeName'      => 'linkoff',
        'name'          => $_POST['productName'],
        'description'   => $_POST['productDescription'],
    ));

    $linkOffOptions = createNewLinkoff(
        $_POST,
        json_decode($default, TRUE),
        $_POST['urlLink']
    );


    $response = json_encode(array_merge(json_decode($default, TRUE), $linkOffOptions));

    return $response;
}

switch ($_POST['productType']) {

    case 'add-product-ecommerce':
        $jsonProduct = createProductEcomm();//createEcomm
        break;

    case 'add-product-leadgen':
        $jsonProduct  = createProductLeadGen();
        break;

    case 'add-product-donation':
        $jsonProduct  = createProductDonation();
        break;

    case 'add-product-link-out':
        $jsonProduct  = createProductLinkOut();
        break;
}

$orig_data = '{"apiKey":"{{publicKey}}","clientId":"' .  $_SESSION['SSMData']['clientGuid'] . '","requestObject":' . $jsonProduct .',"params":null}';
$sb_path = "/api/cms/items/createorupdate";

$response = ServicebusRequest($sb_path, $orig_data);

echo $response;