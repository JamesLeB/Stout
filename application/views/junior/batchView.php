<div id='batchView'>
	<div>
		<?php echo $batch ?>
	</div>
	<div>
		<?php echo $batchData ?>
	</div>
</div>
<style>
	#batchView
	{
		background : white;
		width  : 1200px;
		opacity : 1;
		margin-top   : 20px;;
		margin-left  : auto;
		margin-right : auto;
		border : solid 1px gray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
	}
	#batchView > div:nth-child(1)
	{
		margin-top  : 30px;
		margin-left : 30px;
	}
	#batchView > div:nth-child(2)
	{
		border : 2px inset gray;
		overflow : auto;
		height : 450px;
		width : 85%;
		margin-bottom : 40px;
		margin-top    : 20px;;
		margin-left   : auto;
		margin-right  : auto;
		padding : 20px;
	}
</style>
