<?php

require_once "../classes/DokusWP.php";
class UserMappingTest extends PHPUnit_Framework_TestCase
{
    public function testUserLists()
    {
        $dokusWP = DokusWPFactory::getDokusWP();
        get_list_of_users($dokusWP);
    }

    public function testExplode()
    {
        $body = 'HTTP/1.1 100 Continue

HTTP/1.1 200 OK
Server: nginx
Date: Wed, 04 Jul 2012 18:34:31 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
Vary: Cookie

{
"group": {
"name": "TestHolstad1",
"creation_time": "2011-08-29T00:27:58",
"modification_time": "2012-07-04T20:34:30.819",
"creation_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"members": [
{
"phone_number": "",
"name": "Magnus Hushovd",
"web_site": "",
"zip_place": "",
"address1": "",
"address2": "",
"creation_time": "2011-08-28T19:53:23",
"fax_number": "",
"customer_number": "",
"modification_time": "2011-08-28T19:53:23",
"creation_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"contact": "",
"modification_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"id": 22845,
"country": {
"is_default_country": true,
"norwegian_name": "Norge",
"id": 1,
"english_name": "Norway"
},
"org_number": "",
"email": "mhushovd@gmail.com",
"zip_code": ""
},
{
"phone_number": "",
"name": "Henrik Michelsen",
"web_site": "",
"zip_place": "",
"address1": "",
"address2": "",
"creation_time": "2011-08-28T22:26:51",
"fax_number": "",
"customer_number": "",
"modification_time": "2011-08-28T22:26:52",
"creation_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"contact": "",
"modification_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"id": 22846,
"country": {
"is_default_country": true,
"norwegian_name": "Norge",
"id": 1,
"english_name": "Norway"
},
"org_number": "",
"email": "1@2.com",
"zip_code": ""
}
],
"modification_by": {
"first_name": "Sindre Svendby",
"email": "sindre.svendby@eniro.no",
"id": 763
},
"id": 22813
}
}';
    $json = json_encode($body);
    $json;
    }
}


