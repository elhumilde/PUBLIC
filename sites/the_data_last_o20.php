<?php 


header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'; 

  
function adilsoft_string_latin($string){
    return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','?','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','?','Î','?', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', '?', "'"), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y', '\''), $string);
}
function slugify($text)
    {
        // Strip html tags
        $text=strip_tags($text);
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Transliterate
        setlocale(LC_ALL, 'en_US.utf8');
        $text = iconv('utf-8', 'utf-8//IGNORE', $text);
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Trim
        $text = trim($text, '-');
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // Lowercase
        $text = strtolower($text);
        // Check if it is empty
        if (empty($text)) { return 'n-a'; }
        // Return result
        return $text;
    }


        function replace_microsolft_apostrophe($string){
        $string = str_replace('’', " ", $string);
        $string = str_replace("'", " ", $string);
        return $string;
    }


$hostname = 'sds-138.hosteur.net';
$dbname = 'les500';
$username = 'telecontact2021';
$password = 'Edicom2021';

$dbh = new PDO('mysql:host=sds-138.hosteur.net;dbname=erpprod', $username, $password, array(
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
));


$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );


 
$sth = $myPDO->query("SELECT firmes.`code_firme` AS 'code_firme', `rs_comp` , `rs_abr` , villes.ville AS ville
FROM `firmes`
INNER JOIN villes ON villes.code = firmes.code_ville
WHERE code_fichier != 'O20'
AND maj_k NOT
IN ( 0, 8 )
AND maj_n NOT
IN ( 0, 8 )
"); 

// die('ici');
/*$sth = $myPDO->query("SELECT firmes.`code_firme` as 'code_firme', `rs_comp`, `rs_abr` , villes.ville as ville FROM `firmes`
 INNER JOIN villes ON villes.code = firmes.code_ville 
 Left JOIN annonceur_production on  annonceur_production.code_firme=firmes.`code_firme` 

 where code_fichier != 'O20' AND maj_k NOT IN (0,8) AND maj_n NOT IN (0,8) and annonceur_production.id is null"); 
*/





$half   = floor(($sth->rowCount())/3);
$count  = 0;
$midlle   = floor($half*2);
// $result= $sth->fetch();
while(  $count <= $half && $row = $sth->fetch()) {      

   
/*                                                                    $ville_slug =adilsoft_string_latin($row["ville"]);
                                                                    $ville_slug =slugify($ville_slug);

                                                                    if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }


                        $code_firme = substr($row["code_firme"], -7);

                   echo '<url>';
                 echo '<loc>https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php</loc> ';
                 echo '<lastmod>2022-03-18</lastmod>';
                 echo '<changefreq>Daily</changefreq>';
                 echo '<priority>1.0</priority>';
                 echo '</url>';*/

                 // echo 'https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php <br/>';


$count++;


}




         $b = array();
 
         $sets = array();
while(   $count <= $midlle && $row = $sth->fetch()) {      


/*                                                                    $ville_slug =adilsoft_string_latin($row["ville"]);
                                                                    $ville_slug =slugify($ville_slug);

                                                                    if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }

                        $code_firme = substr($row["code_firme"], -7);

                   echo '<url>';
                 echo '<loc>https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php</loc> ';
                 echo '<lastmod>2022-03-18</lastmod>';
                 echo '<changefreq>Daily</changefreq>';
                 echo '<priority>1.0</priority>';
                 echo '</url>';
*/
                 // echo 'https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php <br/>';

$count++;


}




         $b = array();
 
         $sets = array();
while ($row = $sth->fetch()) {  

                                                                    $ville_slug =adilsoft_string_latin($row["ville"]);
                                                                    $ville_slug =slugify($ville_slug);

                                                                    if($row["rs_abr"]){
                                                                       $slug = adilsoft_string_latin($row["rs_abr"]);     
                                                                       $slug = slugify($slug);
                                                                       $rs_comp =$row["rs_comp"].'( '.$row["rs_abr"].' )';
                                                                        }else{
                                                                               $slug   = adilsoft_string_latin($row["rs_comp"]); 
                                                                               $slug   = slugify($slug);
                                                                              $rs_comp = $row["rs_comp"] ;
                                                                        }

                        $code_firme = substr($row["code_firme"], -7);

                   echo '<url>';
                 echo '<loc>https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php</loc>';
                 echo '<lastmod>2022-03-18</lastmod>';
                 echo '<changefreq>Daily</changefreq>';
                 echo '<priority>1.0</priority>';
                 echo '</url>';
  

// echo 'https://www.telecontact.ma/annonceur/'.$slug.'/'.$code_firme.'/'.$ville_slug.'.php <br/>';



}

echo '</urlset>';





         



?>