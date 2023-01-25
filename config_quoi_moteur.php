<?php

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $string = isset($_POST['quoi']) ? $_POST['quoi'] : NULL;

/*  $param = '{

     "from": 0,
     "size": 6,

      "query": {
         "prefix": {
           "rs_comp_auto": "'.$string.'"
         }
       }
   }';*/
   $param = '{
      "from": 0,
      "size": 6,
      "sort":[
        { "_score": { "order": "desc" }},
          {
             "rs_comp.raw":"asc"
          }
       ],
      "query": {
        "match": {
          "rs_comp_auto": {
            "query": "' . $string . '",
            "operator": "and",
            "fuzziness": 2
          }
        }
      }
  }';

   $header = array(
       'Content-Type: application/json'
   );
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/autocomplete_raison_sociale_2/_search?pretty');
   curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
   curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
   $res = curl_exec($curl);
   curl_close($curl);
   $res = json_decode($res, true);
   echo json_encode($res);

?>
