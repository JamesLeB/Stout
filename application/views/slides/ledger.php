<div id='ledger'>
	<div>
		<button>Setup</button>
		<button>Form</button>
		<button>Load</button>
	</div>
	<div>
		form goes here
	</div>
	<div>
		ledger goes here
	</div>
</div>
<script>
	// Setup button
	$('#ledger > :nth-child(1) > :nth-child(1)').click(function(){
		var target = 'index.php?/slides/ledger/setup';
		var request = $.post(target,'',function(data){
			$('#ledger > :nth-child(3)').html(data);
		});
	});
	// Hide Form button
	$('#ledger > :nth-child(2)').hide();
	$('#ledger > :nth-child(1) > :nth-child(2)').click(function(){
		$('#ledger > :nth-child(2)').toggle();
	});
	// LoadLedger button
	$('#ledger > :nth-child(1) > :nth-child(3)').click(function(){
		var target = 'index.php?/slides/ledger/loadLedger';
		var request = $.post(target,'',function(data){
			$('#ledger > :nth-child(3)').html(data);
		});
	});
	function deleteLedgerEntry(arg1){
		alert('Delete record '+arg1+'?');
		var target = 'index.php?/slides/ledger/deleteLedgerEntry/'+arg1;
		var request = $.post(target,'',function(data){
			$('#ledger > :nth-child(3)').html(data);
		});
	}
</script>
<style>
	#ledger div {
		margin : 5px;
		padding : 5px;
		border-style : ridge;
		border-width : 2px;
	}
	#ledger > :nth-child(1) {
		border-color : yellow;
	}
	#ledger > :nth-child(2) {
		border-color : red;
		height : 100px;
	}
	#ledger > :nth-child(3) {
		border-color : green;
		height : 300px;
	}
</style>
