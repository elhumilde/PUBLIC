<?php 
// die('here');

// waiting to find solution for the hack

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


        function replace_microsolft_apostrophe($string){
        $string = str_replace('’', " ", $string);
        $string = str_replace("'", " ", $string);
        return $string;
    }


$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));



$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

/*$result = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme', `rs_comp`, `rs_abr`,code_statut , villes.ville as ville,forme_jur, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( comp_num_voie, '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,rc,ref_ann_leg,cap,email FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartiers ON quartiers.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur`
LEFT JOIN lien_email AS mail ON mail.`code_firme` = firmes.`code_firme` AND mail.num_ordre =1 where code_fichier != 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8)  ");
*/
/*$count = $myPDO->query("SELECT count(*) as count FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartiers ON quartiers.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur`
LEFT JOIN lien_email AS mail ON mail.`code_firme` = firmes.`code_firme` AND mail.num_ordre =1 where code_fichier != 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8) ");


print_r($count) ;
die();
*/


 
$sth = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme',apparaitre_infos_juridique,apparaitre_tel_tlc, `rs_comp`, `rs_abr`,GAMME_EFF,code_statut , villes.ville as ville,annee_inscr,forme_jur,code_fichier, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( REPLACE(comp_num_voie, 'X', 'Bis'), '' ) , ' ', IFNULL( REPLACE(lib_voie, '- Autre ville', ''), '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartier_nouv.quartier, '' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,rc,ref_ann_leg,cap FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartier_nouv ON quartier_nouv.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur`
LEFT JOIN annonceur_production ON annonceur_production.code_firme = firmes.code_firme
WHERE annonceur_production.code_firme IS NULL
AND code_fichier = 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8) AND code_fichier !='N20'  "); 
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
             '_index' => 'telecontact42'
            
         );
 



        

$half   = floor(($sth->rowCount())/3);
$count  = 0;
$midlle   = floor($half*2);
// $result= $sth->fetch();

while(   $count <= $half && $row = $sth->fetch()) {      




 $tel_1   =  $row["tel"];
 $tel_1_s =  preg_replace('/\s+/', '', $row["tel"]);

// tel1 cheking 
    if(empty($row["tel"])){
       $tel_cheking = $myPDO->query("SELECT * FROM `lien_telephone` WHERE `code_firme` ='".$row["code_firme"]."'  ORDER BY `lien_telephone`.`num_ordre` ASC "); 

                                                               if (!empty($tel_cheking)) { 
                                                                
                                                                         foreach ($tel_cheking as $tel_chek ) {

                                                                                     $tel_1   = $tel_chek["tel"];
                                                                                     $tel_1_s = preg_replace('/\s+/', '', $tel_chek["tel"]);
                                                                                    }

                                                                         }
    }
                                                                               
//tel1 end checking
/*echo  $tel_1.'<br/>';
echo  $tel_1_s ;

die('here');
*/


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
$dirigeant_name ='';

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
                                                                    
                                                            


                                                                    $pin =array();
                                                                           if ( strlen(trim($row["latitude"]))  and  strlen(trim($row["longitude"])) ) {
                                                                    $pin =  array('location' =>  array('lat' => $row["latitude"],'lon' => $row["longitude"]));
                                                                        }

 $eff='';

if ($row["GAMME_EFF"] =='A'){ $eff='De 1 à 9';}
elseif($row["GAMME_EFF"] =='B'){ $eff='De 10 à 19';}
elseif($row["GAMME_EFF"] =='C'){ $eff='De 20 à 49';}
elseif($row["GAMME_EFF"] =='D'){ $eff='De 50 à 99';}
elseif($row["GAMME_EFF"] =='E'){ $eff='De 100 à 249';}
elseif($row["GAMME_EFF"] =='F'){$eff='De 250 à 499' ;}
elseif($row["GAMME_EFF"] =='G'){$eff='De 500 à 999' ;}
elseif($row["GAMME_EFF"] =='H'){$eff='De 1 000 à 4 999'; }
elseif($row["GAMME_EFF"] =='I'){ $eff='Plus de 5 000';}
elseif($row["GAMME_EFF"] =='Z'){ $eff=''; ;}



                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'tel1'           => $tel_1 ,
                                                                     'tel1_s'         => $tel_1_s,
                                                                     'name_search'     =>strtolower($row["rs_comp"]), 
                                                                     'longitude'      => $row["longitude"],
                                                                     'latitude'       => $row["latitude"],
                                                                     'apparaitre_infos_juridique'  => $row["apparaitre_infos_juridique"],
                                                                     'apparaitre_tel_tlc'          => $row["apparaitre_tel_tlc"],  
                                                                     'rc'             => $row["rc"],
                                                                     'ice'            => $row["ref_ann_leg"],
                                                                     'capital'        => $row["cap"],
                                                                     'fax'            => $row["fax"],
                                                                     'fax_s'          => preg_replace('/\s+/', '', $row["fax"]),
                                                                     // 'mail'           => $row["email"],
                                                                     'dirigeant'      => $dirigeant_name,
                                                                     'forme_juridique'=> $row["forme_jur"],
                                                                     'type_d_etablissement'=> $type, 
                                                                     'fichier'=> $row['code_fichier'],      
                                                                     'effectif'  => $eff,  
                                                                     'annee_de_creation'=>$row["annee_inscr"],
                                                                     

                                                                     );




 // star brands 

                $new_brands      = array();
                $mot_brands   = array();
                                                    $brands = $myPDO->query("SELECT lien_marque.code_marque as code_marque ,nom_marque
                                                    FROM `lien_marque`
                                                    INNER JOIN marque on marque.code_marque =lien_marque.code_marque 

                                                    WHERE `code_firme` = '".$row["code_firme"]."' "); 




                                                   // working here 





                                                                     
                                                                  if (!empty($brands)) { 


 
                                                                                 
                                                            
                                                                                    foreach ($brands as $brand ) {
                                                                                     $mot_brands[]=       array(

                                                                                                 'brand' =>  $brand["nom_marque"],
                                                                                                 'code' => $brand["code_marque"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($brand["nom_marque"])),
                                                                                            );

                                                                         }
                                                                                            
                                                                                    }

                                                                    $new_brands = array('brands' => $mot_brands);
                                                                    $doc       =array_merge($doc, $new_brands);
// end brands 
                                            
                                                                                // nested mot cles 

                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data =array();
                                                                                   $mot_rubriques=array();

                                                                                   $renvoi_data   =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  replace_microsolft_apostrophe($key["Lib_Rubrique"]),
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
                                                                              
                                                                                     $mot_rubriques[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
                                                                         $renvoi_data =array();
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






                           $email_data =array();

$national_doc =array();
$national =array();

$vignette_va=0;
$vignette_vl=0;

$vignette_va_rubriques =array();
$vignette_vl_localites =array();

$pvi = 0;
$catalogue = 0;
$catalogue_co = 0;
$page = 0;
$plus_info = 0;
$site_web = '';
$module_logo = '';
$rubriques = array();
$prestations = array();
$marques =array();
$mot_cles =array();
$poid = 0;
$test_ml = 0;
$client = 0;
$video_graphique_id = 0;
$video_id = 0;
$pl = 0;
$villes =array();
$villes1 =array();
$mot_cles1 =array();

$rubriques =  $mot_rubriques;

if (empty($villes)) {
                $second_array = array('villes' => $villes_data);
                $villes_array1  = array('villes1' => $villes_data);
}else{
                $second_array = array('villes' => $villes);
                $villes_array1  = array('villes1' => $villes);
}
if (empty($mot_cles)){
          $new_array = array('mot_cle' => $renvoi_data);
                     $mot_array1  = array('mot_cle1'  => $renvoi_data);
        $national       =array_merge($national, $renvoi_data);
}
else{
          $new_array = array('mot_cle' => $mot_cles);
                     $mot_array1  = array('mot_cle1'  => $mot_cles);
        $national       =array_merge($national, $mot_cles1);
}

                                                                                    // start email 

                                                                         if (!empty($row["code_firme"])) { 

                                                   $lien_email_chek = $myPDO->query("SELECT `email` FROM `lien_email` WHERE `code_firme` = '".$row["code_firme"]."' ORDER BY `lien_email`.`num_ordre` ASC LIMIT 1" ); 
                                                          foreach ($lien_email_chek as $lien_email ) {
                                                                                    $email_data=   array('mail' =>  $lien_email["email"] );

                                                                                        }
                                                                                    }

                                                                                    // end email                                                                


                                                               
$client_arr =       array('annoceur'=>$client);
$pl_arr =           array('pl'=>$pl);
$catalogue_arr =    array('catalogue'=>$catalogue);
$catalogue_co_arr = array('catalogue_co'=>$catalogue_co);
$pvi_co_arr =       array('pvi'=>$pvi);
$page_co_arr =      array('page'=>$page);
$plus_info_co_arr = array('plus_info'=>$plus_info);
$rubriques_arr =    array('rubriques'=>$rubriques);
$prestations_arr =  array('prestations' => $prestations);
$marques_arr =      array('marques' => $marques);
$poid_arr =         array('poid'=> $poid);
$video_graphique_id_arr  = array('video_graphique_id'=> $video_graphique_id);
$video_id_arr  =    array('video_id'=> $video_id);
$module_logo_arr =  array('module_logo' => $module_logo);


$vignette_va_arr                =           array('vignette_va'=>$vignette_va);
$vignette_va_rubriques_arr      =           array('vignette_va_rubriques'=>$vignette_va_rubriques);
$vignette_vl_localites_arr      =           array('vignette_vl_localites'=>$vignette_vl_localites);
$vignette_vl_arr                =           array('vignette_vl'=>$vignette_vl);

if (  $pin ){
$pining =  array('pin' => $pin);
 $doc       =array_merge($doc, $pining);

}
$villes_filter=array();
$villes_filter[]=  array( 'name' => $row["ville"]  );

$villes_filter_arr        =array('villes_filter'=>$villes_filter);
$doc       = array_merge($doc, $villes_filter_arr);

                                                                    $doc       =array_merge($doc,$email_data);
                                                                    $doc       =array_merge($doc, $vignette_va_arr);
                                                                    $doc       =array_merge($doc, $vignette_va_rubriques_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_localites_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_arr);


                                                                     $national_doc =array('national'=> $national );
                                                                                    $doc       =array_merge($doc, $national_doc);



                                                                     $secu      = array('succursale' => $secursa);

                                                                     $doc       =array_merge($doc, $villes_array1);
                                                                     $doc       =array_merge($doc, $mot_array1);



                                                                     $doc       =array_merge($doc, $client_arr);
                                                                     $doc       =array_merge($doc, $pl_arr);
                                                                     $doc       =array_merge($doc, $catalogue_arr);
                                                                     $doc       =array_merge($doc, $catalogue_co_arr);
                                                                     $doc       =array_merge($doc, $pvi_co_arr);
                                                                     $doc       =array_merge($doc, $page_co_arr);
                                                                     $doc       =array_merge($doc, $plus_info_co_arr);
                                                                     $doc       =array_merge($doc, $rubriques_arr);
                                                                     $doc       =array_merge($doc, $prestations_arr);
                                                                     $doc       =array_merge($doc, $marques_arr);
                                                                     $doc       =array_merge($doc, $poid_arr);
                                                                     $doc       =array_merge($doc, $video_graphique_id_arr);
                                                                     $doc       =array_merge($doc, $video_id_arr);                                                                     
                                                                     $doc       =array_merge($doc, $module_logo_arr);                                                                     
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




 $tel_1   =  $row["tel"];
 $tel_1_s =  preg_replace('/\s+/', '', $row["tel"]);

// tel1 cheking 
    if(empty($row["tel"])){
       $tel_cheking = $myPDO->query("SELECT * FROM `lien_telephone` WHERE `code_firme` ='".$row["code_firme"]."'  ORDER BY `lien_telephone`.`num_ordre` ASC "); 

                                                               if (!empty($tel_cheking)) { 
                                                                
                                                                         foreach ($tel_cheking as $tel_chek ) {

                                                                                     $tel_1   = $tel_chek["tel"];
                                                                                     $tel_1_s = preg_replace('/\s+/', '', $tel_chek["tel"]);
                                                                                    }

                                                                         }
    }
                                                                               
//tel1 end checking



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
$dirigeant_name ='';

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
                                                                    $pin =array();
                                                                           if ( strlen(trim($row["latitude"]))  and  strlen(trim($row["longitude"])) ) {
                                                                    $pin =  array('location' =>  array('lat' => $row["latitude"],'lon' => $row["longitude"]));
                                                                        }


 $eff='';

if ($row["GAMME_EFF"] =='A'){ $eff='De 1 à 9';}
elseif($row["GAMME_EFF"] =='B'){ $eff='De 10 à 19';}
elseif($row["GAMME_EFF"] =='C'){ $eff='De 20 à 49';}
elseif($row["GAMME_EFF"] =='D'){ $eff='De 50 à 99';}
elseif($row["GAMME_EFF"] =='E'){ $eff='De 100 à 249';}
elseif($row["GAMME_EFF"] =='F'){$eff='De 250 à 499' ;}
elseif($row["GAMME_EFF"] =='G'){$eff='De 500 à 999' ;}
elseif($row["GAMME_EFF"] =='H'){$eff='De 1 000 à 4 999'; }
elseif($row["GAMME_EFF"] =='I'){ $eff='Plus de 5 000';}
elseif($row["GAMME_EFF"] =='Z'){ $eff=''; ;}


                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'tel1'           => $tel_1 ,
                                                                     'tel1_s'         => $tel_1_s,
                                                                     'name_search'     =>strtolower($row["rs_comp"]), 
                                                                     'longitude'      => $row["longitude"],
                                                                     'latitude'       => $row["latitude"],
                                                                     'apparaitre_infos_juridique'  => $row["apparaitre_infos_juridique"],
                                                                     'apparaitre_tel_tlc'          => $row["apparaitre_tel_tlc"],  
                                                                     'rc'             => $row["rc"],
                                                                     'ice'            => $row["ref_ann_leg"],
                                                                     'capital'        => $row["cap"],
                                                                     'fax'            => $row["fax"],
                                                                     'fax_s'          => preg_replace('/\s+/', '', $row["fax"]),                                                                     
                                                                     // 'mail'           => $row["email"],
                                                                     'dirigeant'      => $dirigeant_name,
                                                                     'forme_juridique'=> $row["forme_jur"],
                                                                     'type_d_etablissement'=> $type, 
                                                                     'fichier'=> $row['code_fichier'],      
                                                                     'annee_de_creation'=>$row["annee_inscr"],
                                                                     'effectif'  =>$eff,  
                                                                        
                                                                     

                                                                     );



                                                                     // start brand 


                                                                $new_brands      = array();
                                                                $mot_brands   = array();
                                                            $brands = $myPDO->query("SELECT lien_marque.code_marque as code_marque ,nom_marque
                                                            FROM `lien_marque`
                                                            INNER JOIN marque on marque.code_marque =lien_marque.code_marque 

                                                            WHERE `code_firme` = '".$row["code_firme"]."' "); 




                                                   // working here 





                                                                     
                                                                  if (!empty($brands)) { 


 
                                                                                 
                                                            
                                                                                    foreach ($brands as $brand ) {
                                                                                     $mot_brands[]=       array(

                                                                                                 'brand' =>  $brand["nom_marque"],
                                                                                                 'code' => $brand["code_marque"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($brand["nom_marque"])),
                                                                                            );

                                                                         }
                                                                                            
                                                                                    }

                                                                    $new_brands = array('brands' => $mot_brands);
                                                                    $doc       =array_merge($doc, $new_brands);

                                                                     // end brands 

                                            

                                                                                // nested mot cles 

                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data =array();
                                                                                   $mot_rubriques=array();
                                                                                   $renvoi_data   =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  replace_microsolft_apostrophe($key["Lib_Rubrique"]),
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );


                                                                                                 $mot_rubriques[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
$renvoi_data =array();
                                                  $renvoi_data[]=       array('mot' =>  $key["Lib_Rubrique_Papier"], 'code' => $key["code_rubrique"], 'slug' => '', );

                                                             $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` = '".$key["code_rubrique"]."'"); 

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






