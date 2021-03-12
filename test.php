<?php
include "sorare.php";
// LOGIN
/*
include "t.txt";

$host = "https://api.sorare.com/users/sign_in.json";
$salt = "https://api.sorare.com/api/v1/users/federicodebona@hotmail.it";
$res = json_decode(file_get_contents($salt, false))->salt;
$hashed = crypt($pwd, $res);

$data = json_encode(array('user' => array('email' => "federicodebona@hotmail.it", 'password' => $hashed)));

$options = array(
	'https' => array(
		'header' => "Content-type: application/json\r\n".
					"Cookie: \r\n".
					"X-CSRF-TOKEN: \r\n",
		'method' => 'POST',
		'content' => $data
	)
);
$context = stream_context_create($options);
$res = file_get_contents($host, false, $context);
*/

$sorare = new SorareUtlis();

$l = [
	"09c8ff63-bb91-4f84-8a83-6d817bc9f5c1",
	"662edcf3-9513-44d1-aa63-87277a7cd361",
	"f93fb1b2-db93-4035-a428-e383fae44e1a",
	"61e6d259-23ef-4a0a-b117-c01ac511a4c0",
	"5da20184-bd3a-4e60-8c69-089cea938534",
	"62b6dd8b-4521-40bc-ad88-0ff0794c376b",
	"824ad089-0731-4b6d-8818-902ad1725f6b",
	"42cb3a57-3fca-4296-b160-b139d8231fb5",
	"2c9fedd9-53ed-4da3-946b-5f6094f20e81",
	"b85b9fa8-c7fb-491a-a556-9a1eb6372db2",
	"7eab6658-d371-4e73-a2d6-8080c4e1d246",
	"67c6314f-8fca-499a-b303-af8d4d95f779",
	"b46ba80d-2d3e-4145-93ff-67e5f9a07f1e",
	"f31b6b0d-cb19-40bf-b433-59bb24dc7b55",
	"2ddd4fc4-8119-4fdd-ad7d-9724fb9c1298",
	"9651af71-5bc3-48e1-a239-15779d08ff38",
	"1668b40e-2365-436c-bc0a-f9db363d5044",
	"f2397151-ba84-4626-ba09-33dbf8253989",
	"e0a744ec-bcaa-4f5b-9fe5-433c199cea42",
	"859abd4c-482f-4325-9873-1f0605b83ae5",
];


/*
$res = $sorare->getOffersAndAuctionsFromCardId("874ad0eb-af30-4637-b86c-c740190c08f6");

$offers = $res[0];
$pastAuctions = $res[1];
*/

$offers = [0.08, 0.07, 0.1];
$pastAuctions = [array("price" => 0.008, "data" => "01/01/2020")];
$table = "<table>";

$table .= "</table>";
echo $table;
/*
$res = json_decode($res, true)['data']['card'];
echo $res['player']['displayName'] . "<br><br>";	
echo intval($res['openAuction']['bestBid']['amount']) / 1000000000000000000;
$url = $res['pictureUrl'];
echo "<img src=\"$url\" width='195px' height='317px'>";
$name = $res['player']['displayName'];
echo '<a href="https://www.soraredata.com/playerSearch/'.$name.'" target="_blank">'.$name.'</a> <br><br>';*/
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Kohei Okuno</title>
</head>
<body>
	<h1><center>Kohei Okuno</center></h1>
	<div class="container">
		<div class="player-img"></div>
		<div class="offers-table">
			<table class="offers">
				<tr>
					<th>Offerte</th>
				</tr>
				<tr>
					<td>0.08 ETH</td>
				</tr>
				<tr>
					<td>0.02 ETH</td>
				</tr>
				<tr>
					<td>0.03 ETH</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>