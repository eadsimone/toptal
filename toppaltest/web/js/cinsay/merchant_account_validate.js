$(document).on('ready',function() {

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                if(step == 0) {
                    $("#merchantAccountInformationForm").validate();
                }
                step++;
            }
        }, '#merchantAccountInformationForm');


    })
        (jQuery)
});