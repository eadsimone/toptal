<?php

require_once __DIR__ . '/../../src/functions.php';

require '../../vendor/autoload.php';
require '../../vendor/amazonwebservices/aws-sdk-for-php/sdk.class.php';
require '../../vendor/amazonwebservices/aws-sdk-for-php/aws.phar';

use Aws\Common;
use Aws\Common\Enum;

use Aws\S3;
use Aws\S3\Enum as S3E;
use Aws\S3\Enum\CannedAcl as CannedAcl;
use Aws\S3\Model;
use Aws\S3\S3Client;

class Upload
{
    public $response = array();
    public $clientTo = array(
        'apiKey'        => 'cinsay99Public',
        'clientId'      => null,
        'requestObject' => null,
        'params'        => null
    );

    public function __construct()
    {
        $this->clientTo['clientId'] = $_SESSION['SSMData']['clientGuid'];
        $encoded                    = base64_encode(json_encode($this->clientTo));
        $_response                  = $this->_SBcurl($encoded . "." . md5('cinsay99Private' . $encoded), 'client/get');
        foreach ($_FILES as $asset => $file) {
            // request the client and capture it
            $this->response[$asset]->sbClient = $client = json_decode($_response, true);
            $name   = $file['name'] = urlencode(htmlspecialchars($file['name']));
            $type   = $file['type'] = stripslashes($file['type']);
            $prefix = '/stag/' . $_SESSION['SSMData']['clientGuid'] . '/originals/';
            $key    = $prefix . $file['name'];
            // prepare request
            $encoded = base64_encode(json_encode(array(
                'apiKey'        => 'cinsay99Public',
                'clientId'      => $client['responseObject']['id'],
                'requestObject' => array(
                    'fileName'     => $name,
                    'Content-type' => stripslashes($type),
                    'typeName'     => 'generateS3UploadURL'
                ), 'params'        => null)));

            // signature call to sb
            $this->response[$asset]->sbSigned = json_decode($this->_SBcurl($encoded . "." . md5('cinsay99Private' . $encoded)), true);

            $s3 = S3Client::factory(array('key'    => "AKIAIRS7PXWA6GAQY2RA",
                                          'secret' => "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",
                                          'region' => Aws\Common\Enum\Region::US_EAST_1
            ));
            $callback = function (S3Client $s3, $key, $prefix, $file) {
                 $s3->putObject(array(
                    'Bucket'    => 'devcinsay',
                    'Key'       => $key,
                    'Delimiter' => "%2F",
                    'Prefix'    => $prefix,
                    'Body'      => @file_get_contents($file['tmp_name']),
                    'ACL'       => CannedAcl::PUBLIC_READ));};
            // execute upload to s3, capture result
            $callback($s3, $key, $prefix, $file);


            $this->response[$asset]->s3       = $s3;
            $this->response[$asset]->files    = $_FILES;
            $this->response = json_decode(stripslashes(urldecode(json_encode($this->response))), true);

            $src = $asset."Url";
            $arr = explode("/", $this->response[$asset]['sbSigned']['responseObject']['assetUrl']);
            $this->responseText = array(
                $src => ($url = implode("/", array("$arr[0]/", $arr[2], $arr[3], $arr[4], "originals", $arr[5]))),
                "straight"=>$this->response[$asset]['sbSigned']['responseObject']['uploadUrl'],
                "assetUrl" => $src,
                "src" => $url,
                "name" => $asset,
                $asset => array('url'=>$url),
                "url" => $url,
                "file" => $arr[5],
                "guid" => $arr[4]
            );

            echo json_encode($this->responseText);

            return json_encode($this->response);
        }
    }



    public function _SBcurl($encrypted, $endpoint = "cms/assets/generateS3UploadURL")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_SERVER['BASE_URL'].'/api/' . $endpoint);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json; charset=UTF-8",
            "Content-length: " . strlen($encrypted)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encrypted);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}

try {
    if (count($_FILES) > 0) {
        return new Upload();
    } else {
        throw new Exception("No \$_FILES, something is wrong with object targeting");
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}