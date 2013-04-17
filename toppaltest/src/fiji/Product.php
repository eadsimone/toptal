<?php
/**
 * User: llasalla
 * Date: 1/30/13
 * Time: 12:17 PM
 */

namespace Fiji\SbService;

require_once('SbService.php');

use Fiji\SbService as SbService;

class Product extends SbService
{

    public $name = 'product';
    public $json = array();

    public static $outputMap = array(
        "thankyouPageDescription", "thankyouPageHeadline", "thankyouPageImage", "thankyouPageUrl", "leadGenType",
        "postUrl", "redirectUrl", "formFields", "thumb", "medium", "large", "description",
        "assetStatus", "name", "creationTime", "modificationTime", "guid"
    );
    public static $inputMap = array(
        "apiKey","clientGuid", "params"=>array("ids"=>array()), "requestObject"=>array()
    );

    public function __construct($action, $object, $params = null)
    {
        $this->mapToSb($action. $object, $params);
        parent::__construct(strtolower($action), strtolower($object), $params);
        $this->json = $this->mapFromSb($this);
    }

    protected function mapFromSb(SbService $Object)
    {
        try {
            while(list($k,$v) = each($Object->raw[$Object->name])) {
                $var = array_pop($v['itemVariants']);
                foreach($var as $key=>$val) {
                    if (is_array($val) && array_key_exists('url',$val)) {
                        $this->json[$k][$key] = $val['url'];
                        unset($var[$key]);
                    }
                }
                foreach($v as $key=>$val) {
                    if (in_array($key, self::$outputMap)) {
                        $this->json[$k][$key] = $val;
                    }
                }
            }
            return $this->json;
        }
        catch(Exception $e) {
            error_log($e->getMessage());
        }
    }
}