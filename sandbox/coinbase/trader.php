<?php
class trader
{
	private $kara;
	private $path;
	private $config;
	private $db;

	public function __construct()
	{
		require_once('database.php');
		$this->db = new database();
		$this->kara = "I love my wife";
		$this->path = 'https://api.exchange.coinbase.com';

		$config = file_get_contents('secret');
		$this->config = preg_split('/\s/',$config);
	}
	public function testDB()
	{
		$rs = $this->db->createTable();
		return $rs;
	}
	public function test()
	{
		return $this->kara;
	}
	public function getOpenOrders()
	{
		$url = '/orders';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$body = ''; #$body = json_encode($body);
		$signatureArray = $this->getSignatureArray($url,$body,'GET');

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$openOrders = curl_exec($curl);
		#$curl = curl_close();
		$obj = json_decode($openOrders,true);

		$t = 'nothing';
		if(sizeof($obj))
		{
			$a = $obj;
			$keys = array_keys($a[0]);
		
			$b = '';
			$c = array();
			$c[] = array('key','value');
			foreach($keys as $key)
			{
				$c = array($key,$a[0][$key]);
			}
			$t = $this->array2table($c);
		}
		return $openOrders."<br/>*************<br/>".$t;
	}
	public function getLastBid()
	{
		$rs = $this->db->getLastBid();
		return $rs;
	}
	public function getMarket()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/stats');
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$market = curl_exec($curl);
		#$curl = curl_close();
		return $market;
	}
	public function getAccounts($type)
	{
		$url = '/accounts';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$body = ''; #$body = json_encode($body);
		$signatureArray = $this->getSignatureArray($url,$body,'GET');

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$accounts = curl_exec($curl);
		$obj = json_decode($accounts,true);

		$usdBalance = 0;
		$usdHold = 0;
		$usdAvailable = 0;

		$btcBalance = 0;
		$btcHold = 0;
		$btcAvailable = 0;

		foreach($obj as $account)
		{
			if($account['currency'] == 'USD')
			{
				$usdBalance   = $account['balance'];
				$usdHold      = $account['hold'];
				$usdAvailable = $account['available'];
			}
			if($account['currency'] == 'BTC')
			{
				$btcBalance   = $account['balance'];
				$btcHold      = $account['hold'];
				$btcAvailable = $account['available'];
			}
		}

		switch($type)
		{
			case 'usda':
				return $usdAvailable;
				break;
			case 'btca':
				return $btcAvailable;
				break;
			case 'available':
				return array($usdAvailable,$btcAvailable);
				break;
			default:
				$myAccounts = array();
				$myAccounts[] = "-----------------";
				$myAccounts[] = "Account Report";
				$myAccounts[] = "-------";
				$myAccounts[] = "USD Balance: $usdBalance";
				$myAccounts[] = "USD Hold: $usdHold";
				$myAccounts[] = "USD Available: $usdAvailable";
				$myAccounts[] = "-------";
				$myAccounts[] = "BTC Balance: $btcBalance";
				$myAccounts[] = "BTC Hold: $btcHold";
				$myAccounts[] = "BTC Available: $btcAvailable";
				$myAccounts[] = "-------";
				return implode('<br/>',$myAccounts);
		}
	}
	public function getOrderBook($quest)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/book');
		$book = curl_exec($curl);
		#$curl = curl_close();
		$obj = json_decode($book,true);
		$bidPrice = $obj['bids'][0][0];
		$bidSize  = $obj['bids'][0][1];
		$askPrice = $obj['asks'][0][0];
		$askSize  = $obj['asks'][0][1];
		$spread   = $askPrice - $bidPrice;
		$rtn = 'default';
		switch($quest)
		{
			case 'bid':
				$rtn = array($bidPrice,$spread);
				break;
			case 'ask':
				$rtn = array($askPrice,$spread);
				break;
			case 'book':
				$rtn = array($bidPrice,$spread,$askPrice);
				break;
			default:
				$h = '****************<br/>';
				$h .= "Bid Price: $bidPrice<br/>";
				$h .= "Bid Size: $bidSize<br/>";
				$h .= "Ask Price: $askPrice<br/>";
				$h .= "Ask Size: $askSize<br/>";
				$h .= "Spread: $spread<br/>";
				$h .= '****************';
				$rtn = "$book<br/>$h";
		}
		return $rtn;
	}
	public function placeOrder($quest)
	{
		$rtn = "default return";
		$log = "log status";
		$responce = "Coinbase responce";
		switch($quest)
		{
			case 'bid':

				$balance = $this->getAccounts('available');
				$price   = $this->getOrderBook('bid');
				$bidPrice = $price[0] + .01;
				$size    = round(($balance[0] - .01) / $bidPrice,8);
				$side    = "buy";# buy or sell
				$product = "BTC-USD";
				$cost    = $size * $bidPrice;

				if($balance[0] <= .02){$rtn = 'no usd spend'; break; }
				if($price[1] <= .03){$rtn = 'no spread'; break; }

				$rtn = "BID ";
				$rtn .= "size: $size ";
				$rtn .= "price: $bidPrice ";
				$rtn .= "cost: $cost ";
				$rtn .= "spread: $price[1] ";

				$order = array();
				$order['size']  = round($size,8);
				$order['price'] = $bidPrice;
				$order['side'] = $side;
				$order['product_id'] = $product;
				
				$state = array();
				$state['USD'] = round($balance[0],8);
				$state['BTC'] = round($balance[1],8);
				$state['spread'] = round($price[1],8);

				$db = new database();
				$rs = $this->db->saveOrder($order,$state);
				$log = "Order Saved";

				$order = json_encode($order);
				$responce = $this->sendOrder($order);

				break;

			case 'ask':

				$balance = $this->getAccounts('available');
				$price   = $this->getOrderBook('ask');
				$askPrice = $price[0]-.01;
				$size    = $balance[1];
				$sale    = ($askPrice) * $size;
				$side    = "sell";# buy or sell
				$product = "BTC-USD";
				
				if($size <= 0){$rtn = 'no btc to sell'; break; }

				$rtn = "ASK ";
				$rtn .= "size: $size ";
				$rtn .= "price: $askPrice ";
				$rtn .= "sale: $sale ";
				$rtn .= "spread: $price[1] ";

				$order = array();
				$order['size']  = round($size,8);
				$order['price'] = $askPrice;
				$order['side'] = $side;
				$order['product_id'] = $product;
				
				$state = array();
				$state['USD'] = round($balance[0],8);
				$state['BTC'] = round($balance[1],8);
				$state['spread'] = round($price[1],8);

				$db = new database();
				$rs = $db->saveOrder($order,$state);
				$log = 'Order Saved';

				$order = json_encode($order);
				$responce = $this->sendOrder($order);

				break;
		}
		return array($rtn,$log,$responce);
	}
	private function sendOrder($body)
	{
		$url = '/orders';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		$signatureArray = $this->getSignatureArray($url,$body,'POST');
		$signatureArray[] = "Content-Type: application/json";
		$length = strlen($body);
		$signatureArray[] = "Content-Length: $length";
		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);
		$order = curl_exec($curl);
		#$curl = curl_close();
		return $order;
	}
	public function getTrades()
	{
		$afterId = '410791';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/trades');
		#curl_setopt($curl, CURLOPT_URL, $this->path."/products/BTC-USD/trades?after=$afterId");
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$trades = curl_exec($curl);
		#$curl = curl_close();
		$obj = json_decode($trades,true);

		$a = array();
		$a[] = array('index','time','trade','price','size','side');

		$afterId;
		$count = 0;
		foreach($obj as $trade)
		{
			$count++;
			$time     = substr($trade['time'],0,19);
			$trade_id = $trade['trade_id'];
			$price    = $trade['price'];
			$size     = $trade['size'];
			$side     = $trade['side'];

			$afterId = $trade_id;

			$a[] = array($count,$time,$trade_id,$price,$size,$side);
		}
		return $this->array2table($a);
	}
	# Utility functions
	private function getSignatureArray($url,$body,$method)
	{
		# Create Signature
		$key        = $this->config[1];
		$passphrase = $this->config[2];
		$secret     = $this->config[0];
		$timestamp = time();
		#$method = 'GET';
		$what = $timestamp.$method.$url.$body;
		$signature = base64_encode(hash_hmac("sha256",$what, base64_decode($secret), true));

		$signatureArray = array(
			"CB-ACCESS-KEY: $key",
			"CB-ACCESS-SIGN: $signature",
			"CB-ACCESS-TIMESTAMP: $timestamp",
			"CB-ACCESS-PASSPHRASE: $passphrase"
		);

		return $signatureArray;
	}
	private function array2table($a)
	{
		$table = "<table>";
		$h = array_shift($a);
		$table .= "<tr>";
		foreach($h as $hh)
		{
			$table .= "<td>$hh</td>";
		}
		$table .= "</tr>";
		foreach($a as $row)
		{
			$table .= "<tr>";
			foreach($row as $item)
			{
				$table .= "<td>$item</td>";
			}
			$table .= "</tr>";
		}
		$table .= "</table>";
		return $table;
	}
}
?>
