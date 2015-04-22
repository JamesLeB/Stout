<div id='sandbox'>
</div>
<style>
	#sandbox
	{
		border: 1px solid blue;
		height: 400px;
		padding: 5px;
		overflow: auto;
	}
	#sandbox td
	{
		padding: 5px;
	}
</style>
<script>
	//var p = {file: file};
	$.post('index.php?/john/sandbox','',function(d)
	{
		$('#sandbox').html('<table>');
		var list = $.parseJSON(d);
		list.forEach(function(i)
		{
			$('#sandbox').append('<tr>');
			$('#sandbox').append('<td>'+i.chart+'</td>');
			$('#sandbox').append('<td>'+i.medicaid+'</td>');
			$('#sandbox').append('<td>'+i.serviceDate+'</td>');
			$('#sandbox').append('<tr>');
		});
		$('#sandbox').append('</table>');
	});
</script>
