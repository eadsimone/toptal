$(document).on('ready',function() {

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){

                $("#saveNewProductForm").validate();

                    jQuery.validator.addMethod("validate-url-cyrillic", function(value, element) {
                        return /^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value); /*/(^\d{12,19}$)/.test(value);*/
                    }, "Please enter a valid URL.");
            }
        }, '#saveNewProductForm');


    })
        (jQuery)
});

