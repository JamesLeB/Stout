<?php
	$groot = $_POST['groot'];
?>
<div id='detailCoinView'>
	<div>
		<button id='switchBack'>&nbsp</button>
	</div>
	<div> <?php echo $groot ?> </div>
</div>
<style>
	#detailCoinView
	{
		height : 300px;
		width  : 800px;
		background : white;
		margin-top : 40px;
		margin-left : auto;
		margin-right : auto;
		border : 1px solid black;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		background : lightblue;
	}
	#detailCoinView > div:nth-child(1)
	{
		position : relative;
		top : 10px;
		left : 20px;
	}
	#detailCoinView > div:nth-child(1) > button:nth-child(1)
	{
		background : red;
	}
	#detailCoinView > div:nth-child(2)
	{
		border : 5px ridge green;
		width : 90%;
		margin-left : auto;
		margin-right : auto;
		position : relative;
		top : 20px;
		padding : 10px;
		background : lightgreen;
	}
</style>
<script>
	$('#switchBack').click(function(){ switchBack(); });
</script>
