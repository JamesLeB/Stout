<?php
class Local extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('local',true);
	}
	function get(){
		$query = 'show tables';
		$rs = $this->db->query($query);
		$rtn = 'Table List<br/>';
		foreach($rs->result_array() as $row){
			$rtn .= $row['Tables_in_local'].'<br/>';
		}
		return $rtn;
	}
	function getTableStatus(){
		$tables = array();
		$table = array(
			'name' => 'Characters',
			'status' => 'Offline'
		);
		$tables[] = $table;
		$table = array(
			'name' => 'Inventory',
			'status' => 'Offline'
		);
		$tables[] = $table;
		return $tables;
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
