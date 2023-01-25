<?php 

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



$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$result = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme', `rs_comp`, `rs_abr`,code_statut , villes.ville as ville,forme_jur, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( comp_num_voie, '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,rc,ref_ann_leg,cap,email FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartiers ON quartiers.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur`
LEFT JOIN lien_email AS mail ON mail.`code_firme` = firmes.`code_firme` AND mail.num_ordre =1 where code_fichier != 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8)
 LIMIT 10000");


ini_set('memory_limit', '-1');

set_time_limit(500); // 


    
         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'telecontact29'
            
         );
 


if (!empty($result)) {

foreach($result as $row) {          
if ($row["code_firme"]){
$rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` LIKE '".$row["code_firme"]."' AND lien.`editable` LIKE '+'"); 


$dirigeant = $myPDO->prepare("SELECT civilite.civilite AS civilite, nom, prenom
FROM `lien_dirigeant`
INNER JOIN personne ON lien_dirigeant.`code_personne` = personne.code_personne
LEFT JOIN civilite ON civilite.code = personne.civilite
WHERE `code_firme` LIKE '".$row["code_firme"]."'
AND lien_dirigeant.`code_fonction` NOT LIKE '0%'
ORDER BY `code_fonction` ASC LIMIT 1"); 

$dirigeant->execute();
$result_dirigeant = $dirigeant->fetch();
if($result_dirigeant){
$dirigeant_name= $result_dirigeant["civilite"].' '.$result_dirigeant["nom"].' '.$result_dirigeant["prenom"];
}else{

$dirigeant_name ='';

}

$secursale=$myPDO->query("SELECT firmes.`code_firme` AS 'code_firme', `rs_comp` , `rs_abr` , SUBSTRING_INDEX( `status` , ' ', 1 ) AS
status , villes.ville AS ville, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( comp_num_voie, '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse', `tel` , fax
FROM `firmes`
INNER JOIN villes ON villes.code = firmes.code_ville
LEFT JOIN quartiers ON quartiers.code = firmes.code_quart
LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme`
AND t.num_ordre =1
LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme`
AND fx.num_ordre =1
LEFT JOIN lien_email AS mail ON mail.`code_firme` = firmes.`code_firme`
AND mail.num_ordre =1
LEFT JOIN statuts ON statuts.code = code_statut
WHERE `code_firme_mere` LIKE '".$row["code_firme"]."'
AND code_fichier != 'O20'
AND maj_k NOT
IN ( 0, 8 )
AND maj_n NOT
IN ( 0, 8 )");




}
$poid =1;

if ($row["code_firme"]=='MA3207150'){$poid =20;}
if ($row["code_firme"]=='MA3207099'){$poid =5;}
if ($row["code_firme"]=='MA3228587'){$poid =3;}
if ($row["code_firme"]=='MA3228922'){$poid =7;}
if ($row["code_firme"]=='MA3207331'){$poid =10;}   

     if ($row["code_statut"]=='A' OR $row["code_statut"]=='B' ){$type='Siège'  ;  } else{$type='Succursale'  ;    }                                                           // working here 

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

                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'poid'           => $poid,
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'tel1'           => $row["tel"],
                                                                     'longitude'      => $row["longitude"],
                                                                     'latitude'       => $row["latitude"],
                                                                     'rc'             => $row["rc"],
                                                                     'ice'            => $row["ref_ann_leg"],
                                                                     'capital'        => $row["cap"],
                                                                     'fax'            => $row["fax"],
                                                                     'mail'           => $row["email"],
                                                                     'dirigeant'      => $dirigeant_name,
                                                                     'forme_juridique'=> $row["forme_jur"],
                                                                     'type_d_etablissement'=> $type, 
                                                                        
                                                                     

                                                                     );

                                                                      if ($row["code_firme"]){ 

                                                                                // nested mot cles 

                                                                        if (!empty($rub)) { 
 
                                                                            $mot =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
                                                                                             
                                                                                            
                                                                                    }

                                                                         }
                                                                                // end nested mot cles 



                                                                                // nested mot succursale 

                                                                        if (!empty($secursale)) { 

                                                                          
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

                                                                         }
                                                                                // end nested succursale 







                                                                                       // nested villes 

                                                                        if (!empty($row["ville"])) { 
 
                                                                            $villes =array();
                                                                  
                                                                                     $villes[]=  array( 'name' => $row["ville"]  );
                                                                                                            
                                                                                  if ($row["code_firme"]=='MA3228922'){ $villes[]= array('name' => 'casablanca');}
                                                                                            
                                                                               

                                                                         }
                                                                                // end nested villes

                                                                     }


                                                                     $new_array = array('mot_cle' => $mot);
                                                                     $second_array = array('villes' => $villes);
                                                                     $secu = array('succursale' => $secursa);




                                                                     $doc       =array_merge($doc, $new_array);
                                                                     $doc       =array_merge($doc, $second_array);
                                                                     $doc       =array_merge($doc, $secu);

                                                                      $now = array('_id'  => $row["code_firme"]);
                                                                     $params       =array_merge($params, $now);
                                                                    
                                                                   // work end here    


             
             $set = array(
                 array('index'=> $params),
                 $doc
             );
             $sets[] = $set;
         }
 

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
         $requestURL = 'https://elastic:HHln35H46Gya5c3V4Asw18lV@e0576074ddd34351ab8aab5f247ce34a.eastus2.azure.elastic-cloud.com/_bulk';
         curl_setopt($conn, CURLOPT_URL, $requestURL);
         curl_setopt($conn,CURLOPT_HTTPHEADER, $header);
         curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, FALSE);
         curl_setopt($conn, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($conn, CURLOPT_FAILONERROR, FALSE);
         curl_setopt($conn, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
         curl_setopt($conn, CURLOPT_FORBID_REUSE, 0);
 
         if (is_array($body) && count($body)) {
             curl_setopt($conn, CURLOPT_POSTFIELDS, json_encode($body));
         } else {
             curl_setopt($conn, CURLOPT_POSTFIELDS, $body);
         }
         
         $response = curl_exec($conn);
         echo $response;

?>