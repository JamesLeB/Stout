<table id='developmentFloor'>
	<tr>
		<td><div class='devWorkerIcons' worker='devWork1' >market</div></td>
		<td><div class='devWorkerIcons' worker='devWork2' >buy</div></td>
		<td><div class='devWorkerIcons' worker='devWork3' >inventory</div></td>
		<td><div class='devWorkerIcons' worker='devWork4' >sales</div></td>
	</tr>
</table>

<div id='devWork1'>
	<button class='closeDevWorker'>Close</button>
	<?php echo $market ?>
</div>
<div id='devWork2'>
	<button class='closeDevWorker'>Close</button>
	<?php echo $buy ?>
</div>
<div id='devWork3'>
	<button class='closeDevWorker'>Close</button>
	<?php echo $inventory ?>
</div>
<div id='devWork4'>
	<button class='closeDevWorker'>Close</button>
	<?php echo $sales ?>
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
