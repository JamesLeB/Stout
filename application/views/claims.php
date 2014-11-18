<html>
<head>
	<script src='js/jquery-1.10.2.js'></script>
	<script src='js/jquery-ui-1.10.4.custom.js'></script>
	<style>
		#wrapper{
			border: 1px solid;
			border-radius : 25px;
			width : 85%;
			height : 500px;
			margin : auto;
			margin : auto;
			padding : 20px;
			margin-top : 30px;
			box-shadow : 3px 3px 3px black;
		}
		#claimList{
			overflow: auto;
			height : 400px;
		}
		.claim{
			list-style-type : none;
		}
		.claim span{
			display : inline-block;
			margin-right : 10px;
			width : 100px;
			margin : 5px;
			padding : 5px;
		}
		.claim span:nth-child(1){
			width : 150px;
		}
		.claim span:nth-child(2){
			width : 120px;
		}
		.claim span:nth-child(3){
			width : 120px;
		}
		.claim span:nth-child(4){
			text-align : center;
		}
		.claim span:nth-child(5){
			text-align : right;
		}
		.claim span:nth-child(6){
			text-align : center;
		}
		#claimHeading{
			margin-top : 20px;
		}
		#claimHeading span{
			background : lightblue;
			text-align : center;
		}
		#notes{
			position : absolute;
			height : 400px;
			width : 500px;
			border : 1px solid black;
			border-radius : 20px;
			padding : 20px;
			background : lightgray;
			right : 0;
			left : 0;
			margin : auto;
			margin-top : 50px;
			z-index : 3;
			opacity : 0;
			box-shadow : 3px 3px 3px black;
		}
		.note{
			margin : 10px;
		}
		#hideNote{
			float : right;
			margin-right : 20px;
		}
		#addNote{
			float : right;
			margin-right : 20px;
		}
		.screen{
			position : absolute;
			left : 0;
			top : 0;
			width : 100%;
			height : 100%;
		}
		#scn1{
			background : gray;
			opacity : 0;
			z-index : 0;
		}
		#scn2{
			z-index : 1;
		}
	</style>
	<script>
		$(document).ready(function(){
			$('#notes').hide();
			$('#logout').click(function(){
				var target = 'index.php?/stout/logout';
				var request = $.post(target,'',function(data){
					window.location.href = "index.php";
				});
			});
			$('.viewNote').click(function(){
				$('#scn1').zIndex(2);
				$('#scn1').fadeTo(500,.8,function(){
					$('#notes').show();
				});
				$('#notes').fadeTo(500,1);
			});
			$('#hideNote').click(function(){
				$('#notes').fadeTo(500,0,function(){
					$('#notes').hide();
				});
				$('#scn1').fadeTo(500,0,function(){
					$('#scn1').zIndex(0);
				});
			});
			$('#addNote').click(function(){
				$('#notes').append("<div class='note'>New Note</div>");
			});
		});
	</script>
</head>
<body>
	<div class='screen' id='scn1'></div>
	<div class='screen' id='scn2'>
	<div id='wrapper'>
		<button id='logout'>logout</button>
		<?php
			# Set headings
			$html = '';
			$html .= "<div id='claimHeading' class='claim'>";
			foreach($claims['headings'] as $h){
				$html .= "<span class='field'>$h</span>";
			}
			$html .= "</div>";
			$html .= "<div id='claimList'>";
			foreach($claims['rows'] as $a){
				$html .= "<div class='claim'>";
				foreach($a as $e){
					$html .= "<span class='field'>$e</span>";
				}
				$html .= "<span class='field'>";
				$html .= "<button class='viewNote'>Notes</button>";
				$html .= "</span>";
				$html .= "</div>";
			}
			$html .= "</div>";
			echo $html;
		?>
	</div>
	</div>
	<div id='notes'>
		NOTES
		<button id='hideNote'>Close</button>
		<button id='addNote'>Add</button>
	</div>
</body>
</html>
