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
$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));



$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$result = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme', `rs_comp`, `rs_abr`,code_statut , villes.ville as ville,forme_jur, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( comp_num_voie, '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,rc,ref_ann_leg,cap,email FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartiers ON quartiers.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur`
LEFT JOIN lien_email AS mail ON mail.`code_firme` = firmes.`code_firme` AND mail.num_ordre =1 where code_fichier != 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8)");


ini_set('memory_limit', '-1');

set_time_limit(50000); // 


    
         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'telecontact29'
            
         );
 


if (!empty($result)) {
        

foreach($result as $row) {          
if ($row["code_firme"]){
$rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` LIKE '".$row["code_firme"]."' AND lien.`editable` LIKE '+'"); 

/*
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

}*/

$dirigeant_name ='';

/*$secursale=$myPDO->query("SELECT firmes.`code_firme` AS 'code_firme', `rs_comp` , `rs_abr` , SUBSTRING_INDEX( `status` , ' ', 1 ) AS
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
*/



}


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
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'tel1'           => $row["tel"],
                                                                     'longitude'      =>if (empty($row["longitude"])){0 }else{$row["longitude"]} ,
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
 
                                                                            $mot_data =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );
                                                                                             
                                                                                            
                                                                                    }

                                                                         }
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





// production start from here
$code_production = $myPDO->query("SELECT  * FROM `annonceur_production` WHERE `code_firme` LIKE '".$row["code_firme"]."' "); 

$code_production = $code_production->fetch();


 
if($code_production){



$sth = $dbh->query('SELECT acc.code_firme,acc.raison_sociale,se.code_produit,se.point as Poids,a.interr,
i.value51 as module_logo,r.rubrique, r.code_rubrique,  CONCAT_WS(",", i.value48, i.value49) AS prest ,acc.ville,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(i.value50, "1|", ""), "2|", ""), "3|", ""), "4|", "" ) , "5|", "") , "zone", "") as ville_supp,i.value52 as marques ,i.value56 as produits,a.logo,
a.video,a.video2,
a.video_graphique1,a.video_graphique2,
a.espace_promo_titre,a.espace_promo_description,
a.professionnel_description,a.professionnel_lien,
a.prof_lib_parcours,a.prof_lib_diplome,a.prof_lib_specialites,a.prof_lib_services,a.certification,a.horaires_ouverture,a.langue_parlee,a.prof_lib_lieux_interet,a.prof_lib_domaine_competence,a.type_client,a.prof_lib_res_face,a.mode_paiement,
a.debut_mise_en_ligne,a.fin_mise_en_ligne,
a.lien
FROM `u_yf_ssingleorders` s 
INNER JOIN u_yf_atribution a on a.ordre=s.ssingleordersid 
INNER JOIN vtiger_service se on se.serviceid=a.serviceid
INNER JOIN vtiger_account acc  on acc.accountid=s.firme

LEFT JOIN u_yf_ssingleorders_inventory i on i.name=a.serviceid and a.ordre=i.id 
LEFT JOIN u_yf_rubriques r on r.rubriquesid=i.ref
LEFT JOIN u_yf_ville v on v.villeid=i.value28
WHERE  concat("MA",a.code_firme) ="'.$row["code_firme"].'" and  now() >= debut_mise_en_ligne and now() <= fin_mise_en_ligne  and interr=0 and a.format<>"" ');



