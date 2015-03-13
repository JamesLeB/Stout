
var ws = {};

var message = {
	open:     0,
	received: 0,
	done:     0,
	match:    0,
	error:    0,
	total:    0
};

var status       = 'Startup';
var eTime        = 0;
var kara         = '';
var click        = 0;

$(document).ready(function()
{
	var p = { func: 'startup' };
	$.post('websocket.php',p,function(data)
	{
		webSocket();
		$('#stopSock').click(function() { ws.close(); });
		setInterval(function(){ tick(); },1000);
	});
});

function tick()
{
	click++;
	if(click % 2 == 0) { $('#clock').css('background','lightgreen'); }
	else               { $('#clock').css('background','yellow'); }

	var p = { func: 'tick' };
	$.post('websocket.php',p,function(data)
	{
		$('#clock > div').html(click + " : " + data);
	});
	refreshPage();
}
function webSocket()
{
	ws = new WebSocket('wss://ws-feed.exchange.coinbase.com');
	ws.onopen = function()
	{
		ws.send('{ "type": "subscribe", "product_id": "BTC-USD" }');
	}
	ws.onmessage = function(evt)
	{
		message.total++;
		var obj = $.parseJSON(evt.data);

		     if(obj.type == 'open')     { message.open++; }
		else if(obj.type == 'received') { message.received++; }
		else if(obj.type == 'done')     { message.done++; }
		else if(obj.type == 'match')    { message.match++; }
		else                            { message.error++; }

		var p = { func: 'upload', message: evt.data };
		$.post('websocket.php',p,function(data)
		{
			eTime++;
			kara = data;
		});
		if(obj.type == 'match'){ $('#feed').prepend( obj.side + ' ' + obj.size + ' ' + obj.price + '<br/>' ); }
	};
}
function refreshPage()
{
	$('#data > div:nth-child(1) > div:nth-child(2)').html(message.open);
	$('#data > div:nth-child(2) > div:nth-child(2)').html(message.received);
	$('#data > div:nth-child(3) > div:nth-child(2)').html(message.done);
	$('#data > div:nth-child(4) > div:nth-child(2)').html(message.match);
	$('#data > div:nth-child(5) > div:nth-child(2)').html(message.error);
	$('#status').html('Status: ' + status + ' -- Messages: ' + message.total + ' -- Sent: ' + eTime + ' -- ' + kara);
}
