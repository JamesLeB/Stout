<!-- Inside div #grapher --!>
<div id='grapher'>
	<div>
		<button>Default Graph</button>
		<button>Config</button>
		<button>Clear</button>
	</div>
	<div>
		Main return area
	</div>
</div>
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
		height : 400px;
		padding : 20px;
	}
</style>
<script>
	// SETTINGS
	//var defaultGraph = '<img src="lib/graphs/defaultGraph.php" />';
	var defaultGraph = '<img src="lib/graphs/sam2.php" />';
	var configTarget = 'index.php?/grapher/config';
	var grapherReturn = '#grapher > :nth-child(2)';
	var grapherControl = '#grapher > :nth-child(1)';

	// Clear
	$(grapherControl + ' > :nth-child(3)').click(function(){
		$(grapherReturn).html('Clear');
	});
	// Default
	$(grapherControl + ' > :nth-child(1)').click(function(){
		$(grapherReturn).html(defaultGraph);
	});
	// Config
	$(grapherControl + ' > :nth-child(2)').click(function(){
		var request = $.post(configTarget,'',function(data){
			$(grapherReturn).html(data);
		});
	});
</script>
