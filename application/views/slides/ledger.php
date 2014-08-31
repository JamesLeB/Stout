<div id='ledger'>
	<div>
		<button>Setup</button>
		<button>Form</button>
		<button>Load</button>
	</div>
	<div>
		<form>
			<p>Add New Record</p> 
			<table>
			<tr>
				<td>Type</td>
				<td>
					<select name='recordType'>
						<option value='spending'>Spending</option>
						<option value='income'>Income</option>
					</select>
				</td>
				<td>Budget</td>
				<td>
					<select name='budget'>
						<option value='initial'>Initial</option>
						<option value='paycheck'>Paycheck</option>
					</select>
				</td>
				<td>Vendor</td>
				<td>
					<select name='vendor'>
						<option value='NA'>NA</option>
						<option value='NYU'>NYU</option>
						<option value='Segal'>Segal</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Account</td>
				<td>
					<select name='account'>
						<option value='j_citi_check'>j_citi_check</option>
						<option value='k_citi_check'>k_citi_check</option>
					</select>
				</td>
				<td>Amount</td>
				<td><input type='text' name='amount' /></td>
				<td><input type='submit' value='submit' /></td>
			</tr>
			</table>
		</form>
	</div>
	<div>
		ledger goes here
	</div>
</div>
<script>
	// Form Submit
	$('#ledger form').submit(function(){
		$('#stoutHeading').css('background','#006699');
		var thisForm = this;
		var val1 = this.recordType.value;
		var val2 = this.account.value;
		var val3 = this.budget.value;
		var val4 = this.vendor.value;
		var val5 = this.amount.value;

/*
		var mess = '';
		mess += val1+"\n";
		mess += val2+"\n";
		mess += val3+"\n";
		mess += val4+"\n";
		mess += val5+"\n";
		alert(mess);
*/
		
		var parm = '';
		parm += '/'+val1;
		parm += '/'+val2;
		parm += '/'+val3;
		parm += '/'+val4;
		parm += '/'+val5;

		//this.value1.value = '';
		var target = 'index.php?/slides/ledger/addRecord'+parm;
		var request=$.post(target,'',function(data){
			$('#ledger > :nth-child(3)').html(data);
			$('#stoutHeading').css('background','white');
		});
		return false;
	});
	// Setup button
	$('#ledger > :nth-child(1) > :nth-child(1)').click(function(){
		var target = 'index.php?/slides/ledger/setup';
		var request = $.post(target,'',function(data){
			$('#ledger > :nth-child(3)').html(data);
		});
	});
	// Hide Form button
	//$('#ledger > :nth-child(2)').hide();
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
	#ledger form{
		background : #3d504a;
	}
	#ledger form table td { border : 1px dashed gray; }
	#ledger div {
		margin  : 3px;
		padding : 3px;
	}
/*
		border-style : ridge;
		border-width : 2px;
	#ledger > :nth-child(1) {
		border-color : yellow;
	}
	#ledger > :nth-child(2) {
		border-color : red;
	}
	#ledger > :nth-child(3) {
		border-color : green;
	}
*/
</style>
