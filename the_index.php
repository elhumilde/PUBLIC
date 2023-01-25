<?php


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
                  "asciifolding",
                  "french_stemmer"
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
         "tel1_s":{
            "type":"text"
         },
         "tel2_s":{
            "type":"text"
         },
         "fax_s":{
            "type":"text"
         },
         "forme_juridique":{
            "type":"text"
         },
         "capital":{
            "type":"text"
         },
         "rc":{
            "type":"text"
         },
         "ice":{
            "type":"text"
         },
         "effectif":{
            "type":"text"
         },
         "annee_de_creation":{
            "type":"text"
         },
         "fichier":{
            "type":"text"
         },
         "type_d_etablissement":{
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
         "dirigeant":{
            "type":"text"
         },
         "adresse":{
            "type":"text"
         },
         "video_id":{
            "type":"integer"
         },
         "video_url":{
            "type":"text"
         },
         "video_graphique_id":{
            "type":"integer"
         },
         "video_graphique_url":{
            "type":"text"
         },
         "film_id":{
            "type":"integer"
         },
         "film_url":{
            "type":"text"
         },
         "agenda_id":{
            "type":"integer"
         },
         "actualiter_id":{
            "type":"integer"
         },
         "act_plus":{
            "type":"integer"
         },
         "agenda_url":{
            "type":"text"
         },

         "module_logo":{
            "type":"text"
         },        
         "site_web":{
            "type":"text"
         },
         "poid":{
            "type":"integer"
         },
         "annoceur":{
            "type":"integer"
         },
         "pl":{
            "type":"integer"
         },
         "pj":{
            "type":"integer"
         },
         "pj_desc":{
            "type":"text"
         },
         "pj_lien":{
            "type":"text"
         },
         "limitrophe":{
            "type":"text",
            "analyzer":"reuters"
         },
         "medecin":{
            "type":"integer"
         },
        "date": {
            "type": "date",
            "format": "dd-MM-yyyy HH:mm:ss"
        },
         "catalogue":{
            "type":"integer"
         },
         "catalogue_co":{
            "type":"integer"
         },
         "pvi":{
            "type":"integer"
         },
         "page":{
            "type":"integer"
         },
         "vignette_va":{
            "type":"integer"
         },
         "vignette_va_rubriques":{
            "type":"nested",
            "properties":{
               "va_rubriques":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },

         "vignette_vl":{
            "type":"integer"
         },
         "vignette_vl_localites":{
            "type":"nested",
            "properties":{
               "vv_localites":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },

         "plus_info":{
            "type":"integer"
         },
         "mot_cle":{
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
         "mot_cle1":{
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
         "mot_cle2":{
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
         "mot_cle3":{
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
         "mot_cle4":{
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
         "mot_cle5":{
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
         "mot_cle6":{
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
         "mot_cle7":{
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
         "mot_cle8":{
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
         "mot_cle9":{
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
         "mot_cle10":{
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
         "pl_parcours":{
            "type":"text"
         },
         "pl_diplome":{
            "type":"text"
         },
         "pl_certification":{
            "type":"text"
         },
         "pl_langue_parle":{
            "type":"text"
         },
         "pl_domaine_competence":{
            "type":"text"
         },
         "marques":{
            "type":"nested",
            "properties":{
               "marque":{
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
         "brands":{
            "type":"nested",
            "properties":{
               "brand":{
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
        "pin": {
        "properties": {
             "location": {
                  "type": "geo_point"
             }
         }
        },

        "succursale":{
            "type":"nested",
            "properties":{
               "code_firme":{
                  "type":"text"
               },
               "type":{
                  "type":"text"
               },
               "rs":{
                  "type":"text"
               },
               "tel":{
                  "type":"text"
               },
               "fax":{
                  "type":"text"
               },
               "adresse":{
                  "type":"text"
               },
               "ville":{
                  "type":"text"
               },
               "rs_slug":{
                  "type":"text"
               },
               "ville_slug":{
                  "type":"text"
               }
            }
           
         },
          "villes":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes1":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes2":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes3":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes4":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes5":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes6":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes7":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes8":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes9":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
               }
            }
           
         },
          "villes10":{
            "type":"nested",
            "properties":{
               "name":{
                  "type":"text",
                  "analyzer":"reuters"
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

     

    curl_setopt($curl, CURLOPT_URL, "http://edicomelastic1.odiso.net:9200/telecontact42/");
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);

        print_r($res);
?>