<?php
class exchange
{
	private $path;
	private $config;

	public function __construct()
	{
		$this->path = 'https://api.exchange.coinbase.com';

		$config = file_get_contents('hide/secret');
		$this->config = preg_split('/\s/',$config);
	}
	public function getOrderBook()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/book?level=3');
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$orderBook = curl_exec($curl);
		return $orderBook;
	}
	public function getBalance()
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

		return $accounts;

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

		$orders = curl_exec($curl);

		return $orders;
	}
	public function placeOrder($size,$price,$side)
	{
		//$size = .01;
		//$price = 999;
		//$side = 'buy';
		$product = 'BTC_USD';

		$ms = 0;
		$a = array();
		$a['size']  = $size;
		$a['price'] = $price;
		$a['side']  = $side;
		$a['product_id'] = $product;

		return "ORDERING!!";
/*

		$json = json_encode($a);
		$newOrder = $this->sendOrder($json);
		$newOrder = json_decode($newOrder,true);
		$order['serverId'] = $newOrder['id'];
		if($order['serverId']){$this->db->saveOrder($order);}
		$ms = $newOrder['id'];

		return $ms;

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
*/

	}
	private function getSignatureArray($url,$body,$method)
	{
		# Create Signature
		$key        = $this->config[1];
		$passphrase = $this->config[2];
		$secret     = $this->config[0];
		$timestamp = time();
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
/*
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
*/
}
?>
