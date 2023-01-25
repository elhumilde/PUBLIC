<?php

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

	     //    $hostname='localhost';
	     //    $dbname='medicalis';
	     //    $username='root';
	     //    $password='';
        
     

        $username='telecontact2021';
        $password='Edicom2021';

        $dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=medicalis', $username,$password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


		$sth = $dbh->query("UPDATE `ActiviteSpecialite` INNER JOIN ( SELECT GROUP_CONCAT(`acte_expertise`.`acte_expertise` ORDER BY `acte_expertise`.`acte_expertise` ASC SEPARATOR ',' ) AS acte_expertises , `acte_expertise`.`id_spe` FROM `acte_expertise` GROUP BY `acte_expertise`.`id_spe` ) AS act ON `ActiviteSpecialite`.`ReferenceActiviteSpecialite` = act.`id_spe` SET `ActiviteSpecialite`.`search` = act.`acte_expertises`");


if($sth ){
	echo'yes';
}else{
	echo'no';

}


