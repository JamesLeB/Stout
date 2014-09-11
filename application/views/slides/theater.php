<div id='theater'>
	<div>
		<button>GO</button>
	</div>
	<div>
		Status
	</div>
	<div>
		Return
	</div>
</div>
<style>
	#theater div{
		border-style : solid;
		border-color : gray;
		border-width ; 1px;
		padding : 10px;
		margin : 10px;
	}
</style>
<script>
	// GO button
	var theaterStatus = '#theater div:nth-child(2)';
	var theaterReturn = '#theater div:nth-child(3)';
	$('#theater div button').click(function(){
		var target = 'index.php?/stage/setup';
		var request = $.post(target,'',function(data){
			$(theaterReturn).html(data);
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
		});
	});
	function stage(){
		var target = 'index.php?/stage/running';
		var request = $.post(target,'',function(data){
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
			var status = request.getResponseHeader('status');
			if( status == 1 ){
				$(theaterStatus).html(data);
			}else{
				$(theaterReturn).append(data);
			}
		});
	}
</script>
