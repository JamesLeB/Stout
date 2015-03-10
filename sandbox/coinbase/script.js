$(document).ready(function(){
	// TIME
	setInterval(function(){ advanceTime(); },3000);

	//$('#debug').hide();

	// GET BALANCES FROM Exchange
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
	$(bidButton).click(function(){
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
			$.post('action.php',p,function(data){
				$('#debug').append(data);
				mode = 'Normal';
				advanceTime();
			});
		}
		else
		{
			$('#debug').append('not enough USD');
		}
	});
	var askButton = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(6) > button:nth-child(3)';
	$(askButton).click(function(){
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
			$.post('action.php',p,function(data){
				$('#debug').append(data);
				mode = 'Normal';
				advanceTime();
			});
		}
		else
		{
			$('#debug').append('not enough BTC');
		}
	});
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
		advanceTime();
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
});

var test = 0;
var status = "Normal";
var mode   = "Start";
var eTime = 0;
var trader = {
	size: .08,
	bidAdj: 0,
	askAdj: 0,
	usd: 0,
	btc: 0
};

function getOrders()
{
	var o = ['a','b','c','d']
	var a = [o];

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
	$.post('action.php',p,function(data){
		$('#debug').html(data);
		mode = 'Normal';
		advanceTime();
	});
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

			status = 'Normal';
			$('#status').css('background','lightgreen');
			$('#status').html(status + " " + test);

			var obj = $.parseJSON(data);

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

			// REFRESH ORDERS
			//currentOrders = $.parseJSON(obj.orders);
			currentBidList = '';
			currentAskList = '';
			trader.orders.forEach(function(order){
				var cList = '';
				cList += "<div class='openOrder'>";
				cList += "<div>" + order[0] + "</div>";
				cList += "<div>" + order[1] + "</div>";
				cList += "<div>" + order[2] + "</div>";
				cList += "<div>" + 0 + "</div>";
				var orderId = order.id;
				cList += '<div><button onclick="cancelOrder(\''+orderId+'\');">Cancel</button></div>';
				cList += "</div>";
				if(order[0] == 'buy')
				{
					currentBidList += cList;
				}
				else if (order[0] == 'sell')
				{
					currentAskList += cList;
				}
				currentBidList += cList;
			});
			$(openBids).html(currentBidList);
			$(openAsks).html(currentAskList);
/*
*/
			//$('#debug').html(obj.openBids);


/*
	Update page
*/
			$(bookBid).html(obj.book.bidPrice);
			$(bookAsk).html(obj.book.askPrice);
			$(bookSpread).html(obj.book.spread);

			trader.bid = obj.book.bidPrice*1 + trader.bidAdj;
			//trader.bid = obj.book.bidPrice*1 - 100;
			trader.ask = obj.book.askPrice*1 - trader.askAdj;
			//trader.ask = obj.book.askPrice*1 + 100;

			$(traderBid).html(trader.bid);
			$(traderAsk).html(trader.ask);
			$(traderSize).html(trader.size);

			$(usdAmount).html(trader.usd);
			$(btcAmount).html(trader.btc);

		});
	}
}
