<?php

require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__ .'/../logger.php';

session_cache_limiter(false);
session_start();

@date_default_timezone_set (date_default_timezone_get()); //quick set of timezone info to server defaults


// Translation logger
function translation_logger($text, $region)
{
    $filename = '../cache/word.'.$region.'.log';

    // Text to be entered into the log
    $logged_text = '"'.$text.'","'.$text.'"';
    $logged_text .= "\r\n";

    if(is_writable($filename))
    {
        $handle = fopen($filename, 'a');
        fwrite($handle, $logged_text);
        fclose($handle);
    }

}

//the simplest implementation of a translator
function __($key) {

	/*
	1.) figure out what the locale of the client is
	2.) look up the locale dictionary if it exists, use it. if not, use default (en_US)
	3.) use the text as the key and return the value from the locale dictionary
	4.) if it doesn't exist in locale, show from default (en_US)
	*/

    // FOR TESTING PURPOSES ONLY
	//return $value = strtoupper($key);

    if(isset($_SESSION['locale']))
    {
        $region = $_SESSION['locale'];
    }
    else
    {
        $region = 'en_US';
    }


    // Parse dictionary file into an array
    $dict = array();
    if($handle = fopen(__DIR__. '/locale/dictionary.'.$region.'.csv','r'))
    {
        while ($list = fgetcsv($handle, 0, ','))
        {
            $dict[$list[0]] = $list[1];
        }
        fclose($handle);
    }


    // Return the value of the text passed. If a null or empty value is returned than the original text is returned
    if(isset($dict[$key])) {
	    if($dict[$key] == '' || $dict[$key] == NULL)
	    {
	        $result = $key;
	        //add some logger that tells this guy isn't yet translated
             translation_logger($key, $region);
	    } else {
	        $result = $dict[$key];
	    }
    } else {
    	$result = $key;
    	//add some logger that tells this guy isn't yet translated
         translation_logger($key, $region);
    }
    
    return $result;

}





/**
 * Get mustache template(s), and prints them in a semi-minified JSON string
 * @param mixed $templateFiles One or more mustache templates to fetch
 * @return string
 */
function loadTemplateCache() {

    $templates = func_get_args();

    foreach( $templates as $template ) {

        $templateFile = '../src/views/' . $template;

        // Quick sanity check. Should/could be disabled on prod environment
        if( !is_readable( $templateFile ) ) {
            return JSON::Encode( array( $templateFile => "ERROR: loadTemplateCache() cannot read template file: " . $templateFile ) );
        }

        // Load file as string
        $templateStr = file_get_contents( $templateFile );

        /*
         *
            1. Get all the i18n tags
	        2. Convert using the function
	        3. Put entire html string back together
            */
            // RegEx for tags
            $matchreg = '/\{\{#i18n\}\}(.+?)\{\{\/i18n\}\}/';

            //returns an array [0] is original text [1] is replaced text
            preg_match_all($matchreg,$templateStr,$match);

            // If $match is not empty, process i18n tags
            if(array_filter($match))
            {
                // convert using i18n function
                $convert = array();
                foreach ($match[1] as $key => $value) {
                	$convert[] = __($value);
                }

                // Combine the original i18n string as the key and the convert
                $final = array_combine($match[0],$convert);

                // The final html text string
                $templateStr = str_replace(
                	array_keys($final),
                	array_values($final),
                	$templateStr
                );
            }

        // Take out newlines and unnecessary spaces
        $retPartials[ $template ] = str_replace(
            array( "\n", "\r", "\t", "  " ),
            array( " ", " ", " ", "" ),
            $templateStr
        );
    }

    return JSON::Encode( $retPartials );
}


/**
 * @param      $text
 * @param null $length
 *
 * @return mixed
 */
function shrinkText($text, $length = NULL)
{
    $length = $length ? $length : 36;
    $max = $length - 6;
    // count chars multibyte, if they are russian should still work
    $count = mb_strlen($text,'UTF-8');

    if ($count > $length)
    {
        // Using this longer more complicated way to do it because it does support russian chars
        $enc = 'utf8';
        $beginning = mb_substr($text, 0, $max, $enc);
        $end = mb_substr($text, -3, mb_strlen($text, $enc), $enc);
        $text = $beginning.'...';

        // Unfortunately this simpler solutions does not support russian chars for splitting text
//			$text = substr_replace($text, '...', $max, -3);
    }
    return $text;
}

