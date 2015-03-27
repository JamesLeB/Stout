
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
var click = 0;

var activeBuffer = 1;
var buffer1 = [];
var buffer2 = [];
var tradeCount = 0;

$(document).ready(function()
{
	//var d = new Date();
	//elapsed = d.getTime();

	// SET UP BUTTON CLICKS
	$('#T').click(function(){ tick(); });
	$('#X').click(function(){ $('#james').toggle(); });
	$('#getOrders').click(function()
	{
		var p = { func: 'getOrders' };
		$.post('websocket.php',p,function(data)
		{
			//var a = $.parseJSON(data);
			$('#debug').html(data);
		});
	});
	$('#getMom').click(function()
	{
		var p = { func: 'getBalance' };
		$.post('websocket.php',p,function(data)
		{
			var balance = $.parseJSON(data);
			$('#mother').html("<div>USD: "+balance[0]+"</div><div>BTC: "+balance[1]+"</div>");
		});
	});
	$('#startFeed').click(function()
	{
		webSocket(); $('#stopSock').click(function() { ws.close(); });
	});
	$('#getBook').click(function()
	{
		var p = { func: 'getBook' };
		$.post('websocket.php',p,function(data) { });
	});
	$('#syncBuffer').click(function()
	{
		var p = { func: 'syncBuffer' };
		$.post('websocket.php',p,function(data) { });
	});
	$('#start').click(function()
	{
		// RUN STARTUP SCRIPT
		var p = { func: 'startup' };
		$.post('websocket.php',p,function(data)
		{
			var minions = $.parseJSON(data);
			var m = '';
			minions.forEach(function(a)
			{
				m += "<div class='minion' minion='"+a.id+"'>";
				m += "<div>" + a.id + "</div>";
				m += "<div>" + a.size + "</div>";
				m += "<div>" + a.cost + "</div>";
				m += "<div>" + a.price + "</div>";
				m += "<div>" + a.orderId + "</div>";
				m += "<div>" + a.state + "</div>";
				m += "<div>" + a.msg + "</div>";
				m += "</div>";
			});
			$('#minions').html(m);
		
			$('.minion').click(function()
			{
				var id = $(this).attr('minion');
				var p = { func: 'activateMinion', minionId: id};
				$.post('websocket.php',p,function(data) {
					//$('#debug').html(data);
				});
			});
		});
	});
});

function tick()
{
	// Switch and clear buffer
	var payload = [];
	if( activeBuffer == 1 )
	{
		activeBuffer = 2;
		payload = buffer1;
		buffer1 = [];
	}
	else
	{
		activeBuffer = 1;
		payload = buffer2;
		buffer2 = [];
	}
/*
*/

	var p = { func: 'tick', click: click, payload: payload };
	$.post('websocket.php',p,function(data)
	{
	//	$('#book').html(data);
		var obj = $.parseJSON(data);

		$('#data').html(obj.feedData);

		// UPDATE CLOCK
		$('#clock > div').html(++click);

		// SEND TICK DEBUG TO PAGE
		//$('#debug').html(obj.debug);

		// UPDATE MINIONS
		var minions = obj.minions;
		minions.forEach(function(m,index)
		{
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(2)').html(m.size);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(3)').html(m.cost);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(4)').html(m.price);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(5)').html(m.orderId);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(6)').html(m.state);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(7)').html(m.msg);
		});
/*
*/

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
/*
##################################################
*/

		// UPDATE socket buffer Feed back
		if( obj.active == 0 )
		{
			$('#james').html(obj.socketBuffer);
		}
		else
		{
			$('#james').html('Running: '+obj.msg);
		}
/*
*/

		// CALL TICK
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
		var obj = $.parseJSON(evt.data);

		message.total++;
		buffer1.push(evt.data);
		buffer2.push(evt.data);
/*
		if( activeBuffer == 1 )
		{
		}
		else
		{
		}
*/
		$('#status').html('');
		$('#status').append('Msg: '+message.total);
		$('#status').append(' B1: '+buffer1.length);
		$('#status').append(' B2: '+buffer2.length);
		$('#status').append(' Seq: '+obj.sequence);

		// PROCESS NEW TRADE
		if(obj.type == 'match')
		{
			var matchSide  = '<div>'+obj.side+'</div>';
			var matchSize  = '<div>'+obj.size+'</div>';
			var matchPrice = '<div>'+Number(obj.price).toFixed(2)+'</div>';
			var matchLine = "<div class='"+obj.side+"'>"+matchSide+matchPrice+matchSize+"</div>";
			$('#feed > div:nth-child(2)').prepend(matchLine);

			var test = $('#feed > div:nth-child(2) > div');
			if(test.length > 50)
			{ 
				$('#feed > div:nth-child(2) > div').last().remove();
 			}
			$('#feed > div:nth-child(1)').html(++tradeCount);
		}

	};


/*
		// UPDATE message feed data
		     if(obj.type == 'open')     { message.open++; }
		else if(obj.type == 'received') { message.received++; }
		else if(obj.type == 'done')     { message.done++; }
		else if(obj.type == 'match')    { message.match++; }
		else                            { message.error++; }
		$('#data > div:nth-child(1) > div:nth-child(2)').html(message.open);
		$('#data > div:nth-child(2) > div:nth-child(2)').html(message.received);
		$('#data > div:nth-child(3) > div:nth-child(2)').html(message.done);
		$('#data > div:nth-child(4) > div:nth-child(2)').html(message.match);
		$('#data > div:nth-child(5) > div:nth-child(2)').html(message.error);
*/

		// SEND new message to PHP
/*
		var p = { func: 'upload', message: evt.data };
		$.post('websocket.php',p,function(data)
		{
			eTime++;
			var s  = 'Messages: ' + message.total;
                s += ' -- Sent: ' + eTime;
                s += ' -- ' + $.parseJSON(data);
			$('#status').html(s);
		});
*/

}
