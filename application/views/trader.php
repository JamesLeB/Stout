<div id='trader'></div>
<style>
	/* background-image : url('lib/images/wood1.jpg'); */
	#trader
	{
		background : green;
		border : 2px solid black;
	}
	.pair
	{
		background-image : url('lib/images/slate1.jpg');
		border : 1px solid gray;
		margin  : 20px;
		padding : 20px;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		color : white;
	}
	.pair > div:nth-child(1)
	{
		border : 1px solid white;
		padding : 5px;
		height : 25px;
	}
	.pair > div:nth-child(1) > div
	{
		border : 1px solid black;
		float : left;
		width : 200px;
	}
	.pair > div:nth-child(1) > div:nth-child(1)
	{
		width : 150px;
	}
	.pair > div:nth-child(1) > div:nth-child(2)
	{
		width : 100px;
	}
	.pair > div:nth-child(1) > div:nth-child(3)
	{
		width : 200px;
	}
	.pair > div:nth-child(1) > div:nth-child(4)
	{
		width : 200px;
	}
	.pair > div:nth-child(2)
	{
		height : 50px;
		border : 5px inset gray;
		width : 1000px;
		height : 400px;
		padding : 10px;
		margin-left   : auto;
		margin-right  : auto;
		margin-top    : 10px;
		margin-bottom :  5px;
		overflow : auto;
	}
</style>
<script>
	$.post('index.php?/trader','',function(data){
		var obj = $.parseJSON(data)
		var html = '';
		obj.forEach(function(a){
			html += '<div class=\'pair\'>';
			 html += '<div>';
			  html += '<div>' + a[0] + '</div>';
			  html += '<div>' + a[1] + '</div>';
			  html += '<div>' + a[2] + '</div>';
			  html += '<div>' + a[3] + '</div>';
			 html += '</div>';
			 html += '<div>';
			  html += '<div>' + a[4] + '</div>';
			 html += '</div>';
			html += '</div>';
		});
		$('#trader').html(html);
		//$('#trader').html(data);
	});
</script>
<?php
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
