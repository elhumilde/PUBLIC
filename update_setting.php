<?php

    $header_tt = array(
        "Content-Type: application/json" 
    );


    $curl_tt = curl_init();

    curl_setopt($curl_tt, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/telecontact42/_close");
    curl_setopt($curl_tt,CURLOPT_HTTPHEADER, $header_tt);
    curl_setopt ($curl_tt, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl_tt, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_tt, CURLOPT_CUSTOMREQUEST, "POST");

     $res_tt = curl_exec($curl_tt);


$param='{
  "analysis" : {
      "char_filter": {
          "remove_accents": {
          "type": "mapping",
          "mappings": [
          "\u0091=>\u0027",
        "\u0092=>\u0027",
        "\u2018=>\u0027",
        "\u2019=>\u0027"]
        }
    },
    "analyzer":{
      "reuters":{
      "type":"custom",
               "tokenizer":"standard",
               "filter":[
                  "french_elision",
                  "lowercase",
                  "french_keywords",
                  "asciifolding",
                  "french_stemmer"
               ],
           "char_filter": ["remove_accents"]
      }
    }
  }
}';








    $header = array(
        "Content-Type: application/json" 
    );

         $curl = curl_init();


    curl_setopt($curl, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/telecontact42/_settings");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);

        print_r($res);



    $header_tt_close = array(
        "Content-Type: application/json" 
    );


    $curl_tt_close = curl_init();

    curl_setopt($curl_tt_close, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/telecontact42/_open");
    curl_setopt($curl_tt_close,CURLOPT_HTTPHEADER, $header_tt_close);
    curl_setopt ($curl_tt_close, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl_tt_close, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_tt_close, CURLOPT_CUSTOMREQUEST, "POST");

     $res_tt_close = curl_exec($curl_tt_close);
     

 ?>