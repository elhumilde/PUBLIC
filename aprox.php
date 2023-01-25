<!DOCTYPE html>
<html lang="en">
<head>
  <title>Starting</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">  .article{  border: 1px solid #dee2ef;border-radius: 4px;padding: 1%; margin: 1%; line-height: 10px; }</style>
</head>
<body>


<div class="container">

  <div class="row">
    <div class="col-sm-4">


 <!-- start from here  -->

      <?php

        // par mot cles  $quoi

      $quoi ='edicom';

// $quoi =preg_replace('/\s+/', '', $quoi);

/*   $param = '{

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
                               "match_phrase_prefix":{
                                "rs_comp_search": {
                                  "query":"'.$quoi.'",
                                  "slop": 2
                                  }
                               }
                            },
            { "exists": {"field": "longitude"}}
        

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


';*/


 $param = '{

  "from": 0,
  "size": 1,
  "sort":[

{ "_score": { "order": "desc" }},
 {
         "rs_comp.raw":"asc"
      }

   ],
  "query": {

      "bool":{
                  "must":[

            {
   "match_phrase_prefix":{
                                "rs_comp_search": {
                                  "query":"'.$quoi.'",
                                  "slop": 2
                                  }
                               }
                            
    },
            { "exists": {"field": "longitude"}}

    ]}


  }

}';



/*
 $param = '{

  "from": 0,
  "size": 10,
  "sort":[

{ "_score": { "order": "desc" }},
 {
         "rs_comp.raw":"asc"
      }

   ],
              "query": {

                 "bool":{
                  "must":[
                "match": {
                  "rs_comp_auto": {
                    "query": "' . $quoi . '",
                    "operator": "and",
                    "fuzziness": 2
                  }
                }

                ]}



              }

}

';*/

    $header = array(
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://elastic:i4swxqQePLQaqa7YuhiFX1ui@edicom.es.francecentral.azure.elastic-cloud.com/telecontact42/_search?pretty');
    curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
    curl_setopt ($curl, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
    $res = curl_exec($curl);
    curl_close($curl);
    $res =json_decode($res, true);
    print_r(   $res);
    die('ici');
      $total        = $res['hits']['total']['value'];







 ?>

 <!-- end here  -->

    </div>

  </div>




</div>

</body>
</html>