function getAppConfig() {

    $curlClient = new Buzz\Client\Curl();
    $curlClient->setTimeout(120);

    if(isset($_SERVER['BASE_URL'])&& ($_SERVER['BASE_URL']!='')){
        $base_url=$_SERVER['BASE_URL'];
    } else {
        $base_url="http://services.int.cinsay.com";
    }

    if(isset($_SERVER['PUBLIC_KEY'])&& ($_SERVER['PUBLIC_KEY']!='')){
        $public_key=$_SERVER['PUBLIC_KEY'];
    } else {
        $public_key="cinsay99Public";
    }

    if(isset($_SERVER['PRIVATE_KEY'])&& ($_SERVER['PRIVATE_KEY']!='')){
        $private_key=$_SERVER['PRIVATE_KEY'];
    } else {
        $private_key="cinsay99Private";
    }

    if(isset($_SERVER['CACHE_SB'])&& ($_SERVER['CACHE_SB']!='')){
        $cache_sb=$_SERVER['CACHE_SB'];
    } else {
        $cache_sb=false;
    }
    
    $servicebuslog = false;

    if(isset($_SERVER['CINSAY_MARKETPLACE_BASE_URL']) && ($_SERVER['CINSAY_MARKETPLACE_BASE_URL']!='')){
        $marketplace_base_url=$_SERVER['CINSAY_MARKETPLACE_BASE_URL'];
    } else {
        $marketplace_base_url="http://marketplace.int.cinsay.com/";
    }

    $config = array(
        "baseUrl" => $base_url,
    	"marketplaceBaseUrl" => $marketplace_base_url,
        "publicKey" => $public_key,
        "privateKey" => $private_key,
        "httpclient" => new Buzz\Browser($curlClient),
        "cacheSB" => $cache_sb,
        "servicebuslog" => $servicebuslog
    );

    return $config;
}


function genericStorage($storageKey, $dataKey, $data = null, $timeOut = 10) {
    if($data == null) {
        if(isset($_SESSION[$storageKey][$dataKey]['data'])) {
            if(isset($_SESSION[$storageKey][$dataKey]['time']) && ($_SESSION[$storageKey][$dataKey]['time'] > strtotime("now"))) {
                return $_SESSION[$storageKey][$dataKey]['data'];
            } else {
                unset($_SESSION[$storageKey][$dataKey]);
            }
        }
        return false;
    } else {
        $_SESSION[$storageKey][$dataKey]['data'] = $data;
        $_SESSION[$storageKey][$dataKey]['time'] = strtotime("+" . $timeOut . " minutes");
        return true;
    }
}

function SSMData($key, $data = null) {
    return genericStorage('SSMData', $key, $data, 120);
}

function unsetSSMData($key) {
    unset( $_SESSION['SSMData'][$key]);
}

function SSMCache($key, $data = null) {
    return genericStorage('SSMCache', $key, $data);
}

function unsetSSMCache($key) {
	unset($_SESSION['SSMCache'][$key]);
}

