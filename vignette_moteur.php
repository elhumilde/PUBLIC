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

      $quoi ='Ménara Fournitures Electriques Méfélec';

      if ( $quoi ){
// $quoi =preg_replace('/\s+/', '', $quoi);

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


      $total        = $res['hits']['total']['value'];

if ($total ){ echo 'yes';}
  else{
    echo 'no';
  }
die('');
if ( $total == 4){

        $autre=1;

    }elseif($total>4){
      $total = 4;
      $autre =$total - 4;
    }elseif($total<4){
            $autre = 4-$total;
            $autre = $autre + 1;

    }




    }


      // par ville ou

    $ville ='casablanca';

    if($ville){

         $param_ville = '{

  "from": 0,
  "size": '.$autre.',
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
                           "path":"vignette_vl_localites",
                           "query":{
                              "bool":{
                                 "must":[
                                    {
                                       "match_phrase_prefix":{
                                       "vignette_vl_localites.vv_localites":  {
                                          "query":"'.$ville.'",
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
            "vignette_vl" : "1"
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


    $header_ville = array(
        'Content-Type: application/json'
    );

    $curl_ville = curl_init();
    curl_setopt($curl_ville, CURLOPT_URL, 'http://edicomelastic1.odiso.net:9200/telecontact42/_search?pretty');
    curl_setopt($curl_ville,CURLOPT_HTTPHEADER, $header_ville);
    curl_setopt ($curl_ville, CURLOPT_CAINFO, "cacert.pem");
    curl_setopt($curl_ville, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_ville, CURLOPT_POSTFIELDS, $param_ville);
    $res_ville = curl_exec($curl_ville);
    curl_close($curl_ville);
    $res_ville =json_decode($res_ville, true);
/*print_r(    $res_ville);
die();*/

      $total_ville        = $res_ville['hits']['total']['value'];



    }


// first result of quoi  start

    if ($total ){

           for ($x = 0; $x < $total ; $x++) {

    $string=substr($res['hits']['hits'][$x]['_source']['code_firme'],2);
    $rs_comp =$res['hits']['hits'][$x]['_source']['rs_comp'];
    $i =$x +1;

    if(  $string){

        ?>    <script>
                                                    pageTracker._trackEvent('vignettes', 'rubrique', '<?php echo("".$string." - ".$rs_comp.""); ?>', <?php echo ($i); ?>);

            </script>
<?php

/*    echo "<h3>".$res['hits']['hits'][$x]['_source']['rs_comp']."</h3>";

    echo "<p> Code firme :".$res['hits']['hits'][$x]['_source']['code_firme']."</p>";*/


    echo '<p>Annonce</p>';
    echo '<embed src="/pubs/vignettes/V'.$string.'/index.html" width="300" height="250">';


}
} }




// first result of quoi  end here





// second result of ville ou



    if ($total_ville >=1 ){


           for ($x_ville = 0; $x_ville < $total_ville ; $x_ville++) {

/*    echo "<h3>".$res_ville['hits']['hits'][$x_ville]['_source']['rs_comp']."</h3>";

    echo "<p> Code firme :".$res_ville['hits']['hits'][$x_ville]['_source']['code_firme']."</p>";*/


    $string_ville=substr($res_ville['hits']['hits'][$x_ville]['_source']['code_firme'],2);
    $rs_comp_ville =$res_ville['hits']['hits'][$x_ville]['_source']['rs_comp'];

    $j =$x_ville+1;


    if( $string_ville){
        ?>    <script>
                                                    pageTracker._trackEvent('vignettes', 'region', '<?php echo("".$string_ville." - ".$rs_comp_ville.""); ?>', <?php echo ($j); ?>);

            </script>
<?php

    echo '<p>Annonce locale</p>';
    echo '<embed src="/pubs/vignettes_regions/V'.$string_ville.'/index.html" width="300" height="250">';


} } }

// second result of ville ou end here


 ?>

 <!-- end here  -->

    </div>

  </div>




</div>

</body>
</html>
