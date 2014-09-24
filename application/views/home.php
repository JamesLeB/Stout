<html>
	<head>
		<title>Stout</title>
		<link href='css/ui-darkness/jquery-ui-1.10.4.custom.css' rel='stylesheet' />
		<link href='css/style.css' rel='stylesheet' />
		<script src='js/jquery-1.10.2.js'></script>
		<script src='js/jquery-ui-1.10.4.custom.js'></script>
		<script src='js/docReady.js'></script>
<!--
		<script src='js/script.js'></script>
		<script src='js/bitglobal.js'></script>
--!>
	</head>
	<body>
		<div id='wrapper'>
			<div id='stoutHeading'>
				<img src='lib/images/cat.jpg' />
				<clock>clock</clock>
				<?php $message = file_get_contents('files/message'); ?>
				<p><?php echo $message; ?></p>
			</div>
			<?php echo $slideTray ?>
		</div>
	</body>
</html>
