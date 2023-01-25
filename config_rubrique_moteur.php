<?php

  $string = isset($_POST['quoi']) ? $_POST['quoi'] : NULL;

   $param = '{
      "from": 0,
      "size": 6,
      "sort":[
      { "_score": { "order": "desc" }},
      {
             "rubrique.raw":"asc"
          }

       ],
      "query": {
        "match": {
          "rubrique_auto": {
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

   $curlRubrique = curl_init();
   curl_setopt($curlRubrique, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/autocomplete_rubriques_2/_search?pretty');
   curl_setopt($curlRubrique,CURLOPT_HTTPHEADER, $header);
   curl_setopt ($curlRubrique, CURLOPT_CAINFO, "elastic/cacert.pem");
   curl_setopt($curlRubrique, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curlRubrique, CURLOPT_POSTFIELDS, $param);
   $resRubrique = curl_exec($curlRubrique);
   curl_close($curlRubrique);
   $resRubrique  =json_decode($resRubrique, true);
   echo json_encode($resRubrique);

?>
