<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<script src='js/jquery-1.11.1.js'></script>
	<script src='js/jquery-ui-1.11.2.custom/jquery-ui.js'></script>
	<link  href='js/jquery-ui-1.11.2.custom/jquery-ui.css' rel='stylesheet'/>
	<script>
		$(document).ready(function(){
			$('#logout').click(function(){
				$.post('index.php?/stout/logout','',function(data){
					window.location.href = "index.php";
				});
			});
			$('#tabs').tabs();
			$('#tabs').tabs({active:2});
		}); // END doc ready function
	</script>
	<style>
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
		<!-- Header -->
		<div>
			<img src='lib/images/nyu.jpg'>
			<button id='logout'><img src='lib/images/exit.png'></button>
		</div>
		<!-- Body -->
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>Tasks</a></li>
					<li><a href='#tab2'>ToDo</a></li>
					<li><a href='#tab3'>Bill Medicaid</a></li>
				</ul>
				<div id='tab1'><!-- Junior Tasks --></div>
				<div id='tab2'><!-- To Do --></div>
				<div id='tab3'><!-- Bill Medicaid --></div>
			</div>
		</div>
		<!-- Footer -->
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
<html>
