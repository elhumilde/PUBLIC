<?php


ini_set('memory_limit', '-1');

set_time_limit(5000000); // 
$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'root';
$password = 'ibarwotfucur';
        $dateN=date('Y-m-d');
        $dateNow = DateTime::createFromFormat("Y-m-d", $dateN);
        $monthNow=$dateNow->format('m');
        $yearNow=$dateNow->format('Y');

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));

$mysqli = new mysqli('mysql:host=sds-138.hosteur.net', $username, $password, $dbname);

$sth = $dbh->query('select com.* , emp.name
from u_yf_commission com inner join vtiger_ossemployees emp on emp.ossemployeesid=com.commercial and `type_employee` != 'Salarie'
 left join u_yf_ssingleorders s on s.support=com.support AND s.num_ordre=com.num_ordre
 where s.support="Telecontact" and s.type_ordre IN ('Papier','Internet') and s.edition=33  ORDER BY emp.name DESC');


var_dump($sth );
die();

$i=0;
while ($row_production = $sth->fetch())
{
  $i++;
  			   echo $row_production['emp.name'] .'<br/>';
  				echo $row_production['commissionid'] .'  '.$row_production['commission'].' '.$row_production['number'] .'  '.$row_production['support'].' '.$row_production['num_ordre'] .'  '.$row_production['commercial'].' '.$row_production['tcom'] .'  '.$row_production['mtrg'].' '.$row_production['dcom'] .'  '.$row_production['nbor'].' '.$row_production['etat'] .'  '.$row_production['numlig'].' '.$row_production['type_client'].' '.$row_production['type_ordre'].' '.$row_production['commission_g'].' '.$row_production['mt_comm'].' '.$row_production['ssingleordersid'].' '.$row_production['crep'].' '.$row_production['date_m_a_j'].' '.$row_production['nbor_lig'].' '.$row_production['mcom'].' '.$row_production['reglementsid'].' '.$row_production['id']
  				echo '<br/>';
				 // $courter_det = $mysqli->query("SELECT dernier_nbor,dernier_lig FROM `u_yf_courtierdet` WHERE annee=$year and mois=$month and commercial=$commercial[0]");




/*                $courter_det = $courter_det->fetch_assoc();
                $dernier_nbor = $courter_det["dernier_nbor"];
                $dernier_lig = intval($courter_det["dernier_lig"]) + 1;
                $mysqli->query("update `u_yf_courtierdet` set dernier_lig=$dernier_lig WHERE annee=$year and mois=$month and commercial=$commercial[0]");*/
}




?>