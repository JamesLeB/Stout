<div id='character'>
	<div>
		<button>Setup</button>
		<button>Form</button>
		<button>Load</button>
	</div>
	<div>
		<p>New Character Form</p> 
		<form>
			<table>
				<tr>
					<td><?php echo $block1 ?></td>
					<td><?php echo $block2 ?></td>
				</tr>
				<tr>
					<td><input type='submit' value='submit' /></td>
				</tr>
			</table>
		</form>
	</div>
	<div>
		Character List
	</div>
</div>
<script>
	// Form Submit
	$('#character form').submit(function(){
		$('#stoutHeading').css('background','#006699');
		var thisForm = this;
		var val1 = this.characterName.value;
		var val2 = this.characterRace.value;
		var val3 = this.characterClass.value;

		this.characterName.value = '';
		this.characterRace.value = 'Human';
		this.characterClass.value = 'Fighter';

		var parm = '';
		parm += '/'+val1;
		parm += '/'+val2;
		parm += '/'+val3;

		//this.value1.value = '';
		var target = 'index.php?/slides/character/addRecord'+parm;
		var request=$.post(target,'',function(data){
			$('#character > :nth-child(3)').html(data);
			$('#stoutHeading').css('background','white');
			// Hide form
			$('#character > :nth-child(2)').hide();
		});
		return false;
	});
	// Setup button
	$('#character > :nth-child(1) > :nth-child(1)').click(function(){
		var target = 'index.php?/slides/character/setup';
		var request = $.post(target,'',function(data){
			$('#character > :nth-child(3)').html(data);
			// Hide form
			$('#character > :nth-child(2)').hide();
		});
	});
	// Hide Form button
	$('#character > :nth-child(1) > :nth-child(2)').click(function(){
		$('#character > :nth-child(2)').toggle();
	});
	// LoadLedger button
	$('#character > :nth-child(1) > :nth-child(3)').click(function(){
		var target = 'index.php?/slides/character/loadList';
		var request = $.post(target,'',function(data){
			$('#character > :nth-child(3)').html(data);
		});
	});
	function deleteCharacter(arg1){
		alert('Delete record '+arg1+'?');
		var target = 'index.php?/slides/character/deleteRecord/'+arg1;
		var request = $.post(target,'',function(data){
			$('#character > :nth-child(3)').html(data);
		});
	}
</script>
<style>
	#character form{
		background : #3d504a;
	}
	#character form table td { border : 1px dashed gray; }
	#character div {
		margin  : 3px;
		padding : 3px;
	}
	/* Moving name race and class block to top of <td> */
	#character form > table > tbody > tr:nth-child(1) > td:nth-child(1) {
		vertical-align : top;
	}
	#newCharacterAttributes input {
		width : 70px;
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
