<?php

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



//   $lat=33.5413248;
//   $long=-7.6480512;
  $kilom='3km';

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$quoi = $ville =  "";
$quoi = isset($_POST['quoi']) ? $_POST['quoi'] : NULL;
$ville = isset($_POST['ville']) ? $_POST['ville'] : NULL;
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$lat = isset($_POST['latitude']) ? $_POST['latitude'] : 33.5127378;
$long = isset($_POST['longitude']) ? $_POST['longitude'] : -7.6598186;
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

      if (!empty($quoi)){



     $param = '{
    
  "from": '.$from.',
  "size": 10,
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
                           "query":"'.$quoi.'",
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
                                          "query":"'.$quoi.'",
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
/*echo $param ;
die();
*/



    $header = array(
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_search?pretty');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $res =json_decode($res, true);

    $total        = $res['hits']['total']['value'];

    if ($total ){
      for ($x = 0; $x < count($res['hits']['hits']) ; $x++) {

                            $latitude = $res['hits']['hits'][$x]['_source']['latitude'];

                            $longitude = $res['hits']['hits'][$x]['_source']['longitude'];



                               $distance = haversineGreatCircleDistance($latitude , $longitude , $lat , $long . ' mètre');

                               $res['hits']['hits'][$x]['_source']['distance'] = $distance;
      }
    }



    echo json_encode($res);

 /*   print_r($res );
    die('');
   */

}