<table id='developmentFloor'>
	<tr>
		<td><div class='devWorkerIcons' worker='devWork1' >one</div></td>
		<td><div class='devWorkerIcons' worker='devWork2' >two</div></td>
		<td><div class='devWorkerIcons' worker='devWork3' >three</div></td>
	</tr>
</table>

<div id='devWork1'>
	<button class='closeDevWorker'>Close</button>
	<?php echo $test ?>
</div>
<div id='devWork2'>
	<button class='closeDevWorker'>Close</button>
	two
</div>
<div id='devWork3'>
	<button class='closeDevWorker'>Close</button>
	three
</div>

<style>
	#developmentFloor td {
		background : lightgray;
		color : black;
	}
	.devWorkerIcons {
		background : white;
		border-style : ridge;
		border-color : green;
		border-size : 1px;
		height : 100px;
		width : 100px;
	}
</style>
<script>
	$('.closeDevWorker').parent().hide();
	$('.closeDevWorker').click(function(){
		$(this).parent().hide();
		$('#developmentFloor').show();
	});
	$('.devWorkerIcons').mouseenter(function(){
		$(this).css('border-color','yellow');
	});
	$('.devWorkerIcons').mouseleave(function(){
		$(this).css('border-color','green');
	});
	$('.devWorkerIcons').click(function(){
		$('#developmentFloor').hide();
		var x = $(this).attr('worker');
		$('#'+x).show();
	});
</script>
