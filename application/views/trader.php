<?php
	$html = "
		<ul>
			<li>Open database connection</li>
			<li>Get List of coins</li>
			<li>Create table view of coins</li>
		</ul>
		<div id='trader'></div>
	";
	$style = "
		<style>
				background-image : url('lib/images/wood1.jpg');
				background-image : url('lib/images/slate1.jpg');
		</style>
	";
	$script = "
		<script>
			$.post('index.php?/trader','',function(data){
				$('#trader').html(data);
			});
/*
			$.post('index.php?/stout/getBter','',function(data){
				var obj = $.parseJSON(data)
				$('#coinData > div:nth-child(1)').html(obj[0]);
			});
*/
		</script>
	";
	echo $style;
	echo $html;
	echo $script;
?>
