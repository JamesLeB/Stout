<?php
	$abilites = array('Str','Dex','Con','Int','Wis','Cha');
	$abilitesHtml = '';
	foreach($abilites as $a){
		$abilitesHtml .= "<div>";
		$abilitesHtml .= "<div>0</div>";
		$abilitesHtml .= "<div class='slot emptySlot'></div>";
		$abilitesHtml .= "<div>$a</div>";
		$abilitesHtml .= "</div>";
	}
	$roles = array(1,2,3,4,5,6);
	$rolesHtml = '';
	foreach($roles as $a){
		$rolesHtml .= "
			<div class='slot filledSlot'>
				<div class='tile'><div>$a</div></div>
			</div>
		";
	}
	$html = "
		<div id='characterSheet'>Character Sheet
			<div id='characterRoles'>$rolesHtml</div>
			<div id='characterAbilities'>
				<div>Abilities</div>
				<div>$abilitesHtml</div>
			</div>
		</div>
	";
	$style = "
		<style>
			#characterSheet{
				border : 1px dashed gray;
			}
			#characterSheet div{
			}
			#characterSheet .slot{
				height : 50px;
				width  : 50px;
				padding : 0px;
				border : 1px gray inset;
				backgroud : lightgray;
			}
			#characterRoles{
				height : 75px;
				padding-left : 15px;
				width : 450px;
				background-image : url('lib/images/wood1.jpg');
				box-shadow : 3px 3px 3px black;
				border-radius : 20px;
			}
			#characterRoles .slot{
				margin : 10px;
				float : left;
			}
			#characterSheet .tile{
				border : none;
				height : 52px;
				width  : 52px;
				margin : 0px;
				background-image : url('lib/images/slate1.jpg');
				box-shadow : 2px 2px 2px black;
				top : -1px;
				left : -1px;
				z-index : 1;
			}
			#characterSheet .tile > div{
				border : none;
				color : white;
				font-size : 120%;
				float : left;
				margin-top  : 13px;
				margin-left : 11px;
			}
			#characterAbilities{
				border : 1px solid black;
				width : 250px;
				margin-top : 30px;
				background-image : url('lib/images/wood1.jpg');
				border-radius : 20px;
				box-shadow : 3px 3px 3px black;
			}
			#characterAbilities > div:nth-child(1){
				font-family: 'rocksalt';
				text-align : center;
				font-weight : bold;
				font-size : 120%;
			}
			#characterAbilities > div:nth-child(2) > div > div:nth-child(1){
				width : 30px;
				text-align : right;
				float : right;
				padding-top  : 12px;
				margin-left  : 30px;
				margin-right : 30px;
				font-size : 120%;
			}
			#characterAbilities > div:nth-child(2) > div > div:nth-child(2){
				float : right;
			}
			#characterAbilities > div:nth-child(2) > div > div:nth-child(3){
				font-family: 'PermanentMarker';
				font-size : 120%;
				height : 53px;
				width : 50px;
				padding-top : 10px;
				margin-left : 30px;
			}
		</style>
	";
	$script = "
		<script>
			$('.tile').draggable({containment:'document'});
			$('.tile').draggable('option','revert',true);
			$('.tile').draggable('option','revertDuration',0);
			$('.tile').draggable('enable');
			$('.tile').draggable({
				stop: function(event,ui){
					$(this).css('top',-1);
					$(this).css('left',-1);
					$(this).css('z-index',1);
				}
			});
			$('.tile').draggable({
				start: function(event,ui){
					$(this).css('z-index',2);
				}
			});
			$('.slot').droppable({
				drop: function(event,ui){
					var test = $(this).hasClass('emptySlot');
					if(test){
						var obj = ui.draggable;
						$(obj).parent().removeClass('filledSlot');
						$(obj).parent().addClass('emptySlot');
						ui.draggable.detach().appendTo($(this));
						$(this).removeClass('emptySlot');
						$(this).addClass('filledSlot');
					}
				}
			});
		</script>
	";
	echo $style;
	echo $html;
	echo $script;
?>
