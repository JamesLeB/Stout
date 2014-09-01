<div id='accounts'>
	<div>
		<button>Setup</button>
		<button>Form</button>
		<button>Load</button>
	</div>
	<div>
		<form>
			<p>Add New Account</p> 
			<table>
			<tr>
				<td>Name</td>
				<td><input type='text' name='accountName' /></td>
				<td>Type</td>
				<td>
					<select name='recordType'>
						<option value='Checking'>Checking</option>
						<option value='Savings'>Savings</option>
						<option value='Credit'>Credit</option>
					</select>
				</td>
				<td><input type='submit' value='submit' /></td>
			</tr>
			</table>
		</form>
	</div>
	<div>
		Accounts goes here
	</div>
</div>
<script>
	// Form Submit
	$('#accounts form').submit(function(){
		$('#stoutHeading').css('background','#006699');
		var thisForm = this;
		var val1 = this.accountName.value;
		var val2 = this.recordType.value;

		var parm = '';
		parm += '/'+val1;
		parm += '/'+val2;

		//this.value1.value = '';
		var target = 'index.php?/slides/accounts/addRecord'+parm;
		var request=$.post(target,'',function(data){
			$('#accounts > :nth-child(3)').html(data);
			$('#stoutHeading').css('background','white');
		});
		return false;
	});
	// Setup button
	$('#accounts > :nth-child(1) > :nth-child(1)').click(function(){
		var target = 'index.php?/slides/accounts/setup';
		var request = $.post(target,'',function(data){
			$('#accounts > :nth-child(3)').html(data);
		});
	});
	// Hide Form button
	//$('#ledger > :nth-child(2)').hide();
	$('#accounts > :nth-child(1) > :nth-child(2)').click(function(){
		$('#accounts > :nth-child(2)').toggle();
	});
	// LoadLedger button
	$('#accounts > :nth-child(1) > :nth-child(3)').click(function(){
		var target = 'index.php?/slides/accounts/loadList';
		var request = $.post(target,'',function(data){
			$('#accounts > :nth-child(3)').html(data);
		});
	});
	function deleteAccount(arg1){
		alert('Delete record '+arg1+'?');
		var target = 'index.php?/slides/accounts/deleteRecord/'+arg1;
		var request = $.post(target,'',function(data){
			$('#accounts > :nth-child(3)').html(data);
		});
	}
</script>
<style>
	#accounts form{
		background : #3d504a;
	}
	#accounts form table td { border : 1px dashed gray; }
	#accounts div {
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
