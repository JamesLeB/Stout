<html>
<head>
	<link rel='stylesheet' type='text/css' href='style.css' />
	<script src='jquery-1.11.1.js'></script>
	<script src='script.js'></script>
<!---
--!>
</head>
<body>
	<div id='clock'></div>
	<div id='status'></div>
	<div id='debug'>Debug</div>
	<div id='exchange'>
		<div>
			<div>Accounts</div>
			<div>
				<div>USD</div>
				<div>Amount</div>
				<div>mode</div>
				<div>
					<button>A</button>
					<button>B</button>
					<button>C</button>
				</div>
			</div>
			<div>
				<div>BTC</div>
				<div>Amount</div>
				<div>Cost</div>
				<div>Net</div>
			</div>
		</div>
		<div>
			<div>
				<div>Trader</div>
				<div>
					Auto <input type='radio' name='traderMode' value='auto' checked>
					Fixed<input type='radio' name='traderMode' value='fixed'>
				</div>
			</div>
			<div>
				<div>Bid</div>
				<div>Amount</div>
				<div>
					<button>+</button>
					<button>-</button>
					<button>Bid</button>
				</div>
				<div>Ask</div>
				<div>Amount</div>
				<div>
					<button>+</button>
					<button>-</button>
					<button>Ask</button>
				</div>
			</div>
			<div>
				<div>Size</div>
				<div>Amount</div>
				<div>
					<button>+</button>
					<button>-</button>
				</div>
			</div>
		</div>
		<div>
			<div>Orders</div>
			<div>
				<div>Bids</div>
				<div>
				</div>
			</div>
			<div>
				<div>Asks</div>
				<div>
				</div>
			</div>
		</div>
		<div>
			<div>Book</div>
			<div>
				<div>Bid</div>
				<div>Spread</div>
				<div>Ask</div>
			</div>
			<div>Bids</div>
			<div>Asks</div>
		</div>
		<div>
			<div>Trades</div>
			<div>Buys</div>
			<div>Sells</div>
		</div>
	</div>
</body>
</html>