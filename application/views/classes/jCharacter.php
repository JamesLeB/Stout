<div id='characterSheet'>
	<div id='charTable'><?php echo $charTable; ?></div>
	<div id='charSheet'><?php echo $charSheet; ?></div>
</div>
<style>
	#characterSheet{
		border : 1px dashed red;
	}
	#charTable{
		border : 1px solid green;
		width : 650px;
		padding : 10px;
		float : right;
	}
	#charSheet{
		width : 500px;
		height : 500px;
		background : lightgreen;
	}
</style>
<script>
	$('#charTable').hide();
</script>
