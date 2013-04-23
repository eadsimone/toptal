
<div id="main"?>

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

function saveNewEvent() {

    var id = $( "#id" ),
        name = $( "#name" ),
        date = $( "#datepicker" ),
        priority = $( "#priority" ),
        status =$( "#status" ),
        description = $( "#description");


//    if(id==null){
        //var link='http://local.toppaltest.com/web/eventadd'
        var link='eventadd'
//    }else{
//        var link='http://local.toppaltest.com/web/eventupdate/'+id
//    }

    var peche= $.ajax({
        url:link,
        type: "POST",
        data:$("#saveNewPlayerForm").serialize(),
        success: function(responseText) {
            var data=responseText.responseObject;

            var edit='<a class="btn addevent_{{id}}" id="edit-event" onclick="editEvent(\''+data.id+'\');"  href="#"><i class="icon-pencil"></i>Edit</a>';
            var del='<a class="btn" id="'+data.id+'"  href="#" onclick="deleteEvent(\''+data.id+'\',\''+data.name+'\')"><i class="icon-remove"></i>Delete</a>';
//        <a class="btn addevent_{{id}}" id="edit-event" onclick="editEvent('{{id}}');"  href="#"><i class="icon-pencil"></i>Edit</a>
//        <a class="btn" id="{{id}}"  href="#" onclick="deletePlayer('{{id}}', '{{name}}')"><i class="icon-remove"></i>Delete</a>




            // if ( bValid ) {
            $( "#myTable tbody" ).append( "<tr>" +
                "<td>" + data.id + "</td>" +
                "<td>" + data.name + "</td>" +
                "<td>" + data.date + "</td>" +
                "<td>" + data.priority + "</td>" +
                "<td>" + data.status + "</td>" +
                "<td>" + data.description + "</td>" +
                "<td>" + edit + del + "</td>" +
                "</tr>" );


//
////            alert(responseText.responseCode);
        }


    })
.done(function(responseText){
            if(responseText.responseCode == 1000) {
//                $("form#saveNewPlayerForm")[0].reset();
//
//                noticeText=responseText.responseText;
//                setSuccessNotice(noticeText);
//
//                //window.location.href="players";
//                C.ssm.loadPartial.helper( {
//                    url: 'getPlayerList.php',
//                    template: 'players/index.html',
//                    elementId: 'home'
//                } );
//
//                $('.tab-nav-a[href="#home"]').trigger('click');
alert('event succesful');

            }else{
//                noticeText=responseText.responseText;
//                setErrorNotice(noticeText);
                alert('event can not created');
            }
        });
    console.log($(peche));
}

//function saveEvent(id) {
function saveEvent(id) {


   /* var id = $( "#id" ),
        name = $( "#name" ),
        date = $( "#datepicker" ),
        priority = $( "#priority" ),
        status =$( "#status" ),
        description = $( "#description");
        */

        var link='eventupdate/'+id


    var peche= $.ajax({
        url:link,
        type: "POST",
        data:$("#saveNewPlayerForm").serialize(),
        success: function(responseText) {
//            var data=responseText.responseObject;
//
//            var edit='<a class="btn addevent_{{id}}" id="edit-event" onclick="editEvent('+data.id+');"  href="#"><i class="icon-pencil"></i>Edit</a>';
//            var del='<a class="btn" id="'+id+'"  href="#" onclick="deletePlayer('+data.id+', '+data.name+')"><i class="icon-remove"></i>Delete</a>';
//
//            $('#'+id).parent().parent().remove();
//
//            // if ( bValid ) {
//            $( "#myTable tbody" ).append( "<tr>" +
//                "<td>" + data.id + "</td>" +
//                "<td>" + data.name + "</td>" +
//                "<td>" + data.date + "</td>" +
//                "<td>" + data.priority + "</td>" +
//                "<td>" + data.status + "</td>" +
//                "<td>" + data.description + "</td>" +
//                "<td>" + edit + del + "</td>" +
//                "</tr>" );
        }


    })
        .done(function(responseText){
            if(responseText.responseCode == 1000) {

                var data=responseText.responseObject;

                var edit='<a class="btn addevent_{{id}}" id="edit-event" onclick="editEvent(\''+data.id+'\');"  href="#"><i class="icon-pencil"></i>Edit</a>';
                var del='<a class="btn" id="'+id+'"  href="#" onclick="deleteEvent(\''+data.id+'\',\''+data.name+'\')"><i class="icon-remove"></i>Delete</a>';

                $('#'+id).parent().parent().remove();


                /*-----*/
//                var usersTable = $("#tablesorter");
//                usersTable.trigger("update")
////                        .trigger("sorton", [usersTable.get(0).config.sortList])
//                    .trigger("sorton",[[0,0]])
//                    .trigger("appendCache")
//                    .trigger("applyWidgets");

                /*----*/

                // if ( bValid ) {
                $( "#myTable tbody" ).append( "<tr>" +
                    "<td>" + data.id + "</td>" +
                    "<td>" + data.name + "</td>" +
                    "<td>" + data.date + "</td>" +
                    "<td>" + data.priority + "</td>" +
                    "<td>" + data.status + "</td>" +
                    "<td>" + data.description + "</td>" +
                    "<td>" + edit + del + "</td>" +
                    "</tr>" );


                var usersTable = $(".tablesorter");
                usersTable.trigger("update")
//                        .trigger("sorton", [usersTable.get(0).config.sortList])
                    .trigger("sorton",[[0,0]])
                    .trigger("appendCache")
                    .trigger("applyWidgets");



//                $("form#saveNewPlayerForm")[0].reset();
//
//                noticeText=responseText.responseText;
//                setSuccessNotice(noticeText);
//
//                //window.location.href="players";
//                C.ssm.loadPartial.helper( {
//                    url: 'getPlayerList.php',
//                    template: 'players/index.html',
//                    elementId: 'home'
//                } );
//
//                $('.tab-nav-a[href="#home"]').trigger('click');
                alert('Event update successful');
                $("#tablesorter").trigger("update")
                    .trigger("sorton",[[0,0]])
                    .trigger("appendCache")
                    .trigger("applyWidgets");

            }else{
//                noticeText=responseText.responseText;
//                setErrorNotice(noticeText);
                alert('Event can not saved');
            }
        });
    console.log($(peche));
}


