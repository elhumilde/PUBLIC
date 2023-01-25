<?php

    $query='climatisation';
   $param = '{

  "from": 0,
  "size": 3,
  "sort":[

{ "_score": { "order": "desc" }}

   ],
"query": {
    "function_score": {

   "query":{
               "bool":{
                  "must":[

        {
                        "nested":{
                           "path":"vignette_va_rubriques",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "vignette_va_rubriques.va_rubriques":  {
                                          "query":"'.$quoi.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     },



           { "term": {
            "vignette_va" : "1"
          }
        }

                  ]
               }
   },

    "random_score": {
        "seed": "'.rand(10,100).'",
        "field": "_seq_no"
      }
  }

   }
}


';


    $header = array(
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_search?pretty');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $res =json_decode($res, true);
    print_r(   $res);


    die('here');

      $total        = $res['hits']['total']['value'];




?>