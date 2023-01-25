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
  <?php 

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$quoi = $ville =  "";
$quoi = isset($_GET['quoi']) ? $_GET['quoi'] : NULL;
$ville = isset($_GET['ville']) ? $_GET['ville'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($_SERVER["REQUEST_METHOD"] == "GET") { 
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
  ?>
<div class="jumbotron text-center">
  <h1>Moteur de recherche</h1>
  <p>Voir la liste</p> 
</div>
  
<div class="container">
  <div class="row">
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <div class="col-sm-4">
  Numero ICE : <input type="text" name="quoi" value="<?php echo $quoi;?>"   required>

  <br><br>
   </div>
    <div class="col-sm-4">
  <!-- ville: <input type="text" name="ville"   value="<?php echo $ville;?>"  required> -->

  <br><br>
</div>
  <div class="col-sm-4">
  <input type="submit" name="submit" value="Envoyer">
    <br><br>
</div>  
</form>

  </div> 
  <div class="row">
    <div class="col-sm-4">


      <?php 
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

   print_r($res );
    die('');


      $total        = $res['hits']['total']['value'];
           
           $limit = 10;

           $pages = ceil($total / $limit);
              $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

                $offset = ($page - 1)  * $limit;
                $start = $offset + 1;
                $end = min(($offset + $limit), $total);
    /*              echo    $total." total<br/>";
                  echo    $pages." pages<br/>";
                  echo    $start." start<br/>";
                  echo    $end." end<br/>";*/
                  

             

      if ( $total >= 1){

    $milliseconds = $res['took'];
    $maxScore     = $res['hits']['max_score'];
    $score        = $res['hits']['hits'][0]['_score'];

  
           echo "<h2> le Total :".$total."</h2>";
}
else{
  echo 'no result';
}


    }

$b=(( $end -$from));


    if ($total ){
           for ($x = 0; $x < $b ; $x++) {

            
echo '<div class="article">';
  echo "<h3> the score : ".$res['hits']['hits'][$x]['_score']."</h3>";
    echo "<h3>".$res['hits']['hits'][$x]['_source']['rs_comp']."</h3>";
    echo "<p> Ville principale :".$res['hits']['hits'][$x]['_source']['ville']."</p>";
    echo "<p> Code firme :".$res['hits']['hits'][$x]['_source']['code_firme']."</p>";
    echo "<p> Poid : ".$res['hits']['hits'][$x]['_source']['poid']."</p>";
       echo "<p> ICE : ".$res['hits']['hits'][$x]['_source']['ice']."</p>";
    foreach ($res['hits']['hits'][$x]['_source']['rubriques'] as $value) {

echo  '----------- :'.$value['rubrique'].'<br/><br/>';
/*echo  '-----------Code    :'.$value['code'].'<br/><br/>';
echo  '------------Slug    :'.$value['slug'].'<br/><br/>';*/
  
   
}
echo  'Villes de recherche : <br/><br/>';
    foreach ($res['hits']['hits'][$x]['_source']['villes'] as $value) {
echo  '-----------   :'.$value['name'].'<br/><br/>';

}
    echo '</div>';
?>
    
<?php } }

    $prevlink = ($page > 1) ? ' <a href="start.php?quoi=Pharmacie+Mars&ville=casablanca&submit=Submit&page=' . ($page - 1) . '" title="Previous page" class="page-link">Précédent</a>' : '<a class="page-link" href="#" disabled>Précédent </a>';

    // The "forward" link
    $nextlink = ($page < $pages) ? ' <a href="start.php?quoi=Pharmacie+Mars&ville=casablanca&submit=Submit&page=' . ($page +1) . '" title="suivant page" class="page-link">Suivant</a>' : '<a class="page-link" href="#" disabled>Suivant </a>';

    // Display the paging information

      ?>
    
    </div>
    
  </div>


<?php if (9<$total){ ?>
  <div class="row">
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><?php echo $prevlink; ?></li>

    <?php

for ($p = 1; $p <= $pages ; $p++) { 
echo '    <li class="page-item"><a class="page-link" href="'.$actual_link.'&page='.$p.'">'.$p.'</a></li>';
}

     ?>
    <li class="page-item"><?php echo $nextlink; ?></li>
  </ul>
</nav>
  </div> 

<?php } ?>

</div>

</body>
</html>

