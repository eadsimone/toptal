
//===== SLIDE PANE PLUGIN =====//


(function( $ ) {

    $.fn.slidePane = (function(options) {

        var defaults = {
            slideSpeed: 300
        }

        var options = $.extend( defaults , options );

        return this.each(function(i) {

            var o = options,
                $this = $(this),
                $thisWrapper = $this.parent(),
                wrapperWidth = $thisWrapper.width(),
                slideSpeed = o.slideSpeed,
                thisId = 'slide-content-' + [i],
                $wb = $('html, body');


            $this.attr('id', thisId );
            var $thisId = $('#' + thisId );

            var $contentLeft = $thisId.find( o.leftContent ),
                $contentRight = $thisId.find( o.rightContent ),
                openBtn = '.' + o.openBtnClass,
                closeBtn = '.' + o.closeBtnClass;


            $('.main-content').on( 'click' , openBtn, function() {

                var $newThis = $(this),
                    thisData = $newThis.data(),
                    $thisContentId = $thisId.find( '#' + thisData.id );

                // scroll to top of page
//                $wb.animate({ scrollTop: 0 }, slideSpeed);

                $thisContentId.empty();

                C.ssm.loadPartial.helper( { url: thisData.json, template: thisData.template, elementId: thisData.id })
                    .done(function( responseData ) {

                        // a couple things to help with transition like turning off body scrollbar
                        $thisId.css({opacity:'0'});
                        $wb.css({overflow:'hidden'});

                        // scroll the page back to top
                        $wb.animate({ scrollTop: 0 }, slideSpeed, function() {

                            $thisId.animate({
                                left: '-' + wrapperWidth,
                                opacity: '1'
                            }, slideSpeed, function() {

                                //turn body scrolling back on
                                $wb.css({overflow:'auto'});

                                // BB - AARRGGEHHHHH!!!!!! NO EVAL!!!!!!
                                // JG - AARRGGEHHHHH HOW COULD YOU BILL!!!??? ;-)
                                if( thisData.callback ) eval( thisData.callback );

                            } );
                        });

                        $contentLeft.hide();
                        $contentRight.show();
                });

            });

            $('.main-content').on( 'click', closeBtn , function() {

                // a couple things to help with transition like turning off body scrollbar
                $thisId.css({opacity:'0'});
                $wb.css({overflow:'hidden'});

                // scroll the page back to top
                $wb.animate({ scrollTop: 0 }, slideSpeed, function() {

                    //animate the slide and turn opacity back up
                    $thisId.animate({
                        left: '0px',
                        opacity: '1'
                    }, slideSpeed, closeCallback( $contentLeft , $contentRight ) );

                    //turn body scrolling back on
                    $wb.css({overflow:'auto'});
                });


            });

            closeCallback = function( $contentLeft , $contentRight ) {
                $contentLeft.show();
                $contentRight.hide();
            }


        });

    });
})(jQuery);