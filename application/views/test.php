<div id='testDiv'>
	<button id='testButton'>Test</button>
</div>
<div id='testReturn'>
	Return goes here
</div>
<style>
	#testDiv {
		border-style : ridge;
		border-color : blue;
		border-width : 5px;
		padding : 10px;
		margin : 10px;
		background : gray;
	}
	#testReturn {
		border-style : ridge;
		border-color : blue;
		border-width : 5px;
		padding : 10px;
		margin : 10px;
		background : gray;
	}
</style>
<script>
	$('#testButton').click(function(){
		$('#testDiv').css('background','lightgray');
		var target = 'index.php?/action/test';
		var request=$.post(target,'',function(data){
			$('#testDiv').css('background','gray');
			$('#testReturn').html(data);
		});
	});
</script>
