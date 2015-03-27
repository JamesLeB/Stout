<div id='todo'>
	<div id='newClaimFolder'></div>
	<div id='eligibilityFiles'><div></div><div></div><div></div></div>
	<div id='addElly'><div></div><div></div><div></div></div>
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
		height: 100px;
		width: 600px;
		overflow: auto;
	}
	#newClaimFolder > div { margin: 5px; }
	#eligibilityFiles
	{
		background: lightgray;
		width: 1200px;
	}
	#eligibilityFiles > div:nth-child(2)
	{
		height: 150px;
		margin-top: 10px;
	}
	#eligibilityFiles > div:nth-child(2) > div { margin: 5px; }
	#eligibilityFiles > div:nth-child(3)
	{
		height: 500px;
		overflow: auto;
		margin-top: 10px;
		padding-left: 20px;
	}
	#addElly
	{
		background: lightgray;
		width: 1200px;
	}
	#addElly > div:nth-child(2)
	{
		height: 150px;
		margin-top: 10px;
	}
	#addElly > div:nth-child(2) > div { margin: 5px; }
	#addElly > div:nth-child(3)
	{
		height: 500px;
		overflow: auto;
		margin-top: 10px;
		padding-left: 20px;
	}
</style>
<script>
$(document).ready(function()
{
	$('#newClaimFolder').hide();
	$('#eligibilityFiles').hide();
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

	$('#eligibilityFiles > div:nth-child(1)').html('271 files');
	$.post('index.php?/john/get271List','',function(d)
	{
		var list = $.parseJSON(d);
		$('#eligibilityFiles > div:nth-child(2)').html('');
		list.forEach(function(i)
		{
			$('#eligibilityFiles > div:nth-child(2)').append('<div>'+i+'</div>');
		});
		$('#eligibilityFiles > div:nth-child(2) > div').mouseenter(function(){
			$(this).css('background','yellow');
		});
		$('#eligibilityFiles > div:nth-child(2) > div').mouseleave(function(){
			$(this).css('background','lightgray');
		});
		$('#eligibilityFiles > div:nth-child(2) > div').click(function(){
			var file = $(this).html();
			var p = {file: file};
			$.post('index.php?/john/process271',p,function(d)
			{
				$('#eligibilityFiles > div:nth-child(3)').html(d);
			});
		});
	});

	$('#addElly > div:nth-child(1)').html('Add elly to claim file');
	$.post('index.php?/john/getNewList','',function(d)
	{
		var list = $.parseJSON(d);
		$('#addElly > div:nth-child(2)').html('');
		list.forEach(function(i)
		{
			$('#addElly > div:nth-child(2)').append('<div>'+i+'</div>');
		});
		$('#addElly > div:nth-child(2) > div').mouseenter(function(){
			$(this).css('background','yellow');
		});
		$('#addElly > div:nth-child(2) > div').mouseleave(function(){
			$(this).css('background','lightgray');
		});
		$('#addElly > div:nth-child(2) > div').click(function(){
			var file = $(this).html();
			var p = {file: file};
			$.post('index.php?/john/addElly',p,function(d)
			{
				$('#addElly > div:nth-child(3)').html(d);
			});
		});
	});

});
</script>
