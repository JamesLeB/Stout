<?php
	$html = "
		<ul>
			<li>Open database connection</li>
			<li>Get List of coins</li>
			<li>Create table view of coins</li>
		</ul>
		<div id='trader'></div>
	";
# background-image : url('lib/images/wood1.jpg');
# background-image : url('lib/images/slate1.jpg');

	$style = "
		<style>
				.pair
				{
					border : 1px solid gray;
					margin : 10px;
					padding : 10px;
				}
				.pair > div:nth-child(1)
				{
					height : 30px;
				}
				.pair > div:nth-child(1) > div
				{
					border : 1px dotted gray;
					float : left;
					width : 200px;
				}
				.pair > div:nth-child(1) > div:nth-child(1)
				{
					width : 200px;
				}
				.pair > div:nth-child(1) > div:nth-child(2)
				{
					width : 200px;
				}
				.pair > div:nth-child(2)
				{
					height : 50px;
					border : 1px solid green;
					width : 900px;
					padding : 10px;
					margin-left   : auto;
					margin-right  : auto;
					margin-top    : 10px;
					margin-bottom :  5px;
				}
		</style>
	";
	$script = "
		<script>
var groot = 'i groot';
			$.post('index.php?/trader','',function(data){
				var obj = $.parseJSON(data)
				var html = '';
				obj.forEach(function(a){
					html += '<div class=\'pair\'>';
					 html += '<div>';
					  html += '<div>' + a[0] + '</div>';
					  html += '<div>' + a[1] + '</div>';
					 html += '</div>';
					 html += '<div>';
					  html += '<div>' + groot + '</div>';
					 html += '</div>';
					html += '</div>';
				});
				$('#trader').html(html);
				//$('#trader').html(data);
			});
		</script>
	";
	echo $style;
	echo $html;
	echo $script;
## TEMP
/*
var list = a[2];
var count = 0;
var trades = '<table>';
trades += '<thead>';
trades += '<tr>';
trades += '<td>Index</td>';
trades += '<td>Type</td>';
trades += '<td>Time</td>';
trades += '<td>Elapsed</td>';
trades += '<td>Price</td>';
trades += '<td>Amount</td>';
trades += '<td>Date</td>';
trades += '</tr>';
trades += '</thead>';
var tStart = list[0].time_stamp;
list.forEach(function(b){
	count++;
	trades += '<tr>';
	trades += '<td>' + count + '</td>';
	trades += '<td>' + b.type + '</td>';
	trades += '<td>' + b.time_stamp + '</td>';
	trades += '<td>' + (b.time_stamp - tStart) + '</td>';
	trades += '<td>' + b.price + '</td>';
	trades += '<td>' + b.amount + '</td>';
	trades += '<td>' + b.date + '</td>';
	trades += '</tr>';
});
trades += '</table>';
		<style>
				.pair table
				{
					border : 1px solid green;
				}
				.pair table td
				{
					padding : 10px;
				}
				.pair table thead td
				{
					background : green;
					color : white;
					text-align : center;
				}
		</style>
*/
## TEMP
?>
