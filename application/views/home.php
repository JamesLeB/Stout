<html>
	<head>
		<title>Stout</title>
		<link href='css/ui-darkness/jquery-ui-1.10.4.custom.css' rel='stylesheet' />
		<link href='css/style.css' rel='stylesheet' />
		<script src='js/jquery-1.10.2.js'></script>
		<script src='js/jquery-ui-1.10.4.custom.js'></script>
		<script src='js/script.js'></script>
		<script src='js/bitglobal.js'></script>
	</head>
	<body>
		<div id='wrapper'>
			<div id='stoutHeading'>0</div>
			<div id='tabs'>
				<ul>
					<li><a href='#test'>Test</a></li>
					<li><a href='#exchange'>Exchange</a></li>
					<li><a href='#development'>Development</a></li>
					<li><a href='#production'>Production</a></li>
				</ul>
				<div id='exchange'><?php echo $exchange ?></div>
				<div id='test'><?php echo $test ?></div>
				<div id='development'><?php echo $development ?></div>
				<div id='production'><?php echo $production ?></div>
			</div>
		</div>
	</body>
</html>
