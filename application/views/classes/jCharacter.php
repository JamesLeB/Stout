<div id='characterSheet'>
	<div id='charTable'>
		<div><button>Load</button></div>
		<div><?php echo $charTable; ?></div>
	</div>
	<div id='charSheet'><?php echo $charSheet; ?></div>
</div>
<style>
	#characterSheet{
	}
	#charTable{
		width : 650px;
		padding : 10px;
		float : right;
	}
	#charTable > div:nth-child(1){
		margin-bottom : 10px;
		width : 80%;
		margin-left : auto;
		margin-right : auto;
	}
	#charSheet{
		width : 500px;
		height : 450px;
	}
</style>
<script>
	$('#charTable > div:nth-child(1) > button').click(function(){
		$.post('index.php?/classes/characterSheet/load','',function(data){
			$('#charTable > div:nth-child(2)').html(data);
		});
	});
</script>
