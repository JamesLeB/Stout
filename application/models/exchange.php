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
		$q = 'select pair from bter group by pair';
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
		return "16 $a";
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

/*
$pair = $row['pair'];
$parm = array($pair);
$sq = "select * from bter where pair = ?";
$rs1 = $this->db->query($sq,$parm);
$list = array();
foreach($rs1->result_array() as $row1)
{
	$list[] = $row1;
}
*/
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
