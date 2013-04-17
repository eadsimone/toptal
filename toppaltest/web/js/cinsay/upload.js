$(document).ready(function() {

    $(document).on("click", "i.icon-remove.video", function() {
        $(this).parents("div#alert-wrapper").fadeTo(250,0);
    });

    $(document).on("change", "input:file", function(event) {
        var asset = {
            $this: this,
            field: $(event.target).get(0),
            event: event
        };
        assetSave(asset);
    });

    $(document).on("click", "#saveVideoButton", function(event) {
        var asset = {
            $this: this,
            form: $("#saveVideoForm")[0] || $("#saveNewVideoForm")[0],
            event: event
        };
        videoSave(asset);
    });
});

function assetSave(asset) {

    var e = asset.event,
        field = asset.field,
        file = $(asset.field.files).get(0),
        parent = $(asset.field).parent(),
        hidden = $(parent).children('input:hidden'),
        progress = $(parent).children('progress'),
        preview = $(parent).children('a.file-preview'),
        percent = $(parent).children('span'),
        cancel  = $(parent).children('i.upload-cancel'),
        imgfield = $(".lightbox img"),
        formdata = new FormData();
    file.name = encodeURIComponent(file);
    formdata.append(field.id, file);
    formdata.append("filelist", field.files);
    var jqXHR = $.ajax({
        url: "../src/jsapiCalls/saveAsset.php",
        data:formdata,
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function() {
            $(progress).show().fadeTo(0, 1);
            $(percent).show().fadeTo(0, 1);
            $(cancel).show().fadeTo(0, 1);
        },
        xhr:function() {
            var Xhr = $.ajaxSettings.xhr();
            if (Xhr.upload) {
                Xhr.upload.addEventListener('progress', progressHandler, false);
            }
            return Xhr;
        },
        success:function(data) {
            var msg = String("Successfully added the " + field.accept.substr(0,5));

            $(hidden).addClass("done");
            window.scrollTo(0,0);
            alertMsg("success",  msg);
            $(imgfield).attr("src", data.url);
            $(hidden).val(data.url);

            if(e.target.id === "flowbackgroundImage") {
                $(hidden).val(data.url).data({"image":data.url, "source":data.url});
                $(preview).data("image",data.url);
            }
            if (e.target.id === 'posterImage') {
                $(preview).data("image", data.url);
                $("#originalVideoUrl").parent().children(".file-preview").data("imageurl", data.url);
            }
            if (e.target.id === "originalVideo") {
                $("#originalVideoUrl").parent().children(".file-preview").data("videourl", data.url);
            }
            if (e.target.id === "thumbImage") {
                $(preview).data("image", data.url);
            }
            if (e.target.id === "thumb") {
                $(preview).data("image", data.url);
                $(hidden).val(data.url).data("image",data.url);
            }
        },
        error:function(response) {
            var msg = response.responseText || "An error occured. Please try again.";
            window.scrollTo(0,0);
            alertMsg("error",  msg);
            $(hidden).removeClass("done");
        },
        complete:function() {
            $(progress).delay(1000).fadeTo(1250, 0);
            $(percent).delay(1000).fadeTo(1250, 0);
            $(cancel).delay(1000).fadeTo(1250, 0);
        }
    });
    jqXHR.fail = jqXHR.error;
    jqXHR.done = jqXHR.success;
    jqXHR.always = jqXHR.complete;
    $(document).on("click", '.upload-cancel', function() {
        $(progress).val("0");
        return jqXHR.abort("Upload " + field.accept.substr(0,5) + " cancelled");
    });
    return jqXHR;
}

function videoSave(asset) {

    var e = asset.event,
        form = asset.form,
        url = ( asset.form.id === 'saveVideoForm' ) ?
            '../src/jsapiCalls/saveVideo.php' :
            '../src/jsapiCalls/saveNewVideo.php',
        alertWrap = $("div#alert-wrapper"),
        alertDiv = $('div.alert'),
        jqXHR = $.ajax({
            url: url,
            data:$(form).serialize(),
            type: "POST",
            beforeSend:function() {
                var done = $(form).find('.done'),
                    Xhr = $.ajaxSettings.xhr();
                if ( $(".done").length!==3 ) {
                    Xhr.abort();
                }
                return Xhr;
            },
            xhr:function() {
                var Xhr = $.ajaxSettings.xhr();
                window.scrollTo(0,0);
                if (Xhr.readystate !== 4) {
                    $(form).fadeTo(1000,'.2');
                }
                return Xhr;
            },
            success:function(data) {
                var imgfield = $(".lightbox-image img")[0],
                    msg = "Saved the video successfully";
                window.scrollTo(0,0);
                $("#saveVideoButton").append("a").attr({"href":"#", "id":"addVideoToMedia"});
                $("#addVideoToMedia").addClass("move-to-summary")
                    .data({
                        destination:"media-summary",
                        source:"media-left-side",
                        type:"media",
                        guid: $("#videoGuid").val(),
                        image: $("#posterImageUrl").val(),
                        video:$("#originalVideoUrl").val(),
                        title:$("#videoname").val()
                    }).one("click", function(event) {
                        $(this).trigger("click", function() { console.log(this); }).off("click");
                    });
                $(form).fadeTo(500,1);
                return alertMsg("success", msg, alertWrap, alertDiv);
            },
            error:function(errorMsg) {
                var msg = errorMsg || "An error occured. Please try again.";
                alertMsg("error", msg, alertWrap, alertDiv);
                $(form).fadeTo(500,1);
            }
        });

    jqXHR.fail = jqXHR.error;
    jqXHR.done = jqXHR.success;
    return jqXHR;
}

function alertMsg(status, msg) {
    var alertWrap = $("div#alert-wrapper[data-asset]"),
        alertDiv = $('div#alert-wrapper[data-asset] div'),
        newStatus = String('alert-'+status + " " + status),
        alertTxt = "<p class='alert-"+status+"'></p>",
        dismissBtn = "<i class='icon-remove video'></i>";

    $(alertWrap).removeAttr('class').addClass(newStatus);
    $(alertDiv).removeAttr('class').addClass(newStatus).empty();
    $(alertDiv).html(alertTxt+dismissBtn);
    $("p.alert-"+status).text(msg);
    $(alertWrap).show().fadeTo(250,1).delay(1000).fadeTo(1250,0);
    $(alertDiv).show().fadeTo(250,1).delay(1000).fadeTo(1250,0);
}

function progressHandler(e) {
    var loadPercent = parseInt((e.loaded / e.total) * 100, 10),
        controlName = $(e.target).data("asset");
    if (e.lengthComputable) {
        $('progress').attr({
            max: e.total,
            value: e.loaded
        });
        $("span."+controlName).text(loadPercent);
    };

}

function debugFunction(e) {
    console.log("on"+ e.type);
    console.log(e);
    console.log(this);
}