function SSMServiceBusLog($path, $request, $response, $encrypted = true, $cached = false, $logLimit = 10) {
    $config = getAppConfig();
    if($config['servicebuslog'] == true) {
        $logData = array(
            'timestamp' => date('Y-m-d G:i:s', time()),
            'path' => $path,
            'encrypted' => $encrypted,
            'cached' => $cached,
            'request' => $request,
            'response' => $response
        );


        if(isset($_SESSION['SSMServiceBusLog'])) {
            while(count($_SESSION['SSMServiceBusLog']) >= $logLimit ) {
                array_shift($_SESSION['SSMServiceBusLog']);
            }
        }
        $_SESSION['SSMServiceBusLog'][] = $logData;


       /*regards to file handle to delete the lines above */
       //$handle = fopen("../cache/client_cliengui_Servicebusgetclient.txt", "r+");
        $clientguid=$_SESSION['SSMData']['clientGuid'];
        $path=$logData["path"];
        $path=str_replace("/", "_", $path);

        //$file="/home/peche/www/cinsay/ssm/trunk/src/main/php/cache/client_".$clientguid."_".$path.".txt";
        //$file="../cache/client_".$clientguid."_".$path.".txt";
         $file=__DIR__."/../cache/client_".$clientguid."_".$path.".txt";

        if (!file_exists($file)) {
            $handle = fopen($file, "a");
            $text="";
            foreach ($logData as $key => $value) {
                $text.="$key ===>$value\n";
                $text.="\r\n";
            }
// Write the contents back to the file
            file_put_contents($file, $text);
            fclose($file);
        }



    }
}


//// Authentication calls. We never want to cache
function ServicebusLogin($email, $password) {
    $request = '{"apiKey":"{{publicKey}}","requestObject":{"username":"{{email}}","password":"{{password}}","typeName":"userAuth"},"params":null}';
    $sb_path = "/api/user/login";

    $request = str_replace("{{email}}", $email, $request);
    $request = str_replace("{{password}}", $password, $request);

    return ServicebusRequest($sb_path, $request);
}

function ServicebusSuperAdminLogin($username, $email, $password) {
    $request = '{"apiKey":"{{publicKey}}","requestObject":{"username":"{{username}}","email":"{{email}}","password":"{{password}}","typeName":"clientAuth"},"params":null}';
    $sb_path = "/api/client/login";

    $request = str_replace("{{username}}", $username, $request);
    $request = str_replace("{{email}}", $email, $request);
    $request = str_replace("{{password}}", $password, $request);

    return ServicebusRequest($sb_path, $request);
}

function ServicebusLogout($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/logout";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    return ServicebusRequest($sb_path, $request);
}

function ServicebusResetPassword($email) {
    $request = '{"apiKey":"{{publicKey}}","requestObject":{"email":"{{email}}","typeName":"clientAuth"},"params":null}';
    $sb_path = "/api/client/resetpassword";

    $request = str_replace("{{email}}", $email, $request);
    
    return ServicebusRequest($sb_path, $request);
}




//Normal CMS calls. We want to cache
function ServicebusGetClientInfo($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetBillingInformation($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/creditcard/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}


function ServicebusGetMerchantinformation($clientGuid=null) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/merchantinfo/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetMarketplaceCategories($clientGuid, $includePrivate = false) { // NEED TO TALK TO MAT ABOUT THIS
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"includePrivate":[{{includePrivate}}]}}';
    $sb_path = "/api/cms/categories/getallrootnodes";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);
    $request = str_replace("{{includePrivate}}", $includePrivate, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}



function ServicebusGetShippingMethods( $clientGuid, $storeID, $type = 'all' ) {

    $requestObject = json_encode(Array(
        'typeName' => 'genericJSON',
        'jsonObject' => Array(
            'storeID' => $storeID,
            'code' => $type
        )
    ));

    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":' . $requestObject . ',"params":null}';
    $sb_path = '/api/client/shipping/cinsayShippingGetShippingMethods';

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);
}

