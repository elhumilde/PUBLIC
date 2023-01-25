<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


 $datetime = new DateTime( "now", new DateTimeZone( "Africa/casablanca" ) );


$datetime=$datetime->format( 'd-m-Y H:i:s' );
  
  function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
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
/*$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

*/

$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
$myediprv = new PDO('mysql:host=localhost;dbname=ediprv', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );


 
$sth = $myPDO->query("SELECT test.code_firme as code_firme,id_user, rs_comp, ville,rs_abr, COALESCE(rdv,'1') as rdv , (CASE
    WHEN code_fichier in ('H53', 'H55', 'H56' )  THEN 1
    else  2
 END ) as type,REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( comp_num_voie, '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,email,apparaitre_tel_rdv
FROM BD_EDICOM.`firmes` as test
LEFT JOIN telecontact_BackOffice_Site.`rdv` As tbsv ON test.`code_firme`= CONCAT('MA', tbsv.`code_firme`) and active=2
LEFT JOIN BD_EDICOM.`villes` as A ON test.`code_ville` = A.code
LEFT JOIN quartiers ON quartiers.code = test.code_quart
LEFT JOIN lien_telephone AS t ON t.`code_firme` = test.`code_firme` AND t.num_ordre =1 
LEFT JOIN lien_fax AS fx ON fx.`code_firme` = test.`code_firme` AND fx.num_ordre =1 
LEFT JOIN lien_email AS mail ON mail.`code_firme` = test.`code_firme` AND mail.num_ordre =1  

WHERE `code_fichier`
IN ('H53', 'H55', 'H56','H63' ,'H65' ,'H73' ,'H54' ,'H50','H78','H67')AND maj_k NOT
IN ( 0, 8 )
AND maj_n NOT
IN ( 0, 8 ) and erdv=1 
 "); 
/*    $stmt = $myPDO->prepare($sql);
    $stmt->execute();
*/
/*    $i=0;
   while ($row = $sth->fetch() ) {
        
      echo  $row['code_firme']."<br/>";
      
    }
        die("here");
*/

/*        $half   = floor(($sth->rowCount())/2);
$count  = 0;

$result= $sth->fetch();

while(   $row = $sth->fetch()) {   

      echo  $row['code_firme']."<br/>";
   }


    die('ici');*/

ini_set('memory_limit', '-1');

set_time_limit(500000000000); // 


    
         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'erdv4'
            
         );
 



    


$half   = floor(($sth->rowCount())/1);
$count  = 0;
$midlle   = $half;
// $result= $sth->fetch();

while(   $count <= $half && $row = $sth->fetch()) {      



       $renvoi_data =array();




if ($row["code_firme"]){
$rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique,Lib_Rubrique_Papier FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` = '".$row["code_firme"]."' AND lien.`editable` = '+' LIMIT 1"); 
}


/*$dirigeant = $myPDO->prepare("SELECT civilite.civilite AS civilite, nom, prenom
FROM `lien_dirigeant`
INNER JOIN personne ON lien_dirigeant.`code_personne` = personne.code_personne
LEFT JOIN civilite ON civilite.code = personne.civilite
 LEFT JOIN `fonction` AS f ON f.`code` = lien_dirigeant.`code_fonction` AND f.`apparaitre` = 2
WHERE `code_firme` LIKE '".$row["code_firme"]."'
AND (lien_dirigeant.`code_fonction` NOT LIKE '0%'  OR lien_dirigeant.`code_fonction` ='0116' )
ORDER BY `code_fonction` ASC LIMIT 1"); 

$dirigeant->execute();
$result_dirigeant = $dirigeant->fetch();
if($result_dirigeant){
$dirigeant_name= $result_dirigeant["civilite"].' '.$result_dirigeant["nom"].' '.$result_dirigeant["prenom"];
}else{

$dirigeant_name ='';

}
*/


     // if ($row["code_statut"]=='A' OR $row["code_statut"]=='B' ){$type='Siège'  ;  } else{$type='Succursale'  ;    }                                                           // working here 

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
                                                                     
                                                                    // Test if string contains the word 
                                                                    if(strpos($mystring, $word) !== false){
                                                                        $search =  str_replace(".","",$mystring);
                                                                        $search =$search.' '.$row["rs_comp"].' '.$row["rs_abr"];
                                                                    } else{
                                                                        $search =$row["rs_comp"].' '.$row["rs_abr"];
                                                                    }
                                                                    
                                                                    $ville_slug =adilsoft_string_latin($row["ville"]);
                                                                    $ville_slug =slugify($ville_slug);
                                                                    
                                                            


                                                                    $pin =array();
                                                                           if ( !empty($row["latitude"])  and  !empty($row["longitude"]) ) {
                                                                    $pin =  array('location' =>  array('lat' => $row["latitude"],'lon' => $row["longitude"]));
                                                                        }
                                                                            $code_f=substr($row["code_firme"],2);

                                                                          $agenda_url='https://www.e-rdv.ma/rdv/'.$slug.'/'.$code_f.'.html';
                                                                          $fiche_url ='https://www.e-rdv.ma/rendez-vous-avec/'.$slug.'/'.$code_f.'/'.$row['id_user'].'.html';    
                                                                            if (empty($row["longitude"])){
                                                                      $long=null;
                                                                        }else{

                                                                      $long=$row["longitude"];
                                                                        }


                                                                        if (empty($row["latitude"])){
                                                                      $latt =null;              
                                                                        }else{
                                                                      $latt =$row["latitude"];         
                                                                        }                                                                                    

                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => trim($search),
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => trim($row["adresse"]),
                                                                     'longitude'      => $long,
                                                                     'latitude'       => $latt,
                                                                     'fax'            => $row["fax"],
                                                                     'mail'           => $row["email"],
                                                                     'agenda_id'      => $row['rdv'],
                                                                     'type'           => $row['type'],
                                                                     'id_user'        => $row['id_user'],
                                                                     'agenda_url'     => $agenda_url,
                                                                     'fiche_url'      => $fiche_url,
                                                                     );




                                            
                                                                                // nested mot cles 

                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );


                                                            $renvoi_data[]=       array('mot' =>  $key["Lib_Rubrique_Papier"], 'code' => $key["code_rubrique"], 'slug' => '', );


                                                             $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` ='".$key["code_rubrique"]."'"); 

                                                               if (!empty($renvois)) { 
                                                                         foreach ($renvois as $ren ) {
                                                                                      $renvoi_data[]=       array('mot' =>  $ren["Lib_Rubrique"], 'code' => $ren["Code_Rubrique"], 'slug' => '', );

                                                                           $renvoi_data[]=       array('mot' =>  $ren["Lib_Rubrique_Papier"], 'code' => $ren["Code_Rubrique"], 'slug' => '', );
                                                                                    }

                                                                         }
                                                                                            
                                                                                    }

                                                                         }
 $renvoi_data       =array_merge($renvoi_data, $mot_data);



                                                                                // end nested mot cles 



                                                                                // nested mot succursale 


 // reasons start 
