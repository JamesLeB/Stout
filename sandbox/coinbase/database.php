<?php
class database
{
	private $kara;

	public function __construct()
	{
		$this->kara = "I love my wife";
	}
	public function test()
	{
		return $this->kara;
	}
	public function saveOrder($order,$state)
	{
		$a = json_encode($order);
		$b = json_encode($state);
		return "saving order<br/>$a<br/>$b";
	}
}
?>
