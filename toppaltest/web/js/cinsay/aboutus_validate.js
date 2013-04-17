$(document).on('ready',function() {

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                if(step == 0) {
                    $("#aboutus_form").validate();

                    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
                        phone_number = phone_number.replace(/\s+/g, "");
                        return this.optional(element) || phone_number.length > 9 &&
                            phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
                    }, "Please specify a valid phone number");

                    jQuery.validator.addMethod("validate-url-cyrillic", function(value, element) {
                        return /^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value); /*/(^\d{12,19}$)/.test(value);*/
                    }, "Please enter a valid URL.");

                }else
                    step++;}
        },'#aboutus_form');


    })(jQuery)
});