<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joan
 * Date: 1/03/13
 * Time: 11:56
 * To change this template use File | Settings | File Templates.
 */

require_once 'handleSbCalls.php';

if( isset($_GET['players']) && isset($_GET['from'])  && isset($_GET['to']) ) {
    $sbHandler = new HandleSbCalls();
    $data = $sbHandler->getAttractStats($_GET['from'], $_GET['to']);
    echo $data;
} else {
    echo json_encode(
        Array(
            'ok' => 'success'
        )
    );
}
