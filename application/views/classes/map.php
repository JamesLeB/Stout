<?php
	$scale = 20;
	$size  = 5;
	$html = '';
	for($i=0;$i<$size;$i++){
		$html .= "<div class='row'>";
		for($j=0;$j<$size;$j++){
			$html .= "<div class='space'></div>";
		}
		$html .= "</div>";
	}
	$mh=$size;
	$mw=$mh;
	$sh=$scale;
	$sw=$scale;
	$rh=$scale+2;
	$rw=$rh*$size;
	$mapw=$rw;
	$style = "
		<style>
			.space{
				background : lightgray;
				height : {$sh}px;
				width  : {$sw}px;
				float : left;
			}
			.row{
				height : {$rh}px;
				width  : {$rw}px;
			}
			#map{
				border : 1px solid green;
				width : {$mapw}px;
			}
		</style>
	";
	$script = "
	";
	$factoryHtml = "
		<div class='piece'></div>
	";
	$factoryStyle = "
		<style>
			#factory{
				border : 1px brown solid;
				width  : 100px;
				height : 100px;
				float : right;
			}
			.piece{
				margin-top  : 10px;
				margin-left : 10px;
				height : {$sh}px;
				width  : {$sw}px;
				background : lightblue;
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
	var c = 'gray';
	$('.space').css('border','1px dotted '+c);
	$('.space').mouseenter(function(){
		$(this).css('border-color','yellow');
	});
	$('.space').mouseleave(function(){
		$(this).css('border-color',c);
	});
</script>
<style>
</style>
