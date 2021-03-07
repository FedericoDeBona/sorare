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
			          #onSale
			          #price
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
		//$offers = [];
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
						/*if ($curr['onSale'] == 'true' && $curr['latestAuction']['open'] == false){
							$offers[] = $curr['price'] / 1000000000000000000;
						}*/
						
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
				          #onSale
				          #price
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

		return $auctions;
	}

	public function getOffersForCards($id)
	{
		$host = "https://api.sorare.com/graphql";
		$query = json_encode(array('query' => 'query {
			  card(slug: "'.$id.'") {
			    player {
			      cards{
			        nodes {
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
		//$offers = [];
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
						/*if ($curr['onSale'] == 'true' && $curr['latestAuction']['open'] == false){
							$offers[] = $curr['price'] / 1000000000000000000;
						}*/
						
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

		return $auctions;
	}
}
?>


