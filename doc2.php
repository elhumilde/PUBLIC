<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$code_firme ='2145653';

$doc=array();
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
                 
if(!$actualite[0]['zones_de_travail']){
if(!empty($actualite[0]['zones_de_travail'])){
   echo  array_count_values($actualite[0]['zones_de_travail']);

    die();
                        foreach (json_decode($actualite[0]['zones_de_travail']) as $zon) {

                            // echo "SELECT ville FROM BD_EDICOM.`villes` where code =".$zon;
   $myPDO_sec_2 = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
   					if ($zon=='zones_de_travail'){}else{
                             $zones_villes     = $myPDO_sec->query("SELECT ville FROM BD_EDICOM.`villes` where code =".$zon);
							$zones_villes =$zones_villes->fetchAll();
                             $zon_arr[]=$zones_villes[0]['ville'];
}


         }
}
}



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
$site_web=$actualite[0]['site_web'];
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

         $b = array();
 
         $sets = array();
 
         $params = array(
             '_index' => 'telecontact42'
            
         );


                                          $doc_2 = array(
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
                                 'site_web_actu' => $site_web,
                                 'fb_actu' => $facebook,
                                 'wp_actu'        => $whatsapp,                                                                     
                                 'in_actu'        => $linkedin,                                                               
                                 'insta_actu' => $instagram,
                                 'actes_actu'        => $actes_arr,                                                         
                                 'langue_actu' => $langues_arr                                                             
                                 );


$doc       =array_merge($doc, $doc_2);

print_r($doc  );
                                         
                                      }

?>