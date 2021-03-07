<?php  
	include 'db.php';
	$start = microtime(true);
	$hasNextPage = true;
	$post_data = (array('query' => 'query{
		  allCards{
		    nodes{
		      id
		    }
		    pageInfo{
		      hasNextPage
		      endCursor
		    }
		  }
		}
      '));
	$k = 0;
	$dbquery = $db->prepare("insert into all_cards (card_id) values (:cardid)");
	//$dbquery->execute([':cardid' => '2']);
	do{
		$cursor = "";
		$crl = curl_init('https://api.sorare.com/graphql');
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLINFO_HEADER_OUT, true);
		curl_setopt($crl, CURLOPT_POST, true);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(
			"Content-Type"=> "application/json",
			"X-CSRF-Token"=> "SXMlVSK+L47+0l6mp4Au6t6OKkDjtxkF4XFAEjQVv/wlgoydWEaHGuDurGPAE0TDLQHLKu8wu6XdrBvqQoK/yw=="
		));
		$result = json_decode(curl_exec($crl), true);
		for ($i=0; $i < count($result['data']['allCards']['nodes']); $i++) { 
			$curr = $result['data']['allCards']['nodes'][$i]['id'];
			$curr = explode(':', $curr)[1];
			$dbquery->execute([':cardid' => $curr]);
			//echo $curr;
		}
		curl_close($crl);
		if ($result['data']['allCards']['pageInfo']['hasNextPage'] == false){
			$hasNextPage = false;
		}else{
			$k += 1;
			$cursor = '(after: "'.$result['data']['allCards']['pageInfo']['endCursor'].'")';
		}

		$post_data = (array('query' => 'query{
			allCards'.$cursor.'{
					nodes{
						id
					}
					pageInfo{
						hasNextPage
						endCursor
					}
				}
			}
			'));
		if($k > 10)
			$hasNextPage = false;
	}while($hasNextPage);


  echo "<br><br>Done in: " . $time_elapsed_secs = microtime(true) - $start . "<br><br>";
?>