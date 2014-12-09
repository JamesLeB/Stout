<div id='newCharacterSheet'>
	<div id='charTable'>
		<div>
			<button>Go</button>
			<button>Load</button>
			<button>Test</button>
		</div>
		<div><?php echo $charTable; ?></div>
	</div>
	<div id='charSheet'><?php echo $charSheet; ?></div>
</div>
<style>
	#newCharacterSheet{
		border : 1px solid gray;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		padding : 10px;
		height : 300px;
	}
	#charTable{
		border : 1px solid blue;
		margin-left : 30px;
		margin-top : 30px;
		width : 650px;
		padding : 10px;
	}
	#charTable > div:nth-child(1) > button{
		margin-bottom : 10px;
		margin-left : 20px;
	}
	#charTable > div:nth-child(2){
		border : 1px dashed gray;
	}
	#charSheet{
		width : 500px;
		height : 450px;
	}
</style>
<script>
	$('#charSheet').hide();

	$('#charTable > div:nth-child(1) > button').click(function(){
		var target = 'index.php?/classes/characterSheet/';
		var func = '';
		var a = $(this).first().html();
		     if(a=='Go')    {func = 'index';}
		else if(a=='Load')  {func = 'loadCharacterTable';}
		else if(a=='Test')  {func = 'test';}
		$.post(target+func,'',function(data){
			$('#charTable > div:nth-child(2)').html(data);
			//$('#error').html(func);
		});
	});
</script>
