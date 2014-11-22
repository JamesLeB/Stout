<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<script src='js/jquery-1.11.1.js'></script>
	<script src='js/jquery-ui-1.11.2.custom/jquery-ui.js'></script>
	<link  href='js/jquery-ui-1.11.2.custom/jquery-ui.css' rel='stylesheet'/>
	<script>
		$(document).ready(function(){
			//alert('Document Ready');
			$('#logout').click(function(){
				$.post('index.php?/stout/logout','',function(data){
					window.location.href = "index.php";
				});
			});
			$('#tabs').tabs();
		});
	</script>
	<style>
/*
		div{
			border : dashed 1px gray;
			margin : 5px;
		}
*/
		#wrapper{
			border : 1px solid green;
			background : white;
			padding : 5px;
			width : 95%;
			margin-left : auto;
			margin-right : auto;
		}
		#wrapper div:nth-child(1) > img{
			/* Incon size */
			height :50px;
		}
		#logout{
			float : right;
			margin-right : 20px;
		}
		#logout img{
			height : 40px;
		}
		#screen{
			position : fixed;
			margin : 0px;
			top : 0;
			left : 0;
			width : 100%;
			height : 100%;
			z-index : -1;
			background : gray;
		}
	</style>
</head>
<body>
	<div id='screen'></div>
	<div id='wrapper'>
		<div>
			<img src='lib/images/cricket.png'>
			<button id='logout'><img src='lib/images/exit.png'></button>
		</div>
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab3'>Character</a></li>
					<li><a href='#tab1'>Batches</a></li>
					<li><a href='#tab2'>Claims</a></li>
				</ul>
				<div id='tab1'>
					<?php echo $jtable ?>
				</div>
				<div id='tab2'>
					<span>Claims</span>
				</div>
				<div id='tab3'>
					<?php echo $jCharacter ?>
				</div>
			</div>
		</div>
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
<html>
