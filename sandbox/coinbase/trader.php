<?php
class trader
{
	private $path;
	private $config;
	private $db;

	public function __construct()
	{
		require_once('database.php');
		$this->db = new database();
		$this->path = 'https://api.exchange.coinbase.com';

		$config = file_get_contents('hide/secret');
		$this->config = preg_split('/\s/',$config);
	}
	public function createTable()
	{
		$rs = $this->db->createTable();
		return $rs;
	}
	public function test()
	{
		return $this->kara;
	}
/*
	public function runOrderTable()
	{
		return $this->db->runOrderTable();
	}
*/
	public function moneyStamp($stamp)
	{
		$this->db->moneyStamp($stamp);
	}
	public function updateOrderProfit($id,$profit)
	{
		$this->db->updateOrderProfit($id,$profit);
	}
	public function updateOrderSold($id,$sold)
	{
		$this->db->updateOrderSold($id,$sold);
	}
	public function updateOrderCost($id,$cost)
	{
		$this->db->updateOrderCost($id,$cost);
	}
	public function updateOrderStatus($b,$status)
	{
		$this->db->updateOrderStatus($b,$status);
	}
	public function checkOpenBids($usd)
	{
		$a = $this->db->getOpenBids();
		$r = "";
		foreach($a as $b)
		{
			$status = json_decode($this->getOrderStatus($b),true);
			$r .= '<br/>'.$b."::".$status['status']."_".$status['done_reason'];
			if($status['status'] == 'done' && $status['done_reason'] == 'canceled')
			{
				$this->db->updateBidStatus($b,'canceled',$usd);
			}
			if($status['status'] == 'done' && $status['done_reason'] == 'filled')
			{
				$this->db->updateBidStatus($b,'filled',$usd);
			}
		}
		return "Open Orders".$r;
	}
	public function getOrderStatus($id)
	{
		$url = '/orders/'.$id;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$body = ''; #$body = json_encode($body);
		$signatureArray = $this->getSignatureArray($url,$body,'GET');

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$openOrders = curl_exec($curl);

		return $openOrders;
	}
	public function getOrders()
	{
		return $this->db->getOrders();

		/* This is old code I tried to get orders from server but this is too slow

		$url = '/orders';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$body = ''; #$body = json_encode($body);
		$signatureArray = $this->getSignatureArray($url,$body,'GET');

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$openOrders = curl_exec($curl);

		return $openOrders;
		*/
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
	public function getAccounts()
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

		$accounts = array();

		foreach($obj as $account)
		{
			if($account['currency'] == 'USD')
			{
				$accounts['usdBalance']   = round($account['balance'],4);
				$accounts['usdHold']      = round($account['hold'],4);
				$accounts['usdAvailable'] = round($account['available'],4);
			}
			if($account['currency'] == 'BTC')
			{
				$accounts['btcBalance']   = round($account['balance'],4);
				$accounts['btcHold']      = round($account['hold'],4);
				$accounts['btcAvailable'] = round($account['available'],4);
			}
		}
		return $accounts;
	}
	public function getOrderBook()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/book');
		$book = curl_exec($curl);
		$obj = json_decode($book,true);
		$orderBook = array();
		$orderBook['bidPrice'] = round($obj['bids'][0][0],2);
		$orderBook['bidSize']  = $obj['bids'][0][1];
		$orderBook['askPrice'] = round($obj['asks'][0][0],2);
		$orderBook['askSize']  = $obj['asks'][0][1];
		$orderBook['spread']   = round($obj['asks'][0][0] - $obj['bids'][0][0],2);

		return $orderBook;
	}
	public function cancelOrder($id)
	{
		$url = "/orders/$id";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.$url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

		$body = ''; #$body = json_encode($body);
		$signatureArray = $this->getSignatureArray($url,$body,'DELETE');

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$cancel = curl_exec($curl);

		return "Canceling Order: $cancel";
	}
	public function placeOrder($order)
	{
		$ms = 0;
		$a = array();
		$a['size']  = $order['size'];
		$a['price'] = $order['price'];
		$a['side']  = $order['side'];
		$a['product_id'] = $order['product_id'];

		$json = json_encode($a);
		$newOrder = $this->sendOrder($json);
		$newOrder = json_decode($newOrder,true);
		$order['serverId'] = $newOrder['id'];
		if($order['serverId']){$this->db->saveOrder($order);}
		$ms = $newOrder['id'];

		return $ms;
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
