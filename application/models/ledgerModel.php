<?php
class ledgerModel extends CI_Model{
	private $db;
/*
	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('dw',true);
	}
*/
	function setupLedger(){
		return 'setting up a blank ledger';
	}
/*
	function sample(){
		$ms = 'Getting query<br/>';
		$file = "querys/warehouse/getOpenMedicaidClaims.sql";
		if(file_exists($file)){
			$ms .= 'found query<br/>';
			$query = file_get_contents($file);
			$parm = array();
			$rs = $this->db->query($query,$parm);
			if($rs){
				$prs = processResultSet($rs);
				$ct = $prs[2];
				$ms .= "yes result set $ct records<br/>";
				$ms .= renderTable($prs[0],$prs[1]);
			}else{
				$ms .= "no result set<br/>";
			}
		}else{
			$ms .= 'no query<br/>';
		}
		return "$ms";
	}
*/
}
?>
