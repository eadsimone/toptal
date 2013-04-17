//--------------------------------------------------------------------------
//    code for when you click the help button
//--------------------------------------------------------------------------
function relatedHelpPage() {

	var activeTab = "";
	var tabSelect = $('div.sub-nav ul.nav-tabs li.active a').attr("href");
	var pageName = "";
	var pageSelect = $('div.ssm-nav-bar ul.ssm-top-bar-nav.pull-left li a.active').attr("href");
	var helpUrl = "http://cinsayu.com/display/SUP/Online+Help";
	
	if(tabSelect != undefined) {
		activeTab = tabSelect.replace("#","");
	}
	if(pageSelect != undefined) {
		pageName = pageSelect;
	}
	
	//alert(pageName + "/" + activeTab);
	
	if(pageName == "players") {
		if(activeTab == "home") {
			helpUrl = "http://cinsayu.com/display/SUP/Creating+Smart+Stores";
		} else if(activeTab == "add") {
			//helpUrl = "";
		} else if(activeTab == "index") {
			helpUrl = "http://cinsayu.com/display/SUP/Part+1%2C+Create+Your+Player";
		} else if(activeTab == "media") {
			helpUrl = "http://cinsayu.com/display/SUP/Part+2%2C+Add+Media";
		} else if(activeTab == "products") {
			helpUrl = "http://cinsayu.com/display/SUP/Part+3%2C+Add+Products";
		} else if(activeTab == "publish") {
			helpUrl = "http://cinsayu.com/display/SUP/Part+4%2C+Launch+the+Smart+Store";
		} else if(activeTab == "advanced") {
			helpUrl = "http://cinsayu.com/display/SUP/Part+5%2C+Optional+Configurations";
		} else {
			helpUrl = "http://cinsayu.com/display/SUP/Creating+Smart+Stores";
		}
	} else if(pageName == "stats") {
		if(activeTab == "summary") {
			helpUrl = "http://cinsayu.com/display/SUP/Summary+Stats";
		} else if(activeTab == "attract") {
			helpUrl = "http://cinsayu.com/display/SUP/Attract+Stats";
		} else if(activeTab == "transact") {
			helpUrl = "http://cinsayu.com/display/SUP/Transact+Stats";
		} else if(activeTab == "interact") {
			helpUrl = "http://cinsayu.com/display/SUP/Interact+Stats";
		}
	} else if(pageName == "account") {
		if(activeTab == "accountinformation") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+Your+Account+Info";
		} else if(activeTab == "billinginformation") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+Your+Account+Payments";
		} else if(activeTab == "merchantaccountinformation") {
			helpUrl = "http://cinsayu.com/display/SUP/Setting+up+a+Merchant+Account";
		} else if(activeTab == "usage") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+and+Upgrading+Your+Plan";
		} else if(activeTab == "plans") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+and+Upgrading+Your+Plan";
		}
	} else if(pageName == "store") {
		if(activeTab == "aboutus") {
			helpUrl = "http://cinsayu.com/display/SUP/About+Us+Information";
		} else if(activeTab == "emailSettings") {
			helpUrl = "http://cinsayu.com/display/SUP/Email+Alerts";
		} else if(activeTab == "shipping") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+Shipping";
		} else if(activeTab == "taxes") {
			helpUrl = "http://cinsayu.com/display/SUP/Managing+Taxes";
		}
	}
	
	window.open(helpUrl);

}

function setNotice(noticeType, noticeText) {
	var alertDiv = $('#alert-wrapper div.alert');

    if(alertDiv.length == 0) {
        var alertDivHTML =
            '<div style="display:none" id="alert-wrapper">'+
                '<div class="alert">' +
                    '<button data-dismiss="alert" class="close" type="button">x</button>' +
                    '<span>ignore me. this is a test notice</span>' +
                '</div>'+
            '</div>';

        $( $('.inner-content')[0]).html(alertDivHTML);
        var alertDiv = $('#alert-wrapper div.alert');
    }
	if(alertDiv.hasClass('alert-success')) {
		alertDiv.removeClass('alert-success');
	}
	if(alertDiv.hasClass('alert-error')) {
		alertDiv.removeClass('alert-error');
	}
	$('#alert-wrapper span').text(noticeText);
	if((noticeType == "success") || (noticeType == "error")) {
		alertDiv.addClass('alert-' + noticeType);
	}
	$('#alert-wrapper').show().fadeTo(3000,1).fadeOut();
}

function setSuccessNotice(noticeText) {
	setNotice('success', noticeText);
}

function setErrorNotice(noticeText) {
	setNotice('error', noticeText);
}






//--------------------------------------------------------------------------

// Set the player summary height ( window height minus the offset of the summary div )
// function run only on player page
setPlayerSummaryHeight = function(summaryId, pageId) {

    var $playerSummary = $(summaryId),
        $page = $(pageId),
        offset = $playerSummary.offset(),
        windowHeight = $(window).height(),
        windowScroll = $(window).scrollTop();

    $playerSummary.css({
        height: windowHeight - (offset.top - windowScroll)
    });

    $page.css({
        minHeight: windowHeight - (offset.top - windowScroll)
    });

}




