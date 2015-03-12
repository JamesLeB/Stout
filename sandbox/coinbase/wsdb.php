<?php
class wsdb
{
	private $link_;

	public function __construct()
	{
		$c = file_get_contents('hide/james');
		$c = preg_split('/\s/',$c);
		$this->link_ = mysqli_connect('localhost',$c[0],$c[1],$c[2]);
	}
	public function upload($a)
	{
		$query = "INSERT INTO websocket (sequence) values (?)";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->bind_param('i',$a);
		$stmt->execute();

		return 1;
	}
	public function createTable()
	{
		$query = "DROP TABLE websocket";
		$stmt = mysqli_prepare($this->link_,$query);
		$stmt->execute();
		$query = "CREATE TABLE websocket (
			sequence       varchar(32),
			time           varchar(32),
			type           varchar(32),
			side           varchar(32),
			price          varchar(32),
			size           varchar(32),
			remaining_size varchar(32),
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
