$(document).on('ready',function() {

    (function($){

        var step = 0;
        $('body').on({
            'mouseover' : function(){
                if(step == 0) {
                    $("#billingInformationForm").validate();

                    jQuery.validator.addMethod("validate-credit-card", function(value, element) {
                        return /^[0-9]{12,18}$/.test(value); /*/(^\d{12,19}$)/.test(value);*/
                    }, "Please enter a valid Credit Card number.");

                    jQuery.validator.addMethod("zip_en_US", function(value, element) {
                        return this.optional(element) || /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(value);
                    }, "Please enter a valid zip code. For example 90602 or 90602-1234.");

                    jQuery.validator.addMethod("zip_ru_RU", function(value, element) {
                        return this.optional(element) || /(^\d{6}$)/.test(value);
                    }, "Please enter a valid zip code. For example 350000.");

                    jQuery.validator.addMethod("cvv", function(value, element) {
                        return /(^[0-9]{3,4})$/.test(value); /*/(^\d{12,19}$)/.test(value);*/
                    }, "If the credit card is AMEX cvv should be contain 4 numbers. Others should be contain 3.");
//                    jQuery.validator.addMethod("validate-millions", function(value, element) {
//                        return value < 100000000;
//                    }, "Please enter a number lower than 100.000.000");

                }else
                    step++;}
        }, '#billingInformationForm');


    })
        (jQuery)


    /* $('#billinginformation').focus(function() {
     consolelog('onfocus');

     });*/
    var flag=0;
    $('#billinginformation').on('click', function() {

        if(flag==0){
            $("#cvv").val('');
            $("#creditcard").val('');
        }
        flag=1;
        /*console.log('peche_responseText'+flag);*/

    });(jQuery)


});


//this variable is on htacces in LEA
var creditCardInfoKey="MIIBCgKCAQEA4jonVFHQunKf8vxTnmZl8es7HBOgqeaDT0uIzQjhaKQ7x/NAGkkVhpKPetcEXUC8WpOyRSSKmsaYyo/7vJETBkAcDuipp8I7DEJY9zoSYEaqTwunIXdrI4NdPXRAbNQb/6bI6jhTysJhn8CzkRITc265juU4XMtEZavkOF96ve2cbvbVkSJ5bl4T2fbX5og+CN8VUdNTup1C9JVMVWO9Npvw/GiniXkv2zzuvacttiSMYT0I/pu63bA02VA/JgMf+DcGL70eUgc7JCiPh84/rWY2z4XqUSlufrpUfzT3JEeDIpmf4BuKw60SqutlWcn4Z96niTdJf3DfcdvPL0nl8wIDAQAB";
var braintree=Braintree.create(creditCardInfoKey);
//var oldCustomFormSubmit=customForm._submit;
//var formCleared = false;




var encripted= function(){

//    $("credit_card").disabled = true;
//    $("#cvv").disabled = true;
//    $("expiration_date_month").disabled = true;
//    $("expiration_date_year").disabled = true;



    var getValueConditionallyEncrypted = function(secretValue) {
        var paymentGateway = $('gateway_service_type') !== null ? $('#gateway_service_type').val() : null;
        var useEncryption = paymentGateway !== 'payonline';

        if (useEncryption) {
            return braintree.encrypt(secretValue);
        } else {
            return secretValue;
        }
    };

//    if ($("#creditcard").value !=='' && $("#creditcard").value.indexOf('*') == -1 ) {
    var aux=$("#creditcard").val();
    if (aux !='') {
        $("#creditcard").val(getValueConditionallyEncrypted($("#creditcard").val()));
    }
    $("#cvv").val(getValueConditionallyEncrypted($("#cvv").val())) ;
    $("#expiration_date").val(getValueConditionallyEncrypted($("#expiration_month").val() +"/" +$("#expiration_year").val()))
//    oldCustomFormSubmit.apply(this);

}
encripted(jQuery);