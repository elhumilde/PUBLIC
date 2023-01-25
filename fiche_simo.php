<?php

$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

// $ville = !empty($_POST['ville']) ? '%' . $_POST['ville'] . '%' : '';

$result = $myPDO->query('DESCRIBE PHARMACIE_GARDE');

if (!empty($result)) {

    // $row = $result->fetchAll(\PDO::FETCH_ASSOC);
    // print_r($row);

// $table = array();

foreach($result as $row) {

    // array_push($table, $row['ville']);
    echo $row['Field'] . ' => ' . $row['Type'] . '<br/>';

}

// echo json_encode($table);

}


?>