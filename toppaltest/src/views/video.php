
<div class="main-content">

<?php

echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

$tabs = array (
    array(
        "title" => __("Home"),
        "slug" => "home",
        "active" => "active"
        )
    );

echo $mustache->render('_common/tabs',array('tabs' => $tabs));

$templates = array(loadTemplateCache(
    '_common/inputClosedTag.html',
    '_common/inputWrappedTag.html',
    'video/add.html',
    'video/edit.html',
    'player/index.html',
    'players/index.html'
));
?>

</div>

<script>

    // Deferred objects (deferreds). Ignore for now.
    deferreds = [];

    (function($,C) {
        C.ssm.loadPartial.helper( { url: 'getVideo.php', template: 'video/edit.html', elementId: 'edit' } );
        //C.ssm.loadPartial.helper( { url: 'addVideo.php', template: 'video.add.html', elementId: 'add' } );

    })($,C);
    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>