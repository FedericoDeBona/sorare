<?php  
//include 'db.php';
$pipe = popen("pipe.php", "w");

echo "ciao";

pclose($pipe);
?>