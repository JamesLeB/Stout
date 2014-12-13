<?php

class localdb {
	
	private $db;
	private $user_;
	private $pass_;
	private $base_;
	private $link_;

	public function __construct(){
		$c = file_get_contents('../../files/james');
		$c = preg_split('/\s/',$c);
		$this->user_ = $c[0];
		$this->pass_ = $c[1];
		$this->base_ = $c[2];
		$this->link_ = mysqli_connect('localhost',$this->user_,$this->pass_,$this->base_);
	}
	public function test(){
		return "testing";
	}
	public function getBterTrade($trade){
		$query = $this->getQuery(5);
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('i',$tid);
		$tid = $trade['tid'];
		$stmt->execute();
		$stmt->bind_result($stamp,$price,$amount,$type);
		$stmt->fetch();
		return array($stamp,$price,$amount,$type);
	}
	public function checkBterTrade($trade){
		$r = 0;
		$query = $this->getQuery(5);
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('i',$tid);
		$tid = $trade['tid'];
		$stmt->execute();
		$stmt->bind_result($stamp,$price,$amount,$type);
		$stmt->fetch();
		if(
			$stamp  == $trade['timeStamp'] && 
			$price  == $trade['price'] &&
			$amount == $trade['amount'] &&
			$type   == $trade['type']
		){
			$r = 1;
		}
		return $r;
	}
	public function insertBterTrade($trade){
		$r = 0;
		if($this->link_ && 1){
			$query = $this->getQuery(4);
			$stmt = mysqli_prepare($this->link_,$query);
			$stmt->bind_param('iddiss',$time_stamp,$price,$amount,$tid,$type,$date);
			$time_stamp = $trade['timeStamp'];
			$price      = $trade['price'];
			$amount     = $trade['amount'];
			$tid        = $trade['tid'];
			$type       = $trade['type'];
			$date       = $trade['date'];
			$r = $stmt->execute() ? 1 : 0;
		}
		return $r;
	}
	public function execute($x){
		$m = array();
		#$link = mysqli_connect('localhost',$this->user_,$this->pass_,$this->base_);
		if($this->link_){
			$m[] = 'Connection Good';
			if(0){
				# Insert with parm example
				$query = $this->getQuery(4);
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('iddiss',$time_stamp,$price,$amount,$tid,$type,$date);
				$time_stamp = 10;
				$price      = 1.2;
				$amount     = 2.3;
				$tid        = 1;
				$type       = "New";
				$date       = "2014-11-01";
				$stmt->execute();
			}
			if(0){
				# Select with parm example
				$query = $this->getQuery(5);
				$stmt = mysqli_prepare($this->link_,$query);
				$stmt->bind_param('s',$a);
				$a = "hello";
				$stmt->execute();
				$stmt->bind_result($col1);
				while($stmt->fetch()){
					$m[] = $col1;
				}
			}
			if(1){
				# NO parm sample
				$query = $this->getQuery($x);
				$result = $this->link_->query($query);
				#while($row = mysqli_fetch_array($result)){$m[] = $row[0];}
			}
			#$a = mysqli_fetch_fields($result);
			#foreach($a as $h){$m[] = $h->name;}
			#$m[] = "ROWS: ".mysqli_num_rows($result);
		}else{
			$m[] = 'Connection Bad';
		}
		return implode('<br/>',$m);
	}
	private function getQuery($x){
		switch($x){
			case 0:
				return "DROP TABLE bter";
			case 1:
				return "
					CREATE TABLE bter (
						time_stamp int,
						price decimal(16,8),
						amount decimal(16,8),
						tid int NOT NULL PRIMARY KEY,
						type varchar(8),
						date datetime
					)
				";
			case 2:
				return "SHOW COLUMNS FROM bter";
			case 3:
				return "SELECT * FROM bter";
			case 4:
				return "
					INSERT INTO bter (
						time_stamp,
						price,
						amount,
						tid,
						type,
						date
					) values (?,?,?,?,?,?)
				";
			case 5:
				return "SELECT time_stamp,price,amount,type FROM bter WHERE tid = ?";
			case 6:
				return "DELETE FROM bter";
		}
	} # END getQuery function

} # END CLASS

?>
