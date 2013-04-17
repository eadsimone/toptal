<?php
/**
 * User: llasalla
 * Date: 1/25/13
 * Time: 3:06 PM
 */

namespace Fiji\SbService;

require_once('SbService.php');

use Fiji\SbService as SbService;

class Player extends SbService
{

    public $name = "player";
    public $json = array();
    protected $object;

    public static $outputMap = array(
        "description","locale","items","videos","embedCode",
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

}