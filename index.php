<?php 
include "sorare.php";
$sorare = new SorareUtlis();
$leagues = $sorare->getAllLeagues();
if(isset($_POST['btnOk'])){
	//benchmark.php?from=0&to=3&max=0.12
	$maxEth = $_POST['maxEth'];
	$selectedLeagues = [];
	for ($i=0; $i < count($leagues); $i++) { 
		if(isset($_POST[$leagues[$i]])){
			$selectedLeagues[] = $_POST[$leagues[$i]];
		}
 	}
}else{
	

	echo '<form method="POST" action="benchmark.php?from=0&to=3&max=0.1">';
	for ($i=0; $i < count($leagues); $i++) { 
		echo "<input type='checkbox' id='$leagues[$i]' name='$leagues[$i]' value='$leagues[$i]'>";
		echo "<label for='$i'>$leagues[$i]</label><br>";
	}
	echo "<br>Max Eth <input type='text' name='maxEth' value='0.1'><br><br>";	
	echo "<button type='submit' name='btnOk'>Cerca</button>";
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