<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 10/04/13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */
require_once 'ssm_callsb.php';

class getReports Extends SSM_CallSB
{

    public function __construct()
    {
    }

    public function getReport()
    {
        $path = '/api/client/reports/get';
        return $this->call(
            $path,
            Array(
                'reportNames' => Array(
                    'refunded'
                ),
                'startDate' => '2012-07-05',
                'endDate'   => '2013-01-31',
            ),
            'reportFilter'
        );
    }


}

$reports = new getReports();

$data = $reports->getReport();

echo '<pre style="text-align: left">';
    if ( $data ) print_r( $data );
    else echo var_dump( $data );
echo '</pre><hr />';


/*
 *
$test = ServiceBusGetReports($_SESSION['SSMData']['clientGuid'], Array(
    'reportNames' => Array(
        'refunded'
    ),
    'startDate' => '2012-07-05',
    'endDate'   => '2013-01-31',
));
 */