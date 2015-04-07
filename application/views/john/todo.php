<div id='todo'>
	<div id='newClaimFolder'></div>
	<div id='eligibilityFiles'><div></div><div></div><div></div></div>
	<div id='addElly'>
		<div></div>
		<div></div>
		<div>Test</div>
		<div>art28</div>
		<div>paul</div>
		<div>error</div>
		<div>medicare</div>
	</div>
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
		height: 300px;
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
		height: 250px;
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
		height: 200px;
		overflow: auto;
		margin-top: 10px;
		padding-left: 20px;
	}
	#addElly > div:nth-child(3)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
	}
	#addElly > div:nth-child(4)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
	}
	#addElly > div:nth-child(5) { border: 5px ridge yellow; }
	#addElly > div:nth-child(5)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
	}
	#addElly table
	{
		background: white;
	}
	#addElly table td
	{
		border: 1px dotted gray;
	}
	#addElly > div:nth-child(6)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
	}
	#addElly > div:nth-child(7)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
	}
</style>
<script>
$(document).ready(function()
{
	//$('#newClaimFolder').hide();
	//$('#eligibilityFiles').hide();
	//$('#addElly > div:nth-child(3)').hide();
	//$('#addElly > div:nth-child(4)').hide();
	//$('#addElly > div:nth-child(6)').hide();

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

//////////////////////////////////////////////////////////////////////////////////////

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
				var thing = $.parseJSON(d);
				$('#addElly > div:nth-child(3)').html(thing.batch+'<br/>');
				$('#addElly > div:nth-child(3)').append(thing.debug);
				var myTable       = '<table>';
				var art28Table    = '<table>';
				var paulTable     = '<table>';
				var errorTable    = '<table>';
				var medicareTable = '<table>';

				paulTable += '<tr>';
				paulTable += '<td>Line</td>';
				paulTable += '<td>Count</td>';
				paulTable += '<td>TCN</td>';
				paulTable += '<td>Echo</td>';
				paulTable += '<td>LastName</td>';
				paulTable += '<td>FirstName</td>';
				paulTable += '<td>Medicaid</td>';
				paulTable += '<td>Status</td>';
				paulTable += '<td>CARC</td>';
				paulTable += '<td>RARC</td>';
				paulTable += '<td>RateCode</td>';
				paulTable += '<td>ClaimBilled</td>';
				paulTable += '<td>ClaimPaid</td>';
				paulTable += '<td>Clinic</td>';
				paulTable += '<td>ServiceDate</td>';
				paulTable += '<td>AdaCode</td>';
				paulTable += '<td>LineBilled</td>';
				paulTable += '<td>LinePaid</td>';
				paulTable += '<td>MaxAllowed</td>';
				paulTable += '<td>ApgPaid</td>';
				paulTable += '<td>BlendPaid</td>';
				paulTable += '<td>ApgNumber</td>';
				paulTable += '<td>ApgWeight</td>';
				paulTable += '<td>ApgPercent</td>';
				paulTable += '<td>CARC</td>';
				paulTable += '<td>RARC</td>';
				paulTable += '<td>CappAddOn</td>';
				paulTable += '<td>OverPaid</td>';
				paulTable += '</tr>';

				
				thing.claimList.forEach(function(j)
				{
				var lineCount = 0;
				var claimCount = 1;
				j[8].forEach(function(k)
				{
					var myRow = '';
					myRow += '<tr>';
					myRow += '<td>'+(++lineCount)+'</td>';
					myRow += '<td>'+claimCount+'</td>';
					claimCount = 0;
					myRow += '<td>_</td>';
					myRow += '<td>'+j[0]+'</td>';
					myRow += '<td>'+j[2]+'</td>';
					myRow += '<td>'+j[3]+'</td>';
					myRow += '<td>'+j[4]+'</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>'+j[5]+'</td>';
					myRow += '<td>'+j[6]+'</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>'+j[7]+'</td>';
					myRow += '<td>'+k[0]+'</td>';
					myRow += '<td>'+k[1]+'</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					myRow += '<td>_</td>';
					var insLines = '';
					var hasMed = 'NO';
					j[1].forEach(function(jj)
					{
						insLines += jj+' __ ';
						check = jj.substring(0,4);
						if( check == 'Med:') { hasMed = 'YES'; }
					});
					myRow += '<td>'+insLines+'</td>';
					//myRow += '<td>'+j[1].length+'</td>';
					//myRow += '<td>'+hasMed+'</td>';
					myRow += '</tr>';
					myTable += myRow;
					if( hasMed == 'YES' && j[1].length == 1 )
					{
						art28Table += myRow;
					}
					else if( hasMed == 'YES' && j[1].length == 2 )
					{
						medicareTable += myRow;
					}
					else if( hasMed == 'YES' && j[1].length > 2 )
					{
						paulTable += myRow;
					}
					else
					{
						errorTable += myRow;
					}
				});
				});
				myTable       += '</table>';
				art28Table    += '</table>';
				paulTable     += '</table>';
				errorTable    += '</table>';
				medicareTable += '</table>';
				$('#addElly > div:nth-child(3)').append(myTable);
				$('#addElly > div:nth-child(3)').append('Done All');
				$('#addElly > div:nth-child(4)').append(art28Table);
				$('#addElly > div:nth-child(4)').append('Done Art28');
				$('#addElly > div:nth-child(5)').append(paulTable);
				$('#addElly > div:nth-child(5)').append('Done Paul');
				$('#addElly > div:nth-child(6)').append(errorTable);
				$('#addElly > div:nth-child(6)').append('Done Error');
				$('#addElly > div:nth-child(7)').append(medicareTable);
				$('#addElly > div:nth-child(7)').append('Done medicare');
			});
		});
	});

});
</script>
