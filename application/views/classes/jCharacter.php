<div id='newCharacterSheet'>
	<div id='charTable'></div>
	<div id='charSheet'><?php echo $charSheet; ?></div>
</div>
<style>
	#newCharacterSheet{
		border : 1px solid gray;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		padding : 10px;
		height : 500px;
	}
	#charTable{
		border : 1px dotted gray;
		margin-left : 0px;
		margin-top  : 0px;
		width : 620px;
		float : right;
	}
	#charSheet{
		border : 1px dotted gray;
		width : 500px;
		height : 450px;
	}
</style>
<script>
	//$('#charSheet').hide();
	function loadCharacterTable(){
		var target = 'index.php?/classes/characterSheet/';
		var func = 'loadCharacterTable';
		$.post(target+func,'',function(data){
			$('#charTable').html(data);
		});
	}
	loadCharacterTable();
</script>
