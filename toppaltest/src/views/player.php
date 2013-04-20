
<div class="main-content clearfix">
<script type="text/javascript">
    window.clientGuid = "<?php echo  $_SESSION['SSMData']['clientGuid']; ?>" || false;
    C.ssm.settings.debug = false;
</script>
<?php 
echo $mustache->render('_common/breadcrumb',array('pageInfo' => $page));
?>

	<div class="content-left">
    <div class="ssm-content-slide-wrapper">
        <ul class="unstyled ssm-content-slide">
            <li>
                <div class="ssm-content-slide-left">

<?php
$tabs = array (
				array(
						"title" => __("General"),
						"slug" => "index", 
						"active" => "active"
						),
				array(
						"title" => __("Media"), 
						"slug"  => "media"
						),
				array(
						"title" => __("Products"), 
						"slug"  => "products"
						),
				array(
						"title" => __("Publish"), 
						"slug"  => "publish"
						),
				array(
						"title" => __("Advanced"), 
						"slug"  => "advanced"
						)
				);


echo $mustache->render('_common/tabs',array('tabs' => $tabs, 'hideSaveButton' => true));

$templates = loadTemplateCache(
        '_common/inputClosedTag.html',
        '_common/inputWrappedTag.html',
        'product/index.html',
        'product/add.html',
        'product/edit.html',
        'product/pwo.html',
		'product/item-library.html',
		'product/item-sidebar.html',
		'video/add.html',
        'video/edit.html',
        'video/index.html',
		'video/item-library.html',
		'video/item-sidebar.html',
		'player/index.html',
        'player/publish.html',
        'player/products.html',
		'player/media.html',
        'player/advanced.html',
		'player/summary.html'
);
?>
                </div>
            </li>
            <li>
                <div class="ssm-content-slide-right" style="display:none;">
                    <div id="sliding-content"></div>
                </div>
            </li>
        </ul>
    </div>
    </div>
    <!-- start realtime edit sidebar -->
    <div class="content-right" id="player-summary">

<?php //echo $mustache->render('player/summary',array('tabs' => $tabs)); ?>
    
    </div>
	<!-- end realtime edit sidebar -->
	
</div>

<?php require('_common/lightboxes.html'); ?>


