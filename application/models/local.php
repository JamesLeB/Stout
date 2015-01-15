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
	function addCharacter($name,$race,$class){
		# check to database first
		$q = "insert into Characters (name,race,class) values ('$name','$race','$class')";
		$rs = $this->db->query($q);
		$t = $rs ? 'Character Added' : 'Duplicat Name';
		return $t;
	}
	function deleteCharacter($charName){
		$q = "delete from Characters where name='$charName'";
		$rs = $this->db->query($q);
		$t = $rs ? 'TRUE' : 'FALSE';
		return "Deleted $charName $t";
	}
	function getCharacterList(){
		$head = array('Name','Race','Class');
		$q = 'select * from Characters';
		$rs = $this->db->query($q);
		$data = array();
		$ct = 0;
		foreach($rs->result_array() as $row){
			$d = array();
			$d[] = $row['name'];
			$d[] = $row['race'];
			$d[] = $row['class'];
			$data[] = $d;
			$ct++;
		}
		return array($head,$data);
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
			$query = "
				create table $t
				(
					name varchar(16) NOT NULL,
					race varchar(16),
					class varchar(16),
					PRIMARY KEY(name)
				)";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		elseif($t == 'Inventory'){
			$query = "create table $t (id int)";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		return implode('<br/>',$m);
	}
	function dropTable($t){
		$m = array();
		$m[] = "Dropping table: $t";
		if($t == 'Characters'){
			$query = "drop table $t";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		elseif($t == 'Inventory'){
			$query = "drop table $t";
			$rs = $this->db->query($query);
			$m[] = $rs ? 'TRUE' : 'FALSE';
		}
		return implode('<br/>',$m);
	}
}
?>
