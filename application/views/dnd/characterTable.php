<div id='charTable'></div>
<style>
	#CharactersDB button{ color : red; font-weight : bold; }
</style>
<script>
	function loadCharacterTable(){
		var target = 'index.php?/classes/characterSheet/';
		var func = 'loadCharacterTable';
		$.post(target+func,'',function(data){
			$('#charTable').html(data);
			$('#CharactersDB button').click(function(){
				var test = confirm('Delete');
				if(test){
					func = 'deleteCharacter';
					var charName = $(this).parent().parent().children().first().html();
					var parm = {charName: charName};
					$.post(target+func,parm,function(data){
						loadCharacterTable();
					});
				}
			});
		});
	}
	loadCharacterTable();
</script>
