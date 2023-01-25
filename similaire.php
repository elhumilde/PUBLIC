<?php


$string ='eau distillee';
$ou ='fes';




if ($string && $ou )
{
// echo '<h1>Sociétés similaires</h1> <br/>';


   $param = '{

  "from": 0,
  "size": 4,
  "sort":[

{ "_score": { "order": "desc" }}

   ],
"query": {
    "function_score": {

   "query":{
      "bool":{
         "should":[


{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle1",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle1.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes1",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes1.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }


]

}


},

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle2",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle2.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes2",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes2.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}

,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle3",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle3.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes3",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes3.name":  {
                                          "query":"'.$ou.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                     ,
                                { "term": {
            "annoceur" : "1"
          }
        }

]

}


}


,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle4",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle4.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes4",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes4.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}
,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle5",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle5.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes5",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes5.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}
,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle6",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle6.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes6",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes6.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}
,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle7",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle7.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes7",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes7.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}
,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle8",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle8.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes8",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes8.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

}


}
,

{
  "bool":{
                  "must":[


            {
               "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"mot_cle9",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "mot_cle9.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                  ]
               }
            },
            {
                        "nested":{
                           "path":"villes9",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "villes9.name":  {
                                          "query":"'.$ou.'",
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
            "annoceur" : "1"
          }
        }

]

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
    curl_setopt($curl, CURLOPT_URL, 'https://elastic:wyNUFvV3lVd4F6rSiSkXxF6c@edicom-a2d5f9.es.eu-west-3.aws.elastic-cloud.com/telecontact42/_search?pretty');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $res =json_decode($res, true);

    $total        = $res['hits']['total']['value'];


    if ($total ){

      // ici le test sur le code fichier 
     // si le code fichier de la fiche d'un profession liberale il faut changer le titre c'est pas sociétés similaires 
echo '<h1>Sociétés similaires</h1> <br/>';
           for ($x = 0; $x < 4 ; $x++) {

    $string=substr($res['hits']['hits'][$x]['_source']['code_firme'],2);
    $rs_comp =$res['hits']['hits'][$x]['_source']['rs_comp'];
    $pj_desc =$res['hits']['hits'][$x]['_source']['pj_desc'];
    $pj_lien =$res['hits']['hits'][$x]['_source']['pj_lien'];

    $i =$x +1;

    if(  $string){


echo    $rs_comp .'<br/>';
echo    $string .'<br/>';

echo   '-----------<br/>';

}
}
}
else{

// Sociétés similaires autres ville 

   $param_autre = '{

  "from":0,
  "size": 4,
  "sort":[

{ "_score": { "order": "desc" }}
   ],
"query": {
    "function_score": {

   "query":{

      "bool":{
                  "must":[
              { "bool":{
                  "should":[
                     {
                        "match_phrase_prefix":{
                         "rs_comp_search": {
                           "query":"'.$string.'",
                           "slop": 2
                           }
                        }
                     },
                     {
                        "nested":{
                           "path":"national",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "national.mot":  {
                                          "query":"'.$string.'",
                                          "slop": 2
                                          }
                                       }
                                    }
                                 ]
                              }
                           }
                        }
                     }
                    
                  ]
               } } ,
                                { "term": {
            "annoceur" : "1"
          }} ]}




   },


         "random_score": {
        "seed": "'.rand(10,100).'",
        "field": "_seq_no"
      }





  }

   }
}


';
    $header_autre  = array(
        'Content-Type: application/json' 
    );

    $curl_autre  = curl_init();
    curl_setopt($curl_autre , CURLOPT_URL, 'https://elastic:wyNUFvV3lVd4F6rSiSkXxF6c@edicom-a2d5f9.es.eu-west-3.aws.elastic-cloud.com/telecontact42/_search?pretty');
    curl_setopt($curl_autre ,CURLOPT_HTTPHEADER, $header_autre );
    curl_setopt ($curl_autre , CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl_autre , CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_autre , CURLOPT_POSTFIELDS, $param_autre);
    $res_autre  = curl_exec($curl_autre );


    curl_close($curl_autre );
    $res_autre  =json_decode($res_autre , true);

    $total_autre        = $res_autre['hits']['total']['value'];



    if ($total_autre ){

            // ici le test sur le code fichier 
            // si le code fichier de la fiche d'un profession liberale il faut changer le titre c'est pas sociétés similaires 
      //

echo '<h1>Sociétés similaires autres villes</h1> ';

           for ($x_autre  = 0; $x_autre < 4 ; $x_autre++) {

    $string_autre=substr($res_autre['hits']['hits'][$x_autre]['_source']['code_firme'],2);
    $rs_comp_autre =$res_autre['hits']['hits'][$x_autre]['_source']['rs_comp'];
    $pj_desc_autre =$res_autre['hits']['hits'][$x_autre]['_source']['pj_desc'];
    $pj_lien_autre =$res_autre['hits']['hits'][$x_autre]['_source']['pj_lien'];

    $i =$x_autre +1;

    if(  $string_autre){


echo    $rs_comp_autre .'<br/>';
echo    $string_autre .'<br/>';

echo   '-----------<br/>';

}
}
}
else
{

   // start Les Professionnels du jour

   $param_pj = '{

  "from": 0,
  "size": 4,
  "sort":[

{ "_score": { "order": "desc" }}

   ],
"query": {
    "function_score": {

   "query":{
               "bool":{
                  "must":[




           { "term": {
            "pj" : "1"
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


    $header_pj = array(
        'Content-Type: application/json'
    );

    $curl_pj = curl_init();
    curl_setopt($curl_pj, CURLOPT_URL, 'https://elastic:wyNUFvV3lVd4F6rSiSkXxF6c@edicom-a2d5f9.es.eu-west-3.aws.elastic-cloud.com/telecontact42/_search?pretty');
    curl_setopt($curl_pj,CURLOPT_HTTPHEADER, $header_pj);
    curl_setopt ($curl_pj, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl_pj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_pj, CURLOPT_POSTFIELDS, $param_pj);
    $res_pj = curl_exec($curl_pj);
    curl_close($curl_pj);
    $res_pj =json_decode($res_pj, true);

  

/*print_r($res['hits']['hits'][0]['_source']);
die();
  */
      $total_pj        = $res_pj['hits']['total']['value'];







// first result of quoi  start
echo '<h1> Les Professionnels du jour</h1> ';

    if ($total_pj ){

           for ($x_pj = 0; $x_pj < 4 ; $x_pj++) {

    $string_pj=substr($res_pj['hits']['hits'][$x_pj]['_source']['code_firme'],2);
    $rs_comp_pj =$res_pj['hits']['hits'][$x_pj]['_source']['rs_comp'];
    $pj_desc =$res['hits']['hits'][$x_pj]['_source']['pj_desc'];
    $pj_lien =$res['hits']['hits'][$x_pj]['_source']['pj_lien'];

    $i =$x_pj +1;

    if(  $string_pj){

echo    $rs_comp_pj .'<br/>';
echo    $string_pj .'<br/>';
echo    $pj_desc_pj .'<br/>';
echo    $pj_lien_pj .'<br/>';
echo 'https://www.telecontact.ma/pubs/PJ/PJ'. $string_pj.'.png'.'<br/>'; 
echo   '-----------<br/>';

}
}
}


}



}




}






?>