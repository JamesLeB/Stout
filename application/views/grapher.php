<!-- Inside div #grapher --!>
<div id='grapher'>
	<div>
		<button>A</button>
		<button>B</button>
		<button>C</button>
	</div>
	<div>
		graph will do here
	</div>
</div>
<script>
	// A button
	$('#grapher > :nth-child(1) > :nth-child(1)').click(function(){
		$('#grapher > :nth-child(2)').html('<img src="lib/graphs/defaultGraph.php" />');
	});
	// B button
	$('#grapher > :nth-child(1) > :nth-child(2)').click(function(){
		var target = 'index.php?/grapher/config';
		var request = $.post(target,'',function(data){
			$('#grapher > :nth-child(2)').html(data);
		});
	});
</script>
<style>
	#grapher div {
		margin : 5px;
		padding : 5px;
		border-style : solid;
		border-width : 2px;
	}
	#grapher > :nth-child(1) {
		border-color : yellow;
	}
	#grapher > :nth-child(2) {
		border-color : green;
		height : 300px;
	}
</style>
