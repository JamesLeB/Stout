	<h3>Post Bid</h3>
	<form id='postBid' method = 'post'>
		<table>
			<tr>
				<td>Price</td>
				<td><input type='text' name='price'</td>
			</tr>
			<tr>
				<td>Amount</td>
				<td><input type='text' name='amount'</td>
			</tr>
			<tr>
				<td><input type='submit' value='BID'</td>
			</tr>
		</table>
	</form>
	<h3>Open Bids</h3>
	<div id='openBids'></div>
	<h3>Cancel Bid</h3>
	<form id='cancelBid' method = 'post'>
		<table>
			<tr>
				<td>Bid</td>
				<td>
					<select id='cancelBidId' name='cancelBidId'>
					</select>
				</td>
				<td><input type='submit' value='Cancel'</td>
			</tr>
		</table>
	</form>
	<h3>Confirm Buy</h3>
	<form id='confirmBid' method = 'post'>
		<table>
			<tr>
				<td>Bid</td>
				<td>
					<select id='confirmBidId' name='confirmBidId'>
					</select>
				</td>
				<td><input type='submit' value='Confirm'</td>
			</tr>
		</table>
	</form>
