
// functions that load global data

// functions that load data from mintpal
/*
	My first attempt at making a call to minpal in javascript failed.
	I believe the issue is related to security feature of the browser which
	is blocking my attempt at sending an Http request to a server in a domain other
	than the server the page was loaded from.

	My solution is to make a call to a php script running on the same server as the page.
	Because I don't know if you'll be viewing this page on a web server with php enabled
	In stead of making a php script call, which may fail, I'm going to load 
	the json data by loading local page.
*/

function readJasonObject(jsonObject){
		var json = $.parseJSON(jsonObject);
}
function getMarketStatus(){
	var target = 'index.php?/worker/test/';
	var request=$.post(target,'',function(data){
	//$.get( "bitphp/marketStatus.php", function(a){
	//$.get( "bitphp/marketStatus.html", function(a){
		$('#marketStatus').html(data);
/*
		var headings = [];
		var data = [];
		data.push(['Last Price',      json[0]["last_price"]]);
		data.push(['Yesterday Price', json[0]["yesterday_price"]]);
		data.push(['Change',          json[0]["change"]]);
		data.push(['24h High',        json[0]["24hhigh"]]);
		data.push(['24h Low',         json[0]["24hlow"]]);
		data.push(['24h Vol',         json[0]["24hvol"]]);
		data.push(['Top Bid',         json[0]["top_bid"]]);
		data.push(['Top Ask',         json[0]["top_ask"]]);
		$('#marketStatus').html(renderTable(headings,data));
		getMarketTrades();
*/
	});
}
function getMarketTrades(){
	$.get( "bitphp/marketTrades.php", function(a){
	//$.get( "bitphp/marketTrades.html", function(a){
		var json = $.parseJSON(a);
		var headings = [];
		headings.push("Id");
		headings.push("Time");
		headings.push("Type");
		headings.push("Price");
		headings.push("Amount");
		headings.push("Total");
		var count = 0;
		var data = [];
		$.each(json["trades"],function(){
			count++;
			var line = [];
			line.push(count);
			line.push(this["time"]);
			var type = this["type"] == 0 ? 'BUY' : 'SELL';
			line.push(type);
			line.push(this["price"]);
			line.push(this["amount"]);
			line.push(this["total"]);
			data.push(line);
		});
		$('#marketTrades').html(renderTable(headings,data));
		getMarketBuyOrders();
	});
}
function getMarketBuyOrders(){
	$.get( "bitphp/marketBuyOrders.php", function(a){
	//$.get( "bitphp/marketBuyOrders.html", function(a){
		var json = $.parseJSON(a);
		var headings = [];
		headings.push("Id");
		headings.push("Price");
		headings.push("Amount");
		headings.push("Total");
		var data = [];
		var count = 0;
		$.each(json["orders"],function(){
			var line = [];
			count++;
			line.push(count);
			line.push(this["price"]);
			line.push(this["amount"]);
			line.push(this["total"]);
			data.push(line);
		});
		$('#marketBuyOrders').html(renderTable(headings,data));
		getMarketSellOrders();
	});
}
function getMarketSellOrders(){
	$.get( "bitphp/marketSellOrders.php", function(a){
	//$.get( "bitphp/marketSellOrders.html", function(a){
		var json = $.parseJSON(a);
		var headings = [];
		headings.push("Id");
		headings.push("Price");
		headings.push("Amount");
		headings.push("Total");
		var data = [];
		var count = 0;
		$.each(json["orders"],function(){
			var line = [];
			count++;
			line.push(count);
			line.push(this["price"]);
			line.push(this["amount"]);
			line.push(this["total"]);
			data.push(line);
		});
		$('#marketSellOrders').html(renderTable(headings,data));
	});
}

// UTILITY FUNCTIONS
function renderTable(headings,data){
	var r  = "<table>";
	if(headings.length > 0){
		r += "<tr class='tableHeading'>";
		$.each(headings,function(){ r += "<td>" + this + "</td>"; });
		r += "</tr>";
	}
	$.each(data,function(){
		r += "<tr>";
		$.each(this,function(){ r += "<td>" + this + "</td>"; });
		r += "</tr>";
	});
	r += "</tr></table>";
	return r;
}

$(document).ready(function(){
	// SETUP PAGE
	$("#tabs").tabs();
	$("#accordion").accordion();
	loadSales();
	loadInventory();
	loadOpenBids();
	loadOpenAsks();
	getMarketStatus();

	// FORM VALIDATION
	$('#confirmAsk').submit(function(){
		var askId  = this.confirmAskId.value;
		if(askId){
			var size   = sales[1].length;
			var lot    = openAsks[1][askId][1];
			var price  = openAsks[1][askId][3];
			var amount = openAsks[1][askId][4];
			var cost   = inventory[1][lot][2];
			var net    = 0;
			sales[1].push([size,'0',cost,price,amount,net]);
			openAsks[1].splice(askId,1);
			inventory[1].splice(lot,1);
			loadOpenAsks();
			loadSales();
			loadInventory();
			alert('Sale confirmed. Record added to sales.');
		}
		return false;
	});
	$('#confirmBid').submit(function(){
		var bidId  = this.confirmBidId.value;
		if(bidId){
			var price  = openBids[1][bidId][1];
			var amount = openBids[1][bidId][2];
			openBids[1].splice(bidId,1);
			loadOpenBids();
			inventory[1].push(['0','0',price,amount,'OK']);
			loadInventory();
			alert('Buy Confirmed. Coins added to inventory.');
		}
		return false;
	});
	$('#cancelBid').submit(function(){
		var bidId  = this.cancelBidId.value;
		if(bidId){
			openBids[1].splice(bidId,1);
			loadOpenBids();
		}
		return false;
	});
	$('#cancelAsk').submit(function(){
		var askId  = this.cancelAskId.value;
		if(askId){
			var lot = openAsks[1][askId][1];
			inventory[1][lot][4] = 'OK';
			openAsks[1].splice(askId,1);
			loadOpenAsks();
			loadInventory();
		}
		return false;
	});
	$('#postAsk').submit(function(){
		var askId  = this.postAskId.value;
		var price  = this.price.value;
		if(askId && price > 0 && inventory[1][askId][4] == 'OK'){
			var lot    = inventory[1][askId][0];
			var time   = inventory[1][askId][1];
			var amount = inventory[1][askId][3];
			inventory[1][askId][4] = 'HOLD';
			openAsks[1].push([0,lot,time,price,amount]);
			loadInventory();
			loadOpenAsks();
		}
		this.price.value = '';
		return false;
	});
	$('#postBid').submit(function(){
		var price  = this.price.value;
		var amount = this.amount.value;
		if(price && !isNaN(price) && amount && !isNaN(amount)){
			openBids[1].push([0,price,amount]);
			loadOpenBids();
		}else{
			alert("Invalid Values");
		}
		this.price.value = '';
		this.amount.value = '';
		return false;
	});
});
