<html>
<head>
	<script src='jquery-1.11.1.js'></script>
	<style>
		#feed
		{
			border: 5px ridge gray;
			background: lightgray;
			height: 400px;
			overflow: auto;
			padding-left: 10px;
			width: 600px;
			float: right;
		}
		#status
		{
			border: 5px ridge yellow;
			background: lightgreen;
			height: 200px;
			overflow: auto;
			padding-left: 10px;
			padding-top: 10px;
			width: 400px;
			margin-left: 20px;
			margin-top: 10px;
		}
		#status div
		{
			border: 1px dotted gray;
		}
		#status > div
		{
			height: 30px;
		}
		#status > div > div
		{
			width: 80px;
			float: left;
		}
		#james
		{
			border: 5px ridge gray;
			background: lightgray;
			height: 400px;
			overflow: auto;
			padding: 10px;
			width: 600px;
			margin-top: 20px;
			margin-left: 20px;
		}
	</style>
</head>
<body>
	WEB SOCKET
	<button id='stopSock'>Stop</button>
	<div id='feed'></div>
	<div id='status'>
		<div>
			<div>open</div>
			<div>0</div>
		</div>
		<div>
			<div>received</div>
			<div>0</div>
		</div>
		<div>
			<div>done</div>
			<div>0</div>
		</div>
		<div>
			<div>match</div>
			<div>0</div>
		</div>
		<div>
			<div>error</div>
			<div>0</div>
		</div>
	</div>

	<div id='james'>

		MATCH
		<ul>
			<li>type</li>
			<li>sequence</li>
			<li>trade_id</li>
			<li>maker_order_id</li>
			<li>taker_order_id</li>
			<li>side</li>
			<li>size</li>
			<li>price</li>
			<li>time</li>
		</ul>

		DONE
		<ul>
			<li>type</li>
			<li>price</li>
			<li>side</li>
			<li>remaining_size</li>
			<li>sequence</li>
			<li>order_id</li>
			<li>reason</li>
			<li>time</li>
		</ul>
	
		RECEIVED
		<ul>
			<li>type</li>
			<li>sequence</li>
			<li>order_id</li>
			<li>size</li>
			<li>price</li>
			<li>side</li>
			<li>time</li>
		</ul>
	
		OPEN
		<ul>
			<li>type</li>
			<li>sequence</li>
			<li>side</li>
			<li>price</li>
			<li>order_id</li>
			<li>renaming_size</li>
			<li>time</li>
		</ul>
	</div>

<script>
var ws = {};

var open = [];
var received = [];
var done = [];
var match = [];
var error = [];

$('#stopSock').click(function(){ ws.close(); });
function webSocket()
{
	ws = new WebSocket('wss://ws-feed.exchange.coinbase.com');
	ws.onopen = function()
	{
		$('#test').append('<br/>'+'Opening websocket');
		ws.send('{ "type": "subscribe", "product_id": "BTC-USD" }');
	}
	ws.onmessage = function(evt)
	{
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
		refreshStatus();
	};
}
function refreshStatus()
{
	//$('#status').html('refreshing status');
	$('#status > div:nth-child(1) > div:nth-child(2)').html(open.length);
	$('#status > div:nth-child(2) > div:nth-child(2)').html(received.length);
	$('#status > div:nth-child(3) > div:nth-child(2)').html(done.length);
	$('#status > div:nth-child(4) > div:nth-child(2)').html(match.length);
	$('#status > div:nth-child(5) > div:nth-child(2)').html(error.length);
}
webSocket();
</script>
</body>
</html>
