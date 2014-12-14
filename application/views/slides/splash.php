<div id='splash'>
		<button>GO</button>
		<button>HA</button>
		<textarea></textarea>
</div>
<style>
	#splash{
		background : gray;
		height : 500px;
		width :  900px;
		margin-left  : auto;
		margin-right : auto;
		position : relative;
	}
	#splash textarea{
		resize : none;
		height : 400px;
		width  : 700px;
		position : absolute;
		left : 100px;
		top  : 20px;
		padding : 10px;
	}
	#splash button:nth-child(1){
		position : absolute;
		left : 20px;
		top  : 20px;
	}
	#splash button:nth-child(2){
		position : absolute;
		left : 20px;
		top : 80px;
	}
</style>
<script>
	$('#splash button:nth-child(1)').click(function(){
		$.get('sandbox/coins/loadbter.php','',function(data){
			$('#splash textarea').val(data);
		});
	});
	$('#splash button:nth-child(2)').click(function(){
		$('#splash textarea').val('');
	});
	$('#splash button:nth-child(1)').trigger('click');
</script>
