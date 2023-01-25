<?php



$param='{
  "properties": {
          "name_search":{
               "type":"text",
            "fields":{
               "raw":{
                  "type":"keyword"
               }
            }
         }
}}';


    $header = array(
        "Content-Type: application/json" 
    );
    $curl = curl_init();

     

    curl_setopt($curl, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/telecontact42/_mapping");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);

        print_r($res);


 ?>