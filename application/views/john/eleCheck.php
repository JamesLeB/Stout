<div id='newJob'></div>
<script>
	$.post('index.php?/john/getnewjob','',function(d)
	{
		$('#newJob').html(d);
	});
</script>