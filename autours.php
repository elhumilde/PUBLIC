<!DOCTYPE html>
 <?php require_once "config/db_connection.php"; ?>

<html>
<head>
  <meta charset="ISO-8859-1" />
  <title>Les pharmacies de garde les plus proche de moi</title>
 <link rel="shortcut icon" href="/trouver/media/images/favicon.ico">
  <meta name="Description" content="Les pharmacies de garde les plus proche de moi" lang="fr" xml:lang="fr">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
   <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
   <link href="/trouver/media/css/font-awesome.min.css" rel="stylesheet">

   <link rel="stylesheet" href="/trouver/media/osm_files/css/pg-styles.css">
   <script type="text/javascript" src="/trouver/media/js/jquery2.js"></script>
</head>
<body style="margin: 0">


  <input type="hidden" name="lat" id="lat" value="">
  <input type="hidden" name="lon" id="lon" value="">


  <div id="carte"></div>




  <!-- fichier js -->

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>


   <script src="/trouver/media/osm_files/js/geocodeur.js"></script>

   <script src="/trouver/media/osm_files/js/routing-machine.js"></script>
<!--     -->

 <!--   <script src="/trouver/osm_files/js/scripts.js"></script> -->

   <script>



   

    const checkmk = `<svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"><path stroke="black" stroke-width="1.5%" opacity="0.8" fill="brown" d="M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1Z"></path></svg>`;

      function checkmk_mk(color) {
    // assume checkmk has `brown` only 1 place
    return checkmk.replace(/brown/g, color);
  }

    const svgpin_Url = encodeURI("data:image/svg+xml;utf-8," + checkmk_mk("red"));
    const svgpin_Url2 = encodeURI("data:image/svg+xml;utf-8," + checkmk_mk("green"));
    const svgpin_Url3 = encodeURI("data:image/svg+xml;utf-8," + checkmk_mk("black"));



    const svgpin_Icon = L.icon({
      iconUrl: '/trouver/media/osm_files/images/man.png',
      iconSize: [40, 40],
      iconAnchor: [20, 20],
      popupAnchor: [0, -22]
    });
    const svgpin_Icon2 = L.icon({
      iconUrl: '/trouver/media/osm_files/images/maps-and-flags.svg',
      iconSize: [40, 40],
      iconAnchor: [20, 20],
      popupAnchor: [0, -22]
    });
    const svgpin_Icon3 = L.icon({
      iconUrl: '/trouver/media/osm_files/images/map_icon_yellow.svg',
      iconSize: [40, 40],
      iconAnchor: [20, 20],
      popupAnchor: [0, -22]
    });

       
      function getLocation() {
        
          if (navigator.geolocation) {
            navigator.geolocation.watchPosition(redirectToPosition);
          }else { 
            
          }
      }

      function redirectToPosition(position) {
         window.location='/pharmacie-de-garde/pharmacie-de-garde-proche-de-moi.html?lat='+position.coords.latitude+'&long='+position.coords.longitude;
      }
 
</script>

 <?php

   $latitude_pos= 33.5020032;/*$_GET['lat']*/
   $longitude_pos= -7.6644352;/*$_GET['long']*/
    



   if($latitude_pos){

?>


<?php
   }else{

?>
<script type="text/javascript"> getLocation();</script> 

  <?php  }


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*try
{
  $bdd = new PDO('mysql:host=localhost;dbname=BD_EDICOM;charset=utf8', 'pyxicom', 'Yz9nVEXjZ2hqptZT');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}*/


