<?php


   $param = '{
  "settings": {
    "analysis": {
      "analyzer": {
        "autocomplete": {
          "tokenizer": "autocomplete",
          "filter": [
            "lowercase"
          ]
        },
        "autocomplete_search": {
          "tokenizer": "lowercase"
        }
      },
      "tokenizer": {
        "autocomplete": {
          "type": "edge_ngram",
          "min_gram": 2,
          "max_gram": 20,
          "token_chars": [
            "letter"
          ]
        }
      }
    }
  },
  "mappings": {
    "properties": {
      "rubrique_auto": {
        "type": "text",
        "analyzer": "autocomplete",
        "search_analyzer": "autocomplete_search"
      },
      "code_rubrique": {
        "type": "text"
      },
      "rubrique":{
            "type":"text",
            "fields":{
               "raw":{
                  "type":"keyword"
               }
            }
         },
      "rubrique_slug": {
        "type": "text"
      }


    }
  }
}
';


    $header = array(
        "Content-Type: application/json" 
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/autocomplete_rubriques_2/");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);

        print_r($res);
?>
