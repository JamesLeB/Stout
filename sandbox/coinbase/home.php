<html>
<head>
<script src='jquery-1.11.1.js'></script>
<script>
	$(document).ready(function(){
		var eTime = 0;
		setInterval(function(){
			eTime++;
			$('#clock').html(eTime);
		},500);
/*
		$.post('go.php','',function(data){
		});
*/
		$('#controls button').click(function(){
			var buttonName = $(this).html();
			parm = { action: buttonName };
			$.post('go.php',parm,function(data){
				var obj = $.parseJSON(data);
				$('#status').html(obj[0]);
				$('#exchange > div:nth-child(1)').html(obj[1]);
				$('#exchange > div:nth-child(2)').html(obj[2]);
				$('#exchange > div:nth-child(3)').html(obj[3]);
				$('#exchange > div:nth-child(4)').html(obj[4]);
				$('#exchange > div:nth-child(5)').html(obj[5]);
			});
		});
	});
</script>
<style>
	#controls
	{
		border: 1px solid red;
		height: 50px;
	}
	#controls > div
	{
		border: 1px solid blue;
		margin: 5px;
		float: left;
	}
	#controls button
	{
		float: left;
		margin: 5px;
	}
	#status
	{
		height: 30px;
		width: 300px;
		background: lightgreen;
	}
	#clock
	{
		border: 1px blue ridge;
		width: 50px;
		background: lightblue;
		text-align: center;
		height: 25px;
		padding-top: 5px;
	}
	#exchange
	{
		border: 5px ridge yellow;
		background: lightgreen;
	}
	#exchange > div
	{
		border: 1px solid black;
		margin: 10px;
	}
	table
	{
		border: 1px blue solid;
		margin: 10px;
	}
	table td
	{
		border: 1px black dashed;
		padding: 5px;
	}
</style>
</head>
<body>
	<div id='controls'>
		<div id='clock'>0</div>
		<div>
			<button>ONE</button>
			<button>BID</button>
			<button>ASK</button>
		</div>
		<div id='status'>Start</div>
	</div>
	<div id='exchange'>
		<div>Market</div>
		<div>Accounts</div>
		<div>Trades</div>
		<div>OrderBook</div>
		<div>Orders</div>
	</div>
</body>
</html>
