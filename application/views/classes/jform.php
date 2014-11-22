<?php

	$jName = 'characterForm';
	
	$html = '';

	$html .= "
		<div id='$jName'><form>
			<div>
				<div>Name</div>
				<div><input type='textbox' name='charName'/></div>
			</div>
			<div>
				<div>Race</div>
				<div>
					<select name='charRace'>
						<option value='Human'>Human</option>
						<option value='Elf'>Elf</option>
						<option value='Dwarf'>Dwarf</option>
						<option value='Halfling'>Halfling</option>
					</select>
				</div>
			</div>
			<div>
				<div>Class</div>
				<div>
					<select name='charClass'>
						<option value='Fighter'>Fighter</option>
						<option value='Thief'>Thief</option>
						<option value='Cleric'>Cleric</option>
						<option value='Wizard'>Wizard</option>
					</select>
				</div>
			</div>
			<div>
				<input type='submit'/>
			</div>
			<div id='debug'>
			</div>
		</form></div>
	";
	$html .= "";
	
	$style = "
		<style>
			#$jName{
				width : 400px;
				height : 380px;
				border : solid 1px black;
				border-radius : 20px;
				box-shadow : 3px 3px 3px black;
				position : relative;
				top : 30px;
				left : 30px;
				padding-top : 30px;
			}
			#$jName form > div{
				width : 95%;
				margin-left : auto;
				margin-right : auto;
				height : 45px;
				margin-bottom : 5px;
			}
			#$jName form > div > div{
				margin : 5px;
				display : inline-block;
				position : relative;
				top : 5px;
			}
			#$jName form > div > div:nth-child(1){ width : 80px; }
			#$jName form > div > div:nth-child(2){ width : 200px; }
		</style>
	";
	$script = "
		<script>
			$('#$jName form').submit(function(){
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
	";

	echo $html;
	echo $style;
	echo $script;
?>
