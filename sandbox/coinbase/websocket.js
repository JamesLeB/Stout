
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
	$('#syncBuffer').click(function()
	{
		var p = { func: 'syncBuffer' };
		$.post('websocket.php',p,function(data) { });
	});
/*
	$('#startFeed').click(function()
	{
		webSocket(); $('#stopSock').click(function() { ws.close(); });
	});
	$('#D').click(function()
	{
		var p = { func: 'clearDebug' };
		$.post('websocket.php',p,function(data)
		{
			$('#debug').html(data);
		});
	});
	$('#loadOrders').click(function()
	{
		var p = { func: 'loadOrders' };
		$.post('websocket.php',p,function(data)
		{
			$('#debug').html(data);
		});
	});
	$('#getOrders').click(function()
	{
		var p = { func: 'getOrders' };
		$.post('websocket.php',p,function(data)
		{
			$('#debug').html(data);
		});
	});
	$('#getOpenOrders').click(function()
	{
		var p = { func: 'getOpenOrders' };
		$.post('websocket.php',p,function(data)
		{
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
	$('#getBook').click(function()
	{
		var p = { func: 'getBook' };
		$.post('websocket.php',p,function(data) { });
	});
*/
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
/*
				var id = $(this).attr('minion');
				var p = { func: 'activateMinion', minionId: id};
				$.post('websocket.php',p,function(data) {
					//$('#debug').html(data);
				});
*/
			});
			tick();
			webSocket(); $('#stopSock').click(function() { ws.close(); });
		});
	});
});

function tick()
{
	var payload = [];
	// Switch and clear buffer
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

	var p = { func: 'tick', click: click, payload: payload };
	$.post('websocket.php',p,function(data)
	{
		// UPDATE CLOCK
		$('#clock > div').html(++click);

		$('#tickReturn').html('<br/>'+data);
		var obj = $.parseJSON(data);

		$('#data').html("Buff: "+obj.socketBuffer);

		var bookTable = '';
		obj.buffer.forEach(function(order)
		{
			var or = $.parseJSON(order);
			bookTable += '<div>' + or.sequence + '</div>';
		});
		$('#book').html(bookTable);
/*


		if(obj.matchedResult[1] == 1){$('#matchedResult').html('<br/>'+obj.matchedResult[2]+'<br/>x');}

		$('#data').html(obj.feedData + " :: " + obj.minionAction);


		// SEND TICK DEBUG TO PAGE
		if(obj.debug != ''){$('#debug').html(obj.debug)};

		// UPDATE MINIONS
		var minions = obj.minions;
		minions.forEach(function(m,index)
		{
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(2)').html(Number(m.size).toFixed(2));
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(3)').html(Number(m.cost).toFixed(2));
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(4)').html(Number(m.price).toFixed(2));
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(5)').html(m.orderId);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(6)').html(m.state);
			$('#minions > div:nth-child('+(index+1)+') > div:nth-child(7)').html(m.msg);
		});

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

		// UPDATE socket buffer Feed back
		if( obj.active == 0 )
		{
			$('#james').html(obj.socketBuffer);
		}
		else
		{
			$('#james').html('Running: '+obj.msg);
		}

		// CALL TICK
		if(obj.stopOrder == 0 && obj.matchedResult[0] == 0){tick();}
*/
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
		var obj = $.parseJSON(evt.data);

		// SEND MESSAGE TO BUFFERS
		message.total++;
	 	buffer1.push(evt.data);
		buffer2.push(evt.data);

		// UPDATE STATUS
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
}
