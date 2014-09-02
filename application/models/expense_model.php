<?php
class Expense_model extends CI_Model{

	private $db;
	private $FILE;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dw',true);
		$this->FILE = 'temp/expense';
	}
	function setupList(){
		$obj = array();
		$obj['headings'] = array(
			'ID',
			'Name',
			'Type',
			'Amount',
			'Delete'
		);
		$obj['records'] = array();
		$json = json_encode($obj);
		file_put_contents($this->FILE,$json);
		return 'Model - Expenses stored as json in temp';
	}
	function addRecord($data){
		$name = $data['name'];
		$type = $data['type'];
		
		$json = file_get_contents($this->FILE);
		$obj = json_decode($json,true);
		$records = $obj['records'];

		$id = 0;
		foreach($records as $r){
			if($r[0] > $id){$id = $r[0];}
		}
		$id++;

		$date = date('Y-m-d');

		$record = array(
			$id,
			$name,
			$type,
			0
		);
		$records[] = $record;

		$obj['records'] = $records;
		$json = json_encode($obj);
		file_put_contents($this->FILE,$json);
		$list = $this->getList();
		return $list;
	}
	function getList(){
		$json = file_get_contents($this->FILE);
		$obj = json_decode($json,true);
		return $obj;
	}
	function deleteRecord($arg1){
		$json = file_get_contents($this->FILE);
		$obj = json_decode($json,true);
		$records = $obj['records'];
		$index = 0;
		$splice = 0;
		foreach($records as $record){
			if ($record[0] == $arg1){$splice = $index;}
			$index++;
		}
		array_splice($records,$splice,1);
		$obj['records'] = $records;
		$json = json_encode($obj);
		file_put_contents($this->FILE,$json);
		$list = $this->getList();
		return $list;
	}
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
}
?>
