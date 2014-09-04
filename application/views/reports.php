<table id='reports'>
	<tr>
		<td><div class='reportIcon' report='report1' >Report1</div></td>
		<td><div class='reportIcon' report='report2' >Report2</div></td>
		<td><div class='reportIcon' report='report3' >Report3</div></td>
		<td><div class='reportIcon' report='report4' >Report4</div></td>
	</tr>
</table>

<div id='report1'>
	<button class='closeReport'>Close</button>
	<?php echo $report1 ?>
</div>
<div id='report2'>
	<button class='closeReport'>Close</button>
	<?php echo $report2 ?>
</div>
<div id='report3'>
	<button class='closeReport'>Close</button>
	<?php echo $report3 ?>
</div>
<div id='report4'>
	<button class='closeReport'>Close</button>
	<?php echo $report4 ?>
</div>

<style>
	#reports td {
		background : lightgray;
		color : black;
	}
	.reportIcon {
		background : white;
		border-style : ridge;
		border-color : green;
		border-size : 1px;
		height : 100px;
		width : 100px;
	}
</style>
<script>
	$('.closeReport').parent().hide();
	$('.closeReport').click(function(){
		$(this).parent().hide();
		$('#reports').show();
	});
	$('.reportIcon').mouseenter(function(){
		$(this).css('border-color','yellow');
	});
	$('.reportIcon').mouseleave(function(){
		$(this).css('border-color','green');
	});
	$('.reportIcon').click(function(){
		$('#reports').hide();
		var x = $(this).attr('worker');
		$('#'+x).show();
	});
</script>
