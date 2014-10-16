<div id='worker'>
	<table>
		<tr>
			<td id='workerIcon'>
				<img src='lib/images/rat.jpg' />
			</td>
			<td id='workerStatus'>Status</td>
		</tr>
		<tr>
			<td id='workerControls'>
				<button>TEST</button>
				<button>Get File</button>
				<button>Claim</button>
				<button>Convert</button>
			</td>
			<td id='workerView'>View</td>
		</tr>
	</table>
</div>
<style>
	#worker table{
		width : 100%;
	}
	#worker td{
		border-style : solid;
		border-width ; 1px;
		padding : 5px;
	}
	#workerIcon{
		border-color : #6C19A3;
		background : white;
		text-align : center;
	}
	#workerIcon img{
		height : 50px;
	}
	#workerStatus{
		border-color : #D1D1AC;
	}
	#workerControls{
		vertical-align : top;
		border-color : #006BB2;
		width : 100px;
		text-align : center;
	}
	#workerControls button{
		width : 90px;
		margin-top : 5px;
	}
	#workerView{
		vertical-align : top;
		border-color : #007A00;
		height : 400px;
		width : 800px;
		text-align : left;
		font-size : 1.5em;
		color : #66AF66;
	}
</style>
<script>
	var workerTarget = 'index.php?/slides/worker/';
	// Test button
	$('#workerControls button').click(function(){
		var target = 'index.php?/slides/worker/';
		var func = '';
		var parm = { secret: 'all' };
		var a = $(this).first().html();
		     if(a=='Get File') {func='getTestFile';}
		else if(a=='Claim')    {func='getTestFile'; parm = { secret: 'claims' }; }
		else if(a=='Convert')  {func='convertEdi';}
		else                   {func='test';}
		var request = $.post(target+func,parm,function(data){
			$('#workerView').html(data);
		});
	});
</script>
