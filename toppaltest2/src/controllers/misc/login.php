<?php
//call : http://services.int.cinsay.com/api/client/resetpassword
//
//json :
//{
//"requestObject":
//{ "email": "eterehov@cinsay.com", "typeName": "clientAuth" }
//
//,
//"apiKey": "cinsay99Public"
//}




function ServicebusLoginUser() {

    //"typeName" : "clientAuth"
    $request = '
    {"apiKey":"{{publicKey}}",
"requestObject" :
{
"email" : "ead@cinsay.com",
"password": "cinsay99",
"typeName": "userAuth"
}
}';

    /*
     real data
    {
   "apiKey":"cinsay99Public",
   "requestObject":{
      "id":"1",
      "guid":"9f50909a-5817-46fa-82e1-2aa6c2d494c2",
      "firstName":"ezequiel",
      "lastName":"De SImone",
      "email":"ead@cinsay.com",
      "password":"cinsay99",
      "active":"true",
      "roles":[
         {
            "id":"1",
            "typeName":"role"
         }
      ],
      "typeName":"user"
   }
}     */

    //$sb_path = "/api/client/login";
    $sb_path = "/api/user/login";


//    $request = str_replace("{{email}}", $email, $request);
//    $request = str_replace("{{password}}", $password, $request);

    return ServicebusRequest($sb_path, $request);
}


ServicebusLoginUser();
//ServicebusRequest($urlPath, $request, $encrypted = true)


function some_logic_here(){
    return '{"User":{"guid":0,"channel":[{"channelPartnerGuid":"123-456-780","name":"World Pay"},{"value":"AK","label":"Alaska","selected":true},{"value":"AS","label":"American Samoa"}],"email":"email0@cinsay.com","login":"login0","lastname":"lastname0","firstname":"firstname0"}}
';
};
return some_logic_here();
