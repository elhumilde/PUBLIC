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



// $quoi =preg_replace('/\s+/', '', $quoi);

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

  

/*print_r($res['hits']['hits'][0]['_source']);
die();
  */
      $total        = $res['hits']['total']['value'];







// first result of quoi  start

    if ($total ){

           for ($x = 0; $x < $total ; $x++) {

    $string=substr($res['hits']['hits'][$x]['_source']['code_firme'],2);
    $rs_comp =$res['hits']['hits'][$x]['_source']['rs_comp'];
    $pj_desc =$res['hits']['hits'][$x]['_source']['pj_desc'];
    $pj_lien =$res['hits']['hits'][$x]['_source']['pj_lien'];

    $i =$x +1;

    if(  $string){

echo    $rs_comp .'<br/>';
echo    $string .'<br/>';
echo    $pj_desc .'<br/>';
echo    $pj_lien .'<br/>';
echo 'https://www.telecontact.ma/pubs/PJ/PJ'. $string.'.png'.'<br/>'; 
echo   '-----------<br/>';

}
}
}




// first result of quoi  end here





// second result of ville ou


?>

 <!-- end here  -->

    </div>

  </div>




</div>

</body>
</html>
