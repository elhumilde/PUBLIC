<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


 $datetime = new DateTime( "now", new DateTimeZone( "Africa/casablanca" ) );


$datetime=$datetime->format( 'd-m-Y H:i:s' );
  
function adilsoft_string_latin($string){
    return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','?','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','?','Î','?', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', '?', "'"), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y', '\''), $string);
}
function slugify($text)
    {
        // Strip html tags
        $text=strip_tags($text);
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Transliterate
        setlocale(LC_ALL, 'en_US.utf8');
        $text = iconv('utf-8', 'utf-8//IGNORE', $text);
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Trim
        $text = trim($text, '-');
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // Lowercase
        $text = strtolower($text);
        // Check if it is empty
        if (empty($text)) { return 'n-a'; }
        // Return result
        return $text;
    }
$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));



$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );




 
$sth = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme', firmes.`rs_comp` as rs_comp , `rs_abr` , villes.ville as ville 

FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville 
LEFT JOIN tts_firme_ajoute  fa on  firmes.code_firme=fa.code_firme  and IFNULL( fa.valide, 0 ) IN ( 0, 2 )

WHERE code_fichier = 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8) AND `code_ville` != ''  and  fa.id is null  "); 



ini_set('memory_limit', '-1');

set_time_limit(500000000000); // 


    
         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'autocomplete_raison_sociale_2'
            
         );
 


$half   = floor(($sth->rowCount())/3);
$count  = 0;
$midlle   = floor($half*2);
// $result= $sth->fetch();

while(   $count <= $half && $row = $sth->fetch()) {      



                                                                   if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }

                                                                        $word = ".";
                                                                        $mystring = $row["rs_comp"];

                                                                                               if(strpos($mystring, $word) !== false){
                                                                        $search =  str_replace(".","",$mystring);
                                                                        $search =$search.' '.$row["rs_comp"].' '.$row["rs_abr"];
                                                                    } else{
                                                                        $search =$row["rs_comp"].' '.$row["rs_abr"];
                                                                    }



                                            
                                                   
                                                                               $slug_ville   = adilsoft_string_latin($row["ville"]); 
                                                                               $slug_ville   = slugify($slug_ville);






                                                                    $doc = array(
                                                                     'code_firme'          => $row["code_firme"],
                                                                     'rs_comp'             => $rs_comp,
                                                                     'rs_comp_auto'        => $search,
                                                                     'rs_comp_slug'        => $slug,
                                                                     'ville_slug'          => $slug_ville,
                                                                     'ville'               => $row["ville"]

                                                                     );

/*                                                                    $doc = array(

                                                                     'quote'        => $search


                                                                     );*/


                                                                      $now = array('_id'  => $row["code_firme"]);
                                                                     $params       =array_merge($params, $now);
                                                                    
                                                                   // work end here    


             
             $set = array(
                 array('index'=> $params),
                 $doc
             );
             $sets[] = $set;



