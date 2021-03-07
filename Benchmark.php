<?php  
$start = microtime(true);
    $post_data = (array('query' => 'query {
        card(slug: "a4462adb-4060-47d1-a596-b3c606db2fff") {
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
  
    
  // Prepare new cURL resource
  $crl = curl_init('https://api.sorare.com/graphql');
  curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($crl, CURLINFO_HEADER_OUT, true);
  curl_setopt($crl, CURLOPT_POST, true);
  curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

  // Set HTTP Header for POST request 
  curl_setopt($crl, CURLOPT_HTTPHEADER, array(
       "Content-Type"=> "application/json",
       "X-CSRF-Token"=> "SXMlVSK+L47+0l6mp4Au6t6OKkDjtxkF4XFAEjQVv/wlgoydWEaHGuDurGPAE0TDLQHLKu8wu6XdrBvqQoK/yw=="
  ));
    
  // Submit the POST request
  $result = curl_exec($crl);
  var_dump($result);
  echo "Done in: " . $time_elapsed_secs = microtime(true) - $start . "<br><br>";
  
?>