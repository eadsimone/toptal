$(document).on('ready',function() {


    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                if(step == 0) {
                    $("#shipping_form").validate();

                    jQuery.validator.addMethod("rate", function(value, element) {
                        return /^[0-9]\d*(\.\d+)?$/.test(value); /*/(^\d{12,19}$)/.test(value);*/
                        //rexp: ^[1-9]\d*(\.\d+)?$
                    }, "Only can be decimal numbers.");
                }else
                    step++;}
        },'#shipping_form');


    })
        (jQuery)
});