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
		$ledger = array();
		$obj['headings'] = array(
			'ID',
			'Date',
			'Type',
			'Account',
			'Budget',
			'Vendor',
			'Amount',
			'Delete'
		);
		$record1= array(
			1,
			'2014-08-28',
			'Income',
			'J_Citi_Check',
			'J_NYU_Pay',
			'NYU',
			2000,
			'<button onclick="deleteLedgerEntry(1);">X</button>'
		);
		$record2= array(
			2,
			'2014-08-28',
			'Income',
			'J_Citi_Check',
			'Initial',
			'ME',
			1000,
			'<button onclick="deleteLedgerEntry(2);">X</button>'
		);
		$obj['records'] = array($record1,$record2);
		$file = 'temp/test';
		$data = json_encode($obj);
		file_put_contents($file,$data);
		return 'Model - Ledger stored as json in temp';
	}
	function getLedger(){
		$file = 'temp/test';
		$json = file_get_contents($file);
		$ledger = json_decode($json,true);
		$headings = $ledger['headings'];
		$records = $ledger['records'];
		$table = renderTable($headings,$records);
		return $table;
	}
	function deleteLedgerEntry($arg1){
		$file = 'temp/test';
		$json = file_get_contents($file);
		$ledger = json_decode($json,true);
		$records = $ledger['records'];
		$index = 0;
		$splice = 0;
		foreach($records as $record){
			if ($record[0] == $arg1){$splice = $index;}
			$index++;
		}
		array_splice($records,$splice,1);
		$ledger['records'] = $records;
		$json = json_encode($ledger);
		file_put_contents($file,$json);
		$ledger = $this->getLedger();
		$ms = '';
		$ms .= "Model - Lets delete a record and the record is $arg1<br/>";
		$ms .= "$ledger";
		return $ms;
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
