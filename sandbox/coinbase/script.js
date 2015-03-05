$(document).ready(function(){
	var eTime = 0;
	setInterval(function(){
		eTime++;
		$('#clock').html(eTime);
		$('#status').css('background','gray');
		$.post('time.php','',function(data){
			$('#status').css('background','lightgreen');
			var obj = $.parseJSON(data);
			$('#status').html(obj.status);
			var usdAmount  = '#exchange > div:nth-child(1) > div:nth-child(2) > div:nth-child(2)';
			var btcAmount  = '#exchange > div:nth-child(1) > div:nth-child(3) > div:nth-child(2)';

			var bookBid    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(1)';
			var bookSpread = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(2)';
			var bookAsk    = '#exchange > div:nth-child(4) > div:nth-child(2) > div:nth-child(3)';

			var traderBid  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(2)';
			var traderAsk  = '#exchange > div:nth-child(2) > div:nth-child(2) > div:nth-child(5)';
			var traderSize = '#exchange > div:nth-child(2) > div:nth-child(3) > div:nth-child(2)';

			$(usdAmount).css('border','1px solid yellow');
			$(btcAmount).css('border','1px solid yellow');

			$(bookBid).css('border','1px solid yellow');
			$(bookSpread).css('border','1px solid yellow');
			$(bookAsk).css('border','1px solid yellow');

			$(traderBid).css('border','1px solid yellow');
			$(traderAsk).css('border','1px solid yellow');
			$(traderSize).css('border','1px solid yellow');
		});
	},1000);
});
