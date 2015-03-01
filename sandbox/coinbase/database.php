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
		return $this->kara;
	}
	public function saveOrder($order,$state)
	{
		$a = json_encode($order);
		$b = json_encode($state);

		$query = "INSERT INTO orders (type,size,price,product,usd,btc) values (?,?,?,?,?,?)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('sddsdd',$type,$size,$price,$product,$usd,$btc);
		$type    = $order['side'];
		$size    = $order['size'];
		$price   = $order['price'];
		$product = $order['product_id'];
		$usd     = $state['USD'];
		$btc     = $state['BTC'];
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
			btc float
		)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		return "Creating table script";
	}
}
?>
