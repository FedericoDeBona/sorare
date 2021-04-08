<?php
include 'sorare.php';
$sorare = new SorareUtlis();
set_time_limit(0);
$nAuctions = 3;
$from = explode('&', $_SERVER['QUERY_STRING'])[0];
$to = explode('&', $_SERVER['QUERY_STRING'])[1];
$maxEth = explode('&', $_SERVER['QUERY_STRING'])[2];
$from = explode('=', $from)[1];
$to = explode('=', $to)[1];
$maxEth = explode('=', $maxEth)[1];
$bestLeagues = array('K League 1', 'J1 League', 'CSL', 'MLS', 'Eredivisie', 'Primera Division', 'Serie A', 'RPL', 'Primeira Liga', 'Ligue 1', 'Bundesliga', 'Liga MX', 'Liga Profesional Argentina');
$playerStatus = array('starter' => '<b style="color: green">Starter</b>', 'regular' => 'Regular', 'not_playing' => '<b style="color: red">Reserve</b>', 'substitute' => 'Substitute');

$start = microtime(true);
$post_data = (array('query' => '
query {
  transferMarket {
    auctions(first: '.$to.') {
      nodes {
        card {
          rarity
          slug
          pictureUrl
          name
          id
          player {
	        status{
              playingStatus
            }
            age
            position
            activeInjuries{
              active
            }
            so5Scores(last: 5){
              score
            }
            activeClub {
              name
              domesticLeague {
                name
              }
            }
            displayName
            id
          }
        }
        endDate
        bestBid {
          amount
        }
      }
    }
  }
}
'));
// Prepare new cURL resource
$crl = curl_init('https://api.sorare.com/graphql');
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($crl, CURLINFO_HEADER_OUT, true);
curl_setopt($crl, CURLOPT_POST, true);
curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

// Set HTTP Header for POST request 
curl_setopt($crl, CURLOPT_HTTPHEADER, array(
	"Content-Type"=> "application/json",
	"X-CSRF-Token"=> "SXMlVSK+L47+0l6mp4Au6t6OKkDjtxkF4XFAEjQVv/wlgoydWEaHGuDurGPAE0TDLQHLKu8wu6XdrBvqQoK/yw==",
	"Accept-Encoding" => "gzip, deflate, br"
));

// Submit the POST request
$result = json_decode(curl_exec($crl), true);

$players = [];
$deals = [];
$reason = "";

for ($i=$from; $i < count($result['data']['transferMarket']['auctions']['nodes']); $i++) {
	$curr = $result['data']['transferMarket']['auctions']['nodes'][$i]['card'];
	$bestBid = $result['data']['transferMarket']['auctions']['nodes'][$i]['bestBid']['amount']/ 1000000000000000000;
	$league = $curr['player']['activeClub']['domesticLeague']['name'];
	if ($curr['rarity'] == "rare"){
		$status = $curr['player']['status']['playingStatus'];
		if (($bestBid > $maxEth) | !(in_array($league, $bestLeagues)) | ($status == 'not_playing')){
			$deals[] = false;
		}else{
			//$deals[] = true;
			$deals[] = $sorare->getOffersForPlayer($curr['player']['id'], $bestBid);
		}
		//$deals[] = false;
	}
}
//var_dump($sorare->getOffersForPlayer($players[0]));

echo "<div class='grid-container'>";
for ($i=$from; $i < count($result['data']['transferMarket']['auctions']['nodes']); $i++) { 
	$bestBid = $result['data']['transferMarket']['auctions']['nodes'][$i]['bestBid']['amount'] / 1000000000000000000;
	$curr = $result['data']['transferMarket']['auctions']['nodes'][$i]['card'];	

	if ($deals[$i-$from] == false){
		$style = "filter: grayscale(100%)";
		$reason = "Asta troppo alta o non ci sono offerte";
		$add = "";
	}else{
		if ((min($deals[$i-$from])-$bestBid) < 0.05){
		//if((min($deals[$i-$from])/2) > $bestBid){
			$style = "filter: grayscale(100%)";	
			$reason = "Non è conveniente";
		}else{
			$style = "";
		}
		$min = min($deals[$i-$from]);
		$maxToBid = $min - 0.03;
		$add = "Offerta migliore: $min - Max to bid: $maxToBid<br><br>";
	}
	if ($curr['rarity'] == "rare"){
		$endDate = $result['data']['transferMarket']['auctions']['nodes'][$i]['endDate'];
		$clubName = $curr['player']['activeClub']['name'];
		$league = $curr['player']['activeClub']['domesticLeague']['name'];
		$age = $curr['player']['age'];
		$position = $curr['player']['position'];
		$isInjured = "TODO";
		//$isInjured = count($curr['player']['activeInjuries'])==0 ? "<img width='20px' height='20px' src='https://img.icons8.com/fluent/48/000000/ok.png'/>" : "<img width='20px' height='20px' src='https://img.icons8.com/emoji/48/000000/cross-mark-emoji.png'/>";
		$status = $playerStatus[$curr['player']['status']['playingStatus']];

		$so5 = 0;
		$zeros = 0;
		for ($j=0; $j < count($curr['player']['so5Scores']); $j++) { 
			$sc = $curr['player']['so5Scores'][$j]['score'];
			if ($sc == 0) $zeros++;
			$so5 += $sc;
		}
		$so5==0 ? $so5= 0 : $so5 = ceil($so5/(count($curr['player']['so5Scores'])-$zeros));
		$playedMatches = count($curr['player']['so5Scores']) - $zeros;
		count($curr['player']['so5Scores'])==0 ? 0 : $perc = (100*$playedMatches)/count($curr['player']['so5Scores']);
		in_array($league, $bestLeagues)==true ? $league = "<b style='color: green'>$league</b>" : $league = "<b style='color: red'>$league</b>";
		if($so5 <= 35){
			$so5 = "<b style='color: red'>$so5</b>";
		}elseif($so5 > 35 && $so5 <= 50){
			$so5 = "<b style='color: darkorange'>$so5</b>";
		}else{
			$so5 = "<b style='color: green'>$so5</b>";
		}
		echo "
		<div class='grid-item'>
			<h4>$curr[name]</h4>
			<a style='text-decoration: none' target='_blank' href='https://www.google.com/search?q=$clubName classifica'>$clubName</a> ($league) | $age | $position | $isInjured | $status | $so5 - $perc%<br><br>
			<b style='font-size: 20px;'>$bestBid Ξ</b><br><br>
			<img class='player-img' onclick='getOffers()' style='".$style."' src='$curr[pictureUrl]'><br>
			<p class='timer".$i."' id=".$endDate."></p>
			<b>$add</b>
			<a href='https://sorare.com/cards/".$curr['slug']."' target='_blank'>Sorare</a> | 
			<a href='https://www.soraredata.com/playerSearch/".$curr['player']['displayName']."' target='_blank'>SorareData</a><br>
		</div>";
	}
}

//var_dump($players);
/*
$post_data = (array('query' => '
	query LatestAuctionsForPlayer {
 	node(id: "'.$players[0].'") {
    ... on Player {
      cards {
        nodes {
          price
          onSale
        }
        pageInfo{
          hasNextPage
          endCursor
        }
      }
    }
  }
}
'));
curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
$result = json_decode(curl_exec($crl), true);

var_dump($result);
*/
/*
echo "<table><tr>";
for ($i=0; $i < count($result['data']['transferMarket']['auctions']['nodes']); $i++) { 
	$curr = $result['data']['transferMarket']['auctions']['nodes'][$i];
	echo "<th> ".$curr['card']['name']."</th>";
}
echo "</tr>";
echo "</table>";
*/
echo "</div>";
echo "<div class='buttons'>";
echo '
	<form method="POST" action="benchmark.php?from=0&to='.$nAuctions.'&max='.$maxEth.'">
		<button type="submit">Ricarica</button>
	</form>';
echo '
	<form method="POST" action="benchmark.php?from='.($from-($to-$from)).'&to='.$from.'&max='.$maxEth.'">
		<button type="submit">Precedente</button>
	</form>';
echo '
	<form method="POST" action="benchmark.php?from='.$to.'&to='.($to+$nAuctions).'&max='.$maxEth.'">
		<button type="submit">Prossimo</button>
	</form>';
echo "</div>";


echo "<br><br>Done in: " . $time_elapsed_secs = microtime(true) - $start . "<br><br>";

?>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript">	
	doTimer();
	var x = setInterval(function() {
		doTimer();
	}, 1000);

	function doTimer() {
		var now = new Date().getTime();
		var elements = document.getElementsByTagName("p");
		for (var i = 0; i < elements.length; i++) {
			if(elements[i].className.indexOf("timer") !== -1){
				var curr = elements[i].id;
				var end = new Date(curr);
				
				
				// Find the distance between now and the count down date
				var distance = end - now;
				
				// Time calculations for days, hours, minutes and seconds
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				// Display the result in the element with id="demo"
				elements[i].innerHTML = hours + "h "	+ minutes + "m " + seconds + "s ";
				
				// If the count down is finished, write some text
				if (distance < 0) {
					elements[i].innerHTML = "EXPIRED";
				}
			}
	
		}
	}
</script>
