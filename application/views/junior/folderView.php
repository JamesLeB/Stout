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
				font-size : 75%;
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
				var todo = $(this).parent().parent().parent().children().first().html();
				if(todo == 'Batch'){
					$('#debug').html('Move '+fileName);
					var target = 'index.php?/junior/';
					var func = 'getBatchFile';
					var parm = { file: fileName };
					$.post(target+func,parm,function(data){
						$('#debug').append('<br/>'+data);
						$('#juniorBiller button').trigger('click');
					});
				}else if(todo == 'To Process'){
					$('#debug').html('process '+fileName);
				}else{
					$('#debug').html('Now what '+todo);
				}
			});
		</script>
	";
	echo $html.$style.$script;
?>