function editEvent(id) {

    $("#dialog-form").dialog("open").data("opener",id);

    $( "#dialog-form" ).dialog( "open" );

    var link='event/'+id


    var peche=$.ajax({
        url:link,
//      data:$("#saveNewPlayerForm").serialize()
        success: function(responseText) {
            var data=responseText.responseObject;

//            $( "#name" ).val(data.id);
            $( "#name" ).val(data.name);
            $( "#datepicker" ).val(data.date);
            $( "#priority" ).val(data.priority);
            $( "#status" ).val(data.status);
            $( "#description" ).val(data.description);
//
////            alert(responseText.responseCode);
        },
        error: function(request, status, error) {
            alert(status);
        }


    }).done(function(responseText){
            if(responseText.responseCode == 1000) {

                var data=responseText.responseObject;

//            $( "#name" ).val(data.id);
                $( "#name" ).val(data.name);
                $( "#datepicker" ).val(data.date);
                $( "#priority" ).val(data.priority);
                $( "#status" ).val(data.status);
                $( "#description" ).val(data.description);

                //noticeText=responseText.responseText;
                //setSuccessNotice(noticeText);

                //window.location.href="players";
//                C.ssm.loadPartial.helper( {
//                    url: 'getPlayerList.php',
//                    template: 'players/index.html',
//                    elementId: 'home'
//                } );

                $('.tab-nav-a[href="#home"]').trigger('click');


            }else{
                //noticeText=responseText.responseText;
                // setErrorNotice(noticeText);
            }
        });
    console.log($(peche));
}


function deleteEvent(id, Name) {
        var doDelete = confirm("Are you sure you want to delete '" + Name + "'?");
        if(doDelete == true) {

            //alert('you pressed OK to delete ' + playerGuid);

            $.ajax({
                url: 'deleteevent/' + id,
//                url: 'http://local.toppaltest.com/web/deleteevent/' + id,
                success: function(msg) {

//                        alert("hi");
                        $('#'+id).parent().parent().remove();




//                    $("#tablesorter").tablesorter({widthFixed: true}).tablesorterPager({container: $("#pager")});
//                    $("#tablesorter").trigger("update")

//                    var usersTable = $("#tablesorter");
//                    usersTable.trigger("update")
////                        .trigger("sorton", [usersTable.get(0).config.sortList])
//                          .trigger("sorton",[[0,0]])
//                        .trigger("appendCache")
//                        .trigger("applyWidgets");


                    var usersTable = $(".tablesorter");
                    usersTable.trigger("update")
//                        .trigger("sorton", [usersTable.get(0).config.sortList])
                        .trigger("sorton",[[0,0]])
                        .trigger("appendCache")
                        .trigger("applyWidgets");


                }
            } )


//                .done(function() { alert("success"); })
//                .fail(function() { alert("error"); })
//                .always(function() { alert("complete"); });
//                .done( function(status) {
//
////                        if(response.responseCode == 1000) {
//
//
//                            $("#myTable").on("click", "#delete", function() {
//                                alert('vino');
////                                $(this).closest("tr").remove();
//                            });
//
//                            var itemToDelete = $('#player_list_item_' + playerGuid);
//                            itemToDelete.fadeOut(300, function() {
//                                itemToDelete.remove();
//                            });
//
//                            noticeText=response.responseText;
//                            setSuccessNotice(noticeText);
//
//                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
//                            C.ssm.log( "Deleted player: " + playerGuid + ". Response:", response );
//
//                            // Redirect Page
//                            //window.location.href( 'account' );
//
////                        }else{
////                            noticeText=response.responseText;
////                            setErrorNotice(noticeText);
////                        }
//
//                    } );

        } else {
            //do nothing
        }
    }

</script>