$vignette_va=0;
$vignette_vl=0;
                           $email_data =array();
$vignette_va_rubriques =array();
$vignette_vl_localites =array();

$national_doc =array();
$national =array();

$pvi = 0;
$catalogue = 0;
$catalogue_co = 0;
$page = 0;
$plus_info = 0;
$site_web = '';
$module_logo = '';
$rubriques = array();
$prestations = array();
$marques =array();
$mot_cles =array();
$poid = 0;
$test_ml = 0;
$client = 0;
$video_graphique_id = 0;
$video_id = 0;
$pl = 0;
$villes =array();
$villes1 =array();
$mot_cles1 =array();

$rubriques =  $mot_rubriques;

if (empty($villes)) {
                $second_array = array('villes' => $villes_data);
                $villes_array1  = array('villes1' => $villes_data);
}else{
                $second_array = array('villes' => $villes);
                $villes_array1  = array('villes1' => $villes);
}
if (empty($mot_cles)){
          $new_array = array('mot_cle' => $renvoi_data);
                     $mot_array1  = array('mot_cle1'  => $renvoi_data);
        $national       =array_merge($national, $renvoi_data);
}
else{
          $new_array = array('mot_cle' => $mot_cles);
                     $mot_array1  = array('mot_cle1'  => $mot_cles);
        $national       =array_merge($national, $mot_cles1);
}            

                                                                                    // start email 

                                                                         if (!empty($row["code_firme"])) { 

                                                   $lien_email_chek = $myPDO->query("SELECT `email` FROM `lien_email` WHERE `code_firme` = '".$row["code_firme"]."' ORDER BY `lien_email`.`num_ordre` ASC LIMIT 1" ); 
                                                          foreach ($lien_email_chek as $lien_email ) {
                                                                                    $email_data=   array('mail' =>  $lien_email["email"] );

                                                                                        }
                                                                                    }

                                                                                    // end email                                                                

                                                               
