<?php

// $code_firme ='MA3297004';
//     $header = array(
//         'Content-Type: application/json'
//     );

//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_doc/'.$code_firme.'?pretty=true');
//     curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
//     curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     $res = curl_exec($curl);
//     curl_close($curl);
//     $response =json_decode($res, true);

//     print_r($response);
//     die('');

$user = "presencemedia";
$pass = "tX632tpv39jD5KRC";

$connectionTc = new PDO('mysql:host=localhost;dbname=telecontact_BackOffice_Site', $user, $pass , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$code_firme = $_POST['code_firme'];
$pl = $_POST['pl'];

$stmtPhotoSrc = $pl == 1 ? $connectionTc->prepare('SELECT * FROM photos WHERE cfirme= ?') : $connectionTc->prepare('SELECT * FROM photoscr WHERE cfirme= ?');

$response = array();

if($stmtPhotoSrc->execute(array($code_firme))){
    $photos = $stmtPhotoSrc->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($photos)) {
        foreach($photos as $row) {
            array_push($response, $row['_image']);
        }
    }
}

echo json_encode($response);

?>
