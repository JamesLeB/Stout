<?php
class minions
{
	private $x;

	public function __construct()
	{
	}
	public function act()
	{
		$adam = $_SESSION['count'];

		$usd = 20;
		$btc = 1;
		$size = .1;
		$bid = 200;
		$ask = 203;
		$spread = $ask - $bid;

		$minions = [];

		$m1 = array(
			'id'      => 1,
			'cost'    => '',
			'price'   => '',
			'size'    => '',
			'orderId' => '',
			'state'   => '0000'
		);

		$m2 = array(
			'id'      => 2,
			'cost'    => '',
			'price'   => '',
			'size'    => '',
			'orderId' => '',
			'state'   => '0000'
		);

		$a = [];
		$a[] = $m1;
		$a[] = $m2;
		foreach($a as $b)
		{
			$mId      = $b['id'];
			$mCost    = $b['cost'];
			$mPrice   = $b['price'];
			$mSize    = $b['size'];
			$mOrderId = $b['orderId'];
			$mState   = $b['state'];

			$minions[] = "
				<div class='minion'>
					Id:      $mId - 
					Cost:    $mCost - 
					Price:   $mPrice - 
					Size:    $mSize - 
					OrderId: $mOrderId - 
					State:   $mState 
				</div>
			";
		}

		$html = '';
		$html .= "
			<div>$adam  - USD: $usd  - BTC: $btc  - Size: $size  - Bid: $bid  - Ask: $ask
			</div>";

		$html .= '<div>';
		foreach($minions as $minion)
		{
			$html .= $minion;
		}
		$html .= '</div>';

		$html .= "
			<style>
				.minion
				{
					border: 1px solid black;
					margin: 5px;
					padding: 5px;
				}
			</style>
			<script>
				$('.minion').click(function()
				{
					$(this).css('background','yellow');
				})
			</script>
		";

		return $html;
	}
}
?>
