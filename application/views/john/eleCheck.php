<button id='goButton'>GO</button>
<button id='goRead'>Read</button>
<div id='newJob'></div>
<script>
	$('#goButton').click(function()
	{
		$.post('index.php?/john/getnewjob','',function(d)
		{
			$('#newJob').html(d);
		});
	});
	$('#goRead').click(function()
	{
		$.post('index.php?/john/getnewjobReadJson','',function(d)
		{
			$('#newJob').html(d);
		});
	});
</script>
<style>
	#newJob table td
	{
		padding: 10px;
	}
</style>