$pharmacie0 = $myPDO->query("SELECT code_firme, rs_comp, `JOUR` , PHARMACIE_GARDE.`QUARTIER` AS 'zone_de_garde', adresse, ville, `tel` , longitude, latitude, 
                                            (  6371 *
                                               acos(cos(radians(".$latitude_pos.")) * 
                                               cos(radians(latitude)) * 
                                               cos(radians(longitude) - 
                                               radians(".$longitude_pos.")) + 
                                               sin(radians(".$latitude_pos.")) * 
                                               sin(radians(latitude )))
                                            ) AS distance 
                                            FROM `PHARMACIE_GARDE` 
                                            WHERE CURDATE( ) +0 >= DATED
                                            AND CURDATE( ) +0 <= DATEF
                                            GROUP BY rs_comp
                                            HAVING distance < 90
                                            ORDER BY distance");

$result = $pharmacie0->fetchAll(\PDO::FETCH_ASSOC);


        /*$servername = "localhost";
        $dbname = "BD_EDICOM";
        $username = "pyxicom";
        $password = "Yz9nVEXjZ2hqptZT";
        $con = new mysqli($servername,$username, $password, $dbname);
        if ($con->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_set_charset($con,"utf8");*/

    /* Pharmacie de garde  */

            $pharmacie = mysqli_query($con, "SELECT datef, code_firme, rs_comp, `JOUR` , PHARMACIE_GARDE.`QUARTIER` AS 'zone_de_garde', adresse, ville, `tel` , longitude, latitude, 
                                            (  6371 *
                                               acos(cos(radians(".$latitude_pos.")) * 
                                               cos(radians(latitude)) * 
                                               cos(radians(longitude) - 
                                               radians(".$longitude_pos.")) + 
                                               sin(radians(".$latitude_pos.")) * 
                                               sin(radians(latitude )))
                                            ) AS distance 
                                            FROM `PHARMACIE_GARDE` 
                                            WHERE CURDATE( ) +0 >= DATED
                                            AND CURDATE( ) +0 <= DATEF
                                            GROUP BY rs_comp
                                            HAVING distance < 90
                                            ORDER BY distance");

            $closest            = $pharmacie->fetch_assoc();
            $closest_jour       =  $closest['JOUR'];
            $closest_longitude  = $closest['longitude'];
            $closest_latitude   = $closest['latitude'];
            $closest_adresse    = $closest['adresse'];
            $closest_code_firme = $closest['code_firme'];
            $closest_code_firme = substr($closest_code_firme, 2);
            $closest_rs_comp    = $closest['rs_comp'];
            $closest_v          = strtolower($closest_rs_comp); 
            $closest_v          = str_replace('.','',$closest_v);
            $closest_v          = str_replace(',','',$closest_v);
            $closest_v          = str_replace('\'','-',$closest_v);
            $closest_v          = str_replace('’','-',$closest_v);
            $closest_v          = str_replace(' ','-',$closest_v);
            $closest_v          = str_replace('','-',$closest_v);
            $closest_v          = str_replace('--','-',$closest_v);
            $closest_v          = str_replace('°','-',$closest_v);
             // $v  ='';
            $closest_v        = preg_replace('/[áàãâä]/ui', 'a', $closest_v);
            $closest_v        = preg_replace('/[éèêë]/ui', 'e', $closest_v);
            $closest_v        = preg_replace('/[íìîï]/ui', 'i', $closest_v);
            $closest_v        = preg_replace('/[óòõôö]/ui', 'o', $closest_v);
            $closest_v        = preg_replace('/[úùûü]/ui', 'u', $closest_v);
            $closest_v        = preg_replace('/[ç]/ui', 'c', $closest_v);

            $name       =  $closest['ville'];
            $id_name    =  str_replace(',','',$name);
            $id_name    =  str_replace('\'','-',$id_name);
            $id_name    =  str_replace('’','-',$id_name);
            $id_name    =  str_replace('°','-',$id_name);
            $id_name    =  str_replace(' ','-',$id_name);
            $id_name    =  str_replace('(','-',$id_name);
            $id_name    =  str_replace(')','-',$id_name);
            $id_name    =  str_replace(':','-',$id_name);
            $id_name    =  str_replace('--','-',$id_name);
            $id_name    =  strtolower($id_name);
            $closest_ville      =  htmlentities($id_name);

    /* end Pharmacie de garde */
 
  ?>



  <input type="hidden" name="pos_lat" id="pos_lat" value="">
  <input type="hidden" name="pos_lon" id="pos_lon" value="">



     
<script type="text/javascript">

   function itineraire() {

     /*  var lat = $('#lat').val();
      var lon = document.getElementById('lon').value;
     alert(lat);alert(lon);*/
     
      let macarte = L.map('carte').setView([<?php echo $latitude_pos ;  ?>, <?php echo $longitude_pos ;  ?>], 13)
      L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
           // Il est toujours bien de laisser le lien vers la source des données
           attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
           minZoom: 6,
           maxZoom: 25
       }).addTo(macarte)


                    <?php





                      $count=0;
                      while ( $row = mysqli_fetch_array($pharmacie)){
                        $count++;
                      $jour =  $row['JOUR'];
                      $latitude =  $row['latitude'];
                      $longitude =  $row['longitude'];
                      $adresse =  $row['adresse'];
                      $adresse =  str_replace(str_split('.'), '', $adresse);
                      $adresse =  str_replace(str_split('?'), '', $adresse);
                      $code_firme = $row['code_firme'];
                      $code_firme = html_entity_decode($code_firme);
                      $code_firme = str_replace('MA', '', $code_firme);
                      $rs_comp  =  $row['rs_comp']; 
                      $v        =   strtolower($rs_comp);
                      $v        =   str_replace('.','',$v);
                      $v        =   str_replace(',','',$v);
                      $v        =   str_replace('\'','-',$v);
                      $v        =   str_replace('’','-',$v);
                      $v        =   str_replace(' ','-',$v);
                      $v        =   str_replace('','-',$v);
                      $v        =   str_replace('--','-',$v);
                      $v        =   str_replace('°','-',$v);

                      $v        = preg_replace('/[áàãâä]/ui', 'a', $v);
                      $v        = preg_replace('/[éèêë]/ui', 'e', $v);
                      $v        = preg_replace('/[íìîï]/ui', 'i', $v);
                      $v        = preg_replace('/[óòõôö]/ui', 'o', $v);
                      $v        = preg_replace('/[úùûü]/ui', 'u', $v);
                      $v        = preg_replace('/[ç]/ui', 'c', $v);
                         /* $v = iconv('utf-8', 'us-ascii//TRANSLIT', $v);*/

                      $name       =  $row['ville'];
                      $id_name    =  str_replace(',','',$name);
                      $id_name    =  str_replace('\'','-',$id_name);
                      $id_name    =  str_replace('’','-',$id_name);
                      $id_name    =  str_replace('°','-',$id_name);
                      $id_name    =  str_replace(' ','-',$id_name);
                      $id_name    =  str_replace('(','-',$id_name);
                      $id_name    =  str_replace(')','-',$id_name);
                      $id_name    =  str_replace(':','-',$id_name);
                      $id_name    =  str_replace('--','-',$id_name);
                      $id_name    =  strtolower($id_name);
                      $ville      =  htmlentities($id_name);
                    ?>
                       var marker<?php echo $count ?> = new L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>], {
                        icon: svgpin_Icon2,
                        draggable: false
                        })
                        .bindPopup("<h2>" + <?php echo json_encode($rs_comp);  ?> + "</h2> " + <?php echo json_encode($adresse);  ?> + "</br><b> Ouverture :</b>" + <?php if($jour == 1){echo json_encode("Jour");} elseif($jour == 2){echo json_encode("Nuit");}elseif($jour == 3){echo json_encode("Jour et nuit");} ?> + "<br><a href='https://www.telecontact.ma/annonceur/"+ <?php echo json_encode($v);  ?> + "/" + <?php echo json_encode($code_firme);  ?> + "/"+<?php echo json_encode($ville);  ?>+".php' target='_blank' >Voir fiche</a>")
                        .addTo(macarte);

                        marker<?php echo $count ?>.on('click', function(ev){
                          var latlng = macarte.mouseEventToLatLng(ev.originalEvent);
                          console.log(ev.latlng.lat,ev.latlng.lng);
                          var lat_mark = ev.latlng.lat;
                          var lng_mark = ev.latlng.lng;
                          var popup = ev.target.getPopup();
                          var content = popup.getContent();
                          var popup_data= content;
                          console.log(content);
                          console.log(ev.latlng.lat,ev.latlng.lng);
                          macarte.off();
                          macarte.remove();
                          newone(lat_mark,lng_mark,popup_data);
                        });

                    <?php } ?>

       
       // activer la gestion itinéraires

       L.Routing.control({
           geocoder: L.Control.Geocoder.nominatim(),
           /*lineOptions: {
               styles: [{
                  color: '#839c49',
                  opacity: 1,
                  weight:7,
               }]
           },*/
           waypoints: [
             L.latLng(<?php echo $latitude_pos ;  ?>,  <?php echo $longitude_pos ;  ?>),
             L.latLng(<?php echo $closest_latitude ; ?>, <?php echo $closest_longitude ; ?>)
           ],  
           autoRoute:true,
           fitSelectedRoutes: false,
           routeWhileDragging: true,
           routeDragInterval: 500,
           collapsible: false, // hide/show panel routing
           reverseWaypoints: false,
           showAlternatives: false,
           router: new L.Routing.osrmv1({
               language: 'fr',
               profile: 'car' 
            }),



           createMarker: function(i, wp, nWps) {
            switch (i) {
              case 0:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon,
                  draggable: false
                }).bindPopup("<b>" + "Ma position" + "</b>").addTo(macarte).openPopup();
              case nWps - 1:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon2,
                  draggable: false
                }).bindPopup("<h2>" + <?php echo json_encode($closest_rs_comp);  ?> + "</h2>" + <?php echo json_encode($closest_adresse);  ?> + "</br><b> Ouverture :</b>" + <?php if($closest_jour == 1){echo json_encode("Jour");} elseif($closest_jour == 2){echo json_encode("Nuit");}elseif($closest_jour == 3){echo json_encode("Jour et nuit");} ?> + "<br><a href='https://www.telecontact.ma/annonceur/"+ <?php echo json_encode($closest_v);  ?> + "/" + <?php echo json_encode($closest_code_firme);  ?> + "/"+<?php echo json_encode($closest_ville);  ?>+".php' target='_blank' >Voir fiche</a>").addTo(macarte).openPopup();
                
              default:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon3,
                  draggable: false
                }).bindPopup("<b>" + "Waypoint" + "</b>");
            }
          }

       }).addTo(macarte)

       
      /*macarte.on('click', function(e) {
        console.log(e.latlng.lat,e.latlng.lng);
        alert(e.latlng.lat+ ', ' + e.latlng.lng);
      });*/



      

    }





    $( document ).ready(function() {

        setTimeout(function(){ 

           $(".label0").text("De "); 
          $(".label0").css({"font-size": "13px", "font-weight": "600"}); 
          $(".label1").text("A ");
          $(".label1").css({"font-size": "13px", "font-weight": "600", "margin-right":"7px"});
          $(".leaflet-routing-geocoders").append("<div class='ma-position-full'><i class='fa fa-location-arrow' aria-hidden='true'></i><span class='ma-position' onclick='getLocation()'> Utiliser ma position </span></div>");

        }, 1000);

    });





