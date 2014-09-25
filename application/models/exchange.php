<?php
class Exchange extends CI_Model{

	#private $db;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dentrix',true);
	}
	function test($x){
		return "return from model test function";
	}
/*
		$htmlTable = 'table';
		$file = "lib/queries/patientLedger.sql";
		if(file_exists($file)){
			$query = file_get_contents($file);
			$parm = array($x);
			$rs = $this->db->query($query,$parm);
			if($rs){
				#$prs = processResultSet($rs);
				$prs = $this->processLedger($rs);
				$htmlTable = renderTable($prs[0],$prs[1]);
			}
		}
		return $htmlTable;
*/
}
?>
