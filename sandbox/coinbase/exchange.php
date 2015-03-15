<?php
class exchange
{
	private $path;

	public function __construct()
	{
		$this->path = 'https://api.exchange.coinbase.com';
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
}
?>
