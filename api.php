<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$mysql_link=mysql_connect('localhost','presencemedia','tX632tpv39jD5KRC');
mysql_select_db('telecontact_BackOffice_Site');
mysql_query("SET NAMES 'utf8'");
 // mysql_query("TRUNCATE TABLE`api` ");
   function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);

    if (!preg_match("/www/i", $string)) {
        $ini=1;

    }

    else{
    $ini += strlen($start);


}
    $len = strpos($string, $end, $ini) - $ini;

    return substr($string, $ini, $len);
}


 mysql_query("UPDATE api LEFT JOIN `solocal` ON SUBSTRING_INDEX( SUBSTRING_INDEX( solocal.ndd, 'w.', -1 ) , '.', 1 ) = SUBSTRING_INDEX( SUBSTRING_INDEX( api.ndd, 'w.', -1 ) , '.', 1 )SET api.codefirme = solocal.cfirme");

 mysql_query("update ediprv.`ct_settings` set `option_value`='' WHERE `option_name` LIKE 'ct_thankyou_page_url'");
 mysql_query(" UPDATE `MOBILE_utilisateur_web` SET  `type` = 'professionnel'   WHERE `type` = 'annonceur'");


 $ch = curl_init();
 $headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
'Authorization: Basic MjZlYTc1YmZhMzo1eHM5ZGpua2pxRnA='
    );
 curl_setopt($ch, CURLOPT_URL, 'https://api.duda.co/api/sites/multiscreen/published?lastDays=2000');
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 $contents = curl_exec($ch);

$contents = json_decode($contents);
foreach ($contents as $value) {

$var='https://api.duda.co/api/sites/multiscreen/'.$value;

curl_setopt($ch, CURLOPT_URL, $var);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$content = curl_exec($ch);
$content = json_decode($content);


    $source = $content->creation_date;
    $date = new DateTime($source);

    $source1 = $content->first_published_date;
    $date1 = new DateTime($source1);

    $source3 = $content->modification_date;
    $date3 = new DateTime($source3);
    $ndd=$content->site_domain;
    $date_creation =$date->format('Y-m-d');
    $date_mel =$date1->format('Y-m-d');
    $date_maj =$date3->format('Y-m-d');   

    $thumbnail_url='';



$results = mysql_query("select * from `api` where ndd='$ndd'");

$num_rows = mysql_num_rows($results);

if ($num_rows>=1){

    mysql_query("UPDATE `api` SET `date_creation`='$date_creation',`date_mel`='$date_mel',`date_maj`='$date_maj',`thumbnail_url`='$thumbnail_url',`ref`='$value'  WHERE ndd='$ndd'");
}
else
{

mysql_query("INSERT INTO `api`(`id`, `date_creation`, `date_mel`, `date_maj`, `ndd`,`ref`) VALUES (null,'$date_creation','$date_mel','$date_maj','$ndd','$value')");

}


 // mysql_query("INSERT INTO `api`(`id`, `date_creation`, `date_mel`, `date_maj`, `thumbnail_url`, `ndd`) VALUES (null,'$date_creation','$date_mel','$date_maj','$thumbnail_url','$ndd')");

  // echo $content->site_domain."  création date :  ".$date->format('d-m-Y')."   date mise en ligne : ".$date1->format('d-m-Y')."   date maj : ".$date3->format('d-m-Y')."<br/>";
}


?>