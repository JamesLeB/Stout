<!-- Inside div #grapher --!>
<div id='grapher'>
	<div>
		<button>Default Graph</button>
		<button>Config</button>
		<button>Clear</button>
		<button>GetBuy</button>
	</div>
	<div>
		<img src="lib/graphs/sam2.php" />
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
		min-height : 400px;
		padding : 20px;
	}
</style>
<script>
	// SETTINGS
	//var defaultGraph = '<img src="lib/graphs/defaultGraph.php" />';
	var grapherControl = '#grapher > :nth-child(1)';
	var defaultGraph = '<img src="lib/graphs/sam2.php" />';
	var grapherTarget = 'index.php?/grapher/';
	var grapherReturn = '#grapher > :nth-child(2)';

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
		var func = 'config';
		var request = $.post(grapherTarget+func,'',function(data){
			$(grapherReturn).html(data);
		});
	});
	// GetBuy
	$(grapherControl + ' > :nth-child(4)').click(function(){
		var func = 'getBuys';
		var request = $.post(grapherTarget+func,'',function(data){
			$(grapherReturn).html(data);
		});
	});
</script>
