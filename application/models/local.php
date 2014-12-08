<?php
class Local extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('local',true);
	}
	function test(){
		return "testing shit";
	}
	function go(){
		$test = $this->getTableList();
		return json_encode($test);
	}
	private function getTableList(){
		$query = 'show tables';
		$rs = $this->db->query($query);
		$rtn = array();
		foreach($rs->result_array() as $row){
			$rtn[] = $row['Tables_in_trader'];
		}
		return $rtn;
	}
	function createTable($t){
		$m = array();
		$m[] = "Creating table: $t";
		if($t == 'Characters'){
			$m[] = "Loading Query to create Character Table";
			$query = "Create table Characters (id int)";
			$m[] = "Dropping Table";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		return implode('<br/>',$m);
	}
	function deleteTable($t){
		$m = array();
		$m[] = "Deleting table: $t";
		if($t == 'Characters'){
			$m[] = "Loading Query to delete Character Table";
			$query = "drop table Characters";
			$m[] = "Dropping table";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		return implode('<br/>',$m);
	}
}
?>
