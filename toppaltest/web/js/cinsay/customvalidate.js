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
                 }/*end if*/
  step++;


            }
        }, '#accountinfo');


    })
    (jQuery)
});