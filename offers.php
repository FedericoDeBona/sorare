<?php
include 'sorare.php';
$sorare = new SorareUtlis();
var_dump($sorare->getOffersForPlayer($_SERVER['QUERY_STRING']));
?>