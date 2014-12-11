<div id='splash'>
		<button>GO</button>
		<textarea></textarea>
</div>
<style>
	#splash{
		background : gray;
		height : 400px;
		width :  800px;
		margin-left  : auto;
		margin-right : auto;
		position : relative;
	}
	#splash textarea{
		resize : none;
		height : 300px;
		width  : 600px;
		position : absolute;
		left : 100px;
		top : 20px;
		padding : 10px;
	}
	#splash button{
		position : absolute;
		left : 20px;
		top : 20px;
	}
</style>
<script>
	$('#splash button').click(function(){
alert('ya');
		$('#splash textarea').html('input here \nnext');
	});
</script>
