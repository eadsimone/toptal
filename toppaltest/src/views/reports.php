<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 12/04/13
 * Time: 13:01
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="main-content">

<?php

    echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

    $tabs = Array (
        Array(
            "title" => __("Reports"),
            "slug" => "reports",
            "active" => "active"
        )
    );

    echo $mustache->render('_common/tabs',array('tabs' => $tabs,'stats' => true,'hideSaveButton' => true));

$templates = loadTemplateCache(
    '_common/inputClosedTag.html',
    '_common/inputWrappedTag.html',
    'reports/content.html'
);
?>

</div>
<?php require('_common/lightboxes.html'); ?>

<script>

// Deferred objects (deferreds). Ignore for now.
var ds = [];

$(function() {

    ds.push(

        C.ssm.loadPartial.helper( {
            url: 'getReports.php',
            template: 'reports/content.html',
            elementId: 'reports'
        })
    )

    $.when.apply( this, ds ).then(
        // ALL completed successfully. Do this stuff
        function() {
            $(function(){
                reports.listenSelect();
            });
        }
    );
});

//Pre-load mustache templates
C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>
<script type="text/javascript" src="js/cinsay/ssm_reports.js"></script>