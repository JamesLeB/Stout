<?php
	$scaleX = 50;
	$scaleY = 40;
	$sizeX  = 10;
	$sizeY  = 10;
	$sh=$scaleY;
	$sw=$scaleX;
	$ph=$scaleY+4;
	$pw=$scaleX+4;
$index = 0;
	$html = '';
	$html .= "<table>";
	for($i=0;$i<$sizeY;$i++){
		$html .= "<tr>";
		for($j=0;$j<$sizeX;$j++){
$index++;
$aa = $index % 2;
$terrain = 'lightgray';
if($aa){$terrain = 'lightgray';}
			$html .= "<td><div class='space emptySpace' style='background:$terrain'></div></td>";
		}
		$html .= "</tr>";
		$html .= "</div>";
	}
	$html .= "</table>";
	$style = "
		<style>
			.space{
				height : {$sh}px;
				width  : {$sw}px;
			}
			#map table{
				border : 1px solid green;
				background : lightgray;
				border-collapse: collapse;
			}
			.
		</style>
	";
	$script = "
	";
	$factoryHtml = "
		<div class='space'>
			<div class='tile'></div>
		</div>
		<div class='space'>
			<div class='tile'></div>
		</div>
	";
	$factoryStyle = "
		<style>
			#factory{
				border : 1px brown solid;
				width  : 150px;
				height : 200px;
				float : right;
			}
			#factory .space{
				margin-left : 10px;
				margin-top  : 10px;
			}
			.tile{
				height : {$ph}px;
				width  : {$pw}px;
				background : purple;
			}
		</style>
	";
	$factoryScript = "
	";
?>
<div id='factory'><?php echo $factoryHtml.$factoryStyle.$factoryScript ?></div>
<div id='map'><?php echo $html.$style.$script ?></div>
<script>
	var c = 'transparent';
	//var c = 'gray';
	var test = 1;
	var lastSpace;
	$('.space').css('border','2px solid '+c);
	$('.space').mouseenter(function(){
		if(test==1)
		{
			$(this).css('border-color','yellow');
		}
	});
	$('.space').mouseleave(function(){
		if(test==1)
		{
			$(this).css('border-color',c);
		}
	});
	$('.space').droppable({
		drop: function(event,ui){
			var test = $(this).hasClass('emptySpace');
			if(test){
				var obj = ui.draggable;
				$(obj).parent().removeClass('filledSpace');
				$(obj).parent().addClass('emptySpace');
				$(obj).parent().css('border-color',c);
				ui.draggable.detach().appendTo($(this));
				$(this).removeClass('emptySpace');
				$(this).addClass('filledSpace');
			}
		},
		over: function(event,ui)
		{
			$(this).css('border-color','yellow');
		},
		out: function(event,ui)
		{
			$(this).css('border-color',c);
			$(lastSpace).parent().css('border-color','blue');
		}
	});
	$('.tile').draggable({containment:'document'});
	$('.tile').draggable('option','revert',true);
	$('.tile').draggable('option','revertDuration',0);
	$('.tile').draggable('enable');
	$('.tile').draggable({
		stop: function(event,ui){
			$(this).css('top',-2);
			$(this).css('left',-2);
			$(this).css('z-index',1);
			test = 1;
		}
	});
	$('.tile').draggable({
		start: function(event,ui){
			$(this).css('z-index',2);
			$('.space').css('border-color',c);
			test = 0;
			lastSpace = this;
		}
	});
	$('.tile').css('top',-2);
	$('.tile').css('left',-2);
</script>
<style>
</style>
