<?php 
include "sorare.php";
set_time_limit(0);
$sorare = new SorareUtlis();
if(isset($_POST['btnOk'])){
	
	$start = microtime(true);
	
	

	echo "<br><br>Done in: " . $time_elapsed_secs = microtime(true) - $start . "<br><br>";
}else{
	$leagues = $sorare->getAllLeagues();

	echo '<form method="POST" action="benchmark.php?from=0&to=3&max=0.12">';
	for ($i=0; $i < count($leagues); $i++) { 
		echo "<input type='checkbox' id='$i' name='$i' value='$leagues[$i]'>";
		echo "<label for='$i'>$leagues[$i]</label><br>";
	}
	echo "<button type='submit'>Cerca</button>";
	echo '</form>';

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sorare</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

</body>
</html>