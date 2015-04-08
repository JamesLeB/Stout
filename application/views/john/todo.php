<div id='todo'>
	<div id='newClaimFolder'></div>
	<div id='eligibilityFiles'><div></div><div></div><div></div></div>
	<div id='addElly'>
		<div></div>
		<div></div>
		<div>All</div>
		<div>Art28</div>
		<div>Medicare</div>
		<div>Paul</div>
		<div>Error</div>
		<div>Debug</div>
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
		height: 200px;
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
	#addElly table
	{
		background: white;
	}
	#addElly table td
	{
		border: 1px dotted gray;
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
	#addElly > div:nth-child(5)
	{
		background: white;
		height: 300px;
		width: 1100px;
		overflow: auto;
		border: 5px ridge yellow;
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
	#addElly > div:nth-child(8)
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
	$('#newClaimFolder').hide();
	$('#eligibilityFiles').hide();
	$('#addElly > div:nth-child(3)').hide();
	$('#addElly > div:nth-child(4)').hide();
	$('#addElly > div:nth-child(5)').hide();
	$('#addElly > div:nth-child(6)').hide();
	$('#addElly > div:nth-child(7)').hide();

	$.post('index.php?/john/getNewList','',function(d)
	{
		var list = $.parseJSON(d);
		$('#newClaimFolder').html('Click to create 270 file<br/><br/>');
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
				$('#newClaimFolder').append(d);
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
				var myTable       = '<table>';
				var art28Table    = '<table>';
				var paulTable     = '<table>';
				var errorTable    = '<table>';
				var medicareTable = '<table>';

				headingRow = '';
				headingRow += '<tr>';
				headingRow += '<td>Line</td>';
				headingRow += '<td>Count</td>';
				headingRow += '<td>TCN</td>';
				headingRow += '<td>Echo</td>';
				headingRow += '<td>LastName</td>';
				headingRow += '<td>FirstName</td>';
				headingRow += '<td>Medicaid</td>';
				headingRow += '<td>Status</td>';
				headingRow += '<td>CARC</td>';
				headingRow += '<td>RARC</td>';
				headingRow += '<td>RateCode</td>';
				headingRow += '<td>ClaimBilled</td>';
				headingRow += '<td>ClaimPaid</td>';
				headingRow += '<td>Clinic</td>';
				headingRow += '<td>ServiceDate</td>';
				headingRow += '<td>AdaCode</td>';
				headingRow += '<td>LineBilled</td>';
				headingRow += '<td>LinePaid</td>';
				headingRow += '<td>MaxAllowed</td>';
				headingRow += '<td>ApgPaid</td>';
				headingRow += '<td>BlendPaid</td>';
				headingRow += '<td>ApgNumber</td>';
				headingRow += '<td>ApgWeight</td>';
				headingRow += '<td>ApgPercent</td>';
				headingRow += '<td>CARC</td>';
				headingRow += '<td>RARC</td>';
				headingRow += '<td>CappAddOn</td>';
				headingRow += '<td>OverPaid</td>';
				headingRow += '</tr>';

/*
				myTable       += headingRow;
				art28Table    += headingRow;
				paulTable     += headingRow;
				errorTable    += headingRow;
				medicareTable += headingRow;
*/
				
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

				$('#addElly > div:nth-child(5)').append(medicareTable);
				$('#addElly > div:nth-child(5)').append('Done Medicare');

				$('#addElly > div:nth-child(6)').append(paulTable);
				$('#addElly > div:nth-child(6)').append('Done Paul');

				$('#addElly > div:nth-child(7)').append(errorTable);
				$('#addElly > div:nth-child(7)').append('Done Error');

				$('#addElly > div:nth-child(8)').html(thing.debug);

			});
		});
	});

});
</script>
