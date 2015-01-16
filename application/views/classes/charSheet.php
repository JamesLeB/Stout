<?php
	$list = array(
		'Strength',
		'Dexterity',
		'Constitution',
		'Intelligence',
		'Wisdom',
		'Charisma'
	);
	$abilities = '';
	foreach($list as $l)
	{
		$abilities .= "
			<div>
				<div>$l</div>
				<div>18</div>
				<div>+4</div>
				<div>+2</div>
			</div>
		";
	}
?>
<div id='characterSheet'>
	<div id='charStats'>
		<div>Name</div>
		<div>Race</div>
		<div>Class</div>
		<div>XP</div>
	</div>
	<div id='charAbilities'>
		<?php echo $abilities; ?>
<!--
		<div>Strength</div>
		<div>Dexterity</div>
		<div>Constitution</div>
		<div>Intelligence</div>
		<div>Wisdom</div>
		<div>Charisma</div>
--!>
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
		position : relative;
	}
	#characterSheet > div
	{
		position : absolute;
		border : 1px solid gray;
		border-radius : 20px;
		padding : 10px;
		box-shadow : 2px 2px 2px black;
	}
	#charStats     { width : 800px; top : 015px; left : 020px; }
	#charAbilities { width : 300px; top : 075px; left : 020px; }
	#charHealth    { width : 130px; top : 075px; left : 690px; }
	#charSkills    { width : 280px; top : 075px; left : 360px; }
	#charCombat    { width : 350px; top : 220px; left : 450px; }
	#charEquipment { width : 300px; top : 350px; left : 020px; }
	#charMagic     { width : 450px; top : 350px; left : 450px; }

	#charStats > div { float : left; }
	#charStats > div:nth-child(1) { width : 200px; margin-left : 20px;}
	#charStats > div:nth-child(2) { width : 200px; }
	#charStats > div:nth-child(3) { width : 200px; }
	#charStats > div:nth-child(4) { width : 100px; }

	#charAbilities > div { height : 35px; margin-left : 10px; }
	#charAbilities > div:nth-child(1) { margin-top : 10px; }
	#charAbilities > div > div { float : left; width : 50px; text-align : center; }
	#charAbilities > div > div:nth-child(1) { width : 120px; text-align : left;}

</style>
