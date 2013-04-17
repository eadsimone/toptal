<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 12/04/13
 * Time: 13:07
 * To change this template use File | Settings | File Templates.
 */

require_once '../functions.php';
if(isset($_GET['search']) && $_GET['search'] == TRUE) {
    if(
        (isset($_POST['date-from']) && trim($_POST['date-from']) != '') &&
        (isset($_POST['date-to']) && trim($_POST['date-to']) != '') &&
        (isset($_POST['reportName']) && trim($_POST['reportName']) != '')
    ) {
        $clientGuid = $_SESSION['SSMData']['clientGuid'];
        $options = Array(
            'reportNames' => Array(
                $_POST['reportName']
            ),
            'startDate' => $_POST['date-from'],
            'endDate'   => $_POST['date-to']
        );

        $response =  ServiceBusGetReports($clientGuid, $options);

        echo '<pre style="text-align: left">';
        if ( $response ) print_r( $response );
        else echo var_dump( $response );
        echo '</pre><hr />';
    }
} else {
    echo json_encode(
        Array(
            'ok' => 'Every is ok'
        )
    );
}
