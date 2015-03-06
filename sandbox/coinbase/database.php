<?php
class database
{
	private $kara;
	private $user_;
	private $pass_;
	private $base_;
	private $link_;

	public function __construct()
	{
		$this->kara = "I love my wife";
		$c = file_get_contents('james');
		$c = preg_split('/\s/',$c);
		$this->user_ = $c[0];
		$this->pass_ = $c[1];
		$this->base_ = $c[2];
		$this->link_ = mysqli_connect('localhost',$this->user_,$this->pass_,$this->base_);
	}
	public function test()
	{
		$query = "CREATE TABLE orders (
			id int primary key not null auto_increment,
			time timestamp,
			size float,
			price float,
			type varchar(4),
			product varchar(16),
			usd float,
			btc float,
			spread float
		)";
		#$stmt = mysqli_prepare($this->link_,$query);
		#$stmt->execute();
		return "Creating lot table";
	}
	public function getLastBid()
	{
		return "getting last bid in database";
	}
	public function saveOrder($order,$state)
	{
		$a = json_encode($order);
		$b = json_encode($state);

		$query = "INSERT INTO orders (type,size,price,product,usd,btc,spread) values (?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('sddsddd',$type,$size,$price,$product,$usd,$btc,$spread);
		$type    = $order['side'];
		$size    = $order['size'];
		$price   = $order['price'];
		$product = $order['product_id'];
		$usd     = $state['USD'];
		$btc     = $state['BTC'];
		$spread  = $state['spread'];
		$stmt->execute();

		return "saving order<br/>$a<br/>$b";
	}
	public function createTable()
	{
		$query = "CREATE TABLE orders (
			id int primary key not null auto_increment,
			time timestamp,
			size float,
			price float,
			type varchar(4),
			product varchar(16),
			usd float,
			btc float,
			spread float
		)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		return "Creating table script";
	}
}
?>
