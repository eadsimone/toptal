/**
 * Created with JetBrains PhpStorm.
 * User: peche
 * Date: 3/22/13
 * Time: 9:54 AM
 * To change this template use File | Settings | File Templates.
 */
$(document).on('ready',function() {



//    $("#myTable").tablesorter();


    (function($){
        $('body').on({
            'mouseover' : function(){

                $("#saveNewPlayerForm").validate();

                jQuery.validator.addMethod("pname", function(value, element) {

//                    $("#add_player_name").val($.trim(value));

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
        },'#saveNewPlayerForm');
    })(jQuery)
});
