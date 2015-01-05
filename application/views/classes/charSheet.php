<?php
	$str = array('Str','18','+4');
	$dex = array('Dex','18','+4');
	$con = array('Con','18','+4');
	$int = array('Int','18','+4');
	$wis = array('Wis','18','+4');
	$cha = array('Cha','18','+4');
	$a = array(
		$str,
		$dex,
		$con,
		$int,
		$wis,
		$cha
	);
	$attributes = "";
	foreach($a as $b){
		$attributes .= "<div>";
		foreach($b as $c){
			$attributes .= "<div>$c</div>";
		}
		$attributes .= "</div>";
	}
?>
<div id='sheet'>
	<div>
		<div>Name</div>
		<div>Race</div>
		<div>Class</div>
	</div>
	<div>
		<div>XP</div>
		<div>HP</div>
		<div>AC</div>
	</div>
	<div>
		<?php echo $attributes ?>
	</div>
	<div>
		Attacks
		<div>
			<div>Weapon</div>
			<div>+6</div>
			<div>1d6 + 4</div>
		</div>
	</div>
	<div>
		Skills
	</div>
	<div>
		Equipment
	</div>
	<div>
		Magic
		<div>Spell Attack</div>
		<div>Spell Save</div>
		<div>Spell Slots</div>
		Spells
	</div>
	<div>
		Damage
	</div>
</div>
<style>
	#sheet
	{
		border : 1px solid gray;
	}
	#sheet div
	{
		border : 1px dotted gray;
		margin : 5px;
	}
	#sheet > div
	{
		border : 1px solid gray;
		margin : 10px;
		border-radius : 20px;
		padding : 10px;
		box-shadow : 2px 2px 2px black;
	}
	#sheet > div:nth-child(1)
	{
		width : 200px;
	}
	#sheet > div:nth-child(2)
	{
		width : 250px;
	}
	#sheet > div:nth-child(3)
	{
		width : 250px;
	}
	#sheet > div:nth-child(3) > div
	{
		height : 35px;
	}
	#sheet > div:nth-child(3) > div > div
	{
		width : 50px;
		float : left;
	}
	#sheet > div:nth-child(4)
	{
		width : 450px;
	}
	#sheet > div:nth-child(4) > div
	{
		height : 35px;
	}
	#sheet > div:nth-child(4) > div > div
	{
		float : left;
	}
	#sheet > div:nth-child(4) > div > div:nth-child(1)
	{
		width : 150px;
	}
	#sheet > div:nth-child(4) > div > div:nth-child(2)
	{
		width : 50px;
	}
	#sheet > div:nth-child(4) > div > div:nth-child(3)
	{
		width : 120px;
	}
</style>
