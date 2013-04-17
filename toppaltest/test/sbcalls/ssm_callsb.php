<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 10/04/13
 * Time: 11:13
 * To change this template use File | Settings | File Templates.
 */
require_once '../../vendor/autoload.php';

class SSM_CallSB
{
    const _PUBLIC_KEY   = 'cinsay99Public';
    const _PRIVATE_KEY  = 'cinsay99Private';
    const _END_POINT    = 'http://services.int.cinsay.com';
    //const _CLIENT_ID    = '6896c593-ce48-4c76-a18f-86d89f7882b1';
    /**
     * pbellusci@cinsay.com @ cinsay.ru
     */
    const _CLIENT_ID    = 'c22e52d1-66ca-474f-b228-d15bd03af434';


    private $_apiPath = null;
    private $_optionCall = Array();
    private $_callData = Array();

    private $_encryptedData = Array();
    private $_curlClient = null;

    public function __construct()
    {
        return $this;
    }

    private function _configureCall($typeCall = 'genericJSON')
    {

        $this->_curlClient = new Buzz\Client\Curl();
        $this->_curlClient->setTimeout(120);

        $responseObject['typeName'] = $typeCall;
        $responseObject = array_merge($responseObject, $this->_optionCall);
//        $responseObject['jsonObject'] = $this->_optionCall;

        /**
         * Mail Jesse Way      
         * 
         */

        $this->_callData = json_encode(Array(
            'apiKey'        => self::_PUBLIC_KEY,
            'clientId'      => self::_CLIENT_ID,
            'requestObject' => $responseObject,
            'params'        => null
        ));

        /**
         * SSM way
         */
//        $this->_callData = json_encode(Array(
//            'apiKey'        => self::_PUBLIC_KEY,
//            'clientId'      => self::_CLIENT_ID,
//            'requestObject' => null,
//            'params'        => $this->_optionCall
//        ));

//
//        echo $this->_callData;
//        die();

        $encryptedData = base64_encode(stripslashes($this->_callData));
        $this->_encryptedData = $encryptedData . "." . md5(self::_PRIVATE_KEY.$encryptedData);
    }

    protected function call($apiPath = '', $options = Array(), $typeCall = 'genericJSON')
    {
        $this->_apiPath = $apiPath;
        $this->_optionCall = $options;
        $this->_configureCall($typeCall);

//        echo self::_END_POINT.$this->_apiPath; die();

        $call = new Buzz\Browser($this->_curlClient);

        $response = $call->post(self::_END_POINT.$this->_apiPath, array('Content-type: application/json; charset=UTF-8'), $this->_encryptedData);

        return $response->getContent();
    }

}