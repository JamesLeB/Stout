<?php
class Exchange extends CI_Model
{

	private $db;

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('trader',true);
	}
	public function getCoinList()
	{
		$rows = array();
		$q = "select pair from bter where pair like '%_btc%' group by pair";
		#$q = "select pair from bter group by pair";
		$rs = $this->db->query($q);
		foreach($rs->result_array() as $row)
		{
			$r = array();
			$rows[] = $row['pair'];
		}
		return $rows;
	}
	public function getBuyCount($a)
	{
		$p = array($a);
		$q = "select count(pair) count from bter where pair = ? and type = 'buy'";
		$r = $this->db->query($q,$p);
		$c = 0;
		foreach($r->result_array() as $row)
		{
			$c = $row['count'];
		}
		return "$c";
	}
	public function getBuys($a)
	{
		$list    = array();
		$under24 = array();
		$under48 = array();

		$p = array($a);
		$q = "select * from bter where pair = ? and type = 'buy' order by time_stamp asc";
		$r = $this->db->query($q,$p);
		$start = 0;
		$current = time();
		foreach($r->result_array() as $row)
		{
			$start = $start ? $start : $row['time_stamp'];
			$time_stamp = $row['time_stamp'];
			$price      = $row['price'];
			$amount     = $row['amount'];
			$date       = $row['date'];
			$elaps = ($time_stamp - $start)   / (60);
			$age   = ($current - $time_stamp) / (60*60);
			$record = array($elaps,$price,$age,$date);
			$list[] = $record;
			if($age < 24){$under24[] = $record;} 
			if($age < 48){$under48[] = $record;} 
		}
		return array($list,$under24,$under48);
	}
	public function test()
	{
		$q = 'select pair,count(pair) as count from bter group by pair';
		$rs = $this->db->query($q);
		$rows = array();
		$ct = 0;
		foreach($rs->result_array() as $row)
		{
			$ct++;
			$r = array();
			$r[] = $row['pair'];
			$r[] = $row['count'];
			$rows[] = $r;
		}
		return $rows;
	}
	public function getExchanges(){
		$pairs = array();
		$pairs[] = array('name'=>'btc_uds');
		$pairs[] = array('name'=>'btc_cyn');
		$exchange = array(
			'name' => 'Bter',
			'pairs' => $pairs
		);
		return array($exchange);
	}
	public function getHistory(){
		$q = 'select pair,time_stamp,price,amount,tid,type,date from bter limit 100';
		$rs = $this->db->query($q);
		$rows = array();
		$ct = 0;
		foreach($rs->result_array() as $row)
		{
			$ct++;
			$rows[] = $row;
		}
		return $rows;
	}
}
?>