$client_arr =       array('annoceur'=>$client);
$pl_arr =           array('pl'=>$pl);
$catalogue_arr =    array('catalogue'=>$catalogue);
$catalogue_co_arr = array('catalogue_co'=>$catalogue_co);
$pvi_co_arr =       array('pvi'=>$pvi);
$page_co_arr =      array('page'=>$page);
$plus_info_co_arr = array('plus_info'=>$plus_info);
$rubriques_arr =    array('rubriques'=>$rubriques);
$prestations_arr =  array('prestations' => $prestations);
$marques_arr =      array('marques' => $marques);
$poid_arr =         array('poid'=> $poid);
$video_graphique_id_arr  = array('video_graphique_id'=> $video_graphique_id);
$video_id_arr  =    array('video_id'=> $video_id);
$module_logo_arr =  array('module_logo' => $module_logo);




$vignette_va_arr                =           array('vignette_va'=>$vignette_va);
$vignette_va_rubriques_arr      =           array('vignette_va_rubriques'=>$vignette_va_rubriques);
$vignette_vl_localites_arr      =           array('vignette_vl_localites'=>$vignette_vl_localites);
$vignette_vl_arr                =           array('vignette_vl'=>$vignette_vl);

if (  $pin ){
$pining =  array('pin' => $pin);
 $doc       =array_merge($doc, $pining);

}

