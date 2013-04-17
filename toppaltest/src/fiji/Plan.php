<?php
/**
 * User: llasalla
 * Date: 1/30/13
 * Time: 12:27 PM
 */

namespace Fiji\SbService;

require_once('SbService.php');

use Fiji\SbService as SbService;

class Plan extends SbService
{

    public $name = "plan";
    public $json = array();

    public static $outputMap = array(
        "description","locale","items","videos","embedCode",
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

}