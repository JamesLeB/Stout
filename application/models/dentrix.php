<?php
class Dentrix extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('dentrix',true);
	}
	function test($chart){
		$ms = '';
		$prs = '';
		$ms .= 'Getting query<br/>';
		$file = "lib/queries/patientLedger.sql";
		if(file_exists($file)){
			$ms .= 'found query<br/>';
			$query = file_get_contents($file);
			$parm = array($chart);
			$rs = $this->db->query($query,$parm);
			if($rs){
				$ms .= "yes result set<br/>";
				#$prs = processResultSet($rs);
				$prs = $this->processLedger($rs);
				$ct = $prs[2];
				$ms .= "$ct Records Processed<br/>";
				$ms .= "Chart#  $chart<br/>";
				$ms .= renderTable($prs[0],$prs[1]);
			}else{
				$ms .= "no result set<br/>";
			}
		}else{
			$ms .= 'no query<br/>';
		}
		return array($prs,$ms);
	} # END test()
	function processLedger($rs){
		$headings = array(
			'Date',
			'lineType',
			'Amount',
			'AdaCode',
			'Description',
			'Clinic',
			'Practice'
		);
		$records  = array();
		$count    = 0;
		foreach($rs->result_array() as $row){
			$line = array();
			$line[] = $row['createDate'];
			$line[] = $row['lineType'];
			$line[] = $row['amount'];
			$line[] = $row['ADACODE'];
			$line[] = $row['DESCRIPTION'];
			$line[] = $row['clinic'];
			$line[] = $row['PRACTITLE'];
			$records[] = $line;
			$count++;
		}
		return array($headings,$records,$count);
	}
}
?>