// WIP for live edit of player summary
$(function() {

   var tabNav = '.tab-nav-a';

   $('.main-content').on('click', tabNav, function() {

        var $this = $(this),
            $these = $(tabNav),
            thisId = $this.attr('href'),
            newId = thisId + '-sidebar',
            $newId = $( newId );

        if ( !$this.hasClass('active') ) {
           $these.removeClass('active');
           $this.addClass('active');

           // OH THE HUMANITY ;-(
           if ( !$newId.closest('.accordion-body').hasClass('in')) {
               $newId.click();
           }

        }

   });

});


//--------------------------------
      //  TEMPORARY
//--------------------------------
//Temp for add video change event
$(document).on('change','#youtube-radio, #upload-radio',function(){
    if($('#youtube-radio').is(':checked')){
        $('#upload-video').hide();
        $('#youtube-input').fadeIn();
    }
    if($('#upload-radio').is(':checked')){
        $('#youtube-input').hide();
        $('#upload-video').fadeIn();
    }
});


$(document).on('change', '#merchant-options',function(){
    $("#" + this.value).fadeIn().siblings().hide();
    });






// FUNCTION TO MOVE PRODUCT BACK AND FORTH FROM SUMMARY
// Could possibly need a cleaner solution by Bill

$(function() {

    // MOVE FROM LIBRARY TO SUMMARY SIDEBAR
    $('.main-content').on('click', '.move-to-summary', function() {

        var $this = $(this),
            thisData = $this.data();

        console.log(thisData);

        // hide and remove the media/product from the left side
        $('#' + thisData.guid).fadeOut(300, function() {
            // SHOULD WE REMOVE OR JUST HIDE ??
            $(this).remove();
        });

        // pick what template to use based on item type
        if ( thisData.type == 'media') {
            var template = C.ssm.mustache.getTemplate( 'video/item-sidebar.html' );
        }

        else if ( thisData.type == 'product') {
            var template = C.ssm.mustache.getTemplate( 'product/item-sidebar.html' );
        }

        //render the template
        var html = Mustache.render(template, thisData);

        //append new div to summary
        $('#' + thisData.destination).append(html);
        $('#' + thisData.guid + '-sidebar').fadeIn(200);


    });

    //MOVE FROM SUMMARY SIDEBAR TO LIBRARY
    $('.main-content').on('click', '.move-to-library', function() {
        var $this = $(this),
            thisData = $this.data();

        // hide and remove the media/product from the right side
        $('#' + thisData.guid + '-sidebar').fadeOut(300, function() {
            $(this).remove();
        });

        // pick what template to use based on item type
        if ( thisData.type == 'media') {
            var template = C.ssm.mustache.getTemplate( 'video/item-library.html' );
        }

        else if ( thisData.type == 'product') {
            var template = C.ssm.mustache.getTemplate( 'product/item-library.html' );
        }

        //render the template
        var html = Mustache.render(template, thisData);

        //append new div to library
        $('#' + thisData.destination).prepend(html);
        $('#' + thisData.guid).fadeIn(200);

    });

});



// Move Items up and down in summary
moveSummaryItemUp = function(thisData) {
    var $this = $(thisData),
        $wrapper = $this.closest('.ssm-media-item-sidebar');

    $wrapper.after( $wrapper.prev() );
}

moveSummaryItemDown = function(thisData) {
    var $this = $(thisData),
        $wrapper = $this.closest('.ssm-media-item-sidebar');

    $wrapper.before( $wrapper.next() );
}





//-------------------------------------------------
//         POP MODALS
//--------------------------------------------------

popEmbedLightbox = function(thisData) {

    var $this = $(thisData),
        data = $this.data(),
        $lb = $('#lightbox-embed'),
        $target = $('.lightbox-embed');

    $target.append(data.embed);

    $lb.show();

}

closeEmbedLightbox = function() {
    var $lb = $('#lightbox-embed'),
        $target = $('.lightbox-embed');

    $target.empty();
    $lb.hide();
}


popImageLightbox = function(thisData) {

    var $this = $(thisData),
        data = $this.data(),
        $lb = $('#lightbox-image'),
        $target = $('.lightbox-image');

    $target.append('<img src="' + data.image + '"/>');

    $lb.show();

}

closeImageLightbox = function() {
    var $lb = $('#lightbox-image'),
        $target = $('.lightbox-image');

    $target.empty();
    $lb.hide();
}

popVideoLightbox = function(thisData) {

    var $this = $(thisData),
        data = $this.data(),
        $lb = $('#lightbox-video'),
        $target = $('.lightbox-video');

    $target.append('<div id="video-preview-div" />');

    jwplayer('video-preview-div').setup({
        flashplayer: '/web/swf/jwplayer.flash.swf',
        file: data.videourl,
        width: '700',
        height: '394',
        primary: 'flash',
        image: data.imageurl
    });

    $lb.show();

}

closeVideoLightbox = function() {
    var $lb = $('#lightbox-video'),
        $target = $('.lightbox-video');

    $target.empty();
    $lb.hide();
}






