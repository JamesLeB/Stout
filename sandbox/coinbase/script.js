var autoRun = 1;
$(document).ready(function(){
	// TIME
	setInterval(function(){ advanceTime(); },3000);

	$('#debug').hide();

	// GET BALANCES FROM Exchange
	mode = 'Start';
	var p = {func: 'getBalances', json: ''};
	$.post('action.php',p,function(data){
		var obj = $.parseJSON(data);
		trader.usd = obj[0];
		trader.btc = obj[1];
		mode = 'Normal';
		advanceTime();
	});

	// GET ORDERS FROM DB
	getOrders();

	var bidButton = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > button:nth-child(3)';
	$(bidButton).click(function(){postBid();});
	var askButton = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(6) > button:nth-child(3)';
	$(askButton).click(function(){postAsk();});
	var buttonA = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(4) > button:nth-child(1)';
	$(buttonA).click(function(){
		if(mode == 'Hold')
		{
			mode = 'Normal';
		}
		else
		{
			mode = 'Hold';
		}
		$('#debug').html('Mode set to: '+mode);
		//advanceTime();
	});
	var buttonB = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(4) > button:nth-child(2)';
	$(buttonB).click(function(){
		var obj = {};
		var jstring = JSON.stringify(obj);
		var p = {func: 'runOrderTable', json: jstring};
		$.post('action.php',p,function(data){
			$('#debug').html(data);
		});
	});
	var buttonC = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(4) > button:nth-child(3)';
	$(buttonC).click(function(){
		var obj = {};
		var jstring = JSON.stringify(obj);
		var p = {func: 'createTable', json: jstring};
		$.post('action.php',p,function(data){
			$('#debug').html(data);
		});
	});
	var bSizeUp = '#exchange > div:nth-child(2) > div:nth-child(3) > div:nth-child(3) > button:nth-child(1)';
	$(bSizeUp).click(function(){
		trader.size = trader.size*1 + .01;
		trader.size = trader.size.toFixed(2);
		refreshPage();
	});
	var bSizeDown = '#exchange > div:nth-child(2) > div:nth-child(3) > div:nth-child(3) > button:nth-child(2)';
	$(bSizeDown).click(function(){
		trader.size = trader.size*1 - .01;
		trader.size = trader.size.toFixed(2);
		refreshPage();
	});
});

