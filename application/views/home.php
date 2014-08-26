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
			<div id='tabs'>
				<ul>
					<li><a href='#exchange'>Exchange</a></li>
					<li><a href='#tab5'>Test</a></li>
					<li><a href='#tab6'>Development</a></li>
					<li><a href='#tab1'>Market</a></li>
					<li><a href='#tab2'>Buy</a></li>
					<li><a href='#tab3'>Inventory</a></li>
					<li><a href='#tab4'>Sales</a></li>
					<li><a href='#tab7'>Production</a></li>
				</ul>
				<div id='exchange'><?php echo $Exchange ?></div>
				<div id='tab1'><?php echo $Market ?></div>
				<div id='tab2'><?php echo $Buy ?></div>
				<div id='tab3'><?php echo $Inventory ?></div>
				<div id='tab4'><?php echo $Sales ?></div>
				<div id='tab5'><?php echo $test ?></div>
				<div id='tab6'><?php echo $development ?></div>
				<div id='tab7'><?php echo $production ?></div>
			</div>
		</div>
	</body>
</html>
