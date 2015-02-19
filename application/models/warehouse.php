<?php
class Warehouse extends CI_Model{

	private $db;

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('dw',true);
	}
	function test($batch,$file)
	{
		$parm  = array($file,$batch);
		$query = "UPDATE sentAxiumClaims set fileName = ? where batchNum = ?";
		$rs = $this->db->query($query,$parm);

		return "batch: $batch !! file: $file !! result: $rs";
	}
	function setEmdeonRef($ref,$file)
	{
		$parm  = array($ref,$file);
		$query = "UPDATE sentAxiumClaims set emdeonAck = ? where fileName = ?";
		$rs = $this->db->query($query,$parm);

		return "$rs";
	}
	function loadRecord($record)
	{

		$batchNum  = $record['batchNum'];
		$batchDate = $record['batchDate'];
		$last      = $record['last'];
		$first     = $record['first'];
		$id        = $record['id'];
		$birth     = $record['birth'];
		$sex       = $record['sex'];
		$claimid   = $record['claimid'];
		$tcn       = $record['tcn'];
		$lineNum   = $record['lineNum'];
		$adacode   = $record['adacode'];
		$tooth     = $record['tooth'];
		$amount    = $record['amount'];
		$date      = $record['date'];
		$payer     = $record['payer'];
		$providerName = $record['providerName'];

		#check for record in db
		$parm  = array($claimid,$lineNum);
		$query = "SELECT claimid FROM sentAxiumClaims WHERE claimid = ? AND lineNum = ?";
		$rs = $this->db->query($query,$parm);
		$haveRecord = $rs->num_rows();
		$message = $haveRecord ? 'Duplicate' : 'New';

		if($haveRecord)
		{
			$errorReport = "$batchNum::$batchDate::$last::$first::$id::$birth::$sex::$claimid::$tcn::$lineNum::$adacode::$tooth::$amount::$date::$payer::$providerName\n";
			file_put_contents('files/edi/dupClaims',$errorReport,FILE_APPEND);
		}
		else
		{
			$parm = array($batchNum,$batchDate,$last,$first,$id,$birth,$sex,$claimid,$tcn,$lineNum,$adacode,$tooth,$amount,$date,$payer,$providerName);
			$query = "INSERT INTO sentAxiumClaims (
				batchNum,
				batchDate,
				lastName,
				firstName,
				id,
				birth,
				sex,
				claimid,
				tcn,
				lineNum,
				adacode,
				tooth,
				amount,
				serviceDate,
				payerName,
				providerName
			) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$rs = $this->db->query($query,$parm);
		}
		return "loading record now -- message: $message";
	}
}
?>
