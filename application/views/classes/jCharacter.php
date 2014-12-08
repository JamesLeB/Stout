<div id='newCharacterSheet'>
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
	#newCharacterSheet{
		border : 1px black solid;
		padding : 10px;
		height : 300px;
	}
	#charTable{
		border : 1px solid blue;
		width : 650px;
		padding : 10px;
	}
	#charTable div{
		border : 1px dashed gray;
	}
	#charTable > div:nth-child(1){
	}
	#charSheet{
		width : 500px;
		height : 450px;
	}
</style>
<script>
	$('#charSheet').hide();

	// Code to trigger a button durning testingg
/*
	$.post('index.php?/classes/characterSheet/check','',function(data){
			$('#charTable > div:nth-child(2)').html(data);
	});
*/

	$('#charTable > div:nth-child(1) > button').click(function(){
		var target = 'index.php?/classes/characterSheet/';
		var func = '';
		var a = $(this).first().html();
		     if(a=='Load')  {func = 'load';}
		else if(a=='Create'){func = 'create';}
		else if(a=='Check') {func = 'check';}
		else                {func = 'test';}
		$.post(target+func,'',function(data){
			$('#charTable > div:nth-child(2)').html(func);
		});
	});
</script>
