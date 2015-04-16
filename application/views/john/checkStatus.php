<div id='claimStatusRequest'>
	Lets create a claim status request
	<div></div>
	<div></div>
</div>
<style>
	#claimStatusRequest
	{
		border: 5px ridge yellow;
		background: lightgreen;
		height:  700px;
		width:  1000px;
	}
	#claimStatusRequest > div
	{
		border: 5px ridge gray;
		background: lightgray;
		margin: 10px;
		padding: 10px;
		height: 200px;
		overflow: auto;
	}
	#claimStatusRequest > div:nth-child(2)
	{
		height: 350px;
	}
</style>
<script>
	$('#claimStatusRequest > div:nth-child(1)').html('getting list from somewhere');
	//$('#claimStatusRequest > div:nth-child(2)').html('Click out put will go here');
	var p = {};
	$.post('index.php?/john/getBatchList',p,function(d)
	{
		$('#claimStatusRequest > div:nth-child(1)').html('Clickable File List');
		var list = $.parseJSON(d);
		list.forEach(function(i)
		{
			$('#claimStatusRequest > div:nth-child(1)').append('<div>'+i+'</div>');
		});
		$('#claimStatusRequest > div:nth-child(1) > div').mouseenter(function(){
			$(this).css('background','yellow');
		});
		$('#claimStatusRequest > div:nth-child(1) > div').mouseleave(function(){
			$(this).css('background','lightgray');
		});
		$('#claimStatusRequest > div:nth-child(1)  > div').click(function(){
			var file = $(this).html();
			var p = {file: file};
			$.post('index.php?/john/createStatusRequest',p,function(d)
			{
				var thing = $.parseJSON(d);
				//$('#claimStatusRequest > div:nth-child(2)').html(thing.batch)
				$('#claimStatusRequest > div:nth-child(2)').html(thing.statusRequest)
			});
		});
/*
*/
	});
</script>