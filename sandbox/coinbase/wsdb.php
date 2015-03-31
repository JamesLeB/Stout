<?php
class wsdb
{
	private $link_;

	public function __construct()
	{
		$c = file_get_contents('hide/james');
		$c = preg_split('/\s/',$c);
		$this->link_ = mysqli_connect('p:localhost',$c[0],$c[1],$c[2]);
	}
	public function punchOut($minion)
	{
		$size = $minion['size'];
		$cost = $minion['cost'];
		$price = $minion['price'];
		$profit = $size*$price - $size*$cost;

		$query = "INSERT INTO timecard 
			(id,size,cost,price,profit) values (1,?,?,?,?)";
/*
		$query = "update timecard set size=?,cost=?,price=?,profit=? where id = 1";
*/
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('ssss',$size,$cost,$price,$profit);
		$stmt->execute();
/*
*/
		

/*
		$query = "DROP TABLE timecard";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();

		$query = "CREATE TABLE timecard (
			id int,
			stamp timestamp,
			size  decimal(16,8),
			cost  decimal(16,8),
			price decimal(16,8),
			profit decimal(16,8)
		)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
*/

		return 1;
	}
	public function upload($a)
	{
		$o = json_decode($a,true);
		$stmt = '';
		switch($o['type'])
		{
			case 'received':
				$query = "INSERT INTO websocket (
					type,sequence,order_id,size,price,side,time) values (?,?,?,?,?,?,?)";
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('sssssss',$o['type'],$o['sequence'],
					$o['order_id'],$o['size'],$o['price'],$o['side'],$o['time']);
				$stmt->execute();
				break;
			case 'open':
				$query = "INSERT INTO websocket (type,sequence,
					side,price,order_id,remaining_size,time) values (?,?,?,?,?,?,?)";
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('sssssss',$o['type'],$o['sequence'],$o['side'],
					$o['price'],$o['order_id'],$o['remaining_size'],$o['time']);
				$stmt->execute();
				break;
			case 'done':
				$query = "INSERT INTO websocket (type,price,side,remaining_size,
					sequence,order_id,reason,time) values (?,?,?,?,?,?,?,?)";
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('ssssssss',$o['type'],$o['price'],$o['side'],
					$o['remaining_size'],$o['sequence'],$o['order_id'],$o['reason'],$o['time']);
				$stmt->execute();
				break;
			case 'match':
				$query = "INSERT INTO websocket (
					type,
					sequence,
					trade_id,
					maker_order_id,
					taker_order_id,
					side,
					size,
					price,
					time
					) values (?,?,?,?,?,?,?,?,?)
				";
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('sssssssss',
					$o['type'],
					$o['sequence'],
					$o['trade_id'],
					$o['maker_order_id'],
					$o['taker_order_id'],
					$o['side'],
					$o['size'],
					$o['price'],
					$o['time']
				);
				$stmt->execute();
				break;
		}

		return 1;
	}
	public function createTable()
	{
		$query = "DROP TABLE websocket";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$query = "CREATE TABLE websocket (
			sequence       int,
			time           datetime,
			type           varchar(8),
			side           varchar(4),
			price          decimal(16,8),
			size           decimal(16,8),
			remaining_size decimal(16,8),
			order_id       varchar(32),
			maker_order_id varchar(32),
			taker_order_id varchar(32),
			trade_id       varchar(32),
			reason         varchar(32)
		)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		return 1;
	}
}
?>
