<?php

$myPDO = new PDO('mysql:host=localhost;dbname=telecontact_BackOffice_Site', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$table = array();

$nom = $_GET["nom"];

$prenom = $_GET["prenom"];

$email = $_GET["email"];

$code_firme = $_GET["code-firme"];

$type = $_GET["type"];

$object = $_GET["object"];

$message = $_GET["message"];

$dateNow = date('Y-m-d H:i:s');

array_push($table, $nom, $prenom, $email, $code_firme, $type, $object, $message, $dateNow);

echo json_encode($table);