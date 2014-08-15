	<h3>Inventory</h3>
	<div id='inventory'></div>
	<h3>Post Ask</h3>
	<form id='postAsk' method = 'post'>
		<table>
			<tr>
				<td>Lot Number</td>
				<td>
					<select id='postAskId' name='postAskId'>
					</select>
				</td>
				<td>Asking Price</td>
				<td><input type='text' name='price'</td>
				<td><input type='submit' value='Post'</td>
			</tr>
		</table>
	</form>
	<h3>Open Asks</h3>
	<div id='openAsks'></div>
	<h3>Cancel Ask</h3>
	<form id='cancelAsk' method = 'post'>
		<table>
			<tr>
				<td>Ask</td>
				<td>
					<select id='cancelAskId' name='cancelAskId'>
					</select>
				</td>
				<td><input type='submit' value='Cancel'</td>
			</tr>
		</table>
	</form>
	<h3>Confirm Sale</h3>
	<form id='confirmAsk' method = 'post'>
		<table>
			<tr>
				<td>Ask</td>
				<td>
					<select id='confirmAskId' name='confirmAskId'>
					</select>
				</td>
				<td><input type='submit' value='Confirm'</td>
			</tr>
		</table>
	</form>
