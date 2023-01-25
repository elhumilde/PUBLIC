<?php
// die('here');

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

$myPDO->query("DROP TABLE IF EXISTS annonceur_3");

$myPDO->query("CREATE TABLE annonceur_3 (code_firme VARCHAR(10) NULL)");




$result = $dbh->query('SELECT concat("MA",acc.code_firme) as code_firme FROM `u_yf_ssingleorders` s INNER join vtiger_ossemployees emp on emp.ossemployeesid=s.comm INNER join vtiger_account acc on acc.accountid=s.firme WHERE timestampdiff(YEAR, s.date_ordre, CURDATE()) <= 3 and s.support = "Telecontact" and s.type_ordre = "Internet" group by acc.code_firme');




while ($row_production = $result->fetch())
{ 

$myPDO->query("INSERT INTO `annonceur_3`(`code_firme`) VALUES ('".$row_production['code_firme']."')");
}

?>