var test = 0;
var status = "Normal";
var mode   = "Normal";
var eTime = 0;
var trader = {
	size: .04,
	bidAdj: 0,
	askAdj: 0,
	usd: 0,
	btc: 0,
	book: {},
	btcCost: 0
};
function postBid()
{
	var bid = {
		type: 'buy',
		size: trader.size,
		price: trader.bid,
		product: 'BTC-USD',
	};
	var jstring = JSON.stringify(bid);
	var p = {func: 'newBid', json: jstring};
	var funding = trader.usd - (trader.size * trader.bid);
	$('#debug').html('Placing Bid: ');
	if( funding > 0 )
	{
		status = 'Request';
		$.post('action.php',p,function(data){
			status = 'Normal';
			$('#debug').append(data);
			//mode = 'Normal';
			//advanceTime();
		});
	}
	else
	{
		$('#debug').append('not enough USD');
	}
}
function postAsk()
{
	var ask = {
		type: 'sell',
		size: trader.size,
		price: trader.ask,
		product: 'BTC-USD',
	};
	var jstring = JSON.stringify(ask);
	var p = {func: 'newAsk', json: jstring};
	var funding = trader.btc - trader.size;
	$('#debug').html('Placing Ask: ');
	if( funding >= 0 )
	{
		status = 'Request';
		$.post('action.php',p,function(data){
			status = 'Normal';
			$('#debug').append(data);
			//mode = 'Normal';
			//advanceTime();
		});
	}
	else
	{
		$('#debug').append('not enough BTC');
	}
}
function getOrders()
{
	var p = {func: 'getOrders', json: ''};
	$.post('action.php',p,function(data){
		var obj = $.parseJSON(data);
		trader.orders = obj;
		$('#debug').html('getting orders');
	});
}
function cancelOrder(a)
{
	var obj = { bidId: a };
	var jstring = JSON.stringify(obj);
	var p = {func: 'cancelOrder', json: jstring};
	status = 'Request';
	$.post('action.php',p,function(data){
		status = 'Normal';
		$('#debug').html(data);
	});
}
function refreshPage()
{
	var usdAmount  = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(2)';
	var btcAmount  = '#exchange > div:nth-child(1) > div:nth-child(3) > div:nth-child(2)';
	var bookBid    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(1)';
	var bookSpread = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(2)';
	var bookAsk    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(3)';
	var traderBid  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(2)';
	var traderAsk  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(5)';
	var traderSize = '#exchange > div:nth-child(2) > div:nth-child(3) > div:nth-child(2)';
	var openBids   = '#exchange > div:nth-child(3) > div:nth-child(2) > div:nth-child(2)';
	var openAsks   = '#exchange > div:nth-child(3) > div:nth-child(3) > div:nth-child(2)';
	var btcCost    = '#exchange > div:nth-child(1) > div:nth-child(3) > div:nth-child(3)';

	// REFRESH ORDERS
	var currentBidList = '';
	var currentAskList = '';
	trader.orders.forEach(function(order){
		var cList = '';
		cList += "<div class='openOrder'>";
		cList += "<div>" + order.id + "</div>";
		cList += "<div>" + order.price + "</div>";
		cList += "<div>" + order.size + "</div>";
		cList += "<div>" + order.status + "</div>";
		cList += "<div>" + order.cost + "</div>";
		cList += "<div>" + order.sold + "</div>";
		if(order.status == 'NEW')
		{
			var orderId = order.serverId;
			cList += '<div><button onclick="cancelOrder(\''+orderId+'\');">Cancel</button></div>';
		}
		cList += "</div>";
		if(order.type == 'buy')
		{
			currentBidList += cList;
		}
		else if (order.type == 'sell')
		{
			currentAskList += cList;
		}
	});
	$(openBids).html(currentBidList);
	$(openAsks).html(currentAskList);

	$(traderBid).html(trader.bid);
	$(traderAsk).html(trader.ask);
	$(traderSize).html(trader.size);

	$(usdAmount).html(trader.usd);
	$(btcAmount).html(trader.btc);
	$(btcCost).html(trader.btcCost);

	$(bookBid).html(trader.book.bid);
	$(bookAsk).html(trader.book.ask);
	$(bookSpread).html(trader.book.spread);
}
function advanceTime()
{
	eTime++;
	$('#clock').html(eTime);
	$('#status').html(status + " " + test);
	$('#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(3)').html(mode);
	if(status == 'Normal' && mode == 'Normal')
	{
		test++;
		status = 'Request';
		//mode   = "Hold";
		$('#status').css('background','gray');
		$('#status').html(status + " " + test);





		$.post('time.php','',function(data){

			//$('#debug').html('From Time');

			status = 'Normal';
			$('#status').css('background','lightgreen');
			$('#status').html(status + " " + test);

			var obj = $.parseJSON(data);
			trader.orders = obj.orders;
			if(obj.debug != '')
			{
				$('#debug').html(obj.debug);
			}
			trader.usd = obj.accounts.usdAvailable;
			trader.btc = obj.accounts.btcAvailable;
			trader.btcCost = obj.btcCost;

			trader.bid = obj.book.bidPrice*1 + trader.bidAdj;
			trader.ask = obj.book.askPrice*1 - trader.askAdj;

			trader.book.ask    = obj.book.askPrice;
			trader.book.bid    = obj.book.bidPrice;
			trader.book.spread = obj.book.spread;
			refreshPage();
// #############################################
			// AUTO ASK CHOICE
			var decide = 'Make your choice';
			decide += '<br/>Get btc total: '+trader.btc;
			decide += '<br/>Get btc cost: '+trader.btcCost;
			decide += '<br/>Get trader ask: '+trader.ask;
			decide += '<br/>do the math: '+(trader.ask - trader.btcCost);
			if(trader.btc > 0 && trader.ask - trader.btcCost >= .01)
			{
				decide += '<br/>POST ASK';
				$('#debug').html(decide);
				postAsk();
			}
		
if(autoRun == 1){
			// AUTO BID CHOICE
			var decide = 'auto bid';
			var bidCount = 0;
			trader.orders.forEach(function(order){
				if(order.type == 'buy' && order.status == 'NEW'){ bidCount++; }
			});
			decide += '<br/>Get open bid count: ' + bidCount;
			decide += '<br/>Get spread: ' + trader.book.spread;
			decide += '<br/>Get usd: ' + trader.usd;
			decide += '<br/>Get bid price: ' + trader.bid;
			decide += '<br/>Get bid size: ' + trader.size;
			decide += '<br/>Get bid Cost: ' + (trader.size * trader.bid);
			decide += '<br/>Do the Math: ' + (trader.usd - trader.size * trader.bid);
			if(trader.usd - trader.size * trader.bid > 0 && bidCount <= 3 && trader.book.spread > .00)
			{
				decide += '<br/>POST BID';
				postBid();
				$('#debug').html(decide);
			}
}
// #############################################
		});
	}
}