$villes_filter=array();
$villes_filter[]=  array( 'name' => $row["ville"]  );

$villes_filter_arr        =array('villes_filter'=>$villes_filter);
$doc       = array_merge($doc, $villes_filter_arr);

                                                                    $doc       =array_merge($doc,$email_data);
                                                                    $doc       =array_merge($doc, $vignette_va_arr);
                                                                    $doc       =array_merge($doc, $vignette_va_rubriques_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_localites_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_arr);
                                                                    


                                                                     $national_doc =array('national'=> $national );

                                                                                    $doc       =array_merge($doc, $national_doc);

                                                                     $secu      = array('succursale' => $secursa);

                                                                     $doc       =array_merge($doc, $villes_array1);
                                                                     $doc       =array_merge($doc, $mot_array1);



                                                                     $doc       =array_merge($doc, $client_arr);
                                                                     $doc       =array_merge($doc, $pl_arr);
                                                                     $doc       =array_merge($doc, $catalogue_arr);
                                                                     $doc       =array_merge($doc, $catalogue_co_arr);
                                                                     $doc       =array_merge($doc, $pvi_co_arr);
                                                                     $doc       =array_merge($doc, $page_co_arr);
                                                                     $doc       =array_merge($doc, $plus_info_co_arr);
                                                                     $doc       =array_merge($doc, $rubriques_arr);
                                                                     $doc       =array_merge($doc, $prestations_arr);
                                                                     $doc       =array_merge($doc, $marques_arr);
                                                                     $doc       =array_merge($doc, $poid_arr);
                                                                     $doc       =array_merge($doc, $video_graphique_id_arr);
                                                                     $doc       =array_merge($doc, $video_id_arr);                                                                     
                                                                     $doc       =array_merge($doc, $module_logo_arr);                                                                     
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

 $tel_1   =  $row["tel"];
 $tel_1_s =  preg_replace('/\s+/', '', $row["tel"]);

