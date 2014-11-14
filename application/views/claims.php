<html>
<head>
	<script src='js/jquery-1.10.2.js'></script>
	<script src='js/jquery-ui-1.10.4.custom.js'></script>
	<style>
		#wrapper{
			border: 2px solid;
			border-radius : 25px;
			width : 800px;
			height : 500px;
			margin : auto;
			margin : auto;
			padding : 20px;
			margin-top : 30px;
		}
		.claim{
			list-style-type : none;
			padding : 10px;
			border : 1px solid gray;
			margin : 10px;
		}
		span{
			display : inline-block;
			margin-right : 10px;
			width : 100px;
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
				$('#notes').append("<div class='note'>item1</div>");
			});
		});
	</script>
</head>
<body>
	<div class='screen' id='scn1'></div>
	<div class='screen' id='scn2'>
	<div id='wrapper'>
		<p><?php echo "User: $user" ?></p>
		<button id='logout'>logout</button>
		<?php
			$array = array(
				'first',
				'second',
				'third'
			);
			$html = '';
			foreach($array as $a){
				$html .= "<div class='claim'>";
				$html .= "<span class='field'>$a</span>";
				$html .= "<span class='field'>two</span>";
				$html .= "<span class='field'>";
				$html .= "<button class='viewNote'>Notes</button>";
				$html .= "</span>";
				$html .= "</div>";
			}
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
