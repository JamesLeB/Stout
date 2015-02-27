<?php
class trader
{
	private $kara;
	private $path;
	private $config;

	public function __construct()
	{
		$this->kara = "I love my wife";
		$this->path = 'https://api.exchange.coinbase.com';

		$config = file_get_contents('secret');
		$this->config = preg_split('/\s/',$config);
	}
	public function test()
	{
		return $this->kara;
	}
	public function getMarket()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/stats');
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$market = curl_exec($curl);
		$curl = curl_close();
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
		$signatureArray = $this->getSignatureArray($url,$body);

		curl_setopt($curl, CURLOPT_HTTPHEADER,$signatureArray);

		$accounts = curl_exec($curl);
		$curl = curl_close();
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
	public function getTrades()
	{
		$afterId = '410791';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->path.'/products/BTC-USD/trades');
		#curl_setopt($curl, CURLOPT_URL, $this->path."/products/BTC-USD/trades?after=$afterId");
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$trades = curl_exec($curl);
		$curl = curl_close();
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
	private function getSignatureArray($url,$body)
	{
		# Create Signature
		$key        = $this->config[1];
		$passphrase = $this->config[2];
		$secret     = $this->config[0];
		$timestamp = time();
		$method = 'GET';
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
