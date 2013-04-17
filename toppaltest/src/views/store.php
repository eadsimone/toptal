<div class="main-content">

    <?php

    echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));

    $tabs = array (
        array(
            "title" => __("About Us"),
            "slug" => "aboutus",
            "active" => "active"
        ),
        array(
            "title" => __("Email"),
            "slug"  => "emailSettings"
        ),
        array(
            "title" => __("Shipping"),
            "slug"  => "shipping"
        ),
        array(
            "title" => __("Taxes"),
            "slug"  => "taxes"
        )
    );

    echo $mustache->render('_common/tabs',array('tabs' => $tabs,'hideSaveButton' => true));

    $templates = loadTemplateCache(
        '_common/inputClosedTag.html',
        '_common/inputWrappedTag.html',
        'store/aboutus.html',
        'store/email.html',
        'store/shipping.html',
        'store/taxes.html'
    );

    ?>

</div>
<?php require('_common/lightboxes.html'); ?>

<script>
    // Deferred objects (deferreds). Ignore for now.
    ds = [];

    $(function() {

        ds.push(
                // Don't mind me ;)

                C.ssm.loadPartial.helper( {
                    url: 'getStore.php',
                    template: 'store/aboutus.html',
                    elementId: 'aboutus'
                } ),
                C.ssm.loadPartial.helper( {
                    url: 'getEmailSettings.php',
                    template: 'store/email.html',
                    elementId: 'emailSettings'
                } ),

                C.ssm.loadPartial.helper( {
                    url: 'getShipping.php',
                    template: 'store/shipping.html',
                    elementId: 'shipping'
                }),
                C.ssm.loadPartial.helper( {
                    url: 'getTaxes.php',
                    template: 'store/taxes.html',
                    elementId: 'taxes'
                } )

        );

        $.when.apply( this, ds ).then(

                // ALL completed successfully. Do this stuff
                function() {

                    $(function(){
                        if($('#shippingRule').val() == 'freeshipping') {
                            $('#shippingRate').parents('.control-group').fadeOut('fast');
                        }

                        $('#shippingRule').on('change', function(){
                            if($(this).val() == 'freeshipping') {
                                $('#shippingRate').parents('.control-group').fadeOut('fast');
                            } else {
                                $('#shippingRate').parents('.control-group').fadeIn('fast');
                            }
                        });

                    });

                });

    });

    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );

</script>
<script type="text/javascript">
    var saveButtons = {

        aboutus: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveStore.php',
                data: $("#aboutus_form").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

       },
        email: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveStore.php',
                data: $("#orderEmailForm").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        },
        shipping: function() {
            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/saveStore.php',
                data: $("#shipping_form").serialize()
            } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Email successfully shared. Response:", response );

                            $("#publish_email").val("");
                            $("#publish_message").val("");

                            // Redirect Page
                            //window.location.href( 'account' );




                        } else {
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }

                    } );

        }

    };

    /*$("button.btn-success").on("click", function(event) {

        var $this = $(this),
                thisText = $this.html(),
                newText = 'Saving...';

        $this.addClass('disabled').html(newText);

        var _form = $('form:visible');
        var _action = $.trim(_form.attr('action'));
        var _urlForm = (typeof (_action) == 'undefined'  || _action == '') ? '#' : _action;

        $.ajax({
            url: _urlForm,
            data:_form.serialize()
        }).done(function(responseText){
                    $this.removeClass('disabled').html(thisText);

                    if(responseText.responseCode == '2000') {
                        setSuccessNotice(responseText.responseText)
                    } else {
                        setErrorNotice(responseText.responseText);
                    }
                });

    });*/
    $("button.btn-success").on("click", function(event) {

        var $this = $(this),
                thisText = $this.html(),
                newText = 'Saving...';

        $this.addClass('disabled').html(newText);

        $.ajax({
            url:"../src/jsapiCalls/saveStore.php",
            data:$("form").serialize()
        })
                .done(function(responseText){
                    $this.removeClass('disabled').html(thisText);

                    if(responseText.responseCode == '2000') {
                        setSuccessNotice(responseText.responseText)
                    } else {
                        setErrorNotice(responseText.responseText);
                    }

                    console.log(responseText);
                });
    });


    function orderEmailAddRow() {
        var lastRow = $('.order-email-item').last();
        var newRow = lastRow.clone();
        newRow.find(':text').val('');
        /*--*/
        if(!$("#orderEmailForm").valid()){
            return false;
        }
        var str=newRow.find(':text').attr('id');
        var n=str.split("orderEmails");
        var num=parseInt(n[1])+1;
        var name='orderEmails['+num+']';
        var nameid='orderEmails'+num;
        newRow.find(':text').attr( "name", name );
        newRow.find(':text').attr( "id", nameid );
        /*---*/
        newRow.appendTo('#order-email-settings-grid');
    }

    function orderEmailRemoveRow(elem) {
        var rowCount = $(elem).parents('tr').siblings().length;
        if(rowCount == 0) {
            pwoAddRow();
        }
        $(elem).parents('tr').remove();
    }

</script>
<script src="js/cinsay/aboutus_validate.js"></script>
<script src="js/cinsay/shipping_validate.js"></script>
<script src="js/cinsay/store_email_validate.js"></script>
<script src="js/cinsay/upload.js"></script>