// new one 
   function newone(lat_mark,lng_mark,popup_data) {

     /*  var lat = $('#lat').val();
      var lon = document.getElementById('lon').value;
     alert(lat);alert(lon);*/
     
      let macarte = L.map('carte').setView([<?php echo $latitude_pos ;  ?>, <?php echo $longitude_pos ;  ?>], 13)
      L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
           // Il est toujours bien de laisser le lien vers la source des données
           attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
           minZoom: 6,
           maxZoom: 25
       }).addTo(macarte)


                    <?php




                    for($i=0; $i<count($result); $i++){
                      
                      $row = $result[$i];
                      $jour =  $row['JOUR'];
                      $latitude =  $row['latitude'];
                      $longitude =  $row['longitude'];
                      $adresse =  $row['adresse'];
                      $adresse =  str_replace(str_split('.'), '', $adresse);
                      $adresse =  str_replace(str_split('?'), '', $adresse);
                      $code_firme = $row['code_firme'];
                      $code_firme = html_entity_decode($code_firme);
                      $code_firme = str_replace('MA', '', $code_firme);
                      $rs_comp  =  $row['rs_comp']; 
                      $v        =   strtolower($rs_comp); 
                      $v        =   str_replace('.','',$v);
                      $v        =   str_replace(',','',$v);
                      $v        =   str_replace('\'','-',$v);
                      $v        =   str_replace('’','-',$v);
                      $v        =   str_replace(' ','-',$v);
                      $v        =   str_replace('','-',$v);
                      $v        =   str_replace('--','-',$v);
                      $v        =   str_replace('°','-',$v);

                      $v        = preg_replace('/[áàãâä]/ui', 'a', $v);
                      $v        = preg_replace('/[éèêë]/ui', 'e', $v);
                      $v        = preg_replace('/[íìîï]/ui', 'i', $v);
                      $v        = preg_replace('/[óòõôö]/ui', 'o', $v);
                      $v        = preg_replace('/[úùûü]/ui', 'u', $v);
                      $v        = preg_replace('/[ç]/ui', 'c', $v);
                    
                    ?>

                       var marker_<?php echo $i ?> = new L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>], {
                        icon: svgpin_Icon2,
                        draggable: false
                        })
                        .bindPopup("<h2>" + <?php echo json_encode($rs_comp);  ?> + "</h2> " + <?php echo json_encode($adresse);  ?> + "</br><b> Ouverture :</b>" + <?php if($jour == 1){echo json_encode("Jour");} elseif($jour == 2){echo json_encode("Nuit");}elseif($jour == 3){echo json_encode("Jour et nuit");} ?> + "<br><a href='https://www.telecontact.ma/annonceur/"+ <?php echo json_encode($v);  ?> + "/" + <?php echo json_encode($code_firme);  ?> + "/casablanca.php' target='_blank' >Voir fiche</a>")
                        .addTo(macarte);

                        marker_<?php echo $i ?>.on('click', function(ev){
                          var latlng = macarte.mouseEventToLatLng(ev.originalEvent);
                          console.log(ev.latlng.lat,ev.latlng.lng);
                          var lat_mark = ev.latlng.lat;
                          var lng_mark = ev.latlng.lng;
                          var popup = ev.target.getPopup();
                          var content = popup.getContent();
                          var popup_data= content;
                          console.log(content);
                          console.log(ev.latlng.lat,ev.latlng.lng);
                          macarte.off();
                          macarte.remove();
                          newone(lat_mark,lng_mark,popup_data);
                        });



                    <?php } ?>

                    



       
       // activer la gestion itinéraires

       L.Routing.control({
           geocoder: L.Control.Geocoder.nominatim(),
           /*lineOptions: {
               styles: [{
                  color: '#839c49',
                  opacity: 1,
                  weight:7,
               }]
           },*/


           waypoints: [
             L.latLng(<?php echo $latitude_pos ;  ?>,  <?php echo $longitude_pos ;  ?>),
             L.latLng(lat_mark,lng_mark)
           ],  
           autoRoute:true,
           fitSelectedRoutes: false,
           routeWhileDragging: true,
           routeDragInterval: 500,
           collapsible: false, // hide/show panel routing-
           reverseWaypoints: false,
           showAlternatives: false,
           router: new L.Routing.osrmv1({
               language: 'fr',
               profile: 'car' 
            }),



           createMarker: function(i, wp, nWps) {
            switch (i) {
              case 0:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon,
                  draggable: false
                }).bindPopup("<b>" + "Ma position" + "</b>").addTo(macarte).openPopup();
              case nWps - 1:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon2,
                  draggable: false
                }).bindPopup(popup_data).addTo(macarte).openPopup();
                
              default:
                return L.marker(wp.latLng, {
                  icon: svgpin_Icon3,
                  draggable: false
                }).bindPopup("<b>" + "Waypoint" + "</b>");
            }
          }

       }).addTo(macarte)

       
    /*  macarte.on('click', function(e) {
        console.log(e.latlng.lat,e.latlng.lng);
        alert(e.latlng.lat+ ', ' + e.latlng.lng);
      });*/

      


    }
