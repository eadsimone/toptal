<?php

function some_logic_here(){
    return '
    {
    "storename":"Storeead",
   "merchantAccountInformation":{
      "braintree":{
         "merchantId":null,
         "publicKey":null,
         "privateKey":null,
         "ClientSideEncriptionKey":null
      },
      "environment":{
         "SANDBOX":true
      },
      "merchantAccountType":{
         "options":[
            {
               "label":"Braintree merchant account",
               "value":"braintree",
               "selected":true
            },
            {
               "label":"Pay online",
               "value":"payOnlineInfo"
            },
            {
               "label":"Paypal Business Standard\/Advanced  ",
               "value":"paypal"
            }
         ],
         "value":"braintree"
      }
   }
}
    ';
};
return some_logic_here();