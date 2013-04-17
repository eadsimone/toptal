$(document).on('ready',function() {
//    $("accountinfo").validate();
//});

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                 if(step == 0) {
                //$("#accountinfo").validate();
                //  }
                //  step++;
                $("#accountinfo").validate({
                    rules: {
                        newpassword: {
                            required: true,
                            minlength: 5
                        },
                        newpasswordconfirmation: {
                            required: true,
                            minlength: 5,
                            equalTo: "#newpassword"
                        }
                    },
                    messages: {
                        newpassword: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        newpasswordconfirmation: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        }
                    }
                });
                     jQuery.validator.addMethod("marketplace-seo-url", function(value, element) {
                         return /^[a-zA-Z0-9_-]+$/.test(value); /*/(^\d{12,19}$)/.test(value);*/
                     }, "Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.");

                 }/*end if*/
  step++;


            }
        }, '#accountinfo');


    })
    (jQuery)
});