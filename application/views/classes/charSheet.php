<div id='characterSheet'>
	<div id='charStats'>
		<div>Name</div>
		<div>Race</div>
		<div>Class</div>
		<div>XP</div>
	</div>
	<div id='charAbilities'>
		<div>Strength</div>
		<div>Dexterity</div>
		<div>Constitution</div>
		<div>Intelligence</div>
		<div>Wisdom</div>
		<div>Charisma</div>
	</div>
	<div id='charHealth'>
		<div>AC</div>
		<div>HP</div>
		<div>Hit Dice</div>
		<div>Damage</div>
	</div>
	<div id='charSkills'>
		Skills
	</div>
	<div id='charCombat'>
		<div>Speed</div>
		<div>Melee</div>
		<div>Melee</div>
		<div>Ranged</div>
	</div>
	<div id='charEquipment'>
		Equipment
	</div>
	<div id='charMagic'>
		<div>Spell Attack</div>
		<div>Spell Save</div>
		<div>Spell Slots</div>
		<div>Prepared Spells</div>
	</div>
</div>
<style>
	#characterSheet
	{
		border : 15px ridge yellow;
		pading : 15px;
		height : 600px;
		width  : 1000px;
	}
	#characterSheet div
	{
		border : 1px dotted gray;
		margin : 5px;
	}
	#characterSheet > div
	{
		position : absolute;
		border : 1px solid gray;
		margin : 10px;
		border-radius : 20px;
		padding : 10px;
		box-shadow : 2px 2px 2px black;
	}
	#charStats
	{
		width : 200px;
		top   : 100px;
		left  : 700px;
	}
	#charAbilities
	{
		width : 300px;
		top   : 100px;
		left  : 100px;
	}
	#charHealth
	{
		width : 200px;
		top   : 100px;
		left  : 450px;
	}
	#charSkills
	{
		width : 450px;
		top  : 550px;
		left : 200px;
	}
	#charCombat
	{
		width : 350px;
		top   : 270px;
		left  : 450px;
	}
	#charSkills
	{
		width : 300px;
		top   : 320px;
		left  : 100px;
	}
	#charEquipment
	{
		width : 300px;
		top   : 450px;
		left  : 100px;
	}
	#charMagic
	{
		width : 450px;
		top   : 450px;
		left  : 450px;
	}
</style>
