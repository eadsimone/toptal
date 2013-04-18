<body>
<div id="main">

<?php

    if(isset($id)){
    $event = $db->todolist()->where("id", $id);

    if ($data = $event->fetch()) {
        $json=array(
            "id" => $data["id"],
            "name" => $data["name"],
            "date" => $data["date"],
            "priority" => $data["priority"],
            "status" => $data["status"],
            "description" => $data["description"]
        );
    }
    }else{$json=array(
        "id" => "",
        "name" => "",
        "date" => "",
        "priority" => "",
        "status" => "",
        "description" => ""
    );}

//    $json='[{"id":"1","name":"evento1","date":"2013-04-13","priority":"1","status":"progress","description":"mi primer evento"},
//    {"id":"2","name":"evento2","date":"2013-04-13","priority":"2","status":null,"description":"segundo evento"}]';
//    $res=json_decode($json, true);

    $aux=array('allPlayers' => $json);

    echo $mustache->render('players/add',$aux);
?>

<script type="text/javascript">
    function saveNewPlayer(id) {
        //alert('saveNewPlayer');
        if(id==null){
            var link='http://local.toppaltest.com/web/eventadd'
            }else{
            var link='http://local.toppaltest.com/web/eventupdate/'+id
        }

        $.ajax({
            url:link,
            type: "post",
            data:$("#saveNewPlayerForm").serialize()
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
            $.ajax({
                url: 'http://local.toppaltest.com/web/deleteevent/' + playerGuid
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