function ServieBusSetShippingMethods($clientGuid, $shippingRule, $shippingRate) {

    $requestObject = json_encode(Array(
        'type' => $shippingRule,
        'rate' => $shippingRate
    ));

    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":' . $requestObject . ',"params":null}';
    $sb_path = '/api/client/shipping/cinsayShippingSetShippingMethods';

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServiceBusGetReports($clientGuid, $options) {

    $options['typeName'] =  'reportFilter';
    $requestObject = json_encode($options);

    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":' . $requestObject . ',"params":null}';
    $sb_path = '/api/client/reports/get';

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetPlans($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/plan/availableoptions";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetClientPlan($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/plan/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetPlayer($clientGuid, $playerGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["{{playerGuid}}"]}}';
    $sb_path = "/api/cms/players/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);
    $request = str_replace("{{playerGuid}}", $playerGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid . "__" . $playerGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}


function ServicebusGetStoreInfo($clientGuid, $storeGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["{{storeGuid}}"]}}';
    $sb_path = "/api/cms/stores/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);
    $request = str_replace("{{storeGuid}}", $storeGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid . "__" . $storeGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetPlayerList ($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/cms/players/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetProduct($clientGuid, $productGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["{{productGuid}}"]}}';
    $sb_path = "/api/cms/items/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);
    $request = str_replace("{{productGuid}}", $productGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid . "__" . $productGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetProductList($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/cms/items/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetSocialMediaList($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/client/sm/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetVideo($clientGuid, $videoGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["{{videoGuid}}"]}}';
    $sb_path = "/api/cms/videos/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);
    $request = str_replace("{{videoGuid}}", $videoGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid . "__" . $videoGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}

function ServicebusGetVideoList($clientGuid) {
    $request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":null}';
    $sb_path = "/api/cms/videos/get";

    $request = str_replace("{{clientGuid}}", $clientGuid, $request);

    $keyName = __FUNCTION__ . "__" . $clientGuid;

    return ServicebusCachableRequest($keyName, $sb_path, $request);

}




//does the SB send and returns the data
function ServicebusRequest($urlPath, $request, $encrypted = true) {
    $config = getAppConfig();

    $url = $config['baseUrl'] . $urlPath;
    $request = str_replace("{{publicKey}}", $config['publicKey'], $request);
    if($encrypted == false) {
        $data = $request;
    } else {
        $data = encodeForServiceBus($request, $config['privateKey']);
    }


    $httpclient = $config['httpclient'];
    $response = $httpclient->post($url, array('Content-type: application/json; charset=UTF-8'), $data);

    SSMServiceBusLog($urlPath, $request, $response->getContent(), $encrypted);
    return $response->getContent();
}

function ServicebusCachableRequest($keyName, $sb_path, $request) {
    $config = getAppConfig();

//    if(($config['cacheSB'] == true) && (SSMCache($keyName) != false)) {
//        return SSMCache($keyName);//load file!!
//    } else {
//        $response = ServicebusRequest($sb_path, $request);//write file
//        if($config['cacheSB'] == true) {
//            SSMCache($keyName, $response);
//        }
//        return $response;
//    }
/***----*/
    $clientguid=$_SESSION['SSMData']['clientGuid'];
    $file=__DIR__."/../cache/client_".$clientguid."_".$keyName.".txt";

    if(($config['cacheSB'] == true) && file_exists($file)) {

        $handle = fopen($file, "a");
        $content=file_get_contents($file);
        fclose($file);
        return $content;
        //return SSMCache($keyName);//load file!!
    } else {
        $response = ServicebusRequest($sb_path, $request);//write file
        if($config['cacheSB'] == true) {

            $handle = fopen($file, "a");
            //file_put_contents($file, json_encode($response));
            file_put_contents($file, $response);
            fclose($file);
            //SSMCache($keyName, $response);
        }
        return $response;
    }
}

//does the encryption for sending to SB
function encodeForServiceBus($data, $privateKey) {
    $enc_data = base64_encode(stripslashes($data));
    return $enc_data . "." . md5($privateKey.$enc_data);
}


/*Return all month */

function setMonth($month_selected) {
    $total_month=11;
    $month = strtotime("January");


    for($i=0;$i<=$total_month;$i++)
    {
        //   print '<option value="'. date("F", $month)  .'">'.$month.'</option>';
        //!!! i do not know is coming number or name of the month!!!!
        if(date('m', strtotime(date("F", $month)))==$month_selected){
            $each_month[]=Array(
                'label'  =>  date("F", $month),
                'value'  =>  date('m', strtotime(date("F", $month))),
                'sel' => true
            );
        }else{
            $each_month[]=Array(
                'label'  =>  date("F", $month),
                'value'  =>  date('m', strtotime(date("F", $month)))
            );
        }
        $month = strtotime("+".$i." months");
    }
    return $each_month;
}
/*Return current year adn the following increment years */
function setYear($max_year_increment,$year_selected) {
    $year = strtotime("now");

    for($i=1;$i<=$max_year_increment;$i++)
    {
        //print '<option value="'. date("Y", $year)  .'">'.date("Y",$year).'</option>';

        if(date("Y", $year)==$year_selected){
            $each_year[]=Array(
                'label'  =>  date("Y", $year),
                'sel' => true
            );
        }else{
            $each_year[]=Array(
                'label'  =>  date("Y", $year)
            );
        }

        $year = strtotime("+".$i." year");

    }

    return $each_year;
}

function prettyJSON($json) {
    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;
    for ($i=0; $i<=$strLen; $i++) {
        $char = substr($json, $i, 1);
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        $result .= $char;
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
        $prevChar = $char;
    }
    return $result;
}

/*for marketplace*/
function cleanupUserKeywordsFromParams($userKeywords)
{

    if ($userKeywords != null) {
        $userKeywords = explode(',', $userKeywords);
        $userKeywords = array_map(function ($keyword) {
            return trim($keyword);
        }, $userKeywords);

        $userKeywords = array_unique($userKeywords);
        $userKeywords = array_filter($userKeywords, function ($keyword) {
            return $keyword !== '';
        });
        $userKeywords = implode(', ', $userKeywords);
    } else {
        $userKeywords = '';
    }

    return $userKeywords;
}

/*GEt Client ID*/
function getClientId($response)
{

    $data=json_decode($response,true);

    $clientid=$data['responseObject']['id'];

    return $clientid;
}
/**
 * BB - JSON wrapper to:
 *   A) contextually handle errors, and
 *   B) set optimal php-version-dependent flags
 * Idea from http://www.php.net/manual/en/function.json-last-error.php
 */
class JSON {

    public static function Encode( $obj ) {

        // JSON_UNESCAPED_UNICODE introduced in PHP 5.4.0
        if( version_compare( PHP_VERSION, '5.4.0', '>=' ) ) {
            $result = json_encode( $obj, JSON_UNESCAPED_UNICODE );
        } else {
            $result = json_encode( $obj );
        }

        self::checkForErrors();

        return $result;
    }

    public static function Decode( $json, $toAssoc = false ) {

        $result = json_decode( $json, $toAssoc );

        self::checkForErrors();

        return $result;
    }

    private static function checkForErrors() {

        // json_last_error() introduced in PHP 5.3.0
        if( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {

            $errNo = json_last_error();

            switch( $errNo ) {
                case JSON_ERROR_DEPTH:
                    $error = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_NONE:
                default:
                    $error = '';
            }

            // JSON_ERROR_UTF8 introduced in PHP 5.3.3
            if( version_compare( PHP_VERSION, '5.3.3', '>=' ) ) {
                if( $errNo === JSON_ERROR_UTF8 ) {
                    $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                }
            }

            if( $error ) {
                throw new Exception( 'JSON Error: ' . $error );
            }
        }
    }
}

//does the SB send and returns the data
function ServicebusRequest2($urlPath, $request, $encrypted = true) {
	$config = getAppConfig();

	$url = $config['baseUrl'] . $urlPath;
	$request = str_replace("{{publicKey}}", $config['publicKey'], $request);
	if($encrypted == false) {
		$data = $request;
	} else {
		$data = encodeForServiceBus($request, $config['privateKey']);
	}


	$httpclient = $config['httpclient'];
	$response = $httpclient->post($url, array('Content-type: application/json; charset=UTF-8'), $data);
	die($urlPath . "\n****************\n" . prettyJSON(print_r($request, true)) . "\n****************\n" . prettyJSON(print_r($response->getContent(), true)));
	SSMServiceBusLog($urlPath, $request, $response->getContent(), $encrypted);
	return $response->getContent();
}

function ServicebusCachableRequest2($keyName, $sb_path, $request) {
	$config = getAppConfig();
	if(($config['cacheSB'] == true) && (SSMCache($keyName) != false)) {
		return SSMCache($keyName);
	} else {
		$response = ServicebusRequest2($sb_path, $request);
		if($config['cacheSB'] == true) {
			SSMCache($keyName, $response);
		}
		return $response;
	}
}
