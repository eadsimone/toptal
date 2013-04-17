$('button[class*="scalable save playerActionButtons admin__player__edit__save"]').each(function(i,x){
    $(x).live('click',function() {
        $('#email_address, #email_message').css({color:'white'}).val('default');
    });
});

var step = 0;
$(document).on('ready',function() {


    (function($){


        $('body').on({
            'mouseover' : function(){
                if(step == 0) {

//                    var ids = [];
//                    $("form").each(function () {
//                        ids.push(this.id);
//                    });
//                    var formId = "#" + ids[0]
//                    $(formId).validate();


                    $("#shareEmailForm").validate();

                    jQuery.validator.addMethod("validate-keyword", function(keywords) {
                        var keywordList = keywords.split(',');

                        for(var i = 0; i < keywordList.length; i++) {
                            var keyword = jQuery.trim(keywordList[i]);
                            if (keyword.length > 20) {
                                return false;
                            }
                        }

                        return true;
                    }, "Please, enter 20 or less characters for each keyword. The keywords must be separated by commas.");


                    jQuery.validator.addMethod("marketplace-seo-url-validation", function(value, element) {
//                        return this.optional(element) ||  /^[a-zA-Z0-9_-]+$/.test(value)
                        return /^[a-zA-Z0-9_-]+$/.test(value)
                    }, "Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.");

//                    Validation.add('marketplace-seo-url-validation', 'Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.', function (v) {
//                        return Validation.get('IsEmpty').test(v) ||  /^[a-zA-Z0-9_-]+$/.test(v)
//                    });


                }else
                    step++;}
        }, '#shareEmailForm');


//    ---------
        $(document).on("click", "#iPhoneCheckContainer", function(event) {
            if ($('#marketplaceonoff').is(':checked')) {
                $('#marketplaceUrl').css({'visibility': 'visible', display: ''});
                $('#marketplaceSeoUrlSuffix').prop('disabled', false);
                $('#keywordbox').prop('disabled', false);
                $('#marketplaceSeoUrlSuffix').addClass("required-entry");
                $("#marketplaceonoff").prop('checked', true );
                $("#marketplaceonoff").prop('value', true );

            }else{
                $('#marketplaceUrl').css({'visibility': 'hidden', display: ''});
                $('#marketplaceSeoUrlSuffix').prop('disabled', true);
                $('#keywordbox').prop('disabled', true);
                $('#marketplaceSeoUrlSuffix').removeClass("required-entry");
                $("#marketplaceonoff").prop('checked', false);
                $("#marketplaceonoff").prop('value', true);
            }
        });

    })(jQuery)

});
/*
        $(document).on("change", "input:file", function(event) {
            window.formData = new FormData($("form")[1]),
                window.fileData = $(event.currentTarget).get(0).files[0],
                window.fileName = fileData.name.replace(' ', '+'),
                window.key= "http://devcinsay.s3.amazonaws.com/stag/"+clientGuid+"/originals/"+fileName,
                window.textfield = $(this).parent().children("input:text").val(key);
            window.formData.append($(event.currentTarget).parent().children('input:text').attr('name'), $(event.currentTarget).parent().children('input:text').val());


            console.log(window.fileData);
            console.log(window.fileName);

            $.ajax({
                url:"../src/jsapiCalls/saveAsset.php",
                type:"POST",
                data:formData,
                xhr: function() {  // custom xhr
                    var Xhr = $.ajaxSettings.xhr();
                    if(Xhr.upload){ // check if upload property exists
                        console.log("upload");
                        Xhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
                    }
                    return Xhr;
                },
                beforeSend: function() {
                    console.log("PUBLISH.JS");
                    console.log("before");
                    console.log($.ajaxSettings.xhr());
                },
                success: function(data) {
                    console.log("success");
                    return window.uploadResult = data;
                },
                error: function() {
                    console.log("error");
                },
                cache: false,
                contentType: false,
                processData: false
            }).done(function(data) {
                    console.log(data);
                    $(this).parent().children("input:text").val(data.responseObject.assetUrl);
                }).always(function(data){

                });
            return false;
        });

        $(document).on("click", "#saveNewButtonVideo", function(event) {
            window.formData=new FormData($("form")[1]);
            window.fileData = $(event.currentTarget).get(0).files[0];
            window.fileName = fileData.name.replace(' ', '+');
            window.key= "http://devcinsay.s3.amazonaws.com/stag/"+window.clientGuid+"/originals/"+window.fileName;
            window.textfield = $(this).parent().children("input:text").val(window.key);
            window.formData.append($(event.currentTarget).parent().children('input:text').attr('name'), $(event.currentTarget).parent().children('input:text').val());
            $.ajax({
                url:"../src/jsapiCalls/saveAsset.php",
                data:window.formData,
                type:"POST",
                xhr:function() {
                    var Xhr = $.ajaxSettings.xhr();
                    if(Xhr.upload){ // check if upload property exists
                        console.log("upload");
                        Xhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
                    }
                    return Xhr;
                },
                beforeSend: function() {
                    console.log("before");
                    console.log($.ajaxSettings.xhr());
                },
                success: function(data) {
                    console.log("success");
                    return window.uploadResult = data;
                },
                error: function() {
                    console.log("error");
                },
                cache: false,
                contentType: false,
                processData: false

            }).done(
                $.ajax({
                    url:"../src/jsapiCalls/saveVideoNew.php",
                    type:"POST",
                    data:formData,
                    xhr:function() {
                        var Xhr = $.ajaxSettings.xhr();
                        if(Xhr.upload){ // check if upload property exists
                            console.log("upload");
                            Xhr.upload.addEventListener('progress',progressHandlingFunction, false); // for handling the progress of the upload
                        }
                        return Xhr;
                    },
                    beforeSend: function(xhr) {
                        console.log("before");
                        console.log($(xhr));
                    },
                    success: function(data) {
                        console.log("success"); return data;
                    },
                    error: function() {
                        console.log("error");
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function(data) {
                        console.log($(data));
                        $("input:text").val(data.responseObject.assetUrl);
                    }).always(function(data) {

                    })

            );
            return false;

        });
        return false;
    })();





    });


function progressHandlingFunction(e){
    console.log("handle");
    console.log($(e.currentTarget));
    $(e.currentTarget).onprogress = function() {
        $(e.currentTarget).progress = $(this).closest("progress");
        $(e.currentTarget).progress.show();
    };
    if(e.lengthComputable){
        $("progress", this).show();
        $('progress').attr({value:e.loaded,max:e.total});
    }
}
*/