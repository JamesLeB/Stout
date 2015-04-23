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

/*
	$.post('index.php?/john/sandbox','',function(d)
	{
		//$('#sandbox').html(d);
		//$('#sandbox').html('');
		var mytable = '';
		mytable += 'Table<table>';
		var list = $.parseJSON(d);
		list.forEach(function(i)
		{
			mytable += '<tr>';
			i.forEach(function(j)
			{
				mytable += '<td>'+j+'</td>';
			});
			mytable += '</tr>';
			//$('#sandbox').append('<div>'+i[0]+'</div>');
		});
		mytable += '</table>EndTable';
		$('#sandbox').html(mytable);
	});
*/
/* THIS Chuck created the eligibility file
*/

	$.post('index.php?/john/sandbox1','',function(d)
	{
		var mytable = '';
		mytable += 'Table<table>';
		var list = $.parseJSON(d);
		list.forEach(function(i)
		{
			mytable += '<tr>';
			mytable += '<td>'+i.chart+'</td>';
			mytable += '<td>'+i.medicaid+'</td>';
			mytable += '<td>'+i.serviceDate+'</td>';
			mytable += '</tr>';
		});
		mytable += '</table>EndTable';
		$('#sandbox').html(mytable);
	});
</script>
