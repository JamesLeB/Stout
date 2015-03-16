<div id='todo'>
	<div>M - Move claim file to 14.97 New folder</div>
	<div>S - Get claim file from 14.97 New folder
		<div id='newClaimFolder'></div>
	</div>
	<div>S - Put claims in 14.97 Sent folder</div>
	<div>S - Put claims in 14.97 claim Queue</div>
	<div>S - Create 270 file from claim file</div>
	<div>S - Send 270 file to 14.97 270 queue</div>
	<div>M - Get 270 file from 14.97 270 queue</div>
	<div>M - Send 270 file to state</div>
</div>
<style>
	#todo
	{
		border: 5px ridge yellow;
		background: lightgreen;
	}
	#todo > div
	{
		border: 1px dotted gray;
		margin: 10px;
	}
	#newClaimFolder
	{
		border: 5px ridge gray;
		background: lightgray;
		height: 200px;
		width: 500px;
	}
	#newClaimFolder > div
	{
		margin: 5px;
	}
</style>
<script>
$(document).ready(function()
{
	$.post('index.php?/john/getNewList','',function(d)
	{
		var list = $.parseJSON(d);
		$('#newClaimFolder').html('');
		list.forEach(function(i)
		{
			$('#newClaimFolder').append('<div>'+i+'</div>');
		});
		$('#newClaimFolder > div').mouseenter(function(){
			$(this).css('background','yellow');
		});
		$('#newClaimFolder > div').mouseleave(function(){
			$(this).css('background','lightgray');
		});
		$('#newClaimFolder > div').click(function(){
			var file = $(this).html();
			var p = {file: file};
			$.post('index.php?/john/getNewFile',p,function(d)
			{
				$('#newClaimFolder').html(d);
			});
		});
	});
});
</script>
