<!DOCTYPE html>
<html>
<head>
	<title>Resume</title>
	<script src='jquery-1.11.1.js'></script>
	<script src='jquery-ui.js'></script>
	<link  href='jquery-ui.css' rel='stylesheet'/>
	<script>
		$(document).ready(function(){
			//alert('Document Ready');
			var p = { james: 'kara' };
			$('#tabs').tabs({active:0});
			$.post('cont.php',p,function(data){
				$('#header').html(data);
			});
		});
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
	</style>
</head>
<?php
	$page1 = file_get_contents('start.html');
?>
<body>
	<div id='wrapper'>
		<!-- HEADER --!>
		<div id='header'>
			Header
		</div>
		<!-- BODY --!>
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>One</a></li>
					<li><a href='#tab2'>Two</a></li>
				</ul>
				<div id='tab1'> <?php echo $page1; ?> </div>
				<div id='tab2'> Second tab </div>
			</div>
		</div>
		<!-- FOOTER --!>
		<div>
			Footer
		</div>
	</div>
</body>
</html>
