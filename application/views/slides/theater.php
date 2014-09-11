<div id='theater'>
	<div>
		<button>GO</button>
	</div>
	<div>
		Return
	</div>
</div>
<style>
</style>
<script>
	// GO button
	var theaterReturn = '#theater div:nth-child(2)';
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
			$(theaterReturn).append(data);
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
		});
	}
</script>
