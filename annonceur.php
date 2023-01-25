<?php

// waiting to find solution for the hack
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));


$myPDO  = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$myPDO->query("DROP TABLE IF EXISTS annonceur_production");

$myPDO->query("CREATE TABLE annonceur_production (code_firme VARCHAR(10) NULL)");



$result = $dbh->query('SELECT concat("MA",acc.code_firme) as code_firme FROM `u_yf_ssingleorders` s INNER JOIN u_yf_atribution a on a.ordre=s.ssingleordersid INNER JOIN vtiger_service se on se.serviceid=a.serviceid INNER JOIN vtiger_account acc on acc.accountid=s.firme LEFT JOIN u_yf_ssingleorders_inventory i on i.name=a.serviceid and a.ordre=i.id LEFT JOIN u_yf_rubriques r on r.rubriquesid=i.ref LEFT JOIN u_yf_ville v on v.villeid=i.value28 WHERE  now() <= fin_mise_en_ligne and interr=0 and a.format<>"" GROUP by a.code_firme ');


while ($row_production = $result->fetch())
{ 

$myPDO->query("INSERT INTO `annonceur_production`(`code_firme`) VALUES ('".$row_production['code_firme']."')");
}


?>

