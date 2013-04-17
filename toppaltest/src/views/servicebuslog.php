<?php

//include '../functions.php';
$loginError = "";
/*if(isset( $_SESSION['SSMData']['error'])) {
	$loginError =  $_SESSION['SSMData']['error'];
	unset( $_SESSION['SSMData']['error']);
}*/

if(isset($_SESSION['SSMServiceBusLog'])) {
    $loginError=$_SESSION['SSMServiceBusLog'];
    //echo "Servicebus Log<br><pre>" . print_r($_SESSION['SSMServiceBusLog'], true) . "</pre>";
} else {
    $loginError="No logs available";
}

//echo $mustache->render('home/servicebuslog',array('pageInfo' => $page, 'error' => $loginError));

//print_r($page);
// print_r($loginError);

/*should be the servicebuslog*/
?>
    <script type="text/javascript">
    function customtoggle2(showHideDiv, switchTextDiv) {
        var ele = document.getElementById(showHideDiv);
        var text = document.getElementById(switchTextDiv);
        if(ele.style.display == "block") {
            ele.style.display = "none";
            text.innerHTML = " (+)";
        }
        else {
            ele.style.display = "block";
            text.innerHTML = " (-)";
        }
    }

</script>
<div class="ssm-log-box">
    <h3 class="header header-full"><?php echo $page['title'];?></h3>
    <div class="">

        <div class="sub-nav-wrapper">
            <div class="sbl-nav second-level-fixed">
                <ul class="nav nav-tabs nose tab clearfix">
                    <li class=""><a data-toggle="tab" id="accountinformation-tab" href="#accountinformation" class="tab-nav-a width">Timestamp</a></li>
                    <li class=""><a data-toggle="tab" id="billinginformation-tab" href="#billinginformation" class="tab-nav-a width">Path</a></li>
                    <li class=""><a data-toggle="tab" id="merchantaccountinformation-tab" href="#merchantaccountinformation" class="tab-nav-a width">Encrypted</a></li>
                    <li class=""><a data-toggle="tab" id="aboutus-tab" href="#aboutus" class="tab-nav-a width">Cached</a></li>
                </ul>
            </div>
        </div>
    </div>


    <?php
    if(is_array($loginError)){
    foreach($loginError as $key=>$value) {
    ?>
        <div class="">
        <div class="">
            <ul class="nav nav-tabs">
                <li class="width"><a  href="#" class="tab-nav-a"><?php echo $value['timestamp'];?></a></li>
                <li class="width"><a  href="#" class="tab-nav-a"><?php echo $value['path'];?></a></li>
                <li class="width"><a  href="#" class="tab-nav-a"><?php echo $value['encrypted'];?></a></li>
                <li class="width">
                        <p>Request<a data-toggle="tab" id="arequest<?php echo $key;?>" onclick="customtoggle2('request<?php echo $key;?>','arequest<?php echo $key;?>');" href="#" class="tab-nav-a"> (+)</a></p>
                        <p>Response<a data-toggle="tab" id="aresponse<?php echo $key;?>" onclick="customtoggle2('response<?php echo $key;?>','aresponse<?php echo $key;?>');" href="#" class="tab-nav-a"> (+)</a></p>


                </li>
            </ul>
        </div>
    </div>
    <div class="">
        <div id="request<?php echo $key;?>" class="reponse"  style="display: none"><?php echo "<pre>" . prettyJSON($value['request'],true) ."</pre>"; ?></div>
        <div id="response<?php echo $key;?>"class="request" style="display: none"><?php echo "<pre>" . prettyJSON($value['response'],true) ."</pre>";?></div>
    </div>

    <?php
    }
    }else{
    echo $loginError;

    }
    ?>



</div>





