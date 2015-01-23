<?php
	$abilites = array('Str','Dex','Con','Int','Wis','Cha');
	$abilitesHtml = '';
	foreach($abilites as $a){
		$abilitesHtml .= "<div>";
		$abilitesHtml .= "<div>0</div>";
		$abilitesHtml .= "<div class='attribSlot emptySlot'></div>";
		$abilitesHtml .= "<div>$a</div>";
		$abilitesHtml .= "</div>";
	}
	$roles = array(1,2,3,4,5,6);
	$rolesHtml = '';
	$index = 0;
	foreach($roles as $a){
		$index++;
		$rolesHtml .= "
			<div class='attribSlot filledSlot' id='attribSlot$index'>
				<div class='attribTile' id='attribTile$index'><div>$a</div></div>
			</div>
		";
	}
	$html = "
		<div id='characterSheet'>
			<div id='characterRoles'>$rolesHtml<button id='rollabilities'>Roll</button></div>
			<div id='characterAbilities'>
				<div>Abilities</div>
				<div>$abilitesHtml</div>
			</div>
		</div>
	";
	$style = "
	";
	$script = "
	";
	echo $style;
	echo $html;
	echo $script;
?>
		<style>
			#characterSheet
			{
				border : 10px ridge blue;
				padding : 10px;
				background : lightblue;
				position : relative;
				height : 500px;
			}
			#characterSheet > div
			{
				box-shadow : 3px 3px 3px black;
				border-radius : 20px;
				position : absolute;
			}
			#characterSheet .attribSlot{
				height : 50px;
				width  : 50px;
				padding : 0px;
				border : 1px gray inset;
				backgroud : lightgray;
			}
			#characterSheet .attribTile{
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
			#characterSheet .attribTile > div{
				border : none;
				color : white;
				font-size : 120%;
				float : left;
				margin-top  : 13px;
				margin-left : 11px;
			}
			#characterRoles{
				height : 85px;
				padding-left : 15px;
				padding-top : 10px;
				width : 550px;
				background-image : url('lib/images/wood1.jpg');
				left : 300px;
			}
			#characterRoles .attribSlot{
				margin : 10px;
				float : left;
			}
			#characterAbilities{
				border : 1px solid black;
				width : 250px;
				background-image : url('lib/images/wood1.jpg');
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
			#rollabilities
			{
				font-size : 150%;
				background : blue;
				color : white;
				height : 40px;
				width : 70px;
				margin-left : 10px;
				margin-top : 15px;
			}
		</style>
		<script>
			$('#rollabilities').click(function(){
				$('#error').html('lets roll');
				var roles = [0,0,0,0,0,0];
				var i = [1,2,3,4,5,6]
				i.forEach(function(a){
						var obj = $('#attribTile'+a);
						$(obj).parent().removeClass('filledSlot');
						$(obj).parent().addClass('emptySlot');
						obj.appendTo($('#attribSlot'+a));
						$(obj).parent().addClass('filledSlot');
						$(obj).parent().removeClass('emptySlot');
				});

$.post('index.php?/dnd/dice/roleCharacter','',function(data){
	$('#debug').html(data);
});

				$('#attribTile1 > div').html('X');
				$('#attribTile2 > div').html('X');
				$('#attribTile3 > div').html('X');
				$('#attribTile4 > div').html('X');
				$('#attribTile5 > div').html('X');
				$('#attribTile6 > div').html('X');
			});
			$('.attribTile').draggable({containment:'document'});
			$('.attribTile').draggable('option','revert',true);
			$('.attribTile').draggable('option','revertDuration',0);
			$('.attribTile').draggable('enable');
			$('.attribTile').draggable({
				stop: function(event,ui){
					$(this).css('top',-1);
					$(this).css('left',-1);
					$(this).css('z-index',1);
				}
			});
			$('.attribTile').draggable({
				start: function(event,ui){
					$(this).css('z-index',2);
				}
			});
			$('.attribSlot').droppable({
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
