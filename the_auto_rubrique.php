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




 
$sth = $myPDO->query("SELECT id,`Code_Rubrique` , `Lib_Rubrique` FROM `rubriques`"); 



ini_set('memory_limit', '-1');

set_time_limit(500000000000); // 


    
         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'autocomplete_rubriques_2'
            
         );
 


$half   = floor(($sth->rowCount())/3);
$count  = 0;
$midlle   = floor($half*2);
// $result= $sth->fetch();

while(   $count <= $half && $row = $sth->fetch()) {      





                                            
                                                   

                                                                       $slug = adilsoft_string_latin($row["Lib_Rubrique"]);     
                                                                       $slug = slugify($slug);




                                                                    $doc = array(
                                                                     'code_rubrique'              => $row["Code_Rubrique"],
                                                                     'rubrique_auto'              => $row["Lib_Rubrique"],
                                                                     'rubrique'                   => $row["Lib_Rubrique"],
                                                                     'rubrique_slug'              => $slug

                                                                     );

/*                                                                    $doc = array(

                                                                     'quote'        => $search


                                                                     );*/


                                                                      $now = array('_id'  => $row["id"]);
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





                                                                       $slug = adilsoft_string_latin($row["Lib_Rubrique"]);     
                                                                       $slug = slugify($slug);




                                                                    $doc = array(
                                                                     'code_rubrique'              => $row["Code_Rubrique"],
                                                                     'rubrique_auto'              => $row["Lib_Rubrique"],
                                                                     'rubrique'                   => $row["Lib_Rubrique"],
                                                                     'rubrique_slug'              => $slug

                                                                     );

                                                                      $now = array('_id'  => $row["id"]);
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



                                                                       $slug = adilsoft_string_latin($row["Lib_Rubrique"]);     
                                                                       $slug = slugify($slug);




                                                                    $doc = array(
                                                                     'code_rubrique'              => $row["Code_Rubrique"],
                                                                     'rubrique_auto'              => $row["Lib_Rubrique"],
                                                                     'rubrique'                   => $row["Lib_Rubrique"],
                                                                     'rubrique_slug'              => $slug

                                                                     );



                                                                      $now = array('_id'  => $row["id"]);
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