// end new one


  itineraire() ;

      

   </script>




   <!-- end fichier js -->


</body>
</html>

<?php



/*SELECT rs_comp, `JOUR` , PHARMACIE_GARDE.`QUARTIER` AS 'zone_de_garde', adresse, ville, `tel` , longitude, latitude
FROM `PHARMACIE_GARDE`
WHERE CURDATE( ) +0 >= DATED
AND CURDATE( ) +0 <= DATEF
GROUP BY rs_comp
ORDER BY `PHARMACIE_GARDE`.`latitude` DESC

SELECT rs_comp, `JOUR` , PHARMACIE_GARDE.`QUARTIER` AS 'zone_de_garde', adresse, ville, `tel` , longitude, latitude, 
(  6371 *
   acos(cos(radians(33.51260900000001)) * 
   cos(radians(latitude)) * 
   cos(radians(longitude) - 
   radians(-7.65956066137696)) + 
   sin(radians(33.51260900000001)) * 
   sin(radians(latitude )))
) AS distance 
FROM `PHARMACIE_GARDE` 
WHERE CURDATE( ) +0 >= DATED
AND CURDATE( ) +0 <= DATEF
GROUP BY rs_comp
HAVING distance < 28
ORDER BY distance LIMIT 0, 20;*/



?>



