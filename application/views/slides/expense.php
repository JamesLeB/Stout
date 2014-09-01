<div id='accounts'>
	<div>
		<button>Setup</button>
		<button>Form</button>
		<button>Load</button>
	</div>
	<div>
		<form>
			<p>Add New Expense</p> 
			<table>
			<tr>
				<td>Name</td>
				<td><input type='text' name='expenseName' /></td>
				<td>Type</td>
				<td>
					<select name='recordType'>
						<option value='type1'>type1</option>
						<option value='type2'>type2</option>
					</select>
				</td>
				<td><input type='submit' value='submit' /></td>
			</tr>
			</table>
		</form>
	</div>
	<div>
		Expenses goes here
	</div>
</div>
<script>
	// Form Submit
	$('#expense form').submit(function(){
		$('#stoutHeading').css('background','#006699');
		var thisForm = this;
		var val1 = this.expenseName.value;
		var val2 = this.recordType.value;

		var parm = '';
		parm += '/'+val1;
		parm += '/'+val2;

		//this.value1.value = '';
		var target = 'index.php?/slides/expense/addRecord'+parm;
		var request=$.post(target,'',function(data){
			$('#expense > :nth-child(3)').html(data);
			$('#stoutHeading').css('background','white');
		});
		return false;
	});
	// Setup button
	$('#expense > :nth-child(1) > :nth-child(1)').click(function(){
		var target = 'index.php?/slides/expense/setup';
		var request = $.post(target,'',function(data){
			$('#expense > :nth-child(3)').html(data);
		});
	});
	// Hide Form button
	//$('#ledger > :nth-child(2)').hide();
	$('#expense > :nth-child(1) > :nth-child(2)').click(function(){
		$('#expense > :nth-child(2)').toggle();
	});
	// LoadLedger button
	$('#expense > :nth-child(1) > :nth-child(3)').click(function(){
		var target = 'index.php?/slides/expense/loadList';
		var request = $.post(target,'',function(data){
			$('#expense > :nth-child(3)').html(data);
		});
	});
	function deleteExpense(arg1){
		alert('Delete record '+arg1+'?');
		var target = 'index.php?/slides/expense/deleteRecord/'+arg1;
		var request = $.post(target,'',function(data){
			$('#expense > :nth-child(3)').html(data);
		});
	}
</script>
<style>
	#expense form{
		background : #3d504a;
	}
	#expense form table td { border : 1px dashed gray; }
	#expense div {
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
