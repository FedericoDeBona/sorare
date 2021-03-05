<?php
class SorareUtlis{

	function getDataFromCardId($id){
		$query = json_encode(array('query' => 'query {card(slug: "'.$id.'") { blockchainId pictureUrl  player{displayName} openAuction { bestBid { amount createdAt } } } }'));
		$host = "https://api.sorare.com/graphql";
		$options = array(
			'http' => array(
				'header' => "Content-type: application/json",
				'method' => 'POST',
				'content' => $query
			)
		);

		$context = stream_context_create($options);
		$res = file_get_contents($host, false, $context);
		return $res;
	}
	public function getETHValue()
	{
		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/info?id=1&slug="ethereum"';
		$parameters = [
		  'id' => '1',
		  'slug' => 'ethereum'
		];

		$headers = [
		  'Accepts: application/json',
		  'X-CMC_PRO_API_KEY: 815ffd11-d27a-4a6a-b961-122ef10f1023'
		];
		$qs = http_build_query($parameters); // query string encode the parameters
		$request = "{$url}?{$qs}"; // create the request URL


		$curl = curl_init(); // Get cURL resource
		// Set cURL options
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $request,            // set the request URL
		  CURLOPT_HTTPHEADER => $headers,     // set the headers 
		  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
		));

		$response = curl_exec($curl); // Send the request, save the response
		print_r(json_decode($response)); // print json decoded response
		curl_close($curl); // Close request
		return $response;
	}
}
?>


