
<div id="main">

<?php



    $json='[{"id":"1","name":"evento1","date":"2013-04-13","priority":"1","status":"progress","description":"mi primer evento"},
    {"id":"2","name":"evento2","date":"2013-04-13","priority":"2","status":null,"description":"segundo evento"}]';
    $res=json_decode($json, true);

    $events = array();
    foreach ($db->todolist() as $event) {
        $events[]  = array(
            "id" => $event["id"],
            "name" => $event["name"],
            "date" => $event["date"],
            "priority" => $event["priority"],
            "status" => $event["status"],
            "description" => $event["description"]
        );
    }

   // echo json_encode($events);

    $aux=array('allPlayers' => $events);


    echo $mustache->render('players/index',$aux);
?>

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

    function deletePlayer(id, Name) {
        var doDelete = confirm("Are you sure you want to delete '" + Name + "'?");
        if(doDelete == true) {

            //alert('you pressed OK to delete ' + playerGuid);

            $.ajax({
                url: 'http://local.toppaltest.com/web/deleteevent/' + id
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