<?php

	/* Start Session */
	session_start();

	$client = $_SESSION["is_client"];
	/* End Session */

	/* Start Connection config */
	try {
		$user = "presencemedia";
		$pass = "tX632tpv39jD5KRC";
		$connection = new PDO('mysql:host=walibix2.odiso.net:3306;dbname=telecontact_BackOffice_Site', $user, $pass , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	} catch(PDOException $e) {
		echo $e->getMessage();
		die;
	}

	/* End Connection config */

	$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

	$request = !empty($_GET) ? $_GET : $_POST;

	/* Ajax demande de devis */
	if($is_ajax && $request["isDemandeDevis"] == "true") {

		$response = array();

		unset($request["isDemandeDevis"]);

		$nomComplet = $request["nom-complet"];

		$email = $request["email"];

		$telephone = $request["telephone"];

		$entreprise = $request["entreprise"];

		$votreBesion = $request["votre-besion"];

		$codeFirme = $request["code-firme"];

		$codeFirmeWithMA = "MA" . $codeFirme;

		$emailDestinateur = $connection->query("SELECT `email` FROM BD_EDICOM.`lien_email` WHERE `code_firme` LIKE '%$codeFirmeWithMA%' AND `num_ordre` = 1")->fetch(PDO::FETCH_COLUMN);

		$stmtDemandeDevis = $connection->prepare("INSERT INTO `demande_devis`(`nom_complet`, `telephone`, `email` ,  `societe`, `bession` , `code_firme`) VALUES (? , ? , ? , ? , ? , ?)");

		if($stmtDemandeDevis->execute(array($nomComplet , $telephone , $email , $entreprise , $votreBesion , $codeFirme))) {

			$headers ="From: <" . $email . ">" . "\r\n";
		    $headers .="Reply-To: " . $emailDestinateur . "\r\n";
		    $headers .= 'Return-Path: ' . $email . "\r\n";
		    $headers .= 'Content-Type: text/html;charset=utf-8' . "\r\n";
		    $headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";

		    $message = '<html>
					     <head>
					     <title>Demande de devis de ' . $entreprise . '</title>
					     </head>
					     <body>
					     	<table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FDFDFD">
					     		<tbody>
					     			<tr>
					     				<td height="70" align="center" valign="middle">
								         	<img style="width:178px" src="https://www.telecontact.ma/trouver/media/images/logo-telecontact-email.png" />
						 		         </td>
							        </tr>

							        <tr>
								         <td align="center" valign="middle">
								         	<img style="width:100%" src="https://www.telecontact.ma/trouver/media/images/img-devis-email.jpg" />
								         </td>
							        </tr>

							        <tr>
								         <td>
								         	<p style="color:black">Bonjour,</p>
								         	<p style="color:black">La <strong>demande de devis suivante</strong> vous a été bien envoyé à partir de telecontact.ma</p>
								         </td>
							        </tr>

							        <tr>
							        	<td height="30" align="center" valign="middle">
							        		<p style="background-color:#FFDB2D;margin:0;height:100%;border-radius:30px 30px 0 0;text-align:center;color:black;padding-top:6px;margin-top:6px" align="center"><strong>Détail de la demande de devis</strong></p>
							        	</td>
							        </tr>

							        <tr>
							        	<td>
							        		<table width="400" cellpadding="5" style="padding: 15px;margin:20px auto;background-color:#fdfadcad;border-radius:10px;">
							        			<tr>
							        				<td>
								        				<div style="width: 95%;">
								        					<label style="margin: 10px 0;font-weight: bold;color:black">NomComplet : </label>
								        					<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $nomComplet . '"/>
								        				</div>
							        				</td>
							        			</tr>
							        			<tr>
							        				<td>
							        					<div style="width: 95%">
							        						<label style="margin: 10px 0;font-weight: bold;color:black">Email : </label>
							        						<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $email . '"/>
							        					</div>
						        					</td>
							        			</tr>
							        			<tr>
							        				<td>
							        					<div style="width: 95%;">
							        						<label style="margin: 10px 0;font-weight: bold;color:black">Numéro de téléphone : </label>
							        						<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $telephone . '"/>
							        					</div>
						        					</td>
							        			</tr>
							        			<tr>
							        				<td>
							        					<div style="width: 95%;">
							        						<label style="margin: 10px 0;font-weight: bold;color:black">Entreprise : </label>
							        						<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $entreprise . '"/>
							        					</div>
						        					</td>
							        			</tr>
							        			<tr>
							        				<td>
								        				<div style="width: 95%">
								        					<label style="margin: 10px 0;font-weight: bold;color:black">Votre besion : </label>
								        					<textarea disabled="disabled" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px;height:97px">' . $votreBesion . '</textarea>
							        					</div>
						        					</td>
							        			</tr>
							        		</table>
							        	</td>
							        </tr>
							        <tr>
				        				<td height="50" bgcolor="#f9f7f7" style="vertical-align:middle">
				        					<p style="text-align:left;padding-left:10px;font-size:12px;color:black">Cordialement,</p>
				        					<p style="text-align:left;padding-left:10px;font-size:12px;color:black">L\'équipe Telecontact</p>
				        				</td>
				        			</tr>
				     			</tbody>
					     	</table>
					     </body>
					     </html>';

		     //if(mail($emailDestinateur, 'Demande de devis de ' . $entreprise , $message, $headers)) {
		     if(mail($emailDestinateur, 'Demande de devis de ' . $entreprise , $message, $headers)) {

		          $response["isSended"] = true;

		     } else {

		          $response["error"] = "the message wasn't sending";

		     }

		} else {

			$response["error"] = "error while insert";

		}

	  	header('Content-Type: application/json; charset=utf-8');

		echo json_encode($response);

	  	exit;

	}

	/* Ajax envoyer un message */
	if($is_ajax && $request["isEnvoyerMessage"] == "true") {

		// Rapporte toutes les erreurs PHP
		error_reporting(E_ALL);

		$response = array();

		$nom = $request["nom"];

		$prenom = $request["prenom"];

		$email = $request["email"];

		$code_firme = $request["code-firme"];


		$type = $request["type"];

		$object = $request["object"];

		$message = $request["message"];

		$dateNow = date('Y-m-d H:i:s');

		

		try {

			/* Debut recuperer l'email et raison social de destinateur */

			$stmtEmailDestinateur = $connection->prepare("SELECT `email` , `rs_comp` FROM BD_EDICOM.`firmes` AS f
				INNER JOIN BD_EDICOM.`lien_email` AS email ON email.`code_firme` = f.`code_firme` AND email.`num_ordre` = 1
				WHERE email.`code_firme` LIKE ?");

			if($stmtEmailDestinateur->execute(array("%" . $code_firme . "%"))) {
				$destinateur = $stmtEmailDestinateur->fetch(PDO::FETCH_ASSOC);
			}

			/* Fin recuperer l'email et raison social de destinateur */

			/* Start Envoyer message */
			$stmtEnvoyerMessage = $connection->prepare("INSERT INTO `Demande_devis_Details`(`Nom_Expediteur`, `Prenom_Expediteur`, `Email_Expediteur`, `Email_Destinataire`, `Objet`, `titre`, `Message`, `Cfirme`, `Raison_sociale`, `Date_Envoi`, `Etat_Message`, `date_lecture_email`, `relance`, `date_lecture_relance`, `relance_flag`, `date_relance`, `email_relance`, `travers`, `type`, `user`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

			if($stmtEnvoyerMessage->execute(array($nom , $prenom , $email , $destinateur["email"] , $object , null , $message , $code_firme , $destinateur["rs_comp"] , $dateNow , 0 , "0000-00-00 00:00:00" , 0 , "0000-00-00 00:00:00" , 1 , null , null , null , $type , null))) {

				 /* Start sending mail */

			     $headers ='From: <' . $email . '>'."\n";
			     $headers .='Reply-To: ' . $destinateur["email"] ."\n";
			     $headers .= 'Return-Path: ' . $email . "\r\n";
				 $headers .= 'Content-Type: text/html;charset=utf-8' . "\r\n";
				 $headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";

			     $message = '<html>
						     <head>
						     <title>'. $object .'</title>
						     </head>
						     <body>
						     	<table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FDFDFD">
						     		<tbody>
						     			<tr>
						     				<td height="70" align="center" valign="middle">
									         	<img style="width:178px" src="https://www.telecontact.ma/trouver/media/images/logo-telecontact-email.png" />
							 		         </td>
								        </tr>

								        <tr>
									         <td align="center" valign="middle">
									         	<img style="width:100%" src="https://www.telecontact.ma/trouver/media/images/img-devis-email.jpg" />
									         </td>
								        </tr>

								        <tr>
									         <td>
									         	<p style="color:black">Bonjour,</p>
									         	<p style="color:black">Le <strong>message suivant</strong> vous a été bien envoyé à partir de telecontact.ma</p>
									         </td>
								        </tr>

								        <tr>
								        	<td height="30" align="center" valign="middle">
								        		<p style="background-color:#FFDB2D;margin:0;height:100%;border-radius:30px 30px 0 0;text-align:center;color:black;padding-top:6px;margin-top:6px" align="center"><strong>Détail du message</strong></p>
								        	</td>
								        </tr>

								        <tr>
								        	<td>
								        		<table width="400" cellpadding="5" style="padding: 15px;margin:20px auto;background-color:#fdfadcad;border-radius:10px;">
								        			<tr>
								        				<td>
									        				<div style="width: 95%;">
									        					<label style="margin: 10px 0;font-weight: bold;color:black">Nom : </label>
									        					<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $nom . '"/>
									        				</div>
								        				</td>
								        			</tr>
								        			<tr>
								        				<td>
								        					<div style="width: 95%">
								        						<label style="margin: 10px 0;font-weight: bold;color:black">Prénom : </label>
								        						<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $prenom . '"/>
								        					</div>
							        					</td>
								        			</tr>
								        			<tr>
								        				<td>
								        					<div style="width: 95%;">
								        						<label style="margin: 10px 0;font-weight: bold;color:black">Email : </label>
								        						<input type="text" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" disabled="disabled" value="' . $email . '"/>
								        					</div>
							        					</td>
								        			</tr>
								        			<tr>
								        				<td>
									        				<div style="width: 95%;">
									        					<label style="margin: 10px 0;font-weight: bold;color:black">Type Message : </label>
									        					<input style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" type="text" disabled="disabled" value="' . $type . '" />
									        				</div>
								        				</td>
								        			</tr>
								        			<tr>
								        				<td>
									        				<div style="width: 95%;">
										        				<label style="margin: 10px 0;font-weight: bold;color:black">Objet : </label>
										        				<input style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px" type="text" disabled="disabled" value="' . $object . '" />
								        					</div>
							        					</td>
								        			</tr>
								        			<tr>
								        				<td>
									        				<div style="width: 95%">
									        					<label style="margin: 10px 0;font-weight: bold;color:black">Message : </label>
									        					<textarea disabled="disabled" style="margin-top:10px;border: 1px solid #bebebe;background-color:#fff;width:100%;padding:5px;border-radius: 6px;height:97px">' . $message . '</textarea>
								        					</div>
							        					</td>
								        			</tr>
								        		</table>
								        	</td>
								        </tr>
								        <tr>
					        				<td height="50" bgcolor="#f9f7f7" style="vertical-align:middle">
					        					<p style="text-align:left;padding-left:10px;font-size:12px;color:black">Cordialement,</p>
					        					<p style="text-align:left;padding-left:10px;font-size:12px;color:black">L\'équipe Telecontact</p>
					        				</td>
					        			</tr>
					     			</tbody>
						     	</table>
						     </body>
				     	</html>';

			     if(mail($destinateur["email"], $object , $message, $headers)) {

			          $response["isSended"] = true;

			     } else {

			          $response["error"] = "the message wasn't sending";

			     }

			     /* End sending mail */

			} else {

				$response["error"] = "error while insert";

			}
			/* End Envoyer message */

		} catch(PDOException $e) {

			echo $e->getMessage();

		}


		header('Content-Type: application/json; charset=utf-8');

		echo json_encode($response);

	  	exit;
	}

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
