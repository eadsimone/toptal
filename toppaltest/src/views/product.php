
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

$templates = array();
?>

</div>



<script>

    // Deferred objects (deferreds). Ignore for now.
    deferreds = [];

    $(function() {

        //New
        C.ssm.loadPartial.helper( { url: 'getProduct.php', template: 'product/edit.html', elementId: 'edit' } );
        C.ssm.loadPartial.helper( { url: 'getVideo.php', template: 'video/edit.html', elementId:' edit' } );
    });

    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>
