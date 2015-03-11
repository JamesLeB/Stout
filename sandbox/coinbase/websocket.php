<html>
<head>
	<script src='jquery-1.11.1.js'></script>
</head>
<body>
	<button id='stopSock'>Stop</button>
	Hello web socket
	<div id='test'></div>
<script>
var ws = {};

var open = [];
var received = [];
var done = [];
var match = [];

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
		$('#test').append('<br/>'+obj.type);
	};
}
webSocket();
</script>
</body>
</html>