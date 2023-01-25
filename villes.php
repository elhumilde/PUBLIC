<?php

$myPDO = new PDO('mysql:host=localhost;dbname=BD_EDICOM', 'presencemedia', 'tX632tpv39jD5KRC', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );

$ville = !empty($_POST['ville']) ? '%' . $_POST['ville'] . '%' : '';

$result = $myPDO->query("SELECT ville FROM villes WHERE ville LIKE '".$ville."' ORDER BY ville ASC LIMIT 10");

if (!empty($result)) {

    $table = array();

    foreach($result as $row) {

        array_push($table, $row['ville']);

    }

    echo json_encode($table);

}


?>