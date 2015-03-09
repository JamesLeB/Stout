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
		return "Creating lot table";
	}
	public function updateBidStatus($id,$newStatus)
	{
		$query = "UPDATE orders set status = ? where serverId = ?";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('ss',$status,$serverId);
		$status = $newStatus;
		$serverId = $id;
		$stmt->execute();
		return "in update bid status $id::$newStatus";
	}
	public function getLastBid()
	{
		return "getting last bid in database";
	}
	public function saveOrder($order)
	{
		$nextIndex = 1;
		$query = "SELECT max(id) from orders";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$stmt->bind_result($col1);
		while($stmt->fetch())
		{
			$nextIndex = $col1 + 1;
		}
		
		$query = "INSERT INTO orders (id,type,size,price,product,status,serverId) values (?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('isddsss',$index,$type,$size,$price,$product,$status,$serverId);
		$index    = $nextIndex;
		$type     = $order['side'];
		$size     = $order['size'];
		$price    = $order['price'];
		$product  = $order['product_id'];
		$status   = 'NEW';
		$serverId = $order['serverId'];
		$stmt->execute();

		return 1;
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
			status varchar(16),
			serverId varchar(64)
		)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		return "Creating table script";
	}
	public function getOpenBids()
	{
		$a = array();
		$query = "SELECT serverId from orders WHERE status = 'NEW'";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$stmt->bind_result($serverId);
		while($stmt->fetch())
		{
			$a[] = $serverId;
		}
		return $a;
	}
}
?>
