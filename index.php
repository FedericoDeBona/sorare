<?php 
include "sorare.php";
if(isset($_POST['btnOk'])){
	$sorare = new SorareUtlis();
	$start = microtime(true);
	$res = $sorare->getPastAuctionsFromCardId("41e1466f-94e2-47d3-b259-9542824f8015");
	
	//print_r($res);
	//$offers = $res[0];
	$pastAuction = $res;
	//$pastAuction = [ array("open"=> false, "currentPrice"=> "40000000000000000", "endDate"=> "2021-03-18T16:03:37Z"), array("open"=> false, "currentPrice"=> "20000000000000000", "endDate"=> "2020-11-29T09:03:21Z")];
	function date_sort($a, $b) {
		return strtotime($b['endDate']) - strtotime($a['endDate']);
	}
	usort($pastAuction, "date_sort");
	for ($i=0; $i < count($pastAuction); $i++) { 
		$pastAuction[$i]['currentPrice'] = $pastAuction[$i]['currentPrice'] / 1000000000000000000;
		$d = new DateTime($pastAuction[$i]['endDate']);
		$pastAuction[$i]['endDate'] = $d->format('d-m-Y');
	}
	

	//$min = min($offers);
	//echo "Best offer " . $min . "<br><br> DEALS:<br>";
	for ($i=0; $i < count($pastAuction); $i++) { 
		$price = $pastAuction[$i]['currentPrice'];
		//if ($price < ($min / 1.5)) {
			echo "Bought at " . $price . " at " . $pastAuction[$i]['endDate'] . "<br><br>";
		//}
	}

	echo "Done in: " . $time_elapsed_secs = microtime(true) - $start . "<br><br>";
	// se c'è stata un asta venduta a 2/3 del min di offerta
	// controllo le aste correnti


}else{
	echo '	
	<form method="POST" action="index.php">
		<textarea id="area"></textarea><br>
		<button type="submit" name="btnOk">Invia</button>
	</form>';
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