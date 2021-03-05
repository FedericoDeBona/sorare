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
	"ad14b355-aa18-4032-9e62-4cf342692e07",
	"33ce0f77-0cdd-406f-a0a5-f693a36f2d52",
	"7d826b04-f016-4f54-933e-394e486bcd05",
	"4ad3f38f-b42d-4886-a264-b52d47e162d4",
	"8edb80d3-3079-49f2-ae61-2149429d1290",
	"ee7a503b-6c05-45dc-9e6d-ad3e8ec9ed04",
	"7a261e9f-97d1-4650-8599-1b0a09b37a55",
	"cd5b5fbb-eb2e-4636-abcf-359c1c01cfbc",
	"0fe4b45a-93cb-4a36-a6bf-8b2aaa12badc",
	"431015e0-5fbb-4dcc-9295-f1fdd85aca40",
	"190704d4-e2f4-4264-bdff-ecaca25d6ef9",
	"a7b28ada-f4ea-4b70-95c3-14543f2949b6",
	"2099b2f0-e60e-4037-9ddf-5c2d9b24a73e",
	"dc6a7ede-180d-4ed8-8cc1-866be3b6d8c6",
	"1efa7240-75a0-4b70-9583-53ef260931bc",
	"1adf8222-f27f-4e98-8863-1a6ade2e6f61",
	"f1ad800f-3b7a-4d1d-a5d0-5d426728ff30",
	"c66fdc5b-6566-4c4d-ad2f-c51801a5d2d4",
	"bfa1d9aa-01cd-4c68-9cb8-8e7bcedf9c43",
	"a4462adb-4060-47d1-a596-b3c606db2fff",
];


for ($i=0; $i < count($l); $i++) { 



$res = $sorare->getDataFromCardId($l[$i]);
$res = json_decode($res, true)['data']['card'];
echo $res['player']['displayName'] . "<br><br>";	
echo intval($res['openAuction']['bestBid']['amount']) / 1000000000000000000;
$url = $res['pictureUrl'];
echo "<img src=\"$url\" width='195px' height='317px'>";
$name = $res['player']['displayName'];
echo '<a href="https://www.soraredata.com/playerSearch/'.$name.'" target="_blank">'.$name.'</a> <br><br>';
}
?>
<link rel="stylesheet" type="text/css" href="style.css">