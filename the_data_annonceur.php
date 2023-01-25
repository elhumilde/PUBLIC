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

$result = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme',apparaitre_infos_juridique,apparaitre_tel_tlc, `rs_comp`,GAMME_EFF, annee_inscr ,`rs_abr`,code_statut , villes.ville as ville,forme_jur, REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( REPLACE(comp_num_voie, 'X', 'Bis'), '' ) , ' ', IFNULL( REPLACE(lib_voie, '- Autre ville', ''), '' )  , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartier_nouv.quartier, '' ) ,' ',IFNULL(arrondissement,'' ) ) , ',', ' ' ) AS 'adresse',`tel`,fax,longitude,latitude,rc,ref_ann_leg,cap,code_fichier FROM `firmes` INNER JOIN villes ON villes.code = firmes.code_ville LEFT JOIN quartier_nouv ON quartier_nouv.code = firmes.code_quart LEFT JOIN lien_telephone AS t ON t.`code_firme` = firmes.`code_firme` AND t.num_ordre =1 
    LEFT JOIN arrondissements on firmes.code_arr=arrondissements.code    

LEFT JOIN lien_fax AS fx ON fx.`code_firme` = firmes.`code_firme` AND fx.num_ordre =1 
LEFT JOIN formes_juridiques AS fors ON fors.`code` = firmes.`code_forme_jur` 
INNER JOIN annonceur_production on  annonceur_production.code_firme=firmes.`code_firme` 
where  maj_k NOT IN (0,8) AND maj_n NOT IN (0,8) AND (code_fichier <> 'N20' or code_fichier is null  )   ");


ini_set('memory_limit', '-1');

set_time_limit(5000000); // 

         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'telecontact42'
            
         );
