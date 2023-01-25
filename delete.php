<?php

  // worked 
    $code_firme ='MA9001287';
    $header = array(
        'Content-Type: application/json'
    );

 // curl -X DELETE http://edicomelastic1.odiso.net:9200/telecontact42/_doc/MA3344637

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_doc/'.$code_firme);
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper('DELETE'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $res = curl_exec($curl);
    curl_close($curl);
    $response =json_decode($res, true);

    print_r($response);
    die('');

?>
