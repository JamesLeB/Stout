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
				<button>Get</button>
			</td>
			<td id='workerView'>View</td>
		</tr>
	</table>
</div>
<style>
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
	$('#workerControls button:nth-child(1)').click(function(){
		var func = 'test';
		var request = $.post(workerTarget+func,'',function(data){
			$('#workerView').html(data);
			//$('#workerView').html('TEST Button disabled');
			//var scene = request.getResponseHeader('scene');
			//if( scene == 1 ){stage();}
		});
		/*
			$('#workerView').html('TEST Button disabled');
		*/
	});
	// Get file button
	$('#workerControls button:nth-child(2)').click(function(){
		var func = 'getTestFile';
		var request = $.post(workerTarget+func,'',function(data){
			$('#workerView').html(data);
		});
	});
/*
	function stage(){
		var func = 'running';
		var request = $.post(target+func,'',function(data){
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
			var status = request.getResponseHeader('status');
			if( status == 1 ){
				$(stageStatus).html(data);
			}else{
				$(stageReturn).append(data);
			}
		});
	}
*/
</script>
