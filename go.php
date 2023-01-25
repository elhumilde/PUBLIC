<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$username='presencemedia';
$password='tX632tpv39jD5KRC';

$dbh = new PDO('mysql:host=localhost;dbname=CRM_EDICOM', $username,$password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$sth = $dbh->query("SELECT * FROM `tts_utilisateur` WHERE `id_service` IN ( 2, 3 ) AND `actif` =1");




while($row = $sth->fetch()) {

 	if($row['id']){


$coms = $dbh->query("SELECT COUNT( id ) AS nbr
FROM tts_visites_planifiees
WHERE date_visite
BETWEEN DATE_FORMAT( DATE_SUB( NOW( ) , INTERVAL 1
MONTH ) , '%Y-%m-%d' )
AND DATE_FORMAT( DATE_SUB( NOW( ) , INTERVAL 2 DAY ) , '%Y-%m-%d' )
AND realise =0
AND id_utilisateur IN ( '".$row['id']."' )");





 while($com = $coms->fetch()) {
 
 	if($com['nbr']){

// echo "nom prenom : ".$row['nom']." ".$row['prenom']." ".$row['email']." nbr en attente : ".$com['nbr']."<br/>";

 // send email 


					$nomUser = $row["nom"];

					$prenomUser = $row["prenom"];

					$emailUser = $row["email"];
					// $emailUser ='f.anouar@edicom.ma';
					ini_set( 'display_errors', 1 );
					error_reporting( E_ALL );

					$from = "noreply@edicom.ma";

					$to = $emailUser;

					$subject = "CRM Edicom Compte(s) rendu de visites a renseigner";

					$message = '<html>
					<head>
					<title>Compte(s) rendu en attente CRM</title>
					</head>
					<body>
					<p>Bonjour ' . $nomUser . ' ' . $prenomUser . '</p>
					<br/>
					<br/>
					<table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FDFDFD">
						<tr style="background-color:#374750;color:white">
						<td height="80" align="center" valign="middle" bgcolor="#374750" color="#ffffff">
							<h1>
								CRM Edicom
							</h1>
						</td>
						</tr>
						<tr>
						<td height="60" color="#000000">
							<p style="padding-left: 20px;padding-right: 20px"><strong>Compte(s) rendu a renseigner :</strong></p>
						</td>
						</tr>
						<tr>
						<td>
							<ul>
								<li bgcolor="#aaa" color="#000000"><label>Vous avez : </label><span>'.$com['nbr']. ' Compte(s) rendu de visites a renseigner</span></li>
					
							</ul>
						</td>
						</tr>

						<tr height="70" align="center" valign="middle" bgcolor="#374750" color="#000000">
							<td>
								<table width="600" border="0" cellspacing="0" cellpadding="0">
									<tr color="#000000">
										<td style="padding-left: 20px;padding-right: 20px"><strong style="color:white">L’Equipe EDICOM</strong></td>
									
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</body>
					</html>';

					$headers = 'From: CRM Edicom <' . $from . '> ' . "\r\n" .
					'Reply-To: CRM Edicom <' . $from . '> ' . "\r\n" .
					'Content-Type:text/html;charset=utf-8' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

					$headers .= "Return-Path: CRM Edicom <" . $from . '> ' . "\r\n";
					// $headers .= "CC: n.belrhazi@edicom.ma\r\n"; 

					if(!mail($to,$subject,$message, $headers)) {

						echo('error envoie de mail <br/>');

					} else {

						
					}
 // end sending email 		


 	}

 }



}



}






























die('die');

?>