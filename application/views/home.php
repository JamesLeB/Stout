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
					<li><a href='#tab1'>Test</a></li>
					<li><a href='#tab2'>Development</a></li>
					<li><a href='#tab3'>Production</a></li>
				</ul>
				<div id='tab1'><?php echo $test ?></div>
				<div id='tab2'><?php echo $development ?></div>
				<div id='tab3'><?php echo $production ?></div>
			</div>
		</div>
	</body>
</html>
