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
		div{
			border : dashed 1px gray;
			margin : 5px;
		}
		#logout img{
			height : 40px;
		}
		.slide{
			position : fixed;
			margin : 0;
			left : 1%;
			top : 1%;
			height : 97%;
			width  : 97%;
			opacity : .5;
		}
		#slide1{
			background : gray;
			z-index : 1;
		}
		#slide2{
			background : gray;
			z-index : 2;
		}
		#slide3{
			background : white;
			z-index : 3;
			opacity : 1;
		}
		#slide3 > div:nth-child(1){
			height : 50px;
		}
		#slide3 > div:nth-child(2){
			height : 400px;
		}
		#slide3 > div:nth-child(3){
			height : 50px;
		}
		#slide3 button{
			float : right;
		}
	</style>
</head>
<body>
	<div id='slide1' class='slide'></div>
	<div id='slide2' class='slide'></div>
	<div id='slide3' class='slide'>
		<div>
			<span>Heading</span>
			<button id='logout'><img src='lib/images/exit.png'></button>
		</div>
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>Batches</a></li>
					<li><a href='#tab2'>Claims</a></li>
				</ul>
				<div id='tab1'>
					<span>Batches</span>
				</div>
				<div id='tab2'>
					<span>Claims</span>
				</div>
			</div>
		</div>
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
<html>
