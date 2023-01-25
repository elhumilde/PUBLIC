<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

   $param = '{
   "settings":{
      "number_of_shards":1,
      "number_of_replicas":0,
      "analysis":{
         "filter":{
            "shingle":{
               "type":"shingle"
            },
            "words_splitter":{
               "catenate_all":"true",
               "type":"word_delimiter",
               "preserve_original":"true"
            },
            "french_elision":{
               "type":"elision",
               "articles_case":true,
               "articles":[
                  "l",
                  "m",
                  "t",
                  "qu",
                  "n",
                  "s",
                  "j",
                  "d",
                  "c",
                  "jusqu",
                  "quoiqu",
                  "lorsqu",
                  "puisqu"
               ]
            },
            "french_stop":{
               "type":"stop",
               "stopwords":"_french_"
            },
            "french_keywords":{
               "type":"keyword_marker",
               "keywords":[
                  
               ]
            },
            "french_stemmer":{
               "type":"stemmer",
               "language":"light_french"
            }
         },
         "char_filter":{
            "pre_negs":{
               "type":"pattern_replace",
               "pattern":"(w+)s+((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))b",
               "replacement":"~$1 $2"
            },
            "post_negs":{
               "type":"pattern_replace",
               "pattern":"b((?i:never|no|nothing|nowhere|noone|none|not|havent|hasnt|hadnt|cant|couldnt|shouldnt|wont|wouldnt|dont|doesnt|didnt|isnt|arent|aint))s+(w+)",
               "replacement":"$1 ~$2"
            }
         },
         "analyzer":{
            "reuters":{
               "type":"custom",
               "tokenizer":"standard",
               "filter":[
                  "french_elision",
                  "lowercase",
                  "french_stop",
                  "french_keywords",
                  "asciifolding"
               ]
            },
            "words":{
               "type":"custom",
               "tokenizer":"keyword",
               "filter":[
                  "words_splitter"
               ]
            }
         }
      }
   },
   "mappings":{
      "properties":{
         "code_firme":{
            "type":"text"
         },
         "rs_comp_search":{
            "type":"text",
            "analyzer":"reuters"
         },
         "rs_comp":{
            "type":"text",
            "fields":{
               "raw":{
                  "type":"keyword"
               }
            }
         },
         "ville":{
            "type":"text",
            "analyzer":"reuters"
         },
         "ville_slug":{
            "type":"text"
         },
         "adresse":{
                  "type":"text"
         },
         "rs_comp_slug":{
            "type":"text"
         },
         "tel1":{
            "type":"text"
         },
         "tel2":{
            "type":"text"
         },
         "fax":{
            "type":"text"
         },
         "mail":{
            "type":"text"
         },
         "longitude":{
            "type":"text"
         },
         "latitude":{
            "type":"text"
         },
         "agenda_id":{
            "type":"integer"
         },
         "type":{
            "type":"integer"
         },
         "date": {
            "type": "date",
            "format": "dd-MM-yyyy HH:mm:ss"
        },
   
         "national":{
            "type":"nested",
            "properties":{
               "mot":{
                  "type":"text",
                  "analyzer":"reuters"
               },
               "code":{
                  "type":"text"
               },
               "slug":{
                  "type":"text"
               }
            }
           
         },
         "rubriques":{
            "type":"nested",
            "properties":{
               "rubrique":{
                  "type":"text"
               },
               "code":{
                  "type":"text"
               },
               "slug":{
                  "type":"text"
               }
            }
           
         },
         "prestations":{
            "type":"nested",
            "properties":{
               "prestation":{
                  "type":"text"
               },
               "code":{
                  "type":"text"
               },
               "slug":{
                  "type":"text"
               }
            }
           
         },
         "specialites":{
            "type":"nested",
            "properties":{
               "specialite":{
                  "type":"text"
               },
               "code":{
                  "type":"text"
               },
               "slug":{
                  "type":"text"
               }
            }
           
         },

        "pin": {
        "properties": {
             "location": {
                  "type": "geo_point"
             }
         }
        }

      }
   }
}
';

    $header = array(
        "Content-Type: application/json" 
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://elastic:wtpz3SGPK3810T00O9hPYI4V@medicalis.es.europe-west1.gcp.cloud.es.io/erdv3/");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);

    $res = curl_exec($curl);
 


if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
    print_r($error_msg);
}

        print_r($res);


?>