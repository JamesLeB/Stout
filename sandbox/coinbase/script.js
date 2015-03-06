$(document).ready(function(){
	setInterval(function(){ advanceTime(); },3000);
	advanceTime();
	var bidButton = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(3) > button:nth-child(3)';
	$(bidButton).click(function(){
		var lot = { lot: 1, amount: trader.size, price: trader.bid };
		currentLots.push(lot);
	});
});

var test = 0;
var status = "Normal";
var eTime = 0;
var trader = {bid: 1, ask: 2, size: .1};

var currentLots = [];
var lot2 = { lot: 2, amount: 100, price: 230.21 };
//currentLots.push(lot2);


function advanceTime()
{
	eTime++;
	$('#clock').html(eTime);
	if(status == 'Normal')
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
			$(openBids).css('border','solid 1px yellow');

			var openLots = '#exchange > div:nth-child(6) > div:nth-child(2)';
			var lots = '';
			currentLots.forEach(function(lot){
				lots += "<div class='lot'><div>"+lot.lot+"</div><div>"+lot.amount+"</div><div>"+lot.price+"</div></div>";
			});
			$(openLots).html(lots);

			$(usdAmount).html(obj.accounts.usdAvailable);
			$(btcAmount).html(obj.accounts.btcAvailable);

			$(bookBid).html(obj.book.bidPrice);
			$(bookSpread).html(obj.book.spread);
			$(bookAsk).html(obj.book.askPrice);

			trader.bid = obj.book.bidPrice*1 + .01;
			trader.ask = obj.book.askPrice - .01;

			$(traderBid).html(trader.bid);
			$(traderAsk).html(trader.ask);
			$(traderSize).html(trader.size);
		});
	}
}
