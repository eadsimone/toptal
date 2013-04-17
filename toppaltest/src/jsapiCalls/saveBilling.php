<?php
include '../functions.php';

//$response = '{
//   "responseCode":"1000",
//   "responseObject":"ok",
//   "responseText":"successful"
//}';
//note:it is on ui side but is not working
if(isset($_POST['zipcode'])&&($_POST['zipcode']!='')){

    if($_POST['country']=="US"){
        if (!preg_match('/(^\d{5}$)|(^\d{5}-\d{4}$)/',$_POST['zipcode'])) {
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid zip code. For example 90602 or 90602-1234.'));
            exit;
        }
    }
}

if(isset($_POST['creditcard'])&&($_POST['creditcard']!='')){

    if (strpos($_POST['creditcard'],'*') !== false) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid Credit Card number, replace "*" for the correct numbers.'));
        exit;
    }

//    if (!preg_match('/^[0-9]{12,18}$/',$_POST['creditcard'])) {
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid Credit Card number,if contain "*" you must replace for the correct numbers.'));
//        exit;
//    }
}

if(isset($_POST['cvv'])&&($_POST['cvv']!='')){

    if (strpos($_POST['cvv'],'*') !== false) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid CVV, without  " * ".'));
        exit;
    }

//    if (!preg_match('/(^[0-9]{3,4})$/',$_POST['cvv'])) {
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'If the credit card is AMEX cvv should be contain 4 numbers. Others should be contain 3.'));
//        exit;
//    }
}

if($_POST['cvv']=='' ||$_POST['creditcard']=='' || $_POST['zipcode']==''){
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'Zip Code, Credit Card, Cvv are required.'));
    exit;
}

$response='
{
    "typeName": "creditCardInfo",
    "state": "TX",
    "country": "US",
    "storeCustomerId": null,
    "customerId": null,
    "ccNumber": "$bt2$Kvxh+8DINFvY3kMSWmBO6i7zUfIYJsVI1P+Vt\\/cWv4CGNqWiAktB9qhNNXmNwcPPqe8EkwVQ4Y\\/2GrMqSS4qeiA7atyZAnqu5mAxBakOjZ\\/sITcBMDoo5+ZF\\/VjbJ+sGuWTdKCO1rI5ZySBvZix9FftTyRQvift+NsKBUBeLSIkXRIQBwCqKqP+u4IdKxZXf8V7cEqc+A9Wu0FS1xdc7FYWA6U5YTYr6V4W4Y32UO5iB5UhotdG1Dx5jThNeO\\/FWKpk5M9j86gUXObnCdjdVujt2AWLWzqhBc0Bsbu0PFS3+7Pz6qWDKbiAgdYZr4kuDfooKHSREG1VsmGHRXWIiAw==$6hpuQ+admpfx5hcdd+aA1rqJv\\/S8tSZEtk+fmz7ZLbivkQXz+lztW8CIYirE7eM6",
    "ccExpMonth": null,
    "ccExpYear": null,
    "ccExpDate": "$bt2$gufUTycdIqoKLbVSYsQILrWmNAiPa5wfAMeyyUMAIWm+J6QNDS2Vm2m4cJOPAYxFTKh2LHohsaEzDD+wUq4jdh1\\/ynYruudnKCYuu16KodGFmoWq5lkCJmyAoDwFG\\/80MMYNqyRCVXOiIzhsLN5+mGqfYz8nqhIikKi2hJ+XUHisieamUNuyIdR2of7\\/rQY3qWueoD90AMXjClHhRyVUHviaLPt\\/7\\/Fy3CHP0ys5EApXLHuIUnQ7W1b8bsvtkmwpSGqpYT\\/mUHF8Vawpt9MWWiXLlZKaBWusr6bgiolVKjnEY8wZxBAzVpirHscmcKJQKwVBHFUmIy2Q0G9iWj9TGA==$5sEwXH5VdHdiBHK21KNr0gvPeKJMR1HMuyDr4ImdIbk=",
    "ccFirstName": "clientFirst",
    "ccLastName": "clientLast",
    "ccCVV": "$bt2$jvbSzEHWkhM71RqaYAGRNYdoL3oQXy6cQpf54YdS\\/YPwEDp5GVkbVm7Fi7mfWRROUafuemkx5JtfLyYmR5Gu21xKFwOmCVSQ\\/jKlY5RJjyUmcuK78PRwWfS6b64Nxh2sLWDrqEuU2i8e2B5siFxpp2A9hLX\\/q+6aeW5i4W5cVbLCL+DXxX3A8K1IiSk4faFdLkBfna8qq1JD+xZyzcXUsoPnuVaMuJ2UzYM06Z+Km9qj4TV+wGMVh9bheX\\/+VT90C1cOrFxhUnJsLG2zeMgXU5XZTsvvwyw+iBNDfZpxWoLdYaq23O8I7GFisA\\/vLbhMfNo2le66hF\\/YknetjDqz2g==$xhJYPjNb5WZysnF5b8OMPRVM54wRRe2DEJOll1zJ68M=",
    "ccNumberMasked": null,
    "streetAddress": "123 Fake St",
    "extendedAddress": null,
    "city": "Austin",
    "postalCode": "78701"
}
';

$Merchant_account_info['typeName']='creditCardInfo';
$Merchant_account_info['state']=$_POST['state'];
$Merchant_account_info['country']=$_POST['country'];
$Merchant_account_info['streetAddress']=$_POST['address'];
$Merchant_account_info['city']=$_POST['city'];

$Merchant_account_info['storeCustomerId']=null;
$Merchant_account_info['customerId']=null;

$Merchant_account_info['ccNumber']=$_POST['creditcard'];

$Merchant_account_info['ccCVV']=$_POST['cvv'];

$Merchant_account_info['ccExpMonth']=$_POST['expiration_month'];
$Merchant_account_info['ccExpYear']=$_POST['expiration_year'];

$Merchant_account_info['ccExpDate']=$_POST['expiration_date'];

$Merchant_account_info['postalCode']=$_POST['zipcode'];


$Merchant_account_info['ccFirstName']='clientFirst';
$Merchant_account_info['ccLastName']='clientLast';


$clientid=$_SESSION['SSMData']['clientGuid'];

$client_id=getClientId(ServicebusGetClientInfo($clientid));

//$client_id='5447';//TAKE OUT IT WHEN JESSE SOLVE THE ISSUE REGARDS CLIENT ID IN SB!!!!

$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'.$client_id.'","requestObject":' . json_encode($Merchant_account_info) .',"params":null}';
//$sb_path = "/api/cms/players/createorupdate";
$sb_path = "/api/client/creditcard/store";


$response = ServicebusRequest($sb_path, $orig_data);


echo print_r($response, true);