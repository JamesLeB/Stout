<div id='characterSheet'>
	<div id='charTable'>
		<div>
			<button>Load</button>
			<button>Create</button>
			<button>Check</button>
		</div>
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
		var target = 'index.php?/classes/characterSheet/';
		var func = '';
		var a = $(this).first().html();
		     if(a=='Load')  {func = 'load';}
		else if(a=='Create'){func = 'create';}
		else                {func = 'test';}
		//$.post('index.php?/classes/characterSheet/load','',function(data){
		$.post(target+func,'',function(data){
			$('#charTable > div:nth-child(2)').html(data);
		});
	});
</script>
