<div id='worker'>
	<table>
		<tr>
			<td id='workerIcon'>Icon</td>
			<td id='workerStatus'>Status</td>
		</tr>
		<tr>
			<td id='workerControls'>
				<button>TEST</button>
				<button>GO</button>
			</td>
			<td id='workerView'>View</td>
		</tr>
	</table>
</div>
<style>
	#worker td{
		border-style : solid;
		border-width ; 1px;
		padding : 10px;
		margin : 10px;
		text-align : center;
	}
	#workerIcon{
		border-color : #6C19A3;
	}
	#workerStatus{
		border-color : #D1D1AC;
	}
	#workerControls{
		vertical-align : top;
		border-color : #006BB2;
		width : 100px;
	}
	#workerControls button{
		width : 90px;
	}
	#workerView{
		border-color : #007A00;
		height : 200px;
		width : 400px;
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
	// GO button
	$('#workerControls button:nth-child(2)').click(function(){
			$('#workerView').html('GO Button disabled');
		/*
		var func = 'test';
		var request = $.post(target+func,'',function(data){
			$(stageReturn).html(data);
		});
		*/
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