// tel1 cheking 
    if(empty($row["tel"])){
       $tel_cheking = $myPDO->query("SELECT * FROM `lien_telephone` WHERE `code_firme` ='".$row["code_firme"]."'  ORDER BY `lien_telephone`.`num_ordre` ASC "); 

                                                               if (!empty($tel_cheking)) { 
                                                                
                                                                         foreach ($tel_cheking as $tel_chek ) {

                                                                                     $tel_1   = $tel_chek["tel"];
                                                                                     $tel_1_s = preg_replace('/\s+/', '', $tel_chek["tel"]);
                                                                                    }

                                                                         }
    }
                                                                               
//tel1 end checking



$rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique,Lib_Rubrique_Papier FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` = '".$row["code_firme"]."' AND lien.`editable` = '+'"); 

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

}*/
$dirigeant_name ='';

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
                                                                    $pin =array();
                                                                           if ( strlen(trim($row["latitude"]))  and  strlen(trim($row["longitude"])) ) {
                                                                    $pin =  array('location' =>  array('lat' => $row["latitude"],'lon' => $row["longitude"]));
                                                                        }

 $eff='';

if ($row["GAMME_EFF"] =='A'){ $eff='De 1 à 9';}
elseif($row["GAMME_EFF"] =='B'){ $eff='De 10 à 19';}
elseif($row["GAMME_EFF"] =='C'){ $eff='De 20 à 49';}
elseif($row["GAMME_EFF"] =='D'){ $eff='De 50 à 99';}
elseif($row["GAMME_EFF"] =='E'){ $eff='De 100 à 249';}
elseif($row["GAMME_EFF"] =='F'){$eff='De 250 à 499' ;}
elseif($row["GAMME_EFF"] =='G'){$eff='De 500 à 999' ;}
elseif($row["GAMME_EFF"] =='H'){$eff='De 1 000 à 4 999'; }
elseif($row["GAMME_EFF"] =='I'){ $eff='Plus de 5 000';}
elseif($row["GAMME_EFF"] =='Z'){ $eff=''; ;}


                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'tel1'           => $tel_1,
                                                                     'tel1_s'         => $tel_1_s,
                                                                     'name_search'     =>strtolower($row["rs_comp"]), 
                                                                     'longitude'      => $row["longitude"],
                                                                     'latitude'       => $row["latitude"],
                                                                     'apparaitre_infos_juridique'  => $row["apparaitre_infos_juridique"],
                                                                     'apparaitre_tel_tlc'          => $row["apparaitre_tel_tlc"],  
                                                                     'rc'             => $row["rc"],
                                                                     'ice'            => $row["ref_ann_leg"],
                                                                     'capital'        => $row["cap"],
                                                                     'fax'            => $row["fax"],
                                                                     'fax_s'           => preg_replace('/\s+/', '', $row["fax"]),
                                                                     // 'mail'           => $row["email"],
                                                                     'dirigeant'      => $dirigeant_name,
                                                                     'forme_juridique'=> $row["forme_jur"],
                                                                     'type_d_etablissement'=> $type, 
                                                                     'fichier'=> $row['code_fichier'],      
                                                                     'annee_de_creation'=>$row["annee_inscr"],
                                                                     'effectif'  =>$eff,  
                                                                        
                                                                     

                                                                     );

                                            

                                                                        // start brands 


                                                    $new_brands      = array();
                                                    $mot_brands   = array();

                                                    $brands = $myPDO->query("SELECT lien_marque.code_marque as code_marque ,nom_marque
                                                    FROM `lien_marque`
                                                    INNER JOIN marque on marque.code_marque =lien_marque.code_marque 

                                                    WHERE `code_firme` = '".$row["code_firme"]."' "); 



                                                                     
                                                                  if (!empty($brands)) { 


 
                                                                                 
                                                            
                                                                                    foreach ($brands as $brand ) {
                                                                                     $mot_brands[]=       array(

                                                                                                 'brand' =>  $brand["nom_marque"],
                                                                                                 'code' => $brand["code_marque"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($brand["nom_marque"])),
                                                                                            );

                                                                         }
                                                                                            
                                                                                    }

                                                                    $new_brands = array('brands' => $mot_brands);
                                                                    $doc       =array_merge($doc, $new_brands);
                                                                        // end brands 


                                                                                // nested mot cles 


                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data      = array();
                                                                                  $mot_rubriques =array();

                                                                                  $renvoi_data   = array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  replace_microsolft_apostrophe($key["Lib_Rubrique"]),
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
                                                                                     $mot_rubriques[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );



$renvoi_data =array();
                                                  $renvoi_data[]=       array('mot' =>  $key["Lib_Rubrique_Papier"], 'code' => $key["code_rubrique"], 'slug' => '', );


                                                                 $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` ='".$key["code_rubrique"]."'"); 
                                                                                                    if (!empty($renvois)) { 
                                                                 $renvoi_data =array();
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




$vignette_va=0;
$vignette_vl=0;

$vignette_va_rubriques =array();
$vignette_vl_localites =array();


$national_doc =array();
$national =array();

                           $email_data =array();

$pvi = 0;
$catalogue = 0;
$catalogue_co = 0;
$page = 0;
$plus_info = 0;
$site_web = '';
$module_logo = '';
$rubriques = array();
$prestations = array();
$marques =array();
$mot_cles =array();
$poid = 0;
$test_ml = 0;
$client = 0;
$video_graphique_id = 0;
$video_id = 0;
$pl = 0;
$villes =array();
$villes1 =array();
$mot_cles1 =array();

$rubriques =  $mot_rubriques;

if (empty($villes)) {
                $second_array = array('villes' => $villes_data);
                $villes_array1  = array('villes1' => $villes_data);
}else{
                $second_array = array('villes' => $villes);
                $villes_array1  = array('villes1' => $villes);
}
if (empty($mot_cles)){
          $new_array = array('mot_cle' => $renvoi_data);
                     $mot_array1  = array('mot_cle1'  => $renvoi_data);
        $national       =array_merge($national, $renvoi_data);
}
else{
          $new_array = array('mot_cle' => $mot_cles);
                     $mot_array1  = array('mot_cle1'  => $mot_cles);
        $national       =array_merge($national, $mot_cles1);
}

                                                                                    // start email 

                                                                         if (!empty($row["code_firme"])) { 

                                                   $lien_email_chek = $myPDO->query("SELECT `email` FROM `lien_email` WHERE `code_firme` = '".$row["code_firme"]."' ORDER BY `lien_email`.`num_ordre` ASC LIMIT 1" ); 
                                                          foreach ($lien_email_chek as $lien_email ) {
                                                                                    $email_data=   array('mail' =>  $lien_email["email"] );

                                                                                        }
                                                                                    }

                                                                                    // end email                                                                

                                                               
$client_arr =       array('annoceur'=>$client);
$pl_arr =           array('pl'=>$pl);
$catalogue_arr =    array('catalogue'=>$catalogue);
$catalogue_co_arr = array('catalogue_co'=>$catalogue_co);
$pvi_co_arr =       array('pvi'=>$pvi);
$page_co_arr =      array('page'=>$page);
$plus_info_co_arr = array('plus_info'=>$plus_info);
$rubriques_arr =    array('rubriques'=>$rubriques);
$prestations_arr =  array('prestations' => $prestations);
$marques_arr =      array('marques' => $marques);
$poid_arr =         array('poid'=> $poid);
$video_graphique_id_arr  = array('video_graphique_id'=> $video_graphique_id);
$video_id_arr  =    array('video_id'=> $video_id);
$module_logo_arr =  array('module_logo' => $module_logo);





$vignette_va_arr                =           array('vignette_va'=>$vignette_va);
$vignette_va_rubriques_arr      =           array('vignette_va_rubriques'=>$vignette_va_rubriques);
$vignette_vl_localites_arr      =           array('vignette_vl_localites'=>$vignette_vl_localites);
$vignette_vl_arr                =           array('vignette_vl'=>$vignette_vl);

if (  $pin ){
$pining =  array('pin' => $pin);
 $doc       =array_merge($doc, $pining);

}
$villes_filter=array();
$villes_filter[]=  array( 'name' => $row["ville"]  );

$villes_filter_arr        =array('villes_filter'=>$villes_filter);
$doc       = array_merge($doc, $villes_filter_arr);

                                                                    $doc       =array_merge($doc,$email_data);
                                                                    $doc       =array_merge($doc, $vignette_va_arr);
                                                                    $doc       =array_merge($doc, $vignette_va_rubriques_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_localites_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_arr);
                                                                    

                                                                     $national_doc =array('national'=> $national );
                                                                                    $doc       =array_merge($doc, $national_doc);

                                                                     $secu      = array('succursale' => $secursa);

                                                                     $doc       =array_merge($doc, $villes_array1);
                                                                     $doc       =array_merge($doc, $mot_array1);


                                                                     $doc       =array_merge($doc, $client_arr);
                                                                     $doc       =array_merge($doc, $pl_arr);
                                                                     $doc       =array_merge($doc, $catalogue_arr);
                                                                     $doc       =array_merge($doc, $catalogue_co_arr);
                                                                     $doc       =array_merge($doc, $pvi_co_arr);
                                                                     $doc       =array_merge($doc, $page_co_arr);
                                                                     $doc       =array_merge($doc, $plus_info_co_arr);
                                                                     $doc       =array_merge($doc, $rubriques_arr);
                                                                     $doc       =array_merge($doc, $prestations_arr);
                                                                     $doc       =array_merge($doc, $marques_arr);
                                                                     $doc       =array_merge($doc, $poid_arr);
                                                                     $doc       =array_merge($doc, $video_graphique_id_arr);
                                                                     $doc       =array_merge($doc, $video_id_arr);                                                                     
                                                                     $doc       =array_merge($doc, $module_logo_arr);                                                                     
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