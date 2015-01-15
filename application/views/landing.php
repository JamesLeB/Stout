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
			$('#tabs').tabs({active:2});
		});
	</script>
	<style>
		@font-face{
			font-family: 'rocksalt';
			src : url('lib/fonts/rocksalt.ttf')
		}
		@font-face{
			font-family: 'PermanentMarker';
			src : url('lib/fonts/PermanentMarker.ttf')
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
		}
	</style>
</head>
<body>
	<div id='screen'></div>
	<div id='wrapper'>
		<!-- HEADER --!>
		<div>
			<img src='lib/images/cricket.png'>
			<span>Welcome Message..</span>
			<button id='logout'><img src='lib/images/exit.png'></button>
		</div>
		<!-- BODY --!>
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>Spash</a></li>
					<li><a href='#tab2'>Trader</a></li>
					<li><a href='#tab3'>NewCharacter</a></li>
					<li><a href='#tab4'>Coins</a></li>
					<li><a href='#tab5'>CharacterSheet</a></li>
					<li><a href='#tab6'>Database</a></li>
					<li><a href='#tab7'>Map</a></li>
					<li><a href='#tab8'>WebGL</a></li>
				</ul>
				<div id='tab1'><?php echo $splash ?></div>
				<div id='tab2'><?php #echo $trader ?></div>
				<div id='tab3'><?php echo $jCharacter ?></div>
				<div id='tab4'><?php echo $coins ?></div>
				<div id='tab5'><?php echo $characterSheet ?></div>
				<div id='tab6'><?php #echo $database ?></div>
				<div id='tab7'><?php #echo $map ?></div>
				<div id='tab8'><?php #echo $webgl ?></div>
			</div>
		</div>
		<!-- FOOTER --!>
		<div>
			<span>Footer</span>
			<div id='error'></div>
		</div>
	</div>
</body>
</html>
