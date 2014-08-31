<?php
class ledgerModel extends CI_Model{

	#private $db;
	private $ledgerFile;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dw',true);
		$this->ledgerFile = 'temp/ledger';
	}
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
		$obj['records'] = array();
		$data = json_encode($obj);
		file_put_contents($this->ledgerFile,$data);
		return 'Model - Ledger stored as json in temp';
	}
	function addRecord($data){
		$file = $this->ledgerFile;
		$json = file_get_contents($file);
		$ledger = json_decode($json,true);
		$records = $ledger['records'];

		$type    = $data['type'];
		$account = $data['account'];
		$budget  = $data['budget'];
		$vendor  = $data['vendor'];
		$amount  = $data['amount'];
		
		$id = 0;
		foreach($records as $r){
			if($r[0] > $id){$id = $r[0];}
		}
		$id++;

		$date = date('Y-m-d');

		$record = array(
			$id,
			$date,
			$type,
			$account,
			$budget,
			$vendor,
			$amount
		);
		$records[] = $record;

		$ledger['records'] = $records;
		$json = json_encode($ledger);
		file_put_contents($file,$json);
		$ledger = $this->getLedger();
		return $ledger;
	}
	function getLedger(){
		$file = $this->ledgerFile;
		$json = file_get_contents($file);
		$ledger = json_decode($json,true);
		return $ledger;
	}
	function deleteLedgerEntry($arg1){
		$file = $this->ledgerFile;
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
		return $ledger;
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