$code_firme_res = substr($row["code_firme"], -7);
    $reasons_array=array();
if ($row['rdv'] ==2){


            $query_reasons=$myediprv->query("SELECT * FROM `ct_services` WHERE `id_med` ='" . $code_firme_res . "'");
  
  if (!empty($query_reasons)) {  



                foreach ($query_reasons as $reasons ) {
                     $reasons_array[]=       array('title' =>  utf8_decode($reasons["title"]), 'code' => $reasons["id"], 'description' => utf8_decode($reasons["description"]), );
                         }
  }

}

 // reasons end 


$secursa=array();
                                                            /*            if (!empty($secursale)) { 

                                                                          
                                                                            $secursa=array();
                                                                                    foreach ($secursale as $suc) {
                                                                                     $secursa[]=       array(
                                                                                                 'code_firme' =>  $suc["code_firme"],
                                                                                                 'type'       =>  $suc["status"],
                                                                                                 'rs'         =>  $suc["rs_comp"],
                                                                                                 'tel'        =>  $suc["tel"],
                                                                                                 'fax'        =>  $suc["fax"],
                                                                                                 'adresse'    =>  $suc["adresse"],
                                                                                                 'ville'      =>  $suc["ville"],
                                                                                                 'rs_slug'    =>  slugify(adilsoft_string_latin($suc["rs_comp"])),
                                                                                                 'ville_slug' =>  slugify(adilsoft_string_latin($suc["ville"])),
                                                                                            );
                                                                                             
                                                                                            
                                                                                    }

                                                                         }*/
                                                                                // end nested succursale 







                                                                                       // nested villes 

                                                                        if (!empty($row["ville"])) { 
 
                                                                            $villes_data =array();
                                                                  
                                                                                     $villes_data[]=  array( 'name' => $row["ville"]  );
                                                                                                            
                                                                           
                                                                                            
                                                                               

                                                                         }
                                                                                // end nested villes








$national_doc =array();
$national =array();





$rubriques = array();
$prestations = array();
$mot_cles =array();
$poid = 1;
if ($row['rdv'] ==2){$poid = 4;}
$villes =array();
$villes1 =array();
$mot_cles1 =array();

$rubriques =  $mot_data;

/*if (empty($villes)) {
                $second_array = array('villes' => $villes_data);
                $villes_array1  = array('villes1' => $villes_data);
}else{
                $second_array = array('villes' => $villes);
                $villes_array1  = array('villes1' => $villes);
}*/
if (empty($mot_cles)){
        $national       =array_merge($national, $renvoi_data);
}
else{
        $national       =array_merge($national, $mot_cles1);
}
                                                               
$reasons_array_arr =array('reasons'=>$reasons_array);
$rubriques_arr =    array('rubriques'=>$rubriques);
$prestations_arr =  array('prestations' => $renvoi_data);
$poid_arr =         array('poid'=> $poid);


if (  $pin ){
$pining =  array('pin' => $pin);
 $doc       =array_merge($doc, $pining);

}


                                        if ($row["apparaitre_tel_rdv"]==1){
                                                     $tel_arr=array('tel1'=> $row["tel"] );
                                                       $doc       =array_merge($doc, $tel_arr);
                                                }else{

                                                             $tel_arr=array('tel1'=> null );
                                                       $doc       =array_merge($doc, $tel_arr);
                                                }


                                                                     $national_doc =array('national'=> $national );
                                                                      $doc       =array_merge($doc, $national_doc);




                                                                     // $doc       =array_merge($doc, $villes_array1);


        
                                                                     $doc       =array_merge($doc, $rubriques_arr);
                                                                     $doc       =array_merge($doc, $prestations_arr);
                                                                     $doc       =array_merge($doc, $poid_arr);
                                                                     $doc       =array_merge($doc, $reasons_array_arr);

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

?>