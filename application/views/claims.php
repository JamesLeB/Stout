<html>
<head>
	<script src='js/jquery-1.10.2.js'></script>
	<style>
		#wrapper{
			border: 2px solid;
			border-radius : 25px;
			width : 800px;
			height : 500px;
			margin : auto;
			margin : auto;
			padding : 20px;
		}
		ul{
		}
		li{
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
			padding : 10px;
			background : lightgray;
			right : 0;
			left : 0;
			margin : auto;
		}
		#hideNote{
			float : right;
		}
		#addNote{
			float : right;
			margin-right : 20px;
		}
	</style>
</head>
<body>
	<button id='logout'>logout</button>
	<div id='wrapper'>
		<div id='notes'>
			NOTES
			<button id='hideNote'>Close</button>
			<button id='addNote'>Add</button>
			<ul>
			</ul>
		</div>
		<p>Hello <?php echo $user ?></p>
		<?php
			$array = array(
				'first',
				'second',
				'third'
			);
			$html = '';
			$html .= '<ul>';
			foreach($array as $a){
				
				$html .= "<li>
					<span>$a</span>
					<span>hell</span>
					<span><button class='viewNote'>Notes</button></span>
				</li>";
			}
			$html .= '</ul>';
			echo $html;
		?>
	</div>
	<script>
		$('#notes').hide();
		$('#logout').click(function(){
			var target = 'index.php?/stout/logout';
			var request = $.post(target,'',function(data){
				window.location.href = "index.php";
			});
		});
		$('.viewNote').click(function(){
			$('#notes').show();
		});
		$('#hideNote').click(function(){
			$('#notes').hide();
		});
		$('#addNote').click(function(){
			$('#notes').append("<li>item1</li>");
		});
	</script>
</body>
</html>
