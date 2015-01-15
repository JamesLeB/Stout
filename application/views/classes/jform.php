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
	<div>&nbsp</div>
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
		padding-bottom : 10px;
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
	#newCharacterForm > div:nth-child(5){
		color : red;
		text-align : center;
		font-size : 120%;
		margin-top : 10px;
	}
	#newCharacterForm > div > div:nth-child(1){ width : 220px; }
	#newCharacterForm > div > div:nth-child(2){ width : 80px; }
</style>
<script>
	$('#newCharacterForm button').click(function(){
		var action = $(this).html();

		var charName  = $('#newCharacterForm > div:nth-child(1) > div:nth-child(1) > input').val();
		var charRace  = $('#newCharacterForm > div:nth-child(2) > div:nth-child(1) > select').val();
		var charClass = $('#newCharacterForm > div:nth-child(3) > div:nth-child(1) > select').val();
		if(action=='Clear'){
			$('#newCharacterForm > div:nth-child(1) > div:nth-child(1) > input').val('');
			$('#newCharacterForm > div:nth-child(2) > div:nth-child(1) > select').val('Human');
			$('#newCharacterForm > div:nth-child(3) > div:nth-child(1) > select').val('Fighter');
			$('#newCharacterForm > div:nth-child(5)').html('&nbsp');
		}else if(action=='Submit' && charName != ''){
			var target = 'index.php?/classes/characterSheet/';
			var func   = 'addCharacter';
			var parm = {
				name: charName,
				race: charRace,
				class: charClass
			};
			$.post(target+func,parm,function(data){
				if(data == 1)
				{
					$('#newCharacterForm > div:nth-child(5)').html('&nbsp');
					$('#tabs').tabs({active:4});
				}
				else
				{
					$('#newCharacterForm > div:nth-child(5)').html('Duplicate Name');
				}
			});
			$('#newCharacterForm > div:nth-child(1) > div:nth-child(1) > input').val('');
			$('#newCharacterForm > div:nth-child(2) > div:nth-child(1) > select').val('Human');
			$('#newCharacterForm > div:nth-child(3) > div:nth-child(1) > select').val('Fighter');
			$('#newCharacterForm > div:nth-child(5)').html('&nbsp');
			loadCharacterTable();
		}else{
			$('#newCharacterForm > div:nth-child(5)').html('Invalid Name');
		}
	});
</script>
