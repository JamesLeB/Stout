<html>
<head>
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
			width : 400px;
			border : 1px solid black;
			border-radius : 20px;
			padding : 10px;
			background : lightgray;
			right : 0;
			left : 0;
			margin : auto;
		}
	</style>
</head>
<body>
	<div id='wrapper'>
		<div id='notes'>NOTES</div>
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
				
				$html .= "<li><span>$a</span><span>hell</span><span><button>go</button></span></li>";
			}
			$html .= '</ul>';
			echo $html;
		?>
	</div>
</body>
</html>
