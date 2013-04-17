$(document).on('ready',function() {
/**
    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                if(step == 0) {
                    $("#saveNewVideoForm").validate();

                    jQuery.validator.addMethod("validate-youtube-url", function(value, element) {
                        return this.optional(element) || /^(v=)?[\w-]{10,12}$|^((?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/watch#!v=))([\w\-]{10,12})\b[?=&\w]*(?!['"][^<>]*>|<\/a>))$/.test(value);
                    }, "Please enter a valid Youtube URL");

//                    Validation.addAllThese([
//                        ['validate-youtube-url', '<?php // echo Mage::helper('catalog')->__('Please enter a valid Youtube URL.') ?>', function(v) {
//                            return Validation.get('IsEmpty').test(v)
//                                ||  /^(v=)?[\w-]{10,12}$|^((?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/watch#!v=))([\w\-]{10,12})\b[?=&\w]*(?!['"][^<>]*>|<\/a>))$/.test(v);
//                        }]
//                    ]);
//
// jQuery.validator.addMethod("validate-millions", function(value, element) {
//                        return value < 100000000;
//                    }, "Please enter a number lower than 100.000.000");

                }else
                    step++;}
        }, '#saveNewVideoForm');


    })
        (jQuery);*/
});