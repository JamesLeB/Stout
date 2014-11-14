<?php
class DenialMangement extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('denial',true);
	}
	function test(){
		$headings = array(
			'Batch',
			'ID',
/*
			'LastName',
			'FirstName',
			'Birth',
			'Sex',
*/
			'PatId',
			'DOS',
			'Amount',
			'Status',
			'Code'
		);
		$row = array();
		$data = array();
		$query = 'select * from claims';
		$rs = $this->db->query($query);
		foreach($rs->result_array() as $row){
			$line = array();
			$line[] = $row['batch'];
			$line[] = $row['id'];
/*
			$line[] = $row['lastName'];
			$line[] = $row['firstName'];
			$line[] = $row['birth'];
			$line[] = $row['sex'];
*/
			$line[] = $row['patId'];
			$line[] = $row['dos'];
			$line[] = $row['amount'];
			$line[] = $row['status'];
			$line[] = $row['code'];
			$data[] = $line;
		}
		$table = renderTable($headings,$data);
		return $table;
	}
	function checkClaim($arg){
		$parm = array($arg);
		$query = "select id from claims where id = ?";
		$rs = $this->db->query($query,$parm);
		$count = 0;
		foreach($rs->result_array() as $row){$count++;}
		return $count;
	}
	function insertClaim($arg){
		$batch     = $arg['batch'];
		$claimid   = $arg['claimid'];
		$lastName  = $arg['last'];
		$firstName = $arg['first'];
		$birth     = $arg['birth'];
		$sex       = $arg['sex'];
		$patId     = $arg['id'];
		$dos       = $arg['date'];
		$amount    = $arg['amount'];
		$parm = array(
			$batch,
			$claimid,
			$lastName,
			$firstName,
			$birth,
			$sex,
			$patId,
			$dos,
			$amount
		);
		$query = "insert into
			claims (
				batch,
				id,
				lastName,
				firstName,
				birth,
				sex,
				patId,
				dos,
				amount,
				status,
				code
			)
			values (?,?,?,?,?,?,?,?,?,'Pend','-')";
		$rs = $this->db->query($query,$parm);
	} # END function insertClaim
	function insertService($arg){
		$claimid = $arg['claimid'];
		$adacode = $arg['adacode'];
		$amount  = $arg['amount'];
		$date    = $arg['date'];
		$adacode = preg_split('/:/',$adacode);
		$adacode = $adacode[1];
		$parm = array(
			$claimid,
			$adacode,
			$amount,
			$date
		);
		$query = "insert into
			services (
				id,
				adacode,
				amount,
				serviceDate,
				status,
				code
			)
			values (?,?,?,?,'Pend','-')";
		$rs = $this->db->query($query,$parm);
	} # END function insertService
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
