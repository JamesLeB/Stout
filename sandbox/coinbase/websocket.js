
var ws = {};

var message = {
	open:     0,
	received: 0,
	done:     0,
	match:    0,
	error:    0,
	total:    0
};

var eTime        = 0;
var kara         = '';
var click        = 0;
var minions = [];

$(document).ready(function()
{
	var d = new Date();
	elapsed = d.getTime();

	var p = { func: 'startup' };
	$.post('websocket.php',p,function(data)
	{
		webSocket();
		$('#stopSock').click(function() { ws.close(); });
		tick();
	});
});
function tick()
{
	click++;
	var p = { func: 'tick' };
	$.post('websocket.php',p,function(data)
	{
		$('#clock > div').html(click);

		var o = $.parseJSON(data);
		minions = o.minions;

var orderBook = o.orderBook;
$('#james').html(orderBook);

		refreshPage();
		tick();
	});
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
			m = $.parseJSON(data);
			var s  = 'Messages: ' + message.total;
                s += ' -- Sent: ' + eTime;
                s += ' -- ' + m;
			$('#status').html(s);
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

/*
	$('#james').html('');
	minions.forEach(function(minion)
	{
		$('#james').append("<div class='minion onBookBid'>"+minion+"</div>");
	});
*/
}
