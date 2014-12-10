<?php
	$html = "<div id='$folderName'>";
	foreach($list as $l){
		$html .= "<div>$l</div>";
	}
	$html .= "</div>";
	$style = "
		<style>
			#$folderName{
				border : 2px gray inset;
				background : white;
				padding : 10px;
				width : 90%;
				margin-left : auto;
				margin-right : auto;
				height : 250px;
				overflow : auto;
			}
			#$folderName > div{
				padding : 5px;
			}
		</style>
	";
	$script = "
		<script>
			$('#$folderName > div').mouseenter(function(){
				$(this).css('background','yellow');
			});
			$('#$folderName > div').mouseleave(function(){
				$(this).css('background','white');
			});
			$('#$folderName > div').click(function(){
				var fileName = $(this).html();
				alert('you clicked '+fileName);
			});
		</script>
	";
	echo $html.$style.$script;
?>
