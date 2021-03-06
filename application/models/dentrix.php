<?php
class Dentrix extends CI_Model{

	private $db;

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database('dentrix',true);
	}
	function test($x){

		$query = 'SELECT PATID FROM DDB_PAT';
		$rs = $this->db->query($query);
		$list = array();
		foreach($rs->result_array() as $row){
			$list[] = $row['PATID'];
		}
		$json = json_encode($list);
		file_put_contents('files/chartList',$json);

		return "list should be there";
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
	function getChartNumber($chart){
		$parm = array($chart);
		$query = 'SELECT CHART FROM DDB_PAT WHERE PATID = ? AND CHART IS NOT NULL';
		$rs = $this->db->query($query,$parm);
		$chartNumber = '';
		foreach($rs->result_array() as $row){
			$chartNumber = $row['CHART'];
		}
		return $chartNumber;
	}
	function getCharts(){
		$json = file_get_contents('files/chartList');
		$obj = json_decode($json);
		return $obj;
	}
# This is code I used to pull the old chart number list
/*
		$out = array();
		foreach($obj as $t){
		#for($i=0;$i<10;$i++){
			$chart = $t[0];
			#$chart = $obj[$i][0];
			$test = preg_match('/\W/',$chart);
			if(!$test){ $out[] = $chart; }
		}
		$json = json_encode($out);
		file_put_contents('files/cleanChartList',$json);

		#foreach($out as $o){ $ms .= "$o<br/>"; }

		$json = file_get_contents('files/chartList');
		$obj = json_decode($json);
		$f1 = $obj[0][0];
		$f2 = $obj[1][0];
		$f3 = $obj[2][0];
		$f4 = $obj[3][0];
		$ms .= "$f1<br/>";
		$ms .= "$f2<br/>";
		$ms .= "$f3<br/>";
		$ms .= "$f4<br/>";

		$file = "lib/queries/getCharts.sql";
		if(file_exists($file)){
			$ms .= 'found query<br/>';
			$query = file_get_contents($file);
			$parm = array();
			$rs = $this->db->query($query,$parm);
			if($rs){
				$ms .= "yes result set<br/>";
				$prs = processResultSet($rs);
				$ct = $prs[2];
				$ms .= "$ct Records Processed<br/>";
				$data = $prs[1];
				$json = json_encode($data);
				file_put_contents('files/chartList',$json);
			}else{
				$ms .= "no result set<br/>";
			}
		}else{
			$ms .= 'no query<br/>';
		}
*/
	function go($chart){
		$ms = '';
		$prs = '';
		$ms .= '--- Getting query<br/>';
		$file = "lib/queries/patientLedger.sql";
		if(file_exists($file)){
			$ms .= '--- found query<br/>';
			$query = file_get_contents($file);
			$parm = array($chart);
			$rs = $this->db->query($query,$parm);
			if($rs){
				$ms .= "--- yes result set<br/>";
				$prs = $this->processLedger($rs);
				$ct = $prs[2];
				$ms .= "--- $ct Records Processed<br/>";
				$ms .= "--- Chart#  $chart<br/>";
			}else{
				$ms .= "--- no result set<br/>";
			}
		}else{
			$ms .= '--- no query<br/>';
		}
		return array($prs,$ms);
	} # END go()
	function processLedger($rs){
		$headings = array(
			'Date',
			'Tooth',
			'Code',
			'Description',
			'Amount',
			'Provider',
			'Clinic',
			'LineType',
			'Balance'
		);
		$records  = array();
		$count    = 0;
		$balance  = 0;
		foreach($rs->result_array() as $row){
			$line = array();
			$line[] = $row['createDate'];
			$line[] = $row['tooth'];
			$line[] = $row['ADACODE'];
			$line[] = $row['DESCRIPTION'];
			$line[] = $row['amount'];
			$balance += $row['amount'];
			$line[] = $row['provider'];
			$line[] = $row['clinic'];
			$line[] = $row['lineType'];
			$line[] = number_format($balance,2);
			$records[] = $line;
			$count++;
		}
		return array($headings,$records,$count);
	}
}
?>
