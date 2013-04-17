<?php

Namespace Fiji;

class SbService {

    public $raw;  // unprocessed sb response data

    public function __construct($action, $object, $params)
    {
        $this->action = $action;
        $this->object = $object;

        $this->file = sprintf(__DIR__.'/../jsapiCalls/%s%s.json', ucwords($this->action), ucwords($this->name));
        $this->raw = json_decode($this->$action($this->file), true);
        //$this->json = $this->raw;
        // object class
    }

    public static function instance()
    {

    }

    protected function get($file)
    {
        // pretend to do a ReST request
        return @file_get_contents($file);
    }

    protected function set()
    {

    }

    protected function mapToSb()
    {
        return $this;
    }

    protected function mapFromSb(SbService $Object)
    {
        try {
            $obj = $Object->name;
            foreach($Object::$outputMap as $key) {

                if (isset($Object->raw[$obj][$key]) && !empty($Object->raw[$obj][$key])) {
                    if (is_array($Object->raw[$obj][$key]) || is_object($Object->raw[$obj][$key])) {
                        $Object->json[$key] = $Object->raw[$obj][$key];
                    } else {
                        $Object->json[$key] = $Object->raw[$obj][$key];
                    }
                }
            }
            return $Object->json;
        }
        catch(Exception $e) {
            error_log($e->getMessage());
        }
    }

}