if (!empty($result)) {
foreach($result as $row) {          
if ($row["code_firme"]){
$rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` = '".$row["code_firme"]."' AND lien.`editable` = '+' LIMIT 1"); 

$dirigeant = $myPDO->prepare("SELECT civilite.civilite AS civilite, nom, prenom
FROM `lien_dirigeant`
INNER JOIN personne ON lien_dirigeant.`code_personne` = personne.code_personne
LEFT JOIN civilite ON civilite.code = personne.civilite
 LEFT JOIN `fonction` AS f ON f.`code` = lien_dirigeant.`code_fonction` AND f.`apparaitre` = 2
WHERE `code_firme` = '".$row["code_firme"]."'
AND (lien_dirigeant.`code_fonction` NOT LIKE '0%'  OR lien_dirigeant.`code_fonction` ='0116' )
ORDER BY `code_fonction` ASC LIMIT 1"); 

$dirigeant->execute();
$result_dirigeant = $dirigeant->fetch();
if($result_dirigeant){
$dirigeant_name= $result_dirigeant["civilite"].' '.$result_dirigeant["nom"].' '.$result_dirigeant["prenom"];
}else{

$dirigeant_name ='';

}

$secursale=$myPDO->query("SELECT firmes.`code_firme` AS 'code_firme', `rs_comp` , `rs_abr` , SUBSTRING_INDEX( `status` , ' ', 1 ) AS
status , villes.ville AS ville , REPLACE( CONCAT( IFNULL( num_voie, '' ) , ' ', IFNULL( REPLACE(comp_num_voie, 'X', 'Bis'), '' ) , ' ', IFNULL( lib_voie, '' ) , ' ', IFNULL( comp_voie, '' ) , ' ', IFNULL( quartiers.quartier, '' ) ) , ',', ' ' ) AS 'adresse', `tel` , fax
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
WHERE `code_firme_mere` = '".$row["code_firme"]."'
AND maj_k NOT
IN ( 0, 8 )
AND maj_n NOT
IN ( 0, 8 )  
AND `apparaitre_firme_mere` =1
");
}


     if ($row["code_statut"]=='A' OR $row["code_statut"]=='B' ){$type='Siège'  ;  } else{$type='Succursale'  ;   }                                                           // working here 

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
                                                                        $mystring = $row["rs_comp"].' '.$row["rs_abr"];
                                                                     
                                                                    // Test if string contains the word 
                                                                    if(strpos($mystring, $word) !== false){
                                                                        $search =  str_replace(".","",$mystring);
                                                                        $search =$search.' '.$row["rs_comp"].' '.$row["rs_abr"];
                                                                    } else{
                                                                        $search =$row["rs_comp"].' '.$row["rs_abr"];
                                                                    }
                                                                    
                                                                        

                                                                    $ville_slug =adilsoft_string_latin($row["ville"]);
                                                                    $ville_slug =slugify($ville_slug);
                                                                    $pin=array();
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
elseif($row["GAMME_EFF"] =='Z'){$eff='Non renseignée' ;}

                                                                     $doc = array(
                                                                     'code_firme'     => $row["code_firme"],
                                                                     'date'           => $datetime,
                                                                     'rs_comp_search' => $search,
                                                                     'rs_comp'        => $rs_comp,
                                                                     'ville'          => $row["ville"],
                                                                     'ville_slug'     => $ville_slug,
                                                                     'rs_comp_slug'   => $slug,
                                                                     'adresse'        => $row["adresse"],
                                                                     'name_search'     =>strtolower($row["rs_comp"]), 
                                                                     
                                                          /*           'tel1'           => $row["tel"],
                                                                     'tel1_s'         => preg_replace('/\s+/', '', $row["tel"]),*/
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
                                                                     // 'site_web'  => $row["web"],   
                                                                     'fichier'=> $row['code_fichier'],            
                                                                     'annee_de_creation'=>$row["annee_inscr"],  
                                                                     'effectif'  =>$eff,  

                                                                     );

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
 
                                                                            $villes_data =array();
                                                                  
                                                                                     $villes_data[]=  array( 'name' => $row["ville"]  );
                                                                                                            
                                                                           
                                                                                            
                                                                               

                                                                         }
                                                                                // end nested villes




 $email_data =array();

$national_doc =array();
$national =array();

 $video_graphique_url = '';
 $video_url = '';
 
$pvi = 0;
$catalogue = 0;
$catalogue_co = 0;
$page = 0;
$plus_info = 0;
$site_web = array();
$module_logo = '';
$pvi_url='';
$rubriques = array();
$prestations = array();

$vignette_va=0;
$vignette_vl=0;

$vignette_va_rubriques =array();
$vignette_vl_localites =array();

$marques =array();
$mot_cles =array();
$mot_cles1 =array();
$mot_cles2 =array();
$mot_cles3 =array();
$mot_cles4 =array();
$mot_cles5 =array();
$mot_cles6 =array();
$mot_cles7 =array();
$mot_cles8 =array();
$mot_cles9 =array();
$mot_cles10 =array();
$sites='';

$poid = 0;
$test_ml = 0;
$client = 0;
$video_graphique_id = 0;
$video_id = 0;
$pl = 0;
$agenda_id=0;
$agenda_url='';

$desc2 = 0;
$desc1 = 0;

$pj =0;
$pj_desc='';
$pj_lien='';
$limitrophe ='';

    $tel_data1 =array();
                                                                         $tel__s1 =array();
                                                                         $tel_data2 =array();
$villes_filter  = array();                                                                         $tel__s2 =array();
$villes   = array();
$villes1  = array();
$villes2  = array();
$villes3  = array();
$villes4  = array();
$villes5  = array();
$villes6  = array();
$villes7  = array();
$villes8  = array();
$villes9  = array();
$villes10 = array();
$prof_lib_specialites =array();

$pl_parcours= array();
$pl_diplome=  array();
$pl_certification= array();
$pl_langue_parle=  array();
$pl_domaine_competence=  array();
$horaires_ouverturee=  array();

// production start from here


                        $code_firme = substr($row["code_firme"], -7);


$sth = $dbh->query('SELECT i.id,acc.code_firme,acc.raison_sociale,
CASE WHEN se.pack="p" THEN "ML" ELSE se.code_produit END AS code_produit,
CASE WHEN se.pack="p" THEN (SELECT point from vtiger_service WHERE serviceid=1714562 ) ELSE se.point END as Poids,
a.interr,i.value51 as module_logo,r.rubrique,r.code_rubrique,rubrique_papier,i.value48 as prest,

CASE WHEN concat("", SUBSTRING_INDEX(i.value49, ",", -1) * 1) =  SUBSTRING_INDEX(i.value49, ",", -1)  THEN  TRIM(trailing "," FROM (trim(trailing (SUBSTRING_INDEX(i.value49, ",", -1)) from i.value49))) 
ELSE i.value49
END AS prest_supp,

acc.ville,REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(i.value50, "1|", ""), "2|", ""), "3|", ""), "4|", "" ) , "5|", "") , "zone", "") as ville_supp,

REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(i.value58, "1|", ""), "2|", ""), "3|", ""), "4|", "" ) , "5|", "") , "zone", "") as ville_sl,

concat((CASE 
WHEN concat("", SUBSTRING_INDEX(COALESCE(i.`value65`,""), ",", -1) * 1) =  SUBSTRING_INDEX(COALESCE(i.`value65`,""), ",", -1)  
THEN  TRIM(trailing "," FROM (trim(trailing (SUBSTRING_INDEX(COALESCE(i.`value65`,""), ",", -1)) from COALESCE(i.`value65`,"")))) 
ELSE COALESCE(i.`value65`,"")
END)      
,(CASE WHEN concat("", SUBSTRING_INDEX(COALESCE(i.`value52`,""), ",", -1) * 1) =  SUBSTRING_INDEX(COALESCE(i.`value52`,""), ",", -1)  
THEN  TRIM(trailing "," FROM (trim(trailing (SUBSTRING_INDEX(COALESCE(i.`value52`,""), ",", -1)) from COALESCE(i.`value52`,"")))) 
ELSE COALESCE(i.`value52`,"")
END )) as marques,

i.value56 as produits
,a.logo,value55 as vignette_rubriques,value54 as vignette_localites,
a.video,a.video2,value53 as va_region,
a.video_graphique1,a.video_graphique2,
a.espace_promo_titre,a.espace_promo_description,
a.professionnel_description,a.professionnel_lien,
a.prof_lib_parcours,a.prof_lib_diplome,a.prof_lib_specialites,a.prof_lib_services,a.certification,a.horaires_ouverture,a.langue_parlee,a.prof_lib_lieux_interet,a.prof_lib_domaine_competence,a.type_client,a.prof_lib_res_face,a.mode_paiement,
a.debut_mise_en_ligne,a.fin_mise_en_ligne,
a.lien
FROM `u_yf_ssingleorders` s 
INNER JOIN u_yf_atribution a on a.ordre=s.ssingleordersid 
INNER JOIN vtiger_service se on se.serviceid=a.serviceid
LEFT JOIN u_yf_ssingleorders_inventory i on i.name=a.serviceid and a.ordre=i.id  and i.remove =0
INNER JOIN vtiger_account acc  on acc.accountid=s.firme
LEFT JOIN u_yf_rubriques r on r.rubriquesid=i.ref
LEFT JOIN u_yf_ville v on v.villeid=i.value28
WHERE  a.code_firme="'.$code_firme.'" and now() <= fin_mise_en_ligne and interr=0 and a.format<>"" ');







$i=0;
while ($row_production = $sth->fetch())
{

    $client = 1;

    // start module_logo

    // ce text c'est pour le poids d'un module logo une seule fois 

    if ($row_production['code_produit'] == 'ML' OR $row_production['code_produit'] == 'CV' )
    {
        $i++;

        if ($test_ml == 0)
        {






                                                                  
  ${"villes$i"}[]=  array( 'name' => $row["ville"]  );
 

      if ($row_production['ville_supp'])
            { 
    $myString_ville = $row_production['ville_supp'];
                $myArray_ville = explode(',', $myString_ville);

                foreach ($myArray_ville as $value_ville)
                {
                    if ($value_ville)
                    {
 
                        ${"villes$i"}[] = array('name' => $value_ville);

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


                         ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value),
                         'code' => $prest_code,
                         'slug' => ''
                         );

                    }
                }
            }



            if ($row_production['prest_supp'])
            {
                $myString_supp = $row_production['prest_supp'];
                $myArray_supp = explode(',', $myString_supp);

                foreach ($myArray_supp as $value_supp)
                {
                    if ($value_supp)
                    {
                        $prest_code_supp = slugify(adilsoft_string_latin($value_supp));

                        $prestations[] = array(
                            'prestation' => $value_supp,
                            'code' => $prest_code_supp,
                            'slug' => $prest_code_supp,
                        );


                         ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value_supp),
                         'code' => $prest_code_supp,
                         'slug' => ''
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


                        ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value_marque),
                         'code' => $marque_code,
                         'slug' => ''
                         );

                    }
                }

            }




            $rubriques[] = array(

                'rubrique' => $row_production["rubrique"],
                'code' => $row_production["code_rubrique"],
                'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])) ,
            );



                                                                        if (!empty($row_production["code_rubrique"])) { 

                                                             $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` = '".$row_production["code_rubrique"]."'"); 

                                                               if (!empty($renvois)) { 
                                                                         
                                                                         foreach ($renvois as $ren ) {
                                                                                      ${"mot_cles$i"}[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );
${"mot_cles$i"}[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique_Papier"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );

                                                                                      

                                                                                    }

                                                                         }
                                                                                            
                                                                                    

                                                                         }

             ${"mot_cles$i"}[]=  array(

                         'mot' =>  replace_microsolft_apostrophe($row_production["rubrique"]),
                         'code' => $row_production["code_rubrique"],
                         'slug' => '',
             );

            $poid = $poid + $row_production['Poids'];

            $test_ml = 1;

        }
        else
        {




              ${"villes$i"}[]=  array( 'name' => $row["ville"]  );
      if ($row_production['ville_supp'])
            { 
    $myString_ville = $row_production['ville_supp'];
                $myArray_ville = explode(',', $myString_ville);

                foreach ($myArray_ville as $value_ville)
                {
                    if ($value_ville)
                    {
 
                        ${"villes$i"}[] = array('name' => $value_ville);

            }                                     
}}                                                                                                            
           



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


                        ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value),
                         'code' => $prest_code,
                         'slug' => ''
                         );

                    }
                }

            }


            if ($row_production['prest_supp'])
            {
                $myString_supp = $row_production['prest_supp'];
                $myArray_supp = explode(',', $myString_supp);

                foreach ($myArray_supp as $value_supp)
                {
                    if ($value_supp)
                    {
                        $prest_code_supp = slugify(adilsoft_string_latin($value_supp));

                        $prestations[] = array(
                            'prestation' => $value_supp,
                            'code' => $prest_code_supp,
                            'slug' => $prest_code_supp,
                        );


                         ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value_supp),
                         'code' => $prest_code_supp,
                         'slug' => ''
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

                        ${"mot_cles$i"}[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value_marque),
                         'code' => $marque_code,
                         'slug' => ''
                         );
                    }
                }

            }





            $rubriques[] = array(

                'rubrique' => $row_production["rubrique"],
                'code' => $row_production["code_rubrique"],
                'slug' => slugify(adilsoft_string_latin($row_production["rubrique"])) ,
            );








                                                                        if (!empty($row_production["code_rubrique"])) { 

                                                             $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` = '".$row_production["code_rubrique"]."'"); 

                                                               if (!empty($renvois)) { 
                                                                         
                                                                         foreach ($renvois as $ren ) {
                                                                                      ${"mot_cles$i"}[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );
                                                                                      ${"mot_cles$i"}[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique_Papier"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );





                                                                                    }

                                                                         }
                                                                                            
                                                                                    

                                                                         }

             ${"mot_cles$i"}[]=  array(

                         'mot' =>  replace_microsolft_apostrophe($row_production["rubrique"]),
                         'code' => $row_production["code_rubrique"],
                         'slug' => '',
             );


        }





    }
    else
    {

        $poid = $poid + $row_production['Poids'];

    }

    // end module_logo


    // vignette VA et VL 

    if ($row_production['code_produit'] == 'VA')
    {
        $vignette_va = 1;



            if ($row_production['vignette_rubriques'])
            {



                $vignette_rubriques = $row_production['vignette_rubriques'];
                $myArray_vignette_rubriques = explode(',', $vignette_rubriques);

                foreach ($myArray_vignette_rubriques as $value_vignette_va)
                {

                    if ($value_vignette_va)
                    {

                        $vignette_va_rubriques[] = array(
                            'va_rubriques' => $value_vignette_va,
                        );



                    }
                }



            }

                    $vignette_va_rubriques[] = array(
                            'va_rubriques' => $search,
                        );



        }

    if ($row_production['code_produit'] == 'VL')
    {
        $vignette_vl = 1;



            if ($row_production['vignette_localites'])
            {



                $vignette_localites = $row_production['vignette_localites'];
                $myArray_vignette_localites = explode(',', $vignette_localites);

                foreach ($myArray_vignette_localites as $value_vignette_vl)
                {

                    if ($value_vignette_vl)
                    {

                        $vignette_vl_localites[] = array(
                            'vv_localites' => $value_vignette_vl,
                        );



                    }
                }



            }

        }


    if ($row_production['ville_sl']){
        $limitrophe =$row_production['ville_sl'];

        $villes1[]=  array( 'name' => $row_production["ville_sl"]  );
        $villes2[]=  array( 'name' => $row_production["ville_sl"]  );
        $villes3[]=  array( 'name' => $row_production["ville_sl"]  );
        $villes4[]=  array( 'name' => $row_production["ville_sl"]  );
        $villes5[]=  array( 'name' => $row_production["ville_sl"]  );


    }

    // vignette VA et VL END 
    

    // autre produits
    
                                                              // start site web 
                                                                         if (!empty($row["code_firme"])) { 

                                  
                                               


                                                             $sites_data = $myPDO->query("SELECT *  FROM `lien_web` WHERE `code_firme` = '".$row["code_firme"]."'
ORDER BY `lien_web`.`num_ordre` DESC LIMIT 1" ); 


                                                               if (!empty($sites_data)) { 
                                                                     
                                                                         foreach ($sites_data as $sites ) {

                             
                                                                                      $site_web =      array('site_web' =>  $sites["web"] );  ;

                                                                                      $sites=$sites["web"];
                                                                                    }

                                                                         }
                                                                                            
                                                                                    }

                                              // end site web 


    if ($row_production['code_produit'] == 'PJ'){
        $pj =1;
        $pj_desc=$row_production['professionnel_description'] ;

        if($row_production['professionnel_lien']){
            $pj_lien =$row_production['professionnel_lien'];

        }
        elseif($sites){
            $pj_lien =$sites;
        }
    }   

    if ($row_production['code_produit'] == 'W1' or $row_production['code_produit'] == 'W2' or $row_production['code_produit'] == 'W3' or $row_production['code_produit'] == 'W4' or $row_production['code_produit'] == 'W5')
    {
        $pvi = 1;


        $pvi_url_data = $myPDO->query(" SELECT * FROM `pvi` WHERE `code_firme` = '".$code_firme."'   LIMIT 1"); 

                                       foreach ($pvi_url_data as $pvi_u ) {
                                                                                  
                                                                           $pvi_url=      $pvi_u['url'];            
                                                                                            
                                                                                    }



    }

    if ($row_production['code_produit'] == 'CC1' or $row_production['code_produit'] == 'CC2' or $row_production['code_produit'] == 'CC3' or $row_production['code_produit'] == 'CC4')
    {
        $catalogue_co = 1;
    }

    if ($row_production['code_produit'] == 'C1' or $row_production['code_produit'] == 'C2' or $row_production['code_produit'] == 'C3' or $row_production['code_produit'] == 'C4' or $row_production['code_produit'] == 'R2' )
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
             $video_url = $row_production['video'];
           
    }


                // desc profession liberal  DESC2
    if ($row_production['code_produit'] == 'DESC2')
    {
        $desc2 = 1;


            if ($row["code_firme"]){
            $rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique,Lib_Rubrique_Papier FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` = '".$row["code_firme"]."' AND lien.`editable` = '+' LIMIT 1"); 
            }



                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data =array();
                                                                                   $renvoi_data   =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );

                                                                                     $rubriques[]=   array(

                                                                                                 'rubrique' =>  $key["Lib_Rubrique"],
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




    }



                // end desc profession liberal 
               
 

               // desc Description (société) DESC1
    if ($row_production['code_produit'] == 'DESC1')
    {
        $desc1 = 1;

        
        
            if ($row["code_firme"]){
            $rub = $myPDO->query("SELECT lien.`code_rubrique`as code_rubrique ,Lib_Rubrique,Lib_Rubrique_Papier FROM `lien_rubrique_internet` lien INNER JOIN rubriques r on r.`code_rubrique`=lien.`Code_Rubrique` WHERE lien.`code_firme` = '".$row["code_firme"]."' AND lien.`editable` = '+' LIMIT 1"); 
            }



                                                                        if (!empty($rub)) { 


 
                                                                                  $mot_data =array();
                                                                                   $renvoi_data   =array();
                                                                                    foreach ($rub as $key ) {
                                                                                     $mot_data[]=       array(

                                                                                                 'mot' =>  $key["Lib_Rubrique"],
                                                                                                 'code' => $key["code_rubrique"],
                                                                                                 'slug' => slugify(adilsoft_string_latin($key["Lib_Rubrique"])),
                                                                                            );

                                                                                     $rubriques[]=   array(

                                                                                                 'rubrique' =>  $key["Lib_Rubrique"],
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


        
    }

                // end Description (société)


        // start tel1 and tel2
        
                          
                                                                         if (!empty($row["code_firme"])) { 

                                  
                                               
                                                             $tel_datas = $myPDO->query("SELECT * FROM `lien_telephone` WHERE `code_firme` = '".$row["code_firme"]."' ORDER BY `lien_telephone`.`num_ordre` ASC LIMIT 2" ); 


                                                               if (!empty($tel_datas)) { 
                                                                     
                                                                         $i=0;
                                                                         foreach ($tel_datas as $tels ) {
                                                                            $i++;   

                                                                            if ($i==1){
                                                                                      $tel_data1=       array('tel'.$i =>  $tels["tel"] );
                                                                                      $tel__s1=       array('tel'.$i.'_s' =>  preg_replace('/\s+/', '', $tels["tel"]) );

                                                                                      }
                                                                                      else if ($i==2){
                                                                                      $tel_data2=       array('tel'.$i =>  $tels["tel"] );
                                                                                      $tel__s2=       array('tel'.$i.'_s' =>  preg_replace('/\s+/', '', $tels["tel"]) );

                                                                                      }else{
                                                                                          $tel_data3=       array('tel'.$i =>  $tels["tel"] );
                                                                                          $tel__s3=       array('tel'.$i.'_s' =>  preg_replace('/\s+/', '', $tels["tel"]) );
                                                                                      }

                                                                                    }

                                                                         }
                                                                                            
                                                                                    }
                                                               
                                                                                            // end tel1 and tel2

                                                                                                                                                                        // start email 

                                                                         if (!empty($row["code_firme"])) { 

                                                   $lien_email_chek = $myPDO->query("SELECT `email` FROM `lien_email` WHERE `code_firme` LIKE '".$row["code_firme"]."'and `email` IS NOT NULL  ORDER BY `lien_email`.`num_ordre` ASC LIMIT 1" ); 
                                                          foreach ($lien_email_chek as $lien_email ) {
                                                                                    $email_data=   array('mail' =>  $lien_email["email"] );

                                                                                        }
                                                                                    }

                                                                                    // end email                                                                






    if ($row_production['code_produit'] == 'PP')
    {
        $plus_info = 1;
    }

    if ($row_production['code_produit'] == 'PL')
    {
        $pl = 1;


                             $renvois_agenda = $myPDO->query("Select * from telecontact_BackOffice_Site.`rdv` where `code_firme`='".$code_firme."' and active=2 "); 

                                                               if (!empty($renvois_agenda)) { 
                                                                         
                                                                         foreach ($renvois_agenda as $agenda ) {

                                                                                        $code_f=substr($row["code_firme"],2);

                                                                                        $agenda_id=1;
                                                                                        $agenda_url='https://www.e-rdv.ma/rendez-vous.php?id_test='.$code_f.'&id_second='.$agenda["id_user"].'&palette=telecontact';

                                                                      
                                                                      
                                                                                    }

                                                                         }




            if ($row_production['prof_lib_specialites'])
            {



                $myString_spec = $row_production['prof_lib_specialites'];
                $myArray_spec = explode(',', $myString_spec);

                foreach ($myArray_spec as $value_spec)
                {

                    if ($value_spec)
                    {
                        $prest_code_spec = slugify(adilsoft_string_latin($value_spec));

                        $prof_lib_specialites[] = array(
                            'specialite' => $value_spec,
                            'code' => $prest_code_spec,
                            'slug' => $prest_code_spec,
                        );


                        $mot_cles1[]=       array(

                         'mot' =>  replace_microsolft_apostrophe($value_spec),
                         'code' => $prest_code_spec,
                         'slug' => $prest_code_spec
                         );

                    }
                }



            }

            $specialites=array('specialites' => $prof_lib_specialites);  
            $pl_parcours=  array('pl_parcours' => $row_production['prof_lib_parcours']);  
            $pl_diplome=  array('pl_diplome' => $row_production['prof_lib_diplome']);  
            $pl_certification= array('pl_certification' => $row_production['certification']);  
            $pl_langue_parle=array('pl_langue_parle' => $row_production['langue_parlee']);  
            $pl_domaine_competence=  array('pl_domaine_competence' => $row_production['prof_lib_domaine_competence'] );  
            $horaires_ouverture=  array('horaires_ouverture' => $row_production['horaires_ouverture'] );  


            
            $doc       =array_merge($doc, $specialites);
            $doc       =array_merge($doc, $pl_parcours);
            $doc       =array_merge($doc, $pl_diplome);
            $doc       =array_merge($doc, $pl_certification);
            $doc       =array_merge($doc, $pl_langue_parle);
            $doc       =array_merge($doc, $pl_domaine_competence);
            $doc       =array_merge($doc, $horaires_ouverture);


            $rubriques[] = array(

                'rubrique' => $row_production["rubrique"],
                'code' => $row_production["code_rubrique"],
                'slug' =>slugify(adilsoft_string_latin($row_production["rubrique"])),
            );


            

  $mot_cles1[]=       array('mot' =>  replace_microsolft_apostrophe($row_production["rubrique_papier"]), 'code' => $row_production["code_rubrique"], 'slug' => '', );

            
                                                                        if (!empty($row_production["code_rubrique"])) { 

                                                             $renvois = $myPDO->query("SELECT Lib_Rubrique, Code_Rubrique,Lib_Rubrique_Papier FROM `rubrique_voir` INNER JOIN `rubriques` ON `Code_Rubrique` = `code_rubrique1`WHERE `code_rubrique2` ='".$row_production["code_rubrique"]."'"); 

                                                               if (!empty($renvois)) { 
                                                                         
                                                                         foreach ($renvois as $ren ) {
                                                                                      $mot_cles1[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );

                                                                                     $mot_cles1[]=       array('mot' =>  replace_microsolft_apostrophe($ren["Lib_Rubrique_Papier"]), 'code' => $ren["Code_Rubrique"], 'slug' => '', );


                                                                                    }

                                                                         }
                                                                                            
                                                                                    

                                                                         }


             $mot_cles1[]=  array(

                         'mot' =>  replace_microsolft_apostrophe($row_production["rubrique"]),
                         'code' => $row_production["code_rubrique"],
                         'slug' =>slugify(adilsoft_string_latin($row_production["rubrique"])),
             );

   
    }

    // end autre produits
    

    
}

/*echo $poid . '<br/>';

print_r($villes);
*/


// production end from here









                                                                     }

/*
                                                                     print_r($mot_cles1);
                                                                     die();*/

// actualitee start 
$doc_2=array();

// echo  'code_firme  '.$code_firme.'<br/>';
 $myPDO_sec = new PDO('mysql:host=localhost;dbname=telecontact_BackOffice_Site', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
   

                $actualite = $myPDO_sec->query("SELECT * FROM `actualite` WHERE `code_firme` = '$code_firme'");
      
                $actualite =$actualite->fetchAll();

              if(!empty($actualite)){

                if(!empty($actualite)){
                    $count_presentation_car = strlen($actualite[0]['livraison']);
                }else{
                    $count_presentation_car = 0;
                }
                




                $actualite = array_map(function($c){

                    $c['conditions'] = utf8_encode($c['conditions']);
                    $c['livraison'] = utf8_encode($c['livraison']);
                    $c['savoir'] = utf8_encode($c['savoir']);

                    return $c;
                }, $actualite);


                if(!empty($actualite[0]['prestations'])){
                    $prestation = explode(',', $actualite[0]['prestations']);
                    $prestation = str_replace('"','', $prestation);
                    $prestation = str_replace('[','', $prestation);
                    $prestation = str_replace(']','', $prestation);
                }else{
                    $prestation = '';
                }


                if(!empty($actualite[0]['produits'])){
                    $produit = explode(',', $actualite[0]['produits']);
                    $produit = str_replace('"','', $produit);
                    $produit = str_replace('[','', $produit);
                    $produit = str_replace(']','', $produit);
                }else{
                    $produit = '';
                }


                if(!empty($actualite[0]['marques'])){
                    $marque = explode(',', $actualite[0]['marques']);
                    $marque = str_replace('"','', $marque);
                    $marque = str_replace('[','', $marque);
                    $marque = str_replace(']','', $marque);
                }else{
                    $marque = '';
                }


                if(!empty($actualite[0]['services_plus'])){
                    $service = explode(',', $actualite[0]['services_plus']);
                    $service = str_replace('"','', $service);
                    $service = str_replace('[','', $service);
                    $service = str_replace(']','', $service);
                }else{
                    $service = '';
                }

                if(!empty($actualite[0]['actes'])){
                    $acte = explode(',', $actualite[0]['actes']);
                    $acte = str_replace('"','', $acte);
                    $acte = str_replace('[','', $acte);
                    $acte = str_replace(']','', $acte);
                }else{
                    $acte = '';
                }

                if(!empty($actualite[0]['zones_de_travail'])){
                    $zones_de_travail = explode(',', $actualite[0]['zones_de_travail']);
                    $zones_de_travail = str_replace('"','', $zones_de_travail);
                    $zones_de_travail = str_replace('[','', $zones_de_travail);
                    $zones_de_travail = str_replace(']','', $zones_de_travail);
                }else{
                    $zones_de_travail = '';
                }

                /*var_dump($produit);die('aa');*/

                $existe_facebook     = $myPDO_sec->query("SELECT * FROM `reseaux_sociaux__actu` WHERE `code_firme` = '". $code_firme ."' AND `type` = 'facebook'");
                $existe_instagram    = $myPDO_sec->query("SELECT * FROM `reseaux_sociaux__actu` WHERE `code_firme` = '". $code_firme ."' AND `type` = 'instagram'");
                $existe_linkedin     = $myPDO_sec->query("SELECT * FROM `reseaux_sociaux__actu` WHERE `code_firme` = '". $code_firme ."' AND `type` = 'linkedin'");
                $existe_whatsapp     = $myPDO_sec->query("SELECT * FROM `reseaux_sociaux__actu` WHERE `code_firme` = '". $code_firme ."' AND `type` = 'whatsapp'");
                                $existe_facebook =$existe_facebook->fetchAll();
                                $existe_instagram =$existe_instagram->fetchAll();
                               $existe_linkedin =$existe_linkedin->fetchAll();
                                $existe_whatsapp =$existe_whatsapp->fetchAll();
           


                    $zon_arr=array();

                    if (is_null($actualite[0]['zones_de_travail'])){}else{
if($actualite[0]['zones_de_travail']){



    if(!empty($actualite[0]['zones_de_travail'])){

                        foreach (json_decode($actualite[0]['zones_de_travail']) as $zon) {

                            // echo "SELECT ville FROM BD_EDICOM.`villes` where code =".$zon;
            if ($zon!='zones_de_travail'){
                             $zones_villes     = $myPDO_sec->query("SELECT ville FROM BD_EDICOM.`villes` where code =".$zon);
                             $zones_villes  = $zones_villes->fetchAll(); 
                             $zon_arr[]=$zones_villes[0]['ville'];

                         }



         }
}



}
}
        // echo $code_firme.'<br/>';



$livraison=$actualite[0]['livraison'];
$valider=$actualite[0]['valider'];
$zon_arr=$zon_arr;
$heure=$actualite[0]['heure'];
$prestations_arr=json_decode($actualite[0]['prestations']);
$produits_arr=json_decode($actualite[0]['produits']);
$marques_arr=json_decode($actualite[0]['marques']);
$services_plus_arr=json_decode($actualite[0]['services_plus']);
$paiement=$actualite[0]['paiement'];
$numero_urgence=$actualite[0]['numero_urgence'];
$site_web_=$actualite[0]['site_web'];
   if ($existe_facebook){
                      
$facebook=$existe_facebook[0]['lien'];
                            }else{
$facebook="";
}


        if ($existe_whatsapp){

                   
$whatsapp=$existe_whatsapp[0]['lien'];

                        }else{

                                $whatsapp="";
                            }


              if ($existe_linkedin){

                            $linkedin=$existe_linkedin[0]['lien'];
}else{

$linkedin="";
                            }

                 if ($existe_instagram){
                            $instagram=$existe_instagram[0]['lien'];
                        }else{ $instagram="";}

$actes_arr=json_decode($actualite[0]['actes']);
$langues_arr=json_decode($actualite[0]['langues']);

  


/*                                          $doc_2 = array(
                                 'presentation_actu'        => $livraison,   
                                 'etat_actu' => $valider,
                                 'zone_actu'        => $zon_arr,
                                 'horaires_actu' => $heure,
                                 'prests_actu'        => $prestations_arr,                                                             
                                 'produits_actu' => $produits_arr,
                                 'marques_actu' => $marques_arr,
                                 'service_plus_actu'        => $services_plus_arr,                                                              
                                 'moyens_paiement_actu' => $paiement,
                                 'numero_urgence_actu'        => $numero_urgence,                                                            
                                 'site_web_actu' => $site_web_,
                                 'fb_actu' => $facebook,
                                 'wp_actu'        => $whatsapp,                                                                     
                                 'in_actu'        => $linkedin,                                                               
                                 'insta_actu' => $instagram,
                                 'actes_actu'        => $actes_arr,                                                         
                                 'langue_actu' => $langues_arr                                                             
                                 );*/

                                          $livraison_arr =array('presentation_actu'        => $livraison);
                                          $valider_arr =array('etat_actu' => $valider);
                                          $zon_arr_arr =array('zone_actu'        => $zon_arr);
                                          $heure_arr =array('horaires_actu' => $heure);
                                          $prestations_arr_arr =array('prests_actu'        => $prestations_arr);
                                          $produits_arr_arr =array('produits_actu' => $produits_arr);
                                          $marques_arr_arr =array('marques_actu' => $marques_arr);
                                          $services_plus_arr_arr =array('service_plus_actu'        => $services_plus_arr);
                                          $paiement_arr =array('moyens_paiement_actu' => $paiement);
                                          $numero_urgence_arr =array('numero_urgence_actu'        => $numero_urgence);
                                          $site_web__arr =array('site_web_actu' => $site_web_);
                                          $facebook_arr =array('fb_actu' => $facebook);
                                          $whatsapp_arr =array('wp_actu'        => $whatsapp);                                          
                                          $actes_arr_arr =array('actes_actu'   => $actes_arr);
                                          $linkedin_arr =array('in_actu'        => $linkedin);
                                          $instagram_arr =array('insta_actu' => $instagram);     
                                          $langues_arr_arr =array('langue_actu' => $langues_arr);     
$doc       =array_merge($doc, $livraison_arr);
$doc       =array_merge($doc, $valider_arr);
$doc       =array_merge($doc, $zon_arr_arr);
$doc       =array_merge($doc, $heure_arr);
$doc       =array_merge($doc, $prestations_arr_arr);
$doc       =array_merge($doc, $produits_arr_arr);
$doc       =array_merge($doc, $marques_arr_arr);
$doc       =array_merge($doc, $services_plus_arr_arr);
$doc       =array_merge($doc, $paiement_arr);
$doc       =array_merge($doc, $numero_urgence_arr);
$doc       =array_merge($doc, $site_web__arr);
$doc       =array_merge($doc, $facebook_arr);
$doc       =array_merge($doc, $whatsapp_arr);
$doc       =array_merge($doc, $actes_arr_arr);
$doc       =array_merge($doc, $linkedin_arr); 
$doc       =array_merge($doc, $instagram_arr);
$doc       =array_merge($doc, $langues_arr_arr); 




                                         
                                      }
                                                                     // actualitee end 



/*print_r($rubriques);

die('here we go');*/

if (empty($villes1)) {
           $second_array = array('villes' => $villes_data);
           $villes_array1  = array('villes1' => $villes_data);
}else{
           $second_array = array('villes' => $villes);
           $villes_array1  = array('villes1' => $villes1);
}
if (empty($mot_cles1)){
          $new_array = array('mot_cle' => $mot_data);
          $mot_array1  = array('mot_cle1'  => $mot_data);

          $national       =array_merge($national, $mot_data);
}
else{
          $new_array = array('mot_cle' => $mot_cles);
           $mot_array1  = array('mot_cle1'  => $mot_cles1);
             $national       =array_merge($national, $mot_cles1);

}
            $pj_array=array('pj'=>$pj);
            $pj_desc_array=array('pj_desc'=>$pj_desc);
            $pj_lien_array=array('pj_lien'=>$pj_lien);
            $limitrophe_array=  array('limitrophe'=>$limitrophe);

                $pvi_url_array=array('pvi_url'=>$pvi_url);
    
           $villes_array2  = array('villes2' => $villes2);
           $villes_array3  = array('villes3' => $villes3);
           $villes_array4  = array('villes4' => $villes4);
           $villes_array5  = array('villes5' => $villes5);
           $villes_array6  = array('villes6' => $villes6);
           $villes_array7  = array('villes7' => $villes7);
           $villes_array8  = array('villes8' => $villes8);
           $villes_array9  = array('villes9' => $villes9);
           $villes_array10 = array('villes10' => $villes10);



           $mot_array2  = array('mot_cle2'  => $mot_cles2);
           $mot_array3  = array('mot_cle3'  => $mot_cles3);
           $mot_array4  = array('mot_cle4'  => $mot_cles4);
           $mot_array5  = array('mot_cle5'  => $mot_cles5);
           $mot_array6  = array('mot_cle6'  => $mot_cles6);
           $mot_array7  = array('mot_cle7'  => $mot_cles7);
           $mot_array8  = array('mot_cle8'  => $mot_cles8);
           $mot_array9  = array('mot_cle9'  => $mot_cles9);
           $mot_array10 = array('mot_cle10' => $mot_cles10);


               $national       =array_merge($national, $mot_cles2);
               $national       =array_merge($national, $mot_cles3);
               $national       =array_merge($national, $mot_cles4);
               $national       =array_merge($national, $mot_cles5);
               $national       =array_merge($national, $mot_cles6);
               $national       =array_merge($national, $mot_cles7);
               $national       =array_merge($national, $mot_cles8);
               $national       =array_merge($national, $mot_cles9);
               $national       =array_merge($national, $mot_cles10);


               $national_doc =array('national'=> $national );
                

                 $doc       =array_merge($doc,$email_data);

               $doc       =array_merge($doc, $national_doc);

               $doc       =array_merge($doc, $villes_array1);
               $doc       =array_merge($doc, $villes_array2);
               $doc       =array_merge($doc, $villes_array3);
               $doc       =array_merge($doc, $villes_array4);
               $doc       =array_merge($doc, $villes_array5);
               $doc       =array_merge($doc, $villes_array6);
               $doc       =array_merge($doc, $villes_array7);
               $doc       =array_merge($doc, $villes_array8);
               $doc       =array_merge($doc, $villes_array9);
               $doc       =array_merge($doc, $villes_array10);

               $doc       =array_merge($doc, $mot_array1);
               $doc       =array_merge($doc, $mot_array2);
               $doc       =array_merge($doc, $mot_array3);
               $doc       =array_merge($doc, $mot_array4);
               $doc       =array_merge($doc, $mot_array5);
               $doc       =array_merge($doc, $mot_array6);
               $doc       =array_merge($doc, $mot_array7);
               $doc       =array_merge($doc, $mot_array8);
               $doc       =array_merge($doc, $mot_array9);
               $doc       =array_merge($doc, $mot_array10);
               
               $doc       =array_merge($doc, $pj_array);
               $doc       =array_merge($doc, $pj_desc_array);   
               $doc       =array_merge($doc, $pj_lien_array);
               $doc       =array_merge($doc, $limitrophe_array);    
               $doc       =array_merge($doc, $pvi_url_array);    
if(!empty($limitrophe)){
$villes_filter[]=  array( 'name' => $limitrophe  );}
$villes_filter[]=  array( 'name' => $row["ville"]  );

$villes_filter_arr        =array('villes_filter'=>$villes_filter);


$agenda_id_arr  =       array('agenda_id'=>$agenda_id);
$agenda_url_arr =       array('agenda_url'=>$agenda_url);

$desc1_arr =           array('act_plus'=>$desc1);
$desc2_arr =           array('actualiter_id'=>$desc2);


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
$module_logo_arr =  array('module_logo' => htmlspecialchars_decode($module_logo));

$video_graphique_url_arr =array('video_graphique_url'=> $video_graphique_url);
$video_url_arr  =array('video_url'=> $video_url);



$vignette_va_arr                =           array('vignette_va'=>$vignette_va);
$vignette_va_rubriques_arr      =           array('vignette_va_rubriques'=>$vignette_va_rubriques);
$vignette_vl_localites_arr      =           array('vignette_vl_localites'=>$vignette_vl_localites);
$vignette_vl_arr                =           array('vignette_vl'=>$vignette_vl);

if (  $pin ){
$pining =  array('pin' => $pin);
 $doc       =array_merge($doc, $pining);

}
                                                                     $doc       = array_merge($doc, $villes_filter_arr);

                                                                     $doc       = array_merge($doc, $agenda_id_arr);
                                                                     $doc       = array_merge($doc, $agenda_url_arr);   

                                                                     $doc       = array_merge($doc, $tel_data1);
                                                                     $doc       = array_merge($doc, $tel__s1);   
                                                                     $doc        = array_merge($doc, $tel_data2);
                                                                     $doc       = array_merge($doc, $tel__s2);   
                                                                     $doc       = array_merge($doc, $site_web);   
                                                                     $secu      = array('succursale' => $secursa);
                                                                     $doc       = array_merge($doc , $secu);
                                                                    $doc        = array_merge($doc, $desc1_arr);
                                                                     $doc       = array_merge($doc, $desc2_arr);   

                                                                     $doc       =array_merge($doc, $video_graphique_url_arr);
                                                                     $doc       =array_merge($doc, $video_url_arr);   

                                                                    $doc       =array_merge($doc, $vignette_va_arr);
                                                                    $doc       =array_merge($doc, $vignette_va_rubriques_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_localites_arr);
                                                                    $doc       =array_merge($doc, $vignette_vl_arr);

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
         $requestURL = 'http://edicomelastic1.odiso.net:9200/_bulk';
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