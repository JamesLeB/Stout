$(document).ready(function(){
	setInterval(function(){ advanceTime(); },3000);
	advanceTime();
});

var test = 0;
var status = "Normal";
var eTime = 0;

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

			$(usdAmount).html(obj.accounts.usdAvailable);
			$(btcAmount).html(obj.accounts.btcAvailable);

			$(bookBid).css('border','1px solid yellow');
			$(bookSpread).css('border','1px solid yellow');
			$(bookAsk).css('border','1px solid yellow');

			$(traderBid).css('border','1px solid yellow');
			$(traderAsk).css('border','1px solid yellow');
			$(traderSize).css('border','1px solid yellow');
		});
	}
}
