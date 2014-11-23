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
}
?>
