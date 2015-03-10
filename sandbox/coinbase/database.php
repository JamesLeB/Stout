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
	public function getOrders()
	{
		$orders = array();
/*
		$order1 = array('my','first','buy order');
		$order2 = array('my','second','sell order');
		$a[] = $order1;
		$a[] = $order2;
*/

		$query =
		"
			SELECT id,size,price,type,status,serverId,cost,sold
			FROM orders
			WHERE status = 'filled' or status = 'NEW'
		";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$stmt->bind_result($id,$size,$price,$type,$status,$serverId,$cost,$sold);
		while($stmt->fetch())
		{
			$cost = $cost ? $cost : '-';
			$sold = $sold ? $sold : '-';
			$line = array(
				'id'       => $id,
				'size'     => round($size,2),
				'price'    => round($price,2),
				'type'     => $type,
				'status'   => $status,
				'serverId' => $serverId,
				'cost'     => round($cost,2),
				'sold'     => round($sold,2)
			);
			$orders[] = $line;
		}
		return $orders;
	}
/*
	public function runOrderTable()
	{
		$html = '';

		$orders = array();
		$buyOrders = array();
		$sellOrders = array();

		$query = "SELECT id,size,price,type,status,usd,cost from orders";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$stmt->bind_result($id,$size,$price,$type,$status,$usd,$cost);
		while($stmt->fetch())
		{
			$line = array(
				$id,
				round($size,2),
				$price,
				$type,
				$status,
				$usd,
				$cost
			);
			$orders[] = $line;
			if($type=='buy'&&$status=='filled'){ $buyOrders[] = $line; }
			if($type=='sell'){ $sellOrders[] = $line; }
		}

foreach($sellOrders as $order)
{
	$buy = array_shift($buyOrders);
	$cost = $buy ? $buy[2] : -1;
	$this->updateOrderCost($order[0],$cost);
	$this->updateOrderSold($buy[0],$order[1]);
}

		$html = '<table>';
		foreach($sellOrders as $c)
		{
			$html .= '<tr>';
			foreach($c as $d)
			{
				$html .= '<td>'.$d.'</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}
*/
	public function updateOrderCost($id,$cost)
	{
		$query = "UPDATE orders set cost = ? where id = ?";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('di',$cost,$id);
		$stmt->execute();
	}
	public function updateOrderProfit($id,$profit)
	{
		$query = "UPDATE orders set profit = ? where id = ?";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('di',$profit,$id);
		$stmt->execute();
	}
	public function updateOrderSold($id,$sold)
	{
		$query = "UPDATE orders set sold = ? where id = ?";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('di',$sold,$id);
		$stmt->execute();
	}
	public function updateOrderStatus($id,$newStatus)
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
			serverId varchar(64),
			cost float,
			profit float,
			sold float
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
