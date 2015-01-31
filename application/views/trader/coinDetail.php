<?php
	$groot = $_POST['groot'];
?>
<div id='detailCoinView'>
	<button id='switchBack'>Close</button>
	<div> <?php echo $groot ?> </div>
</div>
<style>
	#detailCoinView
	{
		height : 600px;
		width  : 800px;
		background : white;
		margin-top : 40px;
		margin-left : auto;
		margin-right : auto;
		border : 1px solid black;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
	}
</style>
<script>
	$('#switchBack').click(function(){ switchBack(); });
</script>
