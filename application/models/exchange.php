<?php
class Exchange extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('trader',true);
	}
	public function test(){
		$q = 'select pair,count(pair) from bter group by pair';
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
