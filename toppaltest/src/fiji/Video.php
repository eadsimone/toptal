<?php
/**
 * User: llasalla
 * Date: 1/25/13
 * Time: 3:06 PM
 */

namespace Fiji\SbService;
require_once('SbService.php');
use Fiji\SbService as SbService;

class Video extends SbService
{

    public $name = 'video';
    public $json = array();
    public $object;

    public static $outputMap = array(
        "posterImage","thumbImage","original","standardDefinition","hiDefinition","mobile",
        "assetStatus", "name", "creationTime", "modificationTime", "guid"
    );
    public static $inputMap = array(
        "apiKey","clientGuid", "params"=>array("ids"=>array()), "requestObject"=>array()
    );

    public function __construct($action, $object, $params = null)
    {
        if ($object == null) {
            $object = $this->name;
        }
        $this->mapToSb($action, $object, $params);
        parent::__construct(strtolower($action), strtolower($object), $params);
        $this->json = $this->mapFromSb($this);
    }

}