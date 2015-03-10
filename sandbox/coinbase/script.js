$(document).ready(function(){
	//$('#debug').hide();
	setInterval(function(){ advanceTime(); },3000);
	advanceTime();
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
var mode   = "Normal";
var eTime = 0;
var trader = {size: .08};

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
/*
	Process open Orders
			currentOrders = $.parseJSON(obj.orders);
			currentBidList = '';
			currentAskList = '';
			currentOrders.forEach(function(currentOrder){
				var cList = '';
				cList += "<div class='openOrder'>";
				cList += "<div>" + currentOrder.size + "</div>";
				cList += "<div>" + currentOrder.price + "</div>";
				cList += "<div>" + currentOrder.side + "</div>";
				cList += "<div>" + 0 + "</div>";
				var orderId = currentOrder.id;
				cList += '<div><button onclick="cancelOrder(\''+orderId+'\');">Cancel</button></div>';
				cList += "</div>";
				if(currentOrder.side == 'buy')
				{
					currentBidList += cList;
				}
				else if (currentOrder.side == 'sell')
				{
					currentAskList += cList;
				}
			});
			$(openBids).html(currentBidList);
			$(openAsks).html(currentAskList);
*/
			//$('#debug').html(obj.openBids);


			$(usdAmount).html(obj.accounts.usdAvailable);
			$(btcAmount).html(obj.accounts.btcAvailable);
			$(bookBid).html(obj.book.bidPrice);
			$(bookAsk).html(obj.book.askPrice);
			$(bookSpread).html(obj.book.spread);
			$(traderBid).html(trader.bid);
			$(traderAsk).html(trader.ask);
			$(traderSize).html(trader.size);

			trader.usd = obj.accounts.usdAvailable;
			trader.btc = obj.accounts.btcAvailable;
			trader.spread = obj.book.spread;

			trader.bid = obj.book.bidPrice*1 + .01;
			//trader.bid = obj.book.bidPrice*1 - 100;
			trader.ask = obj.book.askPrice*1 - .01;
			//trader.ask = obj.book.askPrice*1 + 100;

		});
	}
}
