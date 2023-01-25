<?php

    session_start();

    $client = $_SESSION["utilisateur_web_id"];

    $code_firme = $_GET["code_firme"];

    $code_firme_with_map = 'MA' . $_GET["code_firme"];

    $user = "presencemedia";
    $pass = "tX632tpv39jD5KRC";

    try {
      $connectionTc = new PDO('mysql:host=walibix2.odiso.net:3306;dbname=telecontact_BackOffice_Site', $user, $pass , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $connectionTc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
      echo $e->getMessage();
    }

    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    // convert day in french counter day
    function ConvertDateToFrenchDay($date) {
     if(!ctype_digit($date))
      $date = strtotime($date);
     if(date('Y-m-d', $date) == date('Y-m-d')) {
      $diff = time()-$date;
      if($diff <= 0)
        return 'À l\'instant';
      else if($diff < 60) /* moins de 60 secondes */
       return 'Il y\'a '.$diff.' sec';
      else if($diff < 3600) /* moins d'une heure */
       return 'Il y\'a '.round($diff/60, 0).' minutes';
      else if($diff < 10800) /* moins de 3 heures */
       return 'Il y\'a '.round($diff/3600, 0).' heures';
      else /*  plus de 3 heures ont affiche ajourd'hui à HH:MM:SS */
       return 'Aujourd\'hui';
     }
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 1 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 1 day 23 hours')))
      return 'Hier'/*.date('H:i:s', $date)*/;
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 2 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 2 day 23 hours')))
      return 'Il y\'a 2 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 3 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 3 day 23 hours')))
      return 'Il y\'a 3 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 4 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 4 day 23 hours')))
      return 'Il y\'a 4 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 5 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 5 day 23 hours')))
      return 'Il y\'a 5 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 6 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 6 day 23 hours')))
      return 'Il y\'a 6 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 7 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 7 day 23 hours')))
       return 'Il y\'a 7 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 8 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 8 day 23 hours')))
       return 'Il y\'a 8 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 9 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 9 day 23 hours')))
       return 'Il y\'a 9 jours';
       else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 10 day')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 10 day 23 hours')))
         return 'Il y\'a 10 jours';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 1 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 1 week 23 hours')))
       return 'Il y\'a une semaine';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 2 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 2 week 23 hours')))
       return 'Il y\'a 2 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 3 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 3 week 23 hours')))
       return 'Il y\'a 3 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 4 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 4 week 23 hours')))
       return 'Il y\'a 4 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 5 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 5 week 23 hours')))
       return 'Il y\'a 5 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 6 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 6 week 23 hours')))
       return 'Il y\'a 6 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 7 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 7 week 23 hours')))
       return 'Il y\'a 7 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 8 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 8 week 23 hours')))
       return 'Il y\'a 8 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 9 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 9 week 23 hours')))
       return 'Il y\'a 9 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 10 week')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 10 week 23 hours')))
       return 'Il y\'a 10 semaines';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 1 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 1 month 3 week')))
       return 'Il y\'a 1 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 2 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 2 month 3 week')))
       return 'Il y\'a 2 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 3 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 3 month 3 week')))
       return 'Il y\'a 3 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 4 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 4 month 3 week')))
       return 'Il y\'a 4 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 5 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 5 month 3 week')))
       return 'Il y\'a 5 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 6 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 6 month 3 week')))
       return 'Il y\'a 6 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 7 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 7 month 3 week')))
       return 'Il y\'a 7 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 8 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 8 month 3 week')))
       return 'Il y\'a 8 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 9 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 9 month 3 week')))
       return 'Il y\'a 9 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 10 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 10 month 3 week')))
       return 'Il y\'a 10 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 11 month')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 11 month 3 week')))
       return 'Il y\'a 11 mois';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 1 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 1 year 11 month')))
       return 'Il y\'a un an';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 2 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 2 year 11 month')))
       return 'Il y\'a 2 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 3 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 3 year 11 month')))
       return 'Il y\'a 3 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 4 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 4 year 11 month')))
       return 'Il y\'a 4 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 5 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 5 year 11 month')))
       return 'Il y\'a 5 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 6 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 6 year 11 month')))
       return 'Il y\'a 6 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 7 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 7 year 11 month')))
       return 'Il y\'a 7 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 8 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 8 year 11 month')))
       return 'Il y\'a 8 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 9 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 9 year 11 month')))
       return 'Il y\'a 9 ans';
     else if(date('Y-m-d', $date) >= date('Y-m-d', strtotime('- 10 year')) && date('Y-m-d', $date) <= date('Y-m-d', strtotime('- 10 year 11 month')))
       return 'Il y\'a 10 ans';
     else
      return 'Le '.date('d/m/Y à H:i:s', $date);
    }

    $stmtRatingFiche = $connectionTc->prepare("SELECT AVG(r.`note_globale`) AS noteGlobale , COUNT(r.`id`) AS avis
    FROM `reviews` AS r
    WHERE r.`code_firme` = ?");

    if($stmtRatingFiche->execute(array($code_firme))) {

      $ratingFiche = $stmtRatingFiche->fetch(PDO::FETCH_ASSOC);

    }

    function getHttpResponseCode(string $url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }


    /* Start adding avis */
    if($isAjax && $_POST["act"] == "addAvis") {

      header("Content-Type: application/json");

      $response = array();

      $request = $_POST;

      unset($request["act"]);

      if(empty($client)) {
        // if client is not connected
        $response["clientNotFound"] = false;

      } else if ($request["rating"] > 0) {

        $rating = $request["rating"];

        $exprimezVous = $request["exprimez-vous"];

        // TODO: Add insert query

        try {

          $stmtExprimezVous = $connectionTc->prepare("INSERT INTO `reviews`(`code_firme`, `client_id`, `note_globale`, `commentaire`, `date_creation` , `publication` , `etat`, `whoami`)
          VALUES ( ? , ? , ? , ? , ? , ? , ? , ?)");
  
          if ($stmtExprimezVous->execute(array($code_firme, $_SESSION['utilisateur_web_id'] , $rating , 	$exprimezVous  , date("Y-m-d H:i:s") , 2 , 0 , $client ))) {

            $_SESSION["has_been_voted"] = true;
  
            $response["success"] = "Votre avis à été ajouter avec succès";
  
          }

        } catch(PDOException $e) {
          $response["error"] = $e->getMessage();
        }

        

      } else {
        // if form is failed
        $response["error"] = "Merci de spécifier la note globale";

      }

      echo json_encode($response);

      exit;
    }
    /* End adding avis */

    /* Start corriger fiche */
    if($isAjax && $_POST["act"] == "addCorrigerFiche") { 
      header("Content-Type: application/json");

      $response = array();

      $request = $_POST;

      unset($request["act"]);



      if (!empty($_POST)) {

          $stmtAnomalie = $connectionTc->prepare("INSERT INTO `anomalie`(`cfirme`, `email`, `nom`, `adresse`, `telephone`, `site`, `message`, `date`) VALUES (? , ? , ? , ? , ? , ? , ? , ?)");

          if($stmtAnomalie->execute(array($_POST["code_firme"] , $_POST["email"] , $_POST["nom-complet"] , $_POST["address"] , $_POST["telephone"] , $_POST["site"] , $_POST["message"] , date('Y-m-d')))) {
            
            $response["success"] = "Votre message à été envoyer avec succès"; 
  
          } else {
            
            $response["error"] = "Votre message n'a pas pu envoyer";
  
          }

          echo json_encode($response);
      
          exit;

      }

      
    }
    /* End corriger fiche */

    if ($isAjax && $_GET["is_map"] === "yes") {
      
      header('Content-Type: application/json');

      $response = array();

      $latitude = $_GET['latitude'];
      $longitude = $_GET['longitude'];

      $response["content"] = array(
        "url_map" => '/trouver/media/js/leaflet.js' , 
        "url_map_fullscreen" => '/trouver/media/js/Leaflet.fullscreen.min.js',
        "latitude" => $latitude,
        "longitude" => $longitude
      );

      echo json_encode($response);

      exit;

    }

    if ($isAjax && $_GET["is_galerie_photo"] === "yes") {

      header('Content-Type: application/json');
      $response = array();

      $response["data"] = array();

      // societe
      if ($_GET["is_societe"] === "yes") {

        $stmtPhotoSrc = $connectionTc->prepare("SELECT _image , titre  FROM photoscr  WHERE cfirme = ?");

      } else {

        // profession liberale
        $stmtPhotoSrc = $connectionTc->prepare("SELECT _image  FROM photos  where  cfirme = ?");

      } 
      
      if($stmtPhotoSrc->execute(array($code_firme))) {
        $photos = $stmtPhotoSrc->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($photos)) {
          $response["data"] = $photos;
        }
      }

      echo json_encode($response);
      exit;
    
    }

    /* Start ajouter agenda */
    if ($isAjax && $_GET["is_agenda"] === "yes") {
      
      header('Content-Type: application/json');
      
      $response = array();

      $agenda_url = $_GET['agenda_url'];

      $response["content"] = array(
        "html_content" => '<div id="cleanto" class="direct-load" data-url="' . $agenda_url . '"></div>',
        "url" => 'https://www.e-rdv.ma/assets/js/embed.js?time=1600101288'
      );

      echo json_encode($response);
      exit; 

    }
    /* End ajouter agenda */

    /* Start laisser un avis */

    if ($isAjax && $_POST["laisser_avis"] == "yes") {

      header('Content-Type: application/json');

      $response = array();

      $rating = $_POST["avis"];

      $exprimezVous = $_POST["exprimez-vous"];

      $code_firme = $_POST["code_firme"];

      if(empty($client)) {
        // if client is not connected
        $response["clientNotFound"] = false;

      } else if ($rating > 0) {

        try {

          $stmtExprimezVous = $connectionTc->prepare("INSERT INTO `reviews`(`code_firme`, `client_id`, `note_globale`, `commentaire`, `date_creation` , `publication` , `etat`, `whoami`)
          VALUES ( ? , ? , ? , ? , ? , ? , ? , ?)");
  
          if ($stmtExprimezVous->execute(array($code_firme, $_SESSION['utilisateur_web_id'] , $rating , 	$exprimezVous  , date("Y-m-d H:i:s") , 2 , 0 , $client ))) {
  
            $response["success"] = "Votre avis à été ajouter avec succès";
  
          }

        } catch(PDOException $e) {

          $response["error"] = $e->getMessage();
        
        }

        

      } else {
        // if form is failed
        $response["error"] = "Merci de spécifier la note globale";

      }

      echo json_encode($response);

      exit;
    }

    if ($isAjax && $_POST["laisser_avis_new"] == "yes") {

      header('Content-Type: application/json');

      $response = array();

      $response["msg"] = "bonjour tout le monde laisser une avis new";

      echo json_encode($response);
      exit; 

    }

    /* End laisser un avis */

    /* Start avis list */

    if ($isAjax && $_GET["fiche_comments_list"] == "yes") {

      header('Content-Type: application/json');

      $code_firme = $_REQUEST["code_firme"];

      $response = array();

      $response["isFullList"] = false;

      $stmtCommentaires = $connectionTc->prepare("SELECT r.`id`, r.`titre_commentaire`, r.`commentaire`, r.`date_creation`, r.`note_globale`, r.`p1`, r.`p2`, r.`p3`, r.`p4`,
        CASE WHEN r.`whoami` = ? THEN cu.`nom` WHEN r.`whoami` = ? THEN ecu.`raison_sociale` ELSE u.`nom` END AS nom,
        CASE WHEN r.`whoami` = ?  THEN cu.`prenom` WHEN r.`whoami` = ? THEN '' ELSE u.`prenom` END AS prenom,
        p.`response`, p.`date_creation` AS dc
        FROM telecontact_BackOffice_Site.`reviews` r
        LEFT JOIN replay p ON r.`id` = p.`comment_id`
        LEFT JOIN espace_clients.`utilisateurs` ecu ON ecu.`id_user` = r.`client_id`
        LEFT JOIN telecontact_BackOffice_Site.`MOBILE_utilisateur_web` u ON r.`client_id` = u.`id_user`
        LEFT JOIN CRM_EDICOM.`tts_utilisateur` cu ON r.`client_id` = cu.`id`
        WHERE r.`code_firme` = ? AND r.`publication` = ? ORDER BY r.`id` DESC");

      if ($stmtCommentaires->execute(array(1 , 3 , 1 , 3 , $code_firme , 2))) {

        $list_avis = $stmtCommentaires->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($list_avis)) {

          $list_avis = array_map(function($comment) {

            $comment["date_creation_french_day"] = ConvertDateToFrenchDay($comment["date_creation"]);
  
            $comment["full_name"] = $comment["nom"] . ' ' . $comment["prenom"];

            return $comment;

          } , $list_avis);

          $response["isFullList"] = true;
          
          $response["comments"] = $list_avis;
        
        }
      
      }

      echo json_encode($response);
      exit; 

    }

    /* End avis list */

     // getting the domain name from url
     function get_domain($url) {

      $pieces = parse_url($url);

      $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];

      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {

        return $regs['domain'];
      
      }
      
      return false;
    
    }


?>
