<div class="main-content">

    <?php
    echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

    // Test json string
    $user_info = json_decode(getAdminUser());
    //print_r($user_info);


    //echo $mustache->render('account/userinfo', array());

    ?>

</div>