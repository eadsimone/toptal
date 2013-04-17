<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 09/04/13
 * Time: 16:01
 * To change this template use File | Settings | File Templates.
 */

Class SSMLogger {

    public function __construct()
    {
    }

    public static function log($data)
    {
        if(getenv('SSM_LOGGER') !== FALSE && getenv('SSM_LOGGER') == 'on') {

            $file = join(DIRECTORY_SEPARATOR, Array(__DIR__, 'logs', 'ssm_log_'.date('Y-m-d').'.txt'));

            $print = "\r\n";
            $print .= "\r\n";
            $print .= "------------------------------------- \r\n";
            $print .= "Log -START- ". date('Y-m-d H:i:s') .": \r\n";
            $print .= "------------------------------------- \r\n";
            $print .= "\r\n";
            $print .= print_r($data, TRUE)."\r\n";
            $print .= "\r\n";
            $print .= "------------------------------------- \r\n";
            $print .= "Log -END- ". date('Y-m-d H:i:s') .": \r\n";
            $print .= "------------------------------------- \r\n";

            try {
//            if(is_writable($file)){
                $status = file_put_contents($file, $print, FILE_APPEND | LOCK_EX);
//            }
            } catch (Exception $e) {

            }

        } else {
            return false;
        }

    }
}