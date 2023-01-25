<?php
// the message
$msg = "last line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("fayssal.anouar@gmail.com","My subject",$msg);
?>