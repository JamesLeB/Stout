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
		padding : 10px;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		color : white;
	}
	.pair > div:nth-child(1)
	{
		border : 1px solid transparent;
		padding : 5px;
		height : 20px;
	}
	.pair > div:nth-child(1) > div
	{
		border : 1px solid transparent;
		float : left;
	}
	.pair > div:nth-child(1) > div:nth-child(1) { width : 150px; }
	.pair > div:nth-child(1) > div:nth-child(2) { width : 100px; }
	.pair > div:nth-child(1) > div:nth-child(3) { width : 150px; }
	.pair > div:nth-child(1) > div:nth-child(4) { width : 150px; }
	.pair > div:nth-child(1) > div:nth-child(5) { width : 150px; }
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
		display : none;
	}
</style>
<script>
	$.post('index.php?/trader','',function(data){
		var obj = $.parseJSON(data)
		var html = '';
var factor = 10000000;
		obj.forEach(function(a){
			var slopeAl = a[2]*factor;
			var slope48 = a[3]*factor;
			var slope24 = a[4]*factor;
			html += '<div class=\'pair\'>';
			 html += '<div>';
			  html += '<div>' + a[0] + '</div>';
			  html += '<div>' + a[1] + '</div>';
			  html += '<div>' + slopeAl.toFixed(6) + '</div>';
			  html += '<div>' + slope48.toFixed(6) + '</div>';
			  html += '<div>' + slope24.toFixed(6) + '</div>';
			 html += '</div>';
			 html += '<div>';
			  html += '<div>' + a[5] + '</div>';
			 html += '</div>';
			html += '</div>';
		});
		$('#trader').html(html);
	});
</script>
<?php
?>
