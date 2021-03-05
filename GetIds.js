function getIds() {
	// all images
	let imgs = document.querySelectorAll("[src*=card]");
	let ids = new Array(imgs.length);
	// NAMES
	/*
	for (var i = 0; i < imgs.length; i++) {
		ids[i] = imgs[i].getAttribute("alt").split("-")[0] + " " + imgs[i].getAttribute("alt").split("-")[1]
	}*/
	
	// IDS
	for (var i = 0; i < imgs.length; i++) {
		ids[i] = imgs[i].getAttribute("src").split("card/")[1].split("/picture")[0];
		
	}
	for (var i = 0; i < ids.length; i++) {
		console.log(ids[i]);
	}
	return ids;
}

function searchPlayer(ids) {
	// prezzo /10^16
	let res = new Array(ids.length);
	let s = "query { card(slug: \"";
	let f = "\") { name openAuction{bestBid{amount createdAt}}}}"
	for (var i = 0; i < ids.length; i++) {
		res[i] = s + ids[i] + f + "";
		console.log(res[i])
	}
	
}

searchPlayer(getIds())

query {
  card(slug: "d263c007-723f-4961-9cf9-61148476d24f") {
    name
    openAuction{
      bestBid{
        amount
        createdAt
      }
    }
  }
}

query{
  auctions{
   	nodes{
      card{
        name
      }
      open
      bestBid{
        amount
      }
    }
  }
}

query{
  allCards{
    pageInfo{
      startCursor
      endCursor
    }
    nodes{
      name
      id
      rarity
      onSale
      openAuction{
        bestBid{
          amount
        }
      }
    }
  }
}

query { card(slug: "2ee1a80a-d0d1-4555-a497-67f838eb8c87") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "6bc47336-8ccf-423a-9562-5ddacf12313f") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "b6984f8f-f1bf-4010-8076-b5aa3b5b4b33") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "8f2ba7e5-b178-478b-84cd-283cf352f972") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "6650d456-f747-4a7c-84d5-0a0e129ece1b") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "0b9c8fdd-c903-43fd-8f9f-38ea4600bba5") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "b375bc9c-b681-4ed6-9b99-36887f764a6f") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "52683ce0-1e28-4c3e-a4bf-9ed8c935fd9b") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "2d08cc62-056e-4438-a31f-4e7df2bcba6c") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "67d28feb-01d5-4289-a7a5-23624be1b8ac") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "828fcf1b-433a-42f5-8f44-a1eba4d130fd") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "e2b1b664-157b-431c-983b-02c01981c442") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "057413a2-f375-4b6d-a905-a7357bceee10") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "74abc158-35c4-4226-9a44-42ee9131752e") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "d5ed1f76-37a4-44e7-b94d-e7d9962d0393") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "7cda1a89-923c-411a-bf7f-d2ee7f212681") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "4763c18e-d93c-4c7a-a91b-e2e66c9e7578") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "abf1279b-3e3e-4e62-ac8c-8626c7290394") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "37b73923-ac04-40ee-905f-8a05e04f7d75") { name openAuction{bestBid{amount createdAt}}}}
query { card(slug: "85e1ebf8-eb4c-45b5-bcff-bb884ac3cc31") { name openAuction{bestBid{amount createdAt}}}}