<script>

    (function(window, $){
        var donationProducts = {

            addAmount: function(){

                var trToAdd = (function(){
                    return html =
                        '<tr class="amount_item">' +
                            '<td>' +
                                '<input type="text" value="" name="donationAmonuts[]">'+
                            '</td>'+
                            '<td>' +
                                '<a href="#list-amounts" class="action-amount remove-amount">Remove</a>'+
                            '</td>'+
                        '</tr>';
                })();

                $($('.amount_item').last()).after(trToAdd);

            },

            removeAmount: function(el) {
                $(el).parents('tr').remove();
            }
        };

        $(function(){

            $('#body').on('click', '.action-amount', function(ev) {
                if( $(this).hasClass('add-amount') ) {
                    donationProducts.addAmount();
                }else if( $(this).hasClass('remove-amount') ) {
                    donationProducts.removeAmount(this);
                }
            });

        });

        $(function(){
            $('#body').on('click', '#publish-tab', function(ev) {


                $.ajax({
                    url: '../src/jsapiCalls/getMarketplaceCategories.php',
                    dataType: 'html',
                    success: function(html) {
                        $('#mkplace').html(html);


                    }
                });
            });

        });


    })(window, jQuery);

    var saveButtons = {
        video: function(){

        },
        newVideo:function()
        {},

  /*      newVideo: function() {
            $('#saveNewVideoButton').on( 'click', function() {
                C.ssm.ajax.service( {
                    url: '../src/jsapiCalls/saveNewVideo.php',
                    data: $("#saveNewVideoForm").serialize()
                } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "New video saved. Response:", response );
                            setSuccessNotice(noticeText);
                            // Redirect Page
                            window.location.href = 'player_<?php echo $playerGuid; ?>';

                        }else{
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }*/
                        /*validate for message*/


/*
                    } );
            } );
       },
*/
     /*  video: function() {
            $( '#saveVideoButton' ).on( { click: function() {
                C.ssm.ajax.service( {
                    url: '../src/jsapiCalls/saveVideo.php',
                    data: $("#saveVideoForm").serialize()
                } )
                    .done( function( response ) {

                        if(response.responseCode == 1000) {

                            noticeText=response.responseText;
                            setSuccessNotice(noticeText);

                            // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                            C.ssm.log( "Video saved. Response:", response );
                            setSuccessNotice(noticeText);

                            window.response = response;
                            // Redirect Page

                            window.location.href = 'player_<?php echo $playerGuid; ?>';


                        }else{
                            noticeText=response.responseText;
                            setErrorNotice(noticeText);
                        }
                        /*validate for message*/

          /*          } );
            } } );
        },
*/
        saveProduct: function() {

            $( '#body' ).on( { click: function() {
                C.ssm.ajax.service( {
                    url: '../src/jsapiCalls/saveProduct.php',
                    data: $("#saveProductForm").serialize().length == 0 ? $("#saveNewProductForm").serialize() : $("#saveProductForm").serialize()
                } )
                        .done( function( response ) {
                            if(response.responseCode == 1000) {
                                noticeText=response.responseText;
                                setSuccessNotice(noticeText);
                                //window.location.href = 'player_<?php echo $playerGuid; ?>';

                            }else{
                                noticeText=response.responseText;
                                setErrorNotice(noticeText);
                            }
                        } );
            }}, '#saveProductButton, #saveNewProductButton');

        },

        player: function() {
            $( '#player-summary' ).on( 'click', '#savePlayerButton', function() {

                var $this = $(this),
                    thisText = $this.html(),
                    newText = 'Saving...';

                $this.addClass('disabled').html(newText);

                C.ssm.ajax.service( {
                    url: '../src/jsapiCalls/savePlayer.php?pGuid=<?php echo $playerGuid; ?>',
                    data: $("form").serialize()
                } )
                        .done( function( response ) {

                            $this.removeClass('disabled').html(thisText);

                            if(response.responseCode == 1000) {
                                noticeText=response.responseText;
                                setSuccessNotice(noticeText);

                                // re-mustache player summary on save
                                C.ssm.loadPartial.helper( {
                                    url: 'getPlayer.php?pGuid=<?php echo $playerGuid; ?>',
                                    template: 'player/summary.html',
                                    elementId: 'player-summary'
                                }).done(function() {
                                    setPlayerSummaryHeight('.player-summary','.content-left');
                                });

                                $('.breadcrumb-wrapper li[class=active] a').html($('#player_name').val())

                            }else{
                                noticeText=response.responseText;
                                setErrorNotice(noticeText);
                            }

                        } );
            } );
        },

        shareEmail: function() {

                C.ssm.ajax.service( {
                    url: '../src/jsapiCalls/shareEmail.php?pGuid=<?php echo $playerGuid; ?>',
                    data: $("#shareEmailForm").serialize()
                } )
                        .done( function( response ) {

                            if(response.responseCode == 1000) {

                                noticeText="Email successfully shared.";

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

    $(function() {

        // Deferred objects
        deferreds = [

            // general tab
            C.ssm.loadPartial.helper( {
                url: 'getPlayer.php?pGuid=<?php echo $playerGuid; ?>',
                template: 'player/index.html',
                elementId: 'index'
            } ),
            // publish tab
            C.ssm.loadPartial.helper( {
                url: 'getSocialMediaList.php?pGuid=<?php echo $playerGuid; ?>',
                template: 'player/publish.html',
                elementId: 'publish'
            } ),

            // advanced tab
            C.ssm.loadPartial.helper( {
                url: 'getPlayer.php?pGuid=<?php echo $playerGuid; ?>',
                template: 'player/advanced.html',
                elementId: 'advanced'
            } ),

            // New version
            C.ssm.loadPartial.helper( {
                url: 'getProductListNotInPlayer.php?pGuid=<?php echo $playerGuid; ?>',
                template: 'player/products.html',
                elementId: 'products'
            } ),

            C.ssm.loadPartial.helper( {

                // IT'S HERE
                url: 'getVideoListNotInPlayer.php?pGuid=<?php echo $playerGuid; ?>',/*change to see waht is wrong o playernotlistplayer*/
                template: 'player/media.html',
                elementId: 'media'
            } ),

            // summary sidebar
            C.ssm.loadPartial.helper( {
                url: 'getPlayer.php?pGuid=<?php echo $playerGuid; ?>',
                template: 'player/summary.html',
                elementId: 'player-summary'
            } )


        ];

        $.when.call(this, deferreds[0]).then(function() {
            var html = $('.first-level-fixed .active a').html().replace('Loading Player...', $.trim($('#player_name').val()) );
            $('.first-level-fixed .active a').html( html );
        });

        $.when.apply( this, deferreds ).then(
            // ALL completed successfully. Do this stuff
            function() {

                // init popover (tooltips on steroids) for anything with class
                $('.help').popover();

                // this stuff sets the height of the player summary page
                setPlayerSummaryHeight('.player-summary','.content-left');

                $(window).resize(function() {
                    setPlayerSummaryHeight('.player-summary','.content-left');
                });

                // this takes care of the swiping panes on product and media edit/add
                $('.ssm-content-slide').slidePane({
                    slideSpeed: 200,
                    openBtnClass: 'open-pane',
                    closeBtnClass: 'close-pane',
                    leftContent: '.ssm-content-slide-left',
                    rightContent: '.ssm-content-slide-right'
                });

                // product tab UI show/hide proper fields
                $('.ssm-content-slide-wrapper').on('change', '#productType', function(){
                    $("#" + this.value).fadeIn().siblings().hide();
                });

                // hides shows fields for host and post lead gen
                $('.ssm-content-slide-wrapper').on('change', '#deliveryMethod', function(){
                    if ( $(this).val() == "hostpost" || "hostposttwo"  ) {
                        $("#host-and-post-fields").fadeIn();
                    }
                    if ( $(this).val() == "standard"  ) {
                        $("#host-and-post-fields").hide();
                    }
                });

                // product with options fields change
                $('.ssm-content-slide-wrapper').on('change', '#options', function(){
                    $("#" + this.value).fadeIn().siblings().hide();
                    if ( $(this).val() == "option-size" || "option-color"  ) {
                        $("#option-notification").fadeIn();
                    }
                    if ( $(this).val() == "option-none"  ) {
                        $("#option-notification").hide();
                    }
                });

                // Select embed code when clicked on
                $('#embed_code').focus(function() {
                    var $this = $(this);

                    $this.select();

                    window.setTimeout(function() {
                        $this.select();
                    }, 1);

                    // Work around WebKit's little problem
                    $this.mouseup(function() {
                        // Prevent further mouseup intervention
                        $this.unbind('mouseup');
                        return false;
                    });
                });



                // add switch styles to checkboxes on advanced tab

                switchCheckbox = function(o) {

                    $(o.checkboxClass).each(function() {

                        var $this = $(this);

                        $this.before(
                                '<span class="checkbox-switch">' +
                                    '<span class="checkbox-switch-background" />' +
                                    '<span class="checkbox-switch-mask" />' +
                                '</span>'
                        );

                        $this.hide();

                        if( !$this[0].checked ) {
                            $this.prev().find(o.backgroundClass).css({left: '-56px'});
                        }

                    });

                    $(o.switchClass).on('click', function() {

                        var $this = $(this);

                        if ( $this.next()[0].checked ) {
                            $this.find(o.backgroundClass).animate({left:'-56px'}, 200);
                        }
                        else{
                            $this.find(o.backgroundClass).animate({left: '0px'}, 200);
                        }

                        $this.next()[0].checked = !$this.next()[0].checked;

                    });

                }

                switchCheckbox({
                    checkboxClass: '.switch-style-checkbox',
                    switchClass: '.checkbox-switch',
                    backgroundClass: '.checkbox-switch-background'
                });



                $('.ssm-content-slide-wrapper').on('click','.pop-video-preview', function() {


                    var $this = $(this),
                        thisData = $this.data(),
                        $vidPreview = $('#video-preview');

                    $vidPreview.show();

                    $vidPreview.append('<div id="video-preview-div" />');

                    jwplayer('video-preview-div').setup({
                        flashplayer: '/web/swf/jwplayer.flash.swf',
                        file: thisData.videourl,
                        width: '700',
                        height: '394',
                        primary: 'flash',
                        image: thisData.imageurl
                    });

                    $('.ssm-content-slide-wrapper').on('click','.close-video-preview', function() {
                        $('#video-preview-div_wrapper').remove();
                        $('#video-preview').hide();
                    });

                });

                saveButtons.player();
                saveButtons.saveProduct();

            },

            // One or more failed.
            function() {
                C.ssm.error( "UH OH!!!! Something bombed.  Not setting player Summary Height :-(" );
            }
        );

    });

    //Pre-load mustache templates
    C.ssm.mustache.addTemplates( <?php echo $templates; ?> );


    //code for doing addThis for social network buttons
    
    function socialShare(socialSystem) {
        //alert(socialSystem);
        addThisShare(socialSystem, '<?php echo $playerGuid; ?>', '<?php echo $_SERVER['BASE_URL']; ?>');
    }

    function deleteEntity(type, guid, name) {
    	var doDelete = confirm("Are you sure you want to delete '" + name + "' " + type.toLowerCase() + "? Doing so permanently deletes it from every player.");
    	if(doDelete == true) {
    		
    		//alert('you pressed OK to delete ' + type + ': ' + name + "|" + guid);

            C.ssm.ajax.service( {
                url: '../src/jsapiCalls/delete' + type + '.php?type=' + type + '&guid=' + guid
            } )
                .done( function( response ) {

                    if(response.responseCode == 1000) {

                		var itemToDelete = $('#' + guid);
                		itemToDelete.fadeOut(300, function() {
                			itemToDelete.remove();
                        });
                		
                    	noticeText=response.responseText;
                        setSuccessNotice(noticeText);

                        // Log successful response to console (wrapper handles/logs failures). Todo: Remove this.
                        //alert( "Deleted " + type + ": " + guid + ". Response:", response );

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
<script src="js/cinsay/player_validate.js"></script>
<script src="js/cinsay/upload.js"></script>
<script src="js/cinsay/publish.js"></script>
<script src="js/cinsay/productWithOptions.js"></script>
<script src="js/cinsay/advanced_validate.js"></script>
<script type="text/javascript" src="js/cinsay/product_add_validate.js"></script>

