<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



        $hostname='sds-138.hosteur.net';
        $dbname='les500';
        $username='telecontact2021';
        $password='Edicom2021';

          $dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username,$password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$sth = $dbh->query("SELECT code_firme,`date_ordre`,count(`vtiger_account`.`code_firme` ) as count_nbr FROM `u_yf_ssingleorders` LEFT JOIN `vtiger_account` ON `vtiger_account`.accountid =`u_yf_ssingleorders`.firme WHERE `type_ordre` LIKE 'Siteconnect' AND `support` LIKE 'adscom' GROUP BY `vtiger_account`.`code_firme` ASC");

  
   $mysql_link=mysql_connect('localhost','presencemedia','tX632tpv39jD5KRC');
mysql_select_db('telecontact_BackOffice_Site');
mysql_query("SET NAMES 'utf8'");

mysql_query("truncate table `ndd`");



 while($row = $sth->fetch()) {

 	if($row['code_firme']){

mysql_query("INSERT INTO `ndd`(`date_ordre`, `code_firme`, `count_nbr`) VALUES ('".$row['date_ordre']."','".$row['code_firme']."',".$row['count_nbr'].")");

}
}

die('die');


?>