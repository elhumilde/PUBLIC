<?php 
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$quoi = $ville =  "";
$quoi = isset($_POST['quoi']) ? $_POST['quoi'] : NULL;
$ville = isset($_POST['ville']) ? $_POST['ville'] : NULL;
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


    if ( $quoi ){ 
$quoi =preg_replace('/\s+/', '', $quoi);

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

           { "match": { "ice" : { "query" : "'.$quoi.'" } } }
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