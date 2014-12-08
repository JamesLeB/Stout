<?php
	$abilites = array('Str','Dex','Con','Int','Wis','Cha');
	$abilitesHtml = '';
	foreach($abilites as $a){
		$abilitesHtml .= "<div>";
		$abilitesHtml .= "<div>$a</div>";
		$abilitesHtml .= "<div>Slot</div>";
		$abilitesHtml .= "<div>Tile</div>";
		$abilitesHtml .= "</div>";
	}
	$roles = array(0,0,0,0,0,0);
	$rolesHtml = '';
	foreach($roles as $a){
		$rolesHtml .= "<div>Slot</div>";
		$rolesHtml .= "<div>Tile</div>";
	}
	$html = "
		<div id='characterSheet'>Character Sheet
			<div id='characterRoles'>$rolesHtml </div>
			<div id='characterAbilities'>
				<div>Abilities</div>
					$abilitesHtml
				</div>
			</div>
		</div>
	";
	$style = "
		<style>
			#characterSheet{
				border : 1px dashed gray;
			}
			#characterSheet div{
				border : 1px dashed gray;
				margin : 10px;
			}
		</style>
	";
	echo $style;
	echo $html;
?>
