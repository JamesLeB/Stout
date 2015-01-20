<div id='characterSheet'>
	<div id='charControl'>
		<button>Load</button>
	</div>
	<div id='charStats'>
		<div>Name</div>
		<div>James</div>
		<div>Race</div>
		<div>Elf</div>
		<div>Class</div>
		<div>Thief</div>
		<div>XP</div>
		<div>1000</div>
		<div>Lv</div>
		<div>20</div>
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
			<div>Speed</div>
			<div>30</div>
		</div>
		<div>
			<div>HP</div>
			<div>10</div>
			<div>Damage</div>
			<div>0</div>
		</div>
		<div>
			<div>&nbsp</div>
			<div>&nbsp</div>
			<div>Hit Dice</div>
			<div>1</div>
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
			<div>Bow</div>
			<div>+6</div>
			<div>1d6 + 4</div>
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
			<div>1</div>
			<div>2</div>
			<div>3</div>
			<div>4</div>
			<div>5</div>
			<div>6</div>
			<div>7</div>
			<div>8</div>
			<div>9</div>
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
		height : 750px;
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


	#charControl   { width : 120px; height : 80px; top :  335px; left : 750px; }
	#charControl > button:nth-child(1)  { margin-left : 20px; margin-top : 10px; }

	#charStats     { width : 900px; top : 015px; left : 020px; }
	#charStats > div { float : left; }
	#charStats > div:nth-child(1) { width : 070px; margin-left : 30px;}
	#charStats > div:nth-child(2) { width : 160px; }
	#charStats > div:nth-child(3) { width : 070px; }
	#charStats > div:nth-child(4) { width : 150px; }
	#charStats > div:nth-child(5) { width : 070px; }
	#charStats > div:nth-child(6) { width : 150px; }
	#charStats > div:nth-child(7) { width : 050px; }
	#charStats > div:nth-child(8) { width : 075px; }
	#charStats > div:nth-child(9) { width : 030px; }

	#charAbilities { width : 280px; top : 075px; left : 020px; }
	#charAbilities > div { height : 35px; margin-left : 10px; }
	#charAbilities > div:nth-child(1) { margin-top : 10px; }
	#charAbilities > div > div { float : left; width : 47px; text-align : center; }
	#charAbilities > div > div:nth-child(1) { width : 120px; text-align : left;}

	#charHealth    { width : 240px; top : 335px; left : 420px; }
	#charHealth > div { margin-left : 5px; height : 27px; }
	#charHealth > div > div { float : left; }
	#charHealth > div > div:nth-child(1) { width : 30px; margin-left : 10px; }
	#charHealth > div > div:nth-child(2) { width : 35px; text-align : right; }
	#charHealth > div > div:nth-child(3) { width : 85px; margin-left : 25px; }
	#charHealth > div > div:nth-child(4) { width : 25px; text-align : right; }
	
	#charSkills    { width : 270px; top : 075px; left : 340px; }
	#charSkills > div:nth-child(2)
	{
		border : inset 2px gray;
		padding : 10px;
		margin : 10px;
		height : 150px;
		overflow : auto;
	}
	#charSkills > div:nth-child(2) > div { height : 28px; }
	#charSkills > div:nth-child(2) > div > div { float : left; }
	#charSkills > div:nth-child(2) > div > div:nth-child(1) { width : 150px; }
	#charSkills > div:nth-child(2) > div > div:nth-child(2) { width : 60px; }

	#charCombat    { width : 360px; top : 335px; left : 020px; }
	#charCombat > div { height :  30px; margin-left : 10px; }
	#charCombat > div > div { float :  left; }
	#charCombat > div > div:nth-child(1) { width :  90px; }
	#charCombat > div > div:nth-child(2) { width : 120px; }
	#charCombat > div > div:nth-child(3) { width :  45px; }
	#charCombat > div > div:nth-child(4) { width :  90px; }

	#charEquipment { width : 270px; top : 75px; left : 650px; }
	#charEquipment > div:nth-child(2)
	{
		border : inset 2px gray;
		padding : 10px;
		margin : 10px;
		height : 140px;
		overflow : auto;
	}
	#charEquipment > div:nth-child(2) > div { width : 220px; }

	#charMagic     { width : 360px; top : 466px; left : 020px; }
	#charMagic > div:nth-child(1) { height : 30px; margin-left : 10px; }
	#charMagic > div:nth-child(1) > div { float : left; }
	#charMagic > div:nth-child(1) > div:nth-child(1) { width : 120px; }
	#charMagic > div:nth-child(1) > div:nth-child(2) { width :  50px; }
	#charMagic > div:nth-child(1) > div:nth-child(3) { width : 110px; }
	#charMagic > div:nth-child(1) > div:nth-child(4) { width :  40px; }

	#charMagic > div:nth-child(2) { height : 30px; margin-left : 10px; }
	#charMagic > div:nth-child(2) > div { float : left; width : 22px;}
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
<script>

	$('#charControl > button:nth-child(1)').click(function (){

// Load stats
		var stats = {
			name:  'Stout',
			race:  'Human',
			clas:  'Fighter',
			xp:    0,
			level: 1
		}

// Load abilities
		var str = { score: 1, mod: '+1', save: '+6' };
		var dex = { score: 2, mod: '+2', save: '+5' };
		var con = { score: 3, mod: '+3', save: '+4' };
		var int = { score: 4, mod: '+4', save: '+3' };
		var wis = { score: 5, mod: '+5', save: '+2' };
		var cha = { score: 6, mod: '+6', save: '+1' };
		var abilities = {
			str: str,
			dex: dex,
			con: con,
			int: int,
			wis: wis,
			cha: cha,
		}

// Load health
		var health = {
			ac: 10,
			hp: 20,
			speed: 35,
			damage: 2,
			hitDice: 0
		}

// Load skills
		var skill_1 = ['Perception','+2'];
		var skill_2 = ['Athletics','+4'];
		var skills = [skill_1,skill_2];

// Load Combat
		var combat = {
			melee1: ['Dagger','+2','1d6+3'],
			melee2: ['club','+3','1d4+4'],
			ranged: ['shortBow','+8','1d10+6']
		};

// Load Combat
		var equipment = ['pack','water','club'];

// Load Magic
		var spells = [
			['Fireball','Lv 1'],
			['Witchbolt','Lv 1']
		];
		var spellSlots = [9,8,7,6,5,4,3,2,''];
		var magic = {
			spellattack: '+3',
			spellsave: '15',
			spellSlots: spellSlots,
			spells: spells
		};

// Build Charaacter
		var char = {
			stats : stats,
			abilities : abilities,
			health : health,
			skills : skills,
			combat : combat,
			equipment : equipment,
			magic: magic
		};

// Load Character into dom
		$('#charMagic > div:nth-child(1) > div:nth-child(2)').html(char.magic.spellattack);
		$('#charMagic > div:nth-child(1) > div:nth-child(4)').html(char.magic.spellsave);
		$('#charMagic > div:nth-child(2) > div:nth-child(2)').html(char.magic.spellSlots[0]);
		$('#charMagic > div:nth-child(2) > div:nth-child(3)').html(char.magic.spellSlots[1]);
		$('#charMagic > div:nth-child(2) > div:nth-child(4)').html(char.magic.spellSlots[2]);
		$('#charMagic > div:nth-child(2) > div:nth-child(5)').html(char.magic.spellSlots[3]);
		$('#charMagic > div:nth-child(2) > div:nth-child(6)').html(char.magic.spellSlots[4]);
		$('#charMagic > div:nth-child(2) > div:nth-child(7)').html(char.magic.spellSlots[5]);
		$('#charMagic > div:nth-child(2) > div:nth-child(8)').html(char.magic.spellSlots[6]);
		$('#charMagic > div:nth-child(2) > div:nth-child(9)').html(char.magic.spellSlots[7]);
		$('#charMagic > div:nth-child(2) > div:nth-child(10)').html(char.magic.spellSlots[8]);
		$('#charMagic > div:nth-child(2) > div:nth-child(11)').html(char.magic.spellSlots[9]);
		$('#charMagic > div:nth-child(3)').html('');
		char.magic.spells.forEach(function(d){
			$('#charMagic > div:nth-child(3)').append('<div><div>'+d[0]+'</div><div>'+d[1]+'</div></div>');
		});

		$('#charEquipment > div:nth-child(2)').html('');
		char.equipment.forEach(function(d){
			$('#charEquipment > div:nth-child(2)').append('<div>'+d+'</div>');
		});
		
		$('#charCombat > div:nth-child(1) > div:nth-child(2)').html(char.combat.melee1[0]);
		$('#charCombat > div:nth-child(1) > div:nth-child(3)').html(char.combat.melee1[1]);
		$('#charCombat > div:nth-child(1) > div:nth-child(4)').html(char.combat.melee1[2]);
		$('#charCombat > div:nth-child(2) > div:nth-child(2)').html(char.combat.melee2[0]);
		$('#charCombat > div:nth-child(2) > div:nth-child(3)').html(char.combat.melee2[1]);
		$('#charCombat > div:nth-child(2) > div:nth-child(4)').html(char.combat.melee2[2]);
		$('#charCombat > div:nth-child(3) > div:nth-child(2)').html(char.combat.ranged[0]);
		$('#charCombat > div:nth-child(3) > div:nth-child(3)').html(char.combat.ranged[1]);
		$('#charCombat > div:nth-child(3) > div:nth-child(4)').html(char.combat.ranged[2]);

		$('#charSkills > div:nth-child(2)').html('');
		char.skills.forEach(function(d){
			var skill = '<div><div>' + d[0] + '</div><div>' + d[1] + '</div></div>';
			$('#charSkills > div:nth-child(2)').append(skill);
		});

		$('#charStats > div:nth-child(2)').html(char.stats.name);
		$('#charStats > div:nth-child(4)').html(char.stats.race);
		$('#charStats > div:nth-child(6)').html(char.stats.clas);
		$('#charStats > div:nth-child(8)').html(char.stats.xp);
		$('#charStats > div:nth-child(10)').html(char.stats.level);

		$('#charAbilities > div:nth-child(1) > div:nth-child(2)').html(char.abilities.str.score);
		$('#charAbilities > div:nth-child(2) > div:nth-child(2)').html(char.abilities.dex.score);
		$('#charAbilities > div:nth-child(3) > div:nth-child(2)').html(char.abilities.con.score);
		$('#charAbilities > div:nth-child(4) > div:nth-child(2)').html(char.abilities.int.score);
		$('#charAbilities > div:nth-child(5) > div:nth-child(2)').html(char.abilities.wis.score);
		$('#charAbilities > div:nth-child(6) > div:nth-child(2)').html(char.abilities.cha.score);

		$('#charAbilities > div:nth-child(1) > div:nth-child(3)').html(char.abilities.str.mod);
		$('#charAbilities > div:nth-child(2) > div:nth-child(3)').html(char.abilities.dex.mod);
		$('#charAbilities > div:nth-child(3) > div:nth-child(3)').html(char.abilities.con.mod);
		$('#charAbilities > div:nth-child(4) > div:nth-child(3)').html(char.abilities.int.mod);
		$('#charAbilities > div:nth-child(5) > div:nth-child(3)').html(char.abilities.wis.mod);
		$('#charAbilities > div:nth-child(6) > div:nth-child(3)').html(char.abilities.cha.mod);

		$('#charAbilities > div:nth-child(1) > div:nth-child(4)').html(char.abilities.str.save);
		$('#charAbilities > div:nth-child(2) > div:nth-child(4)').html(char.abilities.dex.save);
		$('#charAbilities > div:nth-child(3) > div:nth-child(4)').html(char.abilities.con.save);
		$('#charAbilities > div:nth-child(4) > div:nth-child(4)').html(char.abilities.int.save);
		$('#charAbilities > div:nth-child(5) > div:nth-child(4)').html(char.abilities.wis.save);
		$('#charAbilities > div:nth-child(6) > div:nth-child(4)').html(char.abilities.cha.save);

		$('#charHealth > div:nth-child(1) > div:nth-child(2)').html(char.health.ac);
		$('#charHealth > div:nth-child(1) > div:nth-child(4)').html(char.health.speed);
		$('#charHealth > div:nth-child(2) > div:nth-child(2)').html(char.health.hp);
		$('#charHealth > div:nth-child(2) > div:nth-child(4)').html(char.health.damage);
		$('#charHealth > div:nth-child(3) > div:nth-child(4)').html(char.health.hitDice);

	});

</script>
