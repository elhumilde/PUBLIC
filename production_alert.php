<?php 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



        $hostname='sds-138.hosteur.net';
        $dbname='les500';
        $username='telecontact2021';
        $password='Edicom2021';

          $dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username,$password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$sth = $dbh->query("SELECT a.code_firme,acc.raison_sociale,s.num_ordre,s.date_ordre,s.edition,emp.name,a.format,se.nom_produit as libelle,a.debut_mise_en_ligne,a.fin_mise_en_ligne
  FROM `u_yf_atribution` a 
  INNER JOIN u_yf_ssingleorders s on s.ssingleordersid=a.ordre
  INNER JOIN vtiger_ossemployees emp on emp.ossemployeesid=s.comm
  INNER JOIN vtiger_account acc on acc.code_firme=a.code_firme
  INNER JOIN vtiger_service se on se.serviceid=a.serviceid
  WHERE
  date_ordre BETWEEN  
  DATE_FORMAT( DATE_SUB( NOW( ) , INTERVAL 6
MONTH ) , '%Y-%m-%d' )
AND DATE_FORMAT( NOW( ) , '%Y-%m-%d' )
  and
  a.debut_mise_en_ligne is null and s.sum_gross>COALESCE((select sum( ABS(f.sum_gross)) from u_yf_finvoice f  WHERE f.num_ordre=s.num_ordre and f.type_facture='Avoir'),0)
  GROUP BY s.num_ordre,a.format  
ORDER BY `s`.`date_ordre` ASC");

  



$i=0;





					$emailUser = 'v.boukhlal@edicom.ma';
					// $emailUser ='f.anouar@edicom.ma';
					ini_set( 'display_errors', 1 );
					error_reporting( E_ALL );

					$from = "noreply@edicom.ma";

					$to = $emailUser;

					$subject = "ERP EDIPROD  Produits en attente";



					$message = '<html>
					<head>
					<title>Produits en attente</title>
					</head>
					<body>
					<p>Bonjour</p>
					<br/>
					<table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FDFDFD">
						<tr style="background-color:#374750;color:white">
						<td height="80" align="center" valign="middle" bgcolor="#374750" color="red">
							<h1>
								ERP EDIPROD
							</h1>
						</td>
						</tr>
						<tr>
						<td height="60" color="#000000">
							<p style="color:red;padding-left: 20px;padding-right: 20px"><strong>La liste des produits en attente de fabrication:</strong></p>
						</td>
						</tr>
						<tr>
						<td><ul>';



 while($com = $sth->fetch()) {
 

 $now = time(); // or your date as well
$your_date = strtotime($com['date_ordre']);
$datediff = $now - $your_date;

$order_days= round($datediff / (60 * 60 * 24));


// echo "code_firme : ".$com['code_firme']." ".$com['raison_sociale']." ".$com['date_ordre']." nbr en attente : ".$com['format']." ".$com['libelle'] ." ".$com['name']." Nbr jours en attente : ".$order_days ."<br/>";

 // send email 



						$message .='	
								<li bgcolor="#aaa" color="#000000"> <strong>le produit</strong> '.$com['format'].' '.$com['libelle'].' <strong> Pour la Société : </strong>' .$com['code_firme'].' '.$com['raison_sociale'].' <strong>Date ordre : </strong>'.$com['date_ordre'].' <strong> Commercial : </strong>'.$com['name'].' <br/> '.$order_days.' <strong>jours en attente </strong> <br/><br/></li>
					
							';

				

 // end sending email 		


 	

 }
	            	$message .='</ul></td>
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



					$headers = 'From: ERP EDIPROD <' . $from . '> ' . "\r\n" .
					'Reply-To: ERP EDIPROD <' . $from . '> ' . "\r\n" .
					'Content-Type:text/html;charset=utf-8' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

					$headers .= "Return-Path: ERP EDIPROD  Produits en attente <" . $from . '> ' . "\r\n";
					$headers .= "CC: n.belrhazi@edicom.ma\r\n"; 

					if(!mail($to,$subject,$message, $headers)) {

						echo('error envoie de mail <br/>');

					} else {

						
					}





























?>