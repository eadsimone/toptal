<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 18/03/13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
require_once 'ssm_callsb.php';

class ShippingTaxesApiCalls Extends SSM_CallSB
{
    private $_sbCall = null;

    public function __construct()
    {
        parent::__construct();
    }


    public function getShippingMethods()
    {
        return $call = $this->call(
            '/api/client/shipping/cinsayShippingGetShippingMethods',
            Array('storeID' => 2, 'code' => 'all')
        );
    }

    public function setShippingMethods()
    {
        return $call = $this->call(
            '/api/client/shipping/cinsayShippingSetShippingMethods',
            Array(
                'type' => 'flatrate_item_percent',
                'rate' => '5'
            )
        );
    }

    public function getTaxesMetadata()
    {
        return $call = $this->call(
            '/api/client/taxes/cinsayTaxGetTaxMetadata',
            Array('jsonObject' => Array('infoRequired' => 'region'))
        );
    }

    public function setTaxRule()
    {
        return $call = $this->call(
            '/api/client/taxes/cinsayTaxCreateTaxRule',
            Array(
                'taxRuleOptions' => Array(
                    'code' => 'createdBy API PATRICIO TEST',
                    'taxCustomerClass' => Array(
                        2
                    ),
                    'taxProductClass' => Array(
                        2
                    ),
                    'taxRate' => Array(
                        5,6
                    ),
                    'priority' => 2,
                    'position'	=> 2
                )
            )
        );
    }

    public function getTaxRule()
    {
        return $call = $this->call(
            '/api/client/taxes/cinsayTaxGetTaxMetadata',
            Array('infoRequired' => 'taxrule')
        );
    }

}
$shipping = new ShippingTaxesApiCalls();
//$data = $shipping->getShippingMethods();
$data = $shipping->getTaxesMetadata();
echo '<pre style="text-align: left">';
    if ( $data ) print_r( $data );
    else echo var_dump( $data );
echo '</pre><hr />';
