
<div class="main-content">

    <?php

    echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));


    $tabs = array (
        array(
            "title" => __("Administrator List"),
            "slug" => "home",
            "active" => "active"
        )
    );

    echo $mustache->render('_common/tabs',array('tabs' => $tabs, 'hideSaveButton' => true));

    $templates = loadTemplateCache(
        '_common/inputClosedTag.html',
        '_common/inputWrappedTag.html',
        'administrators/addedit.html',
        'administrators/index.html'
//        'video/index.html',
//        'video/edit.html',
//        'video/add.html'
    );
    ?>

</div>

<?php require('_common/lightboxes.html'); ?>

<script>

    // Deferred objects (deferreds). Ignore for now.
    ds = [];

    $(function() {

        C.ssm.loadPartial.helper( {
            url: 'getAdminUserList.php',
            template: 'administrators/index.html',
            elementId: 'home'
        } );

        C.ssm.loadPartial.mustache( 'add', 'players/add.html', {
            playerName: C.ssm.loadPartial.formField( C.ssm.fields.playerName ),
            playerDesc: C.ssm.loadPartial.formField( C.ssm.fields.playerDesc ),
            btnAddMedia: C.ssm.loadPartial.formField( C.ssm.fields.btnAddMedia ),
            btnAddProducts: C.ssm.loadPartial.formField( C.ssm.fields.btnAddProducts )
        } );
        C.ssm.loadPartial.helper({ url: 'getVideoListNotInPlayer.php', 'template':'video/edit.html', 'elementId':'edit'});

    });




    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>
<script type="text/javascript">
    function saveNewPlayer() {
        //alert('saveNewPlayer');
        toyin = $.ajax({
            url:"../src/jsapiCalls/saveNewPlayer.php",
            data:$("form#saveNewPlayerForm").serialize()
        }).done(function(responseText){
                    if(responseText.responseCode == 1000) {
                        $("form#saveNewPlayerForm")[0].reset();

                        noticeText=responseText.responseText;
                        setSuccessNotice(noticeText);

                        //window.location.href="players";
                        C.ssm.loadPartial.helper( {
                            url: 'getPlayerList.php',
                            template: 'players/index.html',
                            elementId: 'home'
                        } );

                        $('.tab-nav-a[href="#home"]').trigger('click');


                    }else{
                        noticeText=responseText.responseText;
                        setErrorNotice(noticeText);
                    }
                });
        console.log($(toyin));
    }

    function deletePlayer(playerGuid, playerName) {
        var doDelete = confirm("Are you sure you want to delete '" + playerName + "'?");
        if(doDelete == true) {

            //alert('you pressed OK to delete ' + playerGuid);

            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/deletePlayer.php?pGuid=' + playerGuid
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            var itemToDelete = $('#player_list_item_' + playerGuid);
                            itemToDelete.fadeOut(300, function() {
                                itemToDelete.remove();
                            });

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Deleted player: " + playerGuid + ". Response:", response );

                            // Redirect Page
                            //window.location.href( 'account' );

                        }else{
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        } else {
            //do nothing
        }
    }
</script>
<script src="js/cinsay/add_player_validate.js"></script>