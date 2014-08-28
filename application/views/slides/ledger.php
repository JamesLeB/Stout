<div id='ledger'>
	<div>
		<button>A</button>
		<button>B</button>
	</div>
	<div>
		ledger goes here
	</div>
</div>
<script>
	// A button
	$('#ledger > :nth-child(1) > :nth-child(1)').click(function(){
		$('#ledger > :nth-child(2)').html('hello');
	});
	// B button
	$('#ledger > :nth-child(1) > :nth-child(2)').click(function(){
		$('#ledger > :nth-child(2)').html('world');
/*
		var target = 'index.php?/grapher/config';
		var request = $.post(target,'',function(data){
			$('#grapher > :nth-child(2)').html(data);
		});
*/
	});
</script>
<style>
	#ledger div {
		margin : 5px;
		padding : 5px;
		border-style : solid;
		border-width : 2px;
	}
	#ledger > :nth-child(1) {
		border-color : yellow;
	}
	#ledger > :nth-child(2) {
		border-color : green;
		height : 300px;
	}
</style>
