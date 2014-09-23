<div id='stage'>
	<div>
		<button>GO</button>
		<button>Test</button>
	</div>
	<div>
		Status
	</div>
	<div>
		Return
	</div>
</div>
<style>
	#stage div{
		border-style : solid;
		border-color : gray;
		border-width ; 1px;
		padding : 10px;
		margin : 10px;
	}
</style>
<script>
	var target = 'index.php?/slides/stage/';
	var stageStatus = '#stage div:nth-child(2)';
	var stageReturn = '#stage div:nth-child(3)';
	// GO button
	$('#stage div button:nth-child(1)').click(function(){
		/*
			$(stageReturn).html('Go Button disabled');
		*/
		var func = 'setup';
		var request = $.post(target+func,'',function(data){
			$(stageReturn).html(data);
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
		});
	});
	// Test button
	$('#stage > div button:nth-child(2)').click(function(){
		var func = 'test';
		var request = $.post(target+func,'',function(data){
			$(stageReturn).html(data);
		});
	});
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
</script>
