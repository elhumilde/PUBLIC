<?php 
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$quoi = $ville =  "";
$quoi = isset($_POST['quoi']) ? $_POST['quoi'] : NULL;
$ville = isset($_POST['ville']) ? $_POST['ville'] : NULL;

// if (isset($_GET['quoi']) && isset($_GET['ville'])) {
//    echo $_GET['quoi'] . "<br/>" . $_GET['ville'];
//    die();
// }

$page = isset($_POST['page']) ? $_POST['page'] : 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $quoi = test_input($quoi);
    $ville = test_input($ville);
}
if($ville=='casa')$ville='casablanca';

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

      if($page >=1){
      if ($page==1){$from=0;}
      else{
        $from= ($page-1) *10 ;
      }
    }else{

      $from=0;
    }
      if ( $quoi && $ville){ 

$string=$quoi;
$ou=$ville;
  $weight =(rand(4,15));
   $param = '{

  "from": '.$from.',
  "size": 10,
  "sort":[

{ "_score": { "order": "desc" }},
         {
         "poid":"desc"
      }, {
         "rs_comp.raw":"asc"
      }

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
                           "path":"villes3",
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
                     }

]

}


}





         ]
      }

   },


      "functions": [
        {
          "filter": { "match": { "ville": "'.$ou.'" } },
          "weight": 8
        },

        {
          "filter": { "range": { "poid":  {
                "gte" : 6
            } } },
          "weight": 30
        }

        ,
        {
          "filter": { "range": { "poid":  {
                "lte" : 4
            } } },
          "weight": 0
        }

        ,
          {
          "filter": { "range": {  "poid":  {
                "gte" : 4,
                "lte" : 6
            } } },
           "random_score": {  }, 
             "weight": "25" 
        }
      ],


      "boost_mode": "replace"








  }

   }
}


';


/*echo $param ;
die();
*/

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
    echo json_encode($res);
   }

