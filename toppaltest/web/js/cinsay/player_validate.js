$(document).on('ready',function() {

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){

                $("#player_form").validate();
                jQuery.validator.addMethod("pname", function(value, element) {

//                    $("#player_name").val($.trim(value));

                    var specialchar='@#$^&<>';//should be scape this *

                    for (i=0;i<=specialchar.length;i++){
                        var vchar=specialchar[i];
                        var ans=value.match(vchar);

                        if( ans!=null){
                            for (j=0;j<ans.length;j++){
                                if(ans[j]!=""){
                                    return false
                                    break;
                                }
                            }
                        }
//                        else{

// else{
//                            return true
//                        }
                    }
                    return true

                }, "Please enter a valid player name without white space at beginning and end.");



            }
        }, '#player_form');


    })
        (jQuery)
});

