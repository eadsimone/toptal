<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 22/03/13
 * Time: 11:43
 * To change this template use File | Settings | File Templates.
 */


function percent($num_amount, $num_total) {
    $count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count = number_format($count2, 0);
    return $count;
}

function return_new_json_plan_usage($json){

    $resp_obj=$json['responseObject']['clientPlan']['clientPlanItems'];

    foreach( $resp_obj as $key => $value ){
        $name = $value['name'];

        $used = $value['clientPlanItemUsage']['currentUsage'];

        $total= $value['planItem']['itemLimit'];
        $division= percent($used,$total);
        if($total == "-1") {
        	$total = __("unlimited");
        }
        
        $plans[strtolower($name)]=array(
            "total"=>$total,
            "used"=> round($used, 2),
            "percent"=>$division
        );

    }


    $new_data = array("planUsage" => $plans, "price" => $json['responseObject']['clientPlan']['price']);

    return json_encode($new_data);
}

function canAddMorePlayers($planUsage)
{
    if ( $planUsage['planUsage']['player']['used'] < $planUsage['planUsage']['player']['total']) {
        return TRUE;
    } else {
        return FALSE;
    }

}