while ($row_production = $sth->fetch())
{

    $client = 1;

    // start module_logo
    if ($row_production['code_produit'] == 'ML')
    {

        if ($test_ml == 0)
        {


                                                                  
                                                                                     $villes[]=  array( 'name' => $row_production["ville"]  );
      if ($row_production['ville_supp'])
            { 
    $myString_ville = $row_production['ville_supp'];
                $myArray_ville = explode(',', $myString_ville);

                foreach ($myArray_ville as $value_ville)
                {
                    if ($value_ville)
                    {
 
                        $villes[] = array('name' => $value_ville);

            }                                     
}}                                                                                                            
                                                                              


            $module_logo = $row_production['module_logo'];

            if ($row_production['prest'])
            {
                $myString = $row_production['prest'];
                $myArray = explode(',', $myString);

                foreach ($myArray as $value)
                {
                    if ($value)
                    {
                        $prest_code = slugify(adilsoft_string_latin($value));

                        $prestations[] = array(
                            'prestation' => $value,
                            'code' => $prest_code,
                            'slug' => $prest_code,
                        );


                         $mot_cles[]=       array(

                         'mot' =>  $value,
                         'code' => $prest_code,
                         'slug' => $prest_code
                         );

                    }
                }
            }



              if ($row_production['marques'])
            {
                $myString_marque = $row_production['marques'];
                $myArray_marque = explode(',', $myString_marque);

                foreach ($myArray_marque as $value_marque)
                {

                    if ($value_marque)
                    {
                        $marque_code = slugify(adilsoft_string_latin($value_marque));

                        $marques[] = array(
                            'marque' => $value_marque,
                            'code' => $marque_code,
                            'slug' => $marque_code,
                        );


                        $mot_cles[]=       array(

                         'mot' =>  $value_marque,
                         'code' => $marque_code,
                         'slug' => $marque_code
                         );

                    }
                }

            }




            $rubriques[] = array(

                'rubrique' => $row_production["rubrique"],
                'code' => $row_production["code_rubrique"],
                'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])) ,
            );

             $mot_cles[]=  array(

                         'mot' =>  $row_production["rubrique"],
                         'code' => $row_production["code_rubrique"],
                         'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])),
             );

            $poid = $poid + $row_production['Poids'];

            $test_ml = 1;

        }
        else
        {
            if ($row_production['prest'])
            {
                $myString = $row_production['prest'];
                $myArray = explode(',', $myString);

                foreach ($myArray as $value)
                {

                    if ($value)
                    {
                        $prest_code = slugify(adilsoft_string_latin($value));

                        $prestations[] = array(
                            'prestation' => $value,
                            'code' => $prest_code,
                            'slug' => $prest_code,
                        );


                        $mot_cles[]=       array(

                         'mot' =>  $value,
                         'code' => $prest_code,
                         'slug' => $prest_code
                         );

                    }
                }

            }


              if ($row_production['marques'])
            {
                $myString_marque = $row_production['marques'];
                $myArray_marque = explode(',', $myString_marque);

                foreach ($myArray_marque as $value_marque)
                {

                    if ($value_marque)
                    {
                        $marque_code = slugify(adilsoft_string_latin($value_marque));

                        $marques[] = array(
                            'marque' => $value_marque,
                            'code' => $marque_code,
                            'slug' => $marque_code,
                        );

                        $mot_cles[]=       array(

                         'mot' =>  $value_marque,
                         'code' => $marque_code,
                         'slug' => $marque_code
                         );
                    }
                }

            }





            $rubriques[] = array(

                'rubrique' => $row_production["rubrique"],
                'code' => $row_production["code_rubrique"],
                'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])) ,
            );

             $mot_cles[]=  array(

                         'mot' =>  $row_production["rubrique"],
                         'code' => $row_production["code_rubrique"],
                         'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])),
             );


        }

    }
    else
    {

        $poid = $poid + $row_production['Poids'];

    }

    // end module_logo
    

    // autre produits
    

    if ($row_production['code_produit'] == 'W1' or $row_production['code_produit'] == 'W2' or $row_production['code_produit'] == 'W3' or $row_production['code_produit'] == 'W4' or $row_production['code_produit'] == 'W5')
    {
        $pvi = 1;
    }

    if ($row_production['code_produit'] == 'CC1' or $row_production['code_produit'] == 'CC2' or $row_production['code_produit'] == 'CC3' or $row_production['code_produit'] == 'CC4')
    {
        $catalogue_co = 1;
    }

    if ($row_production['code_produit'] == 'C1' or $row_production['code_produit'] == 'C2' or $row_production['code_produit'] == 'C3' or $row_production['code_produit'] == 'C4')
    {
        $catalogue = 1;
    }

    if ($row_production['code_produit'] == 'PS')
    {
        $page = 1;
    }

    if ($row_production['code_produit'] == 'VG')
    {
             $video_graphique_id = 1;
             $video_graphique_url = $row_production['video_graphique1'];
           
    }

    if ($row_production['code_produit'] == 'VB' OR  $row_production['code_produit'] == 'FR')
    {
             $video_id = 1;
             $video_url = $row_production['video_graphique1'];
           
    }




    if ($row_production['code_produit'] == 'PP')
    {
        $plus_info = 1;
    }

    if ($row_production['code_produit'] == 'PL')
    {
        $pl = 1;
    }

    // end autre produits
    

    
}

/*echo $poid . '<br/>';

print_r($villes);
*/

}

// production end from here








                                                                     }

if (empty($villes)) {
           $second_array = array('villes' => $villes_data);
}else{
           $second_array = array('villes' => $villes);
}
if (empty($mot_cles)){
          $new_array = array('mot_cle' => $mot_data);
}
else{
          $new_array = array('mot_cle' => $mot_cles);
}
                                                               
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







                                                                     $secu      = array('succursale' => $secursa);




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