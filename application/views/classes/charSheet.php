<div id='characterSheet'>
	<div id='charStats'>
		<div>Name</div>
		<div>James</div>
		<div>Race</div>
		<div>Elf</div>
		<div>Class</div>
		<div>Thief</div>
		<div>XP</div>
		<div>1000</div>
	</div>
	<div id='charAbilities'>
		<div>
			<div>Strength</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
		<div>
			<div>Dexterity</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
		<div>
			<div>Constitution</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
		<div>
			<div>Intelligence</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
		<div>
			<div>Wisdom</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
		<div>
			<div>Charisma</div>
			<div>18</div>
			<div>+4</div>
			<div>+2</div>
		</div>
	</div>
	<div id='charHealth'>
		<div>
			<div>AC</div>
			<div>15</div>
		</div>
		<div>
			<div>HP</div>
			<div>10</div>
		</div>
		<div>
			<div>Hit Dice</div>
			<div>1</div>
		</div>
		<div>
			<div>Damage</div>
			<div>0</div>
		</div>
		<div>
			<div>Speed</div>
			<div>30</div>
		</div>
	</div>
	<div id='charSkills'>
		<div>
			Skills
		</div>
		<div>
			<div>
				<div>Dark Vision</div>
				<div>30 Ft</div>
			</div>
			<div>
				<div>Stealth</div>
				<div>+6</div>
			</div>
		</div>
	</div>
	<div id='charCombat'>
		<div>
			<div>
				<div>Melee</div>
				<div>Sword</div>
				<div>+6</div>
				<div>1d6 + 4</div>
			</div>
			<div>
				<div>Melee</div>
				<div>Dagger</div>
				<div>+6</div>
				<div>1d4</div>
			</div>
			<div>
				<div>Ranged</div>
				<div>Sword</div>
				<div>+6</div>
				<div>1d6 + 4</div>
			</div>
		</div>
	</div>
	<div id='charEquipment'>
		<div>
			Equipment
		</div>
		<div>
			<div>Item1</div>
			<div>Item2</div>
			<div>Item3</div>
		</div>
	</div>
	<div id='charMagic'>
		<div>
			<div>Spell Attack</div>
			<div>+6</div>
			<div>Spell Save</div>
			<div>12</div>
		</div>
		<div>
			<div>Spell Slots</div>
			<div>2</div>
			<div>1</div>
		</div>
		<div>
			<div>
				<div>Spell 1</div>
				<div>lv 1</div>
			</div>
			<div>
				<div>Spell 2</div>
				<div>lv 1</div>
			</div>
		</div>
	</div>
</div>
<style>
	#characterSheet
	{
		border : 15px ridge yellow;
		pading : 15px;
		height : 800px;
		width  : 1000px;
		position : relative;
		background : green;
	}
	#characterSheet > div
	{
		background : lightgreen;
		position : absolute;
		border : 1px solid black;
		border-radius : 20px;
		padding : 10px;
		box-shadow : 2px 2px 2px black;
	}
	#charStats     { width : 850px; top : 015px; left : 020px; }
	#charAbilities { width : 300px; top : 075px; left : 020px; }
	#charHealth    { width : 130px; top : 075px; left : 730px; }
	#charSkills    { width : 310px; top : 075px; left : 370px; }
	#charCombat    { width : 360px; top : 340px; left : 370px; }
	#charEquipment { width : 300px; top : 340px; left : 020px; }
	#charMagic     { width : 350px; top : 480px; left : 370px; }

	#charStats > div { float : left; }
	#charStats > div:nth-child(1) { width : 070px; margin-left : 30px;}
	#charStats > div:nth-child(2) { width : 160px; }
	#charStats > div:nth-child(3) { width : 070px; }
	#charStats > div:nth-child(4) { width : 150px; }
	#charStats > div:nth-child(5) { width : 070px; }
	#charStats > div:nth-child(6) { width : 150px; }
	#charStats > div:nth-child(7) { width : 050px; }
	#charStats > div:nth-child(8) { width : 070px; }

	#charAbilities > div { height : 35px; margin-left : 10px; }
	#charAbilities > div:nth-child(1) { margin-top : 10px; }
	#charAbilities > div > div { float : left; width : 50px; text-align : center; }
	#charAbilities > div > div:nth-child(1) { width : 120px; text-align : left;}

	#charHealth > div { margin-left : 5px; height : 25px;; }
	#charHealth > div > div { float : left; }
	#charHealth > div > div:nth-child(1) { width : 80px; }
	#charHealth > div > div:nth-child(2) { width : 40px; text-align : center; }
	
	#charSkills > div:nth-child(2)
	{
		border : inset 2px gray;
		padding : 10px;
		margin : 10px;
		height : 150px;
		overflow : auto;
	}
	#charSkills > div > div { float : left; }
	#charSkills > div > div:nth-child(1) { width : 150px; }
	#charSkills > div > div:nth-child(2) { width : 80px; }

	#charCombat > div > div { height :  30px; margin-left : 10px; }
	#charCombat > div > div > div { float :  left; }
	#charCombat > div > div > div:nth-child(1) { width :  90px; }
	#charCombat > div > div > div:nth-child(2) { width : 120px; }
	#charCombat > div > div > div:nth-child(3) { width :  45px; }
	#charCombat > div > div > div:nth-child(4) { width :  90px; }

	#charEquipment > div:nth-child(2)
	{
		border : inset 2px gray;
		padding : 10px;
		margin : 10px;
		height : 140px;
		overflow : auto;
	}
	#charEquipment > div:nth-child(2) > div { width : 220px; }

	#charMagic > div:nth-child(1) { height : 30px; margin-left : 10px; }
	#charMagic > div:nth-child(1) > div { float : left; }
	#charMagic > div:nth-child(1) > div:nth-child(1) { width : 120px; }
	#charMagic > div:nth-child(1) > div:nth-child(2) { width :  50px; }
	#charMagic > div:nth-child(1) > div:nth-child(3) { width : 110px; }
	#charMagic > div:nth-child(1) > div:nth-child(4) { width :  40px; }

	#charMagic > div:nth-child(2) { height : 30px; margin-left : 10px; }
	#charMagic > div:nth-child(2) > div { float : left; width : 30px;}
	#charMagic > div:nth-child(2) > div:nth-child(1) { width : 110px;}

	#charMagic > div:nth-child(3)
	{
		border : inset 2px gray;
		padding : 10px;
		margin : 10px;
		height : 140px;
		overflow : auto;
	}
	#charMagic > div:nth-child(3) > div { height : 30px; width : 270px;}
	#charMagic > div:nth-child(3) > div > div { float : left; }
	#charMagic > div:nth-child(3) > div > div:nth-child(1) { width : 170px; }
	#charMagic > div:nth-child(3) > div > div:nth-child(2) { width :  60px; }

</style>
