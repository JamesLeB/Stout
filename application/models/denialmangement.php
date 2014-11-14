<?php
class DenialMangement extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('denial',true);
	}
	function test(){

$this->insertRecord();

		$headings = array('ID');
		$row = array();
		$data = array();
		$query = 'select * from claims';
		$rs = $this->db->query($query);
		foreach($rs->result_array() as $row){
			$line = array();
			$line[] = $row['id'];
			$data[] = $line;
		}
		$table = renderTable($headings,$data);
		return $table;
	}
	function insertRecord(){
		$parm = array(99);
		$query = "insert into claims (id) values (?)";
		$rs = $this->db->query($query,$parm);
	}
/*
		#$json = json_encode($list);
		#file_put_contents('files/chartList',$json);
		$file = "lib/queries/patientLedger.sql";
		if(file_exists($file)){
			$query = file_get_contents($file);
			$parm = array($x);
			$rs = $this->db->query($query,$parm);
			if($rs){
			}
		}
*/
}
?>
