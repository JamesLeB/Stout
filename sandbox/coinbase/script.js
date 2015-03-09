$(document).ready(function(){
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
		$('#debug').html('Placing Bid ' + funding);
		if( funding > 0 )
		{
			$.post('action.php',p,function(data){
				//var lot = { lot: data, amount: trader.size, price: trader.bid };
				//currentLots.push(lot);
				$('#debug').append('<br/>' + data);
			});
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
var mode   = "Hold";
var eTime = 0;
var trader = {size: .1};

var currentLots = [];
var lot2 = { lot: 2, amount: 100, price: 230.21 };
//currentLots.push(lot2);


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
		$('#status').css('background','gray');
		$('#status').html(status + " " + test);
		$.post('time.php','',function(data){
			status = 'Normal';
			$('#status').css('background','lightgreen');
			$('#status').html(status + " " + test);
			var obj = $.parseJSON(data);
			//$('#status').html(obj.status);
			var usdAmount  = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(2)';
			var btcAmount  = '#exchange > div:nth-child(1) > div:nth-child(3) > div:nth-child(2)';

			var bookBid    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(1)';
			var bookSpread = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(2)';
			var bookAsk    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(3)';

			var traderBid  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(2)';
			var traderAsk  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(5)';
			var traderSize = '#exchange > div:nth-child(2) > div:nth-child(3) > div:nth-child(2)';

			var openBids = '#exchange > div:nth-child(3)';
			$(openBids).css('border','solid 1px red');

			var openLots = '#exchange > div:nth-child(6) > div:nth-child(2)';
			var lots = '';
			currentLots.forEach(function(lot){
				lots += "<div class='lot'><div>"+lot.lot+"</div><div>"+lot.amount+"</div><div>"+lot.price+"</div></div>";
			});
			$(openLots).html(lots);

			$(usdAmount).html(obj.accounts.usdAvailable);
			trader.usd = obj.accounts.usdAvailable;
			$(btcAmount).html(obj.accounts.btcAvailable);
			trader.btc = obj.accounts.btcAvailable;

			$(bookBid).html(obj.book.bidPrice);
			$(bookSpread).html(obj.book.spread);
			trader.spread = obj.book.spread;
			$(bookAsk).html(obj.book.askPrice);

			//trader.bid = obj.book.bidPrice*1 + .01;
		trader.bid = obj.book.bidPrice*1 - 100;

			trader.ask = obj.book.askPrice - .01;

			$(traderBid).html(trader.bid);
			$(traderAsk).html(trader.ask);
			$(traderSize).html(trader.size);
		});
	}
}
