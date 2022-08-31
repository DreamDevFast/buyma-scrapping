const db = require("../models");
const axios = require("axios"); 
const RakutenList = db.rakuten_list;
const competitionList = db.competition_list;

var user_id = 0;

var index = 0;
var item_list = {};
var compList = {};

class itmeInfo{
	data = {};
	res = {};
	constructor(data) {
		this.data = data;
	}

	getRakutneInfo(){
		let yahooToken = "1571d294868bc45f11a3353708aad795c";
		let url = "https://webservice.valuecommerce.ne.jp/productdb/search?token="+yahooToken;
		//url = url+"&keyword="+this.data["item_name"];
			url = url+"&format=json&sort_by=price&sort_order=desc";

		//if(this.data['y_search_condition'] == 0){

		if(this.data["y_search_kind"] == 1)url = url + "&product_id="+this.data["jan_code"];	//JANを利用 
		else url = url + "&keyword="+this.data["item_name"];								                //キーワードを利用 

		// if(this.data["y_point_true"] == 0)param.pointRateFlag = 1;	//ポイント含む	
		// if(this.data["y_free_deli_true"] == 0)param.postageFlag = 1;	//送料無料 含む	

		//if(this.data["y_tracking_shop"] != "")url = url + "&Merchant="+this.data["y_tracking_shop"];

		// if(this.data["y_low_price"] > 0)url = url + "&price_max="+this.data["y_low_price"];//param.maxPrice = this.data["r_low_price"]
		url = url + "&price_min="+100;

		url = url+"&format=json&sort_by=price";  		
		
		

		axios.get(url, {}).then(response => {		

			var comp_list = compList["yahoo_list"];			
			
			let update_query = {};
			
			if(response.data.items.length > 0){ 
				
				var shop_list = [];

				for(var i = 0; i < response.data.items.length; i++){
					var add_flag = 0;

					for(var j = 0; j < comp_list.length; j++){
						if(comp_list[j] == response.data.items[i].subStoreName)add_flag = 1;
					}

					if(add_flag == 0){
						var shop_info = {};
						shop_info['shopName'] = response.data.items[i].subStoreName;
						shop_info['shopUrl'] = response.data.items[i].guid;
						shop_info['itemName'] = response.data.items[i].title;
						shop_info['itemUrl'] = response.data.items[i].link;
						shop_info['itemPrice'] = response.data.items[i].price;
						shop_info['itemCode'] = response.data.items[i].markCode;
						shop_info['imageUrl'] = response.data.items[i].imageSmall.url;
						
						shop_list.push(shop_info);		
					}	
				}
				update_query.y_shop_list = JSON.stringify(shop_list);          
				update_query.y_real_low_price = shop_list[0].itemPrice;
				update_query.y_img_url = shop_list[0].imageUrl;  
				update_query.y_master_code = shop_list[0].itemCode;
			}else{
				update_query.y_shop_list = "";
			}			

			RakutenList.update(update_query, {
				where: { id: this.data["id"] }
			})
			.then(num => {
				console.log("Update data Okay!", update_query);
				//this.res.json(update_query);
			})
			.catch(err => {
				console.log("Update data Failed!");
			});

			     

		}).catch(error => {
			console.log("Error getRakutneInfo!", error);
		});

	}
}

function callItemInfo(){
	var item = new itmeInfo(item_list[index]);	
	item.getRakutneInfo();
	console.log("callItemInfo_index : ", index);
	if(index < item_list.length-1){
		index++;
		setTimeout(callItemInfo, 3000);
	}
}

exports.changeInfo = (req, res) => {	
	
	try{
		if(req.query.sel > 0 && req.query.item > 0){
			user_id = req.query.sel;
			item_id = req.query.item;

			competitionList.findAll({ where: {user_id : user_id}})
			.then(data => {					
				compList = data[0];
				
				})
				.catch(err => {
					console.log("Error get com_list!")
				});

			RakutenList.findAll({ where: {user_id : user_id, id : item_id}})
			.then(data => {
				
				var item = new itmeInfo(data[0]);	
				item.res = res;
				item.getRakutneInfo();
				//console.log("change", data);
			  })
			  .catch(err => {
				console.log("Error get item_list!")
			  });

		}else{
			console.log("Sel is 0!");
		}
	}catch (error) {
		console.log("Error getInfo!");
	}
}

exports.getInfo = (req, res) => {	
	//return req.query.sel;
	try{
		if(req.query.sel > 0){
			user_id = req.query.sel;

			competitionList.findAll({ where: {user_id : user_id}})
			.then(data => {					
				compList = data[0];
				
				})
				.catch(err => {
					console.log("Error get com_list!")
				});
				
			RakutenList.findAll({ where: {user_id : user_id}})
			.then(data => {
				item_list = data;
				callItemInfo();
			  })
			  .catch(err => {
				console.log("Error get item_list!")
			  });

		}else{
			console.log("Sel is 0!");
		}
	}catch (error) {
		console.log("Error Yahoo getInfo!");
	}
}
