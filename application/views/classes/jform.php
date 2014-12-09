<div id='newCharacterForm'>
	<div>
		<div><input type='textbox' maxlength='16'/></div>
		<div>Name</div>
	</div>
	<div>
		<div>
			<select>
				<option value='Human'>Human</option>
				<option value='Elf'>Elf</option>
				<option value='Dwarf'>Dwarf</option>
				<option value='Halfling'>Halfling</option>
			</select>
		</div>
		<div>Race</div>
	</div>
	<div>
		<div>
			<select>
				<option value='Fighter'>Fighter</option>
				<option value='Thief'>Thief</option>
				<option value='Cleric'>Cleric</option>
				<option value='Wizard'>Wizard</option>
			</select>
		</div>
		<div>Class</div>
	</div>
	<div>
		<button>Submit</button>
		<button>Clear</button>
	</div>
	<div></div>
</div>
<style>
	#newCharacterForm{
		font-family : 'rocksalt';
		width : 380px;
		margin-left : auto;
		margin-right : auto;
		border : solid 1px black;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		padding-top : 30px;
		padding-bottom : 20px;
		background-image : url('lib/images/wood1.jpg');
	}
	#newCharacterForm div{
	}
	#newCharacterForm > div > div:nth-child(1){
		float : right;
		margin-right : 30px;
	}
	#newCharacterForm > div > div:nth-child(2){
		margin-left : 40px;
		height : 50px;
	}
	#newCharacterForm > div:nth-child(4) > button{
		background : blue;
		color : white;
		width : 100px;
		margin-top : 20px;
		margin-left : 20px;
	}
	#newCharacterForm > div:nth-child(4) > button:nth-child(1){
		margin-left : 80px;
	}
	#newCharacterForm > div > div:nth-child(1){ width : 220px; }
	#newCharacterForm > div > div:nth-child(2){ width : 80px; }
</style>
<script>
	$('#newCharacterForm form').submit(function(){
		var charName  = this.charName.value;
		var charRace  = this.charRace.value;
		var charClass = this.charClass.value;
		parm = $(this).serialize();
		//alert('name '+charName+'\\nrace '+charRace+'\\nclass '+charClass);
		this.charName.value = '';
		this.charRace.value = 'Human';
		this.charClass.value = 'Fighter';

		$.post('index.php?/classes/characterSheet',parm,function(data){
			$('#debug').html(data);
		});
		return false;
	});
</script>
