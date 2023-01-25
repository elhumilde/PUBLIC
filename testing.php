<?php


    $code_firme ='MA3400651';
    $header = array(
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_doc/'.$code_firme.'?pretty=true');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // $res = curl_exec($curl);
    // curl_close($curl);


    curl_exec($curl);
if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
}
curl_close($curl);

if (isset($error_msg)) {
    // TODO - Handle cURL error accordingly
}



/*    $response =json_decode($res, true);

    print_r($response);*/
    die('');

?>
