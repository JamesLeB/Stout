
var ws = {};

var message = {
	open:     0,
	received: 0,
	done:     0,
	match:    0,
	error:    0,
	total:    0
};

var eTime = 0;
var kara  = '';
var click = 0;

var minions  = [];
var liveBook = {};
var book     = [];

$(document).ready(function()
{
	//var d = new Date();
	//elapsed = d.getTime();

	var p = { func: 'startup' };
	$.post('websocket.php',p,function(data)
	{
		var obj = $.parseJSON(data);
		var o = obj.book;

		// READ and DISPLAY full order book

		sequence = o.sequence;

		bids = o.bids;
		var bidTable = "<table id=bidTable>";
		bids.forEach(function(bid)
		{
			bidTable += '<tr>';
			bidTable += '<td>+</td>';
			bid.forEach(function(e)
			{
				bidTable += '<td>'+e+'</td>';
			});
			bidTable += '</tr>';
		});
		bidTable += '</table>';

		asks = o.asks;
		var askTable = "<table id=askTable>";
		asks.forEach(function(ask)
		{
			askTable += '<tr>';
			askTable += '<td>-</td>';
			ask.forEach(function(e)
			{
				askTable += '<td>'+e+'</td>';
			});
			askTable += '</tr>';
		});
		askTable += '</table>';

		//$('#james').append(sequence);
		//$('#james').append(bidTable);
		//$('#james').append(askTable);
		//$('#james').html(obj.debug);

		webSocket(); $('#stopSock').click(function() { ws.close(); });
		tick();
	});
});
function tick()
{
	var p = { func: 'tick', click: click };
	$.post('websocket.php',p,function(data)
	{
		$('#clock > div').html(++click);
		var obj = $.parseJSON(data);

		// ADD LIVE ORDER BOOK
		var liveBookTable = '';
		liveBookTable += "<table>";
		obj.liveBook.forEach(function(order)
		{
			var side = order.shift();
			liveBookTable += "<tr class='"+side+"'>";
			liveBookTable += "<td>"+Number(order[0]).toFixed(2)+"</td>";
			liveBookTable += "<td>"+Number(order[1]).toFixed(8)+"</td>";
			liveBookTable += "<td>"+order[2]+"</td>";
			liveBookTable += "<td>"+order[3]+"</td>";
			var orders = '';
			order[4].forEach(function(x)
			{
				orders += '<div>'+x[0]+' : '+x[1]+'</div>';
			});
			liveBookTable += "<td>"+orders+"</td>";
			liveBookTable += "</tr>";
		});
		liveBookTable += "</table>";
		$('#book').html(liveBookTable);

		$('#james').html(obj.socketBuffer);
		$('#james').append('<br/>'+obj.nextOrder);

		//var o = $.parseJSON(data);
		//minions = o.minions;

		if(obj.stopOrder == 0){tick();}
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

		refreshPage();

		var p = { func: 'upload', message: evt.data };
		$.post('websocket.php',p,function(data)
		{
			eTime++;
			var s  = 'Messages: ' + message.total;
                s += ' -- Sent: ' + eTime;
                s += ' -- ' + $.parseJSON(data);
			$('#status').html(s);
		});

		// PROCESS NEW TRADE
		if(obj.type == 'match')
		{
			var matchSide  = '<div>'+obj.side+'</div>';
			var matchSize  = '<div>'+obj.size+'</div>';
			var matchPrice = '<div>'+Number(obj.price).toFixed(2)+'</div>';
			var matchLine = "<div class='"+obj.side+"'>"+matchSide+matchPrice+matchSize+"</div>";
			$('#feed').prepend(matchLine);
		}
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
