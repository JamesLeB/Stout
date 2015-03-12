
$(document).ready(function()
{
	var p = { func: 'startup' };
	$.post('websocket.php',p,function(data)
	{
		kara = data;
		webSocket();
		$('#stopSock').click(function(){ ws.close(); });
		setInterval(function(){ refreshPage(); },100);
	});
});

var ws = {};

var open = [];
var received = [];
var done = [];
var match = [];
var error = [];

var status = 'Startup';
var eTime = 0;
var messageTotal = 0;
var kara = '';


function webSocket()
{
	ws = new WebSocket('wss://ws-feed.exchange.coinbase.com');
	ws.onopen = function()
	{
		ws.send('{ "type": "subscribe", "product_id": "BTC-USD" }');
	}
	ws.onmessage = function(evt)
	{
		messageTotal++;
		var obj = $.parseJSON(evt.data);

		if(obj.type == 'open')
		{
			open.push(evt.data);
		}
		else if(obj.type == 'received')
		{
			received.push(evt.data);
		}
		else if(obj.type == 'done')
		{
			done.push(evt.data);
		}
		else if(obj.type == 'match')
		{
			//$('#feed').prepend(evt.data+'<br/>');
			$('#feed').prepend( obj.side + ' ' + obj.size + ' ' + obj.price + '<br/>' );
			match.push(evt.data);
		}
		else
		{
			error.push(evt.data);
		}
		var p = { func: 'upload' };
		$.post('websocket.php',p,function(data)
		{
			eTime++;
			kara = data;
		});
		refreshPage();
	};
}
function refreshPage()
{
	$('#data > div:nth-child(1) > div:nth-child(2)').html(open.length);
	$('#data > div:nth-child(2) > div:nth-child(2)').html(received.length);
	$('#data > div:nth-child(3) > div:nth-child(2)').html(done.length);
	$('#data > div:nth-child(4) > div:nth-child(2)').html(match.length);
	$('#data > div:nth-child(5) > div:nth-child(2)').html(error.length);
	$('#status').html('Status: ' + status + ' -- Messages: ' + messageTotal + ' -- Sent: ' + eTime + ' -- ' + kara);
}
