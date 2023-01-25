<?php

/* Start search engine */

// redirect if has ?page on /liens/ link or /maroc/

if (strpos($_SERVER['REQUEST_URI'] , '?page=') !== false) {

   $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

   $actual_link = str_replace('?' , '&' , $actual_link);

   header('Location: ' . $actual_link);

}

$language = empty($_GET["lang"]) ? "fr" : $_GET["lang"];

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return round($angle * $earthRadius);
}

$rand =rand(1,4);

   $request_uri = $_SERVER["REQUEST_URI"];
   $pos = strpos($request_uri, '&');

   if ($pos === false) {
      $actual_link = $request_uri;
   }else{
      $actual_link = substr($request_uri,0,$pos);
   }

   $lat= $_GET["lat"];
   $long= $_GET["lng"];
  $kilom= isset($_GET['km']) && !empty($_GET["km"]) ? $_GET["km"] : '20km';
   
   $page = isset($_GET['page']) ? $_GET['page'] : 1;
   if ($_SERVER["REQUEST_METHOD"] == "GET") {
       $string = test_input($string);
       $ou = test_input($ou);
   }
   if($ou=='casa')$ou='casablanca';

   function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
   }

     if($page >=1){
     if ($page==1){$from=0;}
     else{
       $from= ($page-1) *20 ;
     }
    }else{

      $from=0;
    }

      if ( $string && $ou){
    if ( $string && $ou != "Autour de moi"){

if( $ou=="national"){
   $param = '{

  "from": '.$from.',
  "size": 20,
  "sort":[

{ "_score": { "order": "desc" }},
         {
         "poid":"desc"
      }, {
         "name_search.raw":"asc"
      }

   ],
"query": {
    "function_score": {

   "query":{
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
               }
   },


      "functions": [


        {
          "filter": { "range": { "poid":  {
                "gte" : 5
            } } },
          "weight": 6
        }
      ],


      "boost_mode": "replace"







  }

   }
}


';


}
else{
// traitement

  $weight =(rand(4,15));
   $param = '{

  "from": '.$from.',
  "size": 20,
  "sort":[

{ "_score": { "order": "desc" }},
         {
         "poid":"desc"
      }, {
         "name_search.raw":"asc"
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
          "filter": { "match": { "limitrophe": "'.$ou.'" } },
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


}




     }



     elseif($ou == "Autour de moi"){

           $param = '{

        "from": '.$from.',
        "size": 20,
        "sort":[

      { "_score": { "order": "desc" }},
               {
               "poid":"desc"
            } , {
                  "_geo_distance" : {
                      "pin.location" : {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                      },
                      "order" : "asc",
                      "unit" : "km"
                  }
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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }
      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

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
                  }

      ],
            "filter": {
              "geo_distance": {
                "distance": "'.$kilom.'",
                "pin.location": {
                  "lat": "'.$lat.'",
                  "lon": "'.$long.'"
                }
              }
            }

      }


      }





               ]
            }

         },


            "functions": [


              {
                "filter": { "range": { "poid":  {
                      "gte" : 5
                  } } },
                "weight": 6
              }
            ],


            "boost_mode": "replace"







        }

         }
      }


      ';
      }

   } else if($string != "" && !$ou) {
      $param = '{

         "from": '.$from.',
         "size": 20,
         "sort":[
       
       { "_score": { "order": "desc" }},
                {
                "poid":"desc"
             }, {
                "name_search.raw":"asc"
             }
       
          ],
       "query": {
           "function_score": {
       
          "query":{
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
                      }
          },
       
       
             "functions": [
       
       
               {
                 "filter": { "range": { "poid":  {
                       "gte" : 5
                   } } },
                 "weight": 6
               }
             ],
       
       
             "boost_mode": "replace"
       
       
       
       
       
       
       
         }
       
          }
       }
       
       
       ';
       
   }

/*echo $param ;
die();
*/


   if(!empty($string)) {
    $header = array(
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_search?pretty');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "elastic/cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $res =json_decode($res, true);

    /*print_r($res );*/
    /*die('here');*/


      $total        = $res['hits']['total']['value'];

     $limit = 20;

     $total_p = $total <= 100 ? $total : 100;

     $pages = ceil($total_p / $limit);
      $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
      )));

      $offset = ($page - 1)  * $limit;
      $start = $offset + 1;
      $end = min(($offset + $limit), $total);

   }

   $b=(( $end -$from));

   function get_current_url($string , $ou , $lat , $lng , $current , $isPrevLink = false , $isNextLink = false) {

      if ($isPrevLink == true) $current =  ($current - 1);
      else if ($isNextLink == true) $current = ($current + 1);
      else $current = $current;

      if (strpos($_SERVER['REQUEST_URI'], '/trouver/index.php?string=') !== false) {

         return '/trouver/index.php?string='.$_GET["string"].'&ou='.str_replace(" " , "+" , stripslashes($ou)) . $lat . $lng .'&nxo=moteur&nxs=process' . '&page=' . $current;

      } else if (strpos($_SERVER['REQUEST_URI'] , '/trouver/maroc.php?string=' . $_GET["string"] . '&produit=') !== false) {

         return '/trouver/maroc.php?string=' . $_GET["string"] . '&produit=&nxo=moteur&nxs=process' . '&page=' . $current;

      } else if (strpos($_SERVER['REQUEST_URI'] , '/trouver/index.php?nxo=recherche_marques&nxs=process') !== false) {

         return '/trouver/index.php?nxo=recherche_marques&nxs=process&recherche=marques&marque=' . $_GET["string"] . '&produit=national' . '&page=' . $current;
      
      } else if (strpos($_SERVER['REQUEST_URI'] , '/trouver/index.php?nxo=reverse_moteur&nxs=process&recherche=reverse') !== false) {

         return '/trouver/index.php?nxo=reverse_moteur&nxs=process&recherche=reverse&tel='.$_GET["string"] . '&page=' . $current;
      
      } else if (strpos($_SERVER["REQUEST_URI"] , '/liens' . '/' . $_GET["string"] . '/' . $_GET["ou"] . '.php') !== false) { 

         return '/liens/' . $_GET["string"] . '/' . $_GET["ou"] . '.php' . '&page=' . $current;

      } else if (strpos($_SERVER['REQUEST_URI'] , '/maroc/' . $_GET["string"] . '.html') !== false) {

         return '/maroc/' . $_GET["string"] . '.html' . '&page=' . $current;

      }
   }

    $prevlink = ($page > 1) ? ' <a href="' . (get_current_url($string , $ou , $lat , $lng , $page , true , false)) . '" title="Previous page" class="page-link">Précédent</a>' : '<a class="page-link" href="#" disabled>Précédent </a>';

    // The "forward" link
    $nextlink = ($page < $pages) ? ' <a href="' . (get_current_url($string , $lat , $lng , $ou , $page , false , true)) . '" title="suivant page" class="page-link">Suivant</a>' : '<a class="page-link" href="#" disabled>Suivant </a>';

    // Display the paging information
   /* End search engine */


?>
