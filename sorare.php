<?php
class SorareUtlis{

	public function getPastAuctionsFromCardId($id){
		$host = "https://api.sorare.com/graphql";
		$query = json_encode(array('query' => 'query {
			  card(slug: "'.$id.'") {
			    player {
			      cards{
			        nodes {
			          latestAuction{
			            open
			            currentPrice
			            endDate
			          }
			          rarity
			          onSale
			          price
			        }
			        pageInfo {
			          hasNextPage
			          endCursor
			        }
			      }
			    }
			  }
			}
			'));
		$hasNextPage = true;
		$offers = [];
		$auctions = [];

		do{
			$options = array(
				'http' => array(
					'header' => "Content-type: application/json",
					'method' => 'POST',
					'content' => $query
				)
			);
			$context = stream_context_create($options);
			$res = json_decode(file_get_contents($host, false, $context), true);
			
			if ($res['data']['card']['player']['cards']['pageInfo']['hasNextPage'] == false)
				$hasNextPage = false;
			else
				$cursor = '(after: "'.$res['data']['card']['player']['cards']['pageInfo']['endCursor'].'")';
			
			for ($i=0; $i < count($res['data']['card']['player']['cards']['nodes']); $i++) { 
				$curr = $res['data']['card']['player']['cards']['nodes'][$i];
				if ($curr['rarity'] == 'rare'){
					if($curr['latestAuction'] != null){
						if ($curr['onSale'] == 'true' && $curr['latestAuction']['open'] == false){
							$offers[] = $curr['price'] / 1000000000000000000;
						}
						
						if ($curr['latestAuction']['open'] == false){
							$auctions[] = $curr['latestAuction'];
						}
					}
				}
			}
			$query = json_encode(array('query' => 'query {
				  card(slug: "'.$id.'") {
				    player {
				      cards'.$cursor.'{
				        nodes {
				          latestAuction{
				            open
				            currentPrice
				            endDate
				          }
				          rarity
				          onSale
				          price
				        }
				        pageInfo {
				          hasNextPage
				          endCursor
				        }
				      }
				    }
				  }
				}
				'));		
		}while($hasNextPage);

		return array($offers, $auctions);
	}

	public function getOffersForPlayer($id, $bestBid = 10)
	{
		$host = "https://api.sorare.com/graphql";
		$query = json_encode(array('query' => 
			'query {
			  node(id: "'.$id.'") {
			    ... on Player {
			      cards {
			        nodes {
			          latestAuction{open}
		        	  rarity
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
			}'));
		$hasNextPage = true;
		$offers = [];

		do{
			$options = array(
				'http' => array(
					'header' => "Content-type: application/json",
					'method' => 'POST',
					'content' => $query
				)
			);
			$context = stream_context_create($options);
			$res = json_decode(file_get_contents($host, false, $context), true);
			
			if ($res['data']['node']['cards']['pageInfo']['hasNextPage'] == false)
				$hasNextPage = false;
			else
				$cursor = '(after: "'.$res['data']['node']['cards']['pageInfo']['endCursor'].'")';
			
			for ($i=0; $i < count($res['data']['node']['cards']['nodes']); $i++) { 
				$curr = $res['data']['node']['cards']['nodes'][$i];
				if ($curr['rarity'] == 'rare'){
					if ($curr['onSale'] == 'true' && $curr['latestAuction']['open'] == false){
						$price = $curr['price'] / 1000000000000000000;
						$offers[] = $price;
					}
				}
			}
			if ($hasNextPage == true){
				$query = json_encode(array('query' => 
					'query {
					  node(id: "'.$id.'") {
					    ... on Player {
					      cards'.$cursor.' {
					        nodes {
					          latestAuction{open}
					          rarity
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
					}'));
			}
		}while($hasNextPage);

		return (count($offers)==0) ? false : $offers;
	}
	public function getAllLeagues()
	{
		$post_data = (array('query' => '
		query{
			leaguesOpenForGameStats{
		    	name
		  }
		}
		'));

		$crl = curl_init('https://api.sorare.com/graphql');
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLINFO_HEADER_OUT, true);
		curl_setopt($crl, CURLOPT_POST, true);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

		// Set HTTP Header for POST request 
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(
			"Content-Type"=> "application/json",
			"X-CSRF-Token"=> "SXMlVSK+L47+0l6mp4Au6t6OKkDjtxkF4XFAEjQVv/wlgoydWEaHGuDurGPAE0TDLQHLKu8wu6XdrBvqQoK/yw==",
			'HTTP_APIKEY' => "c2ac26c9cd5752b87afd4da1200496d04716dbd174421c4914df429a2518a049010be6f34ea57f8de37bb99cf3fac25fb9b66d9d988d8c03789d7dce96c9730a",
			"Accept-Encoding" => "gzip, deflate, br"
		));
		$result = json_decode(curl_exec($crl), true);
		$leagues = [];
		for ($i=0; $i < count($result['data']['leaguesOpenForGameStats']); $i++) { 
			$leagues[] = $result['data']['leaguesOpenForGameStats'][$i]['name'];
		}
		return $leagues;
	}
}
?>