$count++;


}













         foreach ($sets as $set) {
             foreach ($set as $s) {
                 $b[] = json_encode($s);
             }
         }




         $body =  join("\n", $b) . "\n";
             $header = array(
        "Content-Type: application/json" 
    );



         $conn = curl_init();

                  $requestURL = 'http://edicomelastic1.odiso.net:9200/_bulk';

         curl_setopt($conn, CURLOPT_URL, $requestURL);
         curl_setopt($conn,CURLOPT_HTTPHEADER, $header);
         curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($conn, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($conn, CURLOPT_FAILONERROR, TRUE);
         curl_setopt($conn, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
         curl_setopt($conn, CURLOPT_FORBID_REUSE, 0);
 
         if (is_array($body) && count($body)) {
             curl_setopt($conn, CURLOPT_POSTFIELDS, json_encode($body));
         } else {
             curl_setopt($conn, CURLOPT_POSTFIELDS, $body);
         }
         
         $response = curl_exec($conn);
         print_r($response) ;



echo 'hello word <br/>';





// the middle one 
    
         $b = array();
 
         $sets = array();

while(   $count <= $midlle && $row = $sth->fetch()) {      




                                                                   if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }

                                                                        $word = ".";
                                                                        $mystring = $row["rs_comp"];

                                                                                               if(strpos($mystring, $word) !== false){
                                                                        $search =  str_replace(".","",$mystring);
                                                                        $search =$search.' '.$row["rs_comp"].' '.$row["rs_abr"];
                                                                    } else{
                                                                        $search =$row["rs_comp"].' '.$row["rs_abr"];
                                                                    }

                                                                               $slug_ville   = adilsoft_string_latin($row["ville"]); 
                                                                               $slug_ville   = slugify($slug_ville);

/*
                                                                      $doc = array(

                                                                     'quote'        => $search


                                                                     );*/
                                                                      
                                                                    $doc = array(
                                                                     'code_firme'          => $row["code_firme"],
                                                                     'rs_comp'             => $rs_comp,
                                                                     'rs_comp_auto'        => $search,
                                                                     'rs_comp_slug'        => $slug,
                                                                     'ville_slug'          => $slug_ville,
                                                                     'ville'               => $row["ville"]

                                                                     );

                                                                      $now = array('_id'  => $row["code_firme"]);
                                                                     $params       =array_merge($params, $now);
                                                                    
                                                                   // work end here    


             
             $set = array(
                 array('index'=> $params),
                 $doc
             );
             $sets[] = $set;



$count++;


}













         foreach ($sets as $set) {
             foreach ($set as $s) {
                 $b[] = json_encode($s);
             }
         }




         $body =  join("\n", $b) . "\n";
             $header = array(
        "Content-Type: application/json" 
    );



         $conn = curl_init();
         $requestURL = 'http://edicomelastic1.odiso.net:9200/_bulk';
         curl_setopt($conn, CURLOPT_URL, $requestURL);
         curl_setopt($conn,CURLOPT_HTTPHEADER, $header);
         curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($conn, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($conn, CURLOPT_FAILONERROR, TRUE);
         curl_setopt($conn, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
         curl_setopt($conn, CURLOPT_FORBID_REUSE, 0);
 
         if (is_array($body) && count($body)) {
             curl_setopt($conn, CURLOPT_POSTFIELDS, json_encode($body));
         } else {
             curl_setopt($conn, CURLOPT_POSTFIELDS, $body);
         }
         
         $response = curl_exec($conn);
         print_r($response) ;



echo 'hello middle <br/>';


// end of middle one 




// the secon one start from here 

         $b = array();
 
         $sets = array();

while ($row = $sth->fetch()) {  


                                                                   if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }

                                                                        $word = ".";
                                                                        $mystring = $row["rs_comp"];

                                                                                               if(strpos($mystring, $word) !== false){
                                                                        $search =  str_replace(".","",$mystring);
                                                                        $search =$search.' '.$row["rs_comp"].' '.$row["rs_abr"];
                                                                    } else{
                                                                        $search =$row["rs_comp"].' '.$row["rs_abr"];
                                                                    }
 
                                                                               $slug_ville   = adilsoft_string_latin($row["ville"]); 
                                                                               $slug_ville   = slugify($slug_ville);

/*                                                                    $doc = array(

                                                                     'quote'        => $search


                                                                     );*/


                                                                    $doc = array(
                                                                     'code_firme'          => $row["code_firme"],
                                                                     'rs_comp'             => $rs_comp,
                                                                     'rs_comp_auto'        => $search,
                                                                     'rs_comp_slug'        => $slug,
                                                                     'ville_slug'          => $slug_ville,
                                                                     'ville'               => $row["ville"]

                                                                     );



                                                                      $now = array('_id'  => $row["code_firme"]);
                                                                     $params       =array_merge($params, $now);
                                                                    
                                                                   // work end here    


             
             $set = array(
                 array('index'=> $params),
                 $doc
             );
             $sets[] = $set;




}







         foreach ($sets as $set) {
             foreach ($set as $s) {
                 $b[] = json_encode($s);
             }
         }




         $body =  join("\n", $b) . "\n";
             $header = array(
        "Content-Type: application/json" 
    );



         $conn = curl_init();
         $requestURL = 'http://edicomelastic1.odiso.net:9200/_bulk';
         curl_setopt($conn, CURLOPT_URL, $requestURL);
         curl_setopt($conn,CURLOPT_HTTPHEADER, $header);
         curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($conn, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($conn, CURLOPT_FAILONERROR, TRUE);
         curl_setopt($conn, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
         curl_setopt($conn, CURLOPT_FORBID_REUSE, 0);
 
         if (is_array($body) && count($body)) {
             curl_setopt($conn, CURLOPT_POSTFIELDS, json_encode($body));
         } else {
             curl_setopt($conn, CURLOPT_POSTFIELDS, $body);
         }
         
         $response = curl_exec($conn);
         print_r($response) ;


echo 'hello word again';










?>