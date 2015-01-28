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
			$('#tabs').tabs({active:1});
		}); // END doc ready function
	</script>
	<style>
		body
		{
			background : gray;
		}
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
			opacity : 0;
		}
		#special
		{
			position : fixed;
			margin : 0px;
			top : 0;
			left : 0;
			width : 100%;
			height : 100%;
			z-index : -1;
		}
	</style>
</head>
<body>
	<div id='screen'></div>
	<div id='special'></div>
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
					<li><a href='#tab1'>ToDo</a></li>
					<li><a href='#tab2'>Bill Medicaid</a></li>
					<li><a href='#tab3'>Load 277</a></li>
					<li><a href='#tab4'>Tables</a></li>
					<li><a href='#tab5'>LoadClaims</a></li>
				</ul>
				<div id='tab1'><?php echo $todo ?></div>
				<div id='tab2'><?php echo $billMedicaid ?></div>
				<div id='tab3'><?php echo $load277 ?></div>
				<div id='tab4'><?php echo $dbtables ?></div>
				<div id='tab5'><?php echo $loadClaims ?></div>
			</div>
		</div>
		<!-- Footer -->
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
</html>
