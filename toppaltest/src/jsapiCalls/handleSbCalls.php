<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joan
 * Date: 1/03/13
 * Time: 14:39
 * To change this template use File | Settings | File Templates.
 */
require_once 'servicebus/ServiceBus/ServiceBus.php';
require_once 'servicebus/ServiceBus/HttpClient.php';

class HandleSbCalls
{

    private $_serviceBus;

    public function __construct()
    {
        $this->_serviceBus = new \ServiceBus\ServiceBus();
    }

    public function getSummaryStats($from, $to, $player = 'all')
    {
        $response = $this->_serviceBus->getAnalyticsData('summary', $player, $from, $to);
        return $response;
    }

    public function getAttractStats($from, $to, $player = 'all')
    {
        $response = $this->_serviceBus->getAnalyticsData('attract', $player, $from, $to);
        return $response;
    }

    public function getTransactStats($from, $to, $player = 'all')
    {
        $response = $this->_serviceBus->getAnalyticsData('transact', $player, $from, $to);
        return $response;
    }

    public function getInteractStats($from, $to, $player = 'all')
    {
        $response = $this->_serviceBus->getAnalyticsData('interact', $player, $from, $to);
        return $response;
    }

}
