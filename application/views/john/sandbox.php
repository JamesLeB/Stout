<div id='sandbox'>
</div>
<style>
	#sandbox
	{
		border: 1px solid blue;
		height: 600px;
		padding: 5px;
		overflow: auto;
	}
	#sandbox td
	{
		padding: 5px;
		border: dotted 1px gray;
	}
	#sandbox div
	{
		padding: 5px;
	}
</style>
<script>
	//var p = {file: file};

	$.post('index.php?/john/sandbox','',function(d)
	{
		//$('#sandbox').html(d);
		//$('#sandbox').html('');
		$('#sandbox').html('<table>');
		var list = $.parseJSON(d);
		list.forEach(function(i)
		{
			$('#sandbox').append('<tr>');
			i.forEach(function(j)
			{
				$('#sandbox').append('<td>'+j+'</td>');
			});
			$('#sandbox').append('<tr>');
			//$('#sandbox').append('<div>'+i[0]+'</div>');
		});
		$('#sandbox').append('</table>');
	});
/* THIS Chuck created the eligibility file
	$.post('index.php?/john/sandbox1','',function(d)
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
*/
</script>
