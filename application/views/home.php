<html>
	<head>
		<link href='css/ui-darkness/jquery-ui-1.10.4.custom.css' rel='stylesheet' />
		<link href='css/style.css' rel='stylesheet' />
		<script src='js/jquery-1.10.2.js'></script>
		<script src='js/jquery-ui-1.10.4.custom.js'></script>
		<script src='js/script.js'></script>
	</head>
	<body>
		<div id='wrapper'>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>Tab1</a></li>
					<li><a href='#tab2'>Development</a></li>
					<li><a href='#tab3'>Tab3</a></li>
				</ul>
				<div id='tab1'>first tab</div>
				<div id='tab2'><?php echo $develop ?></div>
				<div id='tab3'>third tab</div>
			</div>
		</div>
<!--
--!>
	</body>
</html>
