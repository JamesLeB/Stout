<?php
class dentalClaim{

	private $claimIndex;
	private $patientFirst;
	private $patientLast;
	private $patientMiddle;
	private $patientId;
	private $patientStreet;
	private $patientCity;
	private $patientState;
	private $patientZip;
	private $patientBirth;
	private $patientSex;
	private $payerName;
	private $payerId;
	private $payer2ndId;
	private $payerStreet1;
	private $payerStreet2;
	private $payerCity;
	private $payerState;
	private $payerZip;
	private $billingProvider2ndId;
	private $claimId;
	private $claimAmount;
	private $facilityCode;
	private $signature;
	private $assignmentCode;
	private $assignmentStatus;
	private $release;
	private $serviceDate;
	private $claimNote;

	function __construct(){
		$this->claimIndex = '';
		$this->patientFirst = '';
		$this->patientLast = '';
		$this->patientMiddle = '';
		$this->patientId = '';
		$this->patientStreet = '';
		$this->patientCity = '';
		$this->patientState = '';
		$this->patientZip = '';
		$this->patientBirth = '';
		$this->patientSex = '';
		$this->payerName = '';
		$this->payerId = '';
		$this->payer2ndId = '';
		$this->payerStreet1 = '';
		$this->payerStreet2 = '';
		$this->payerCity = '';
		$this->payerState = '';
		$this->payerZip = '';
		$this->billingProvider2ndId = '';
		$this->claimId = '';
		$this->claimId2 = '';
		$this->claimAmount = '';
		$this->facilityCode = '';
		$this->signature = '';
		$this->assignmentCode = '';
		$this->assignmentStatus = '';
		$this->release = '';
		$this->serviceDate = '';
		$this->claimNote = '';
	}

	# SETTERS
	function setClaimIndex($x){ $this->claimIndex = $x; }
	function setPatientFirst($x){ $this->patientFirst = $x; }
	function setPatientLast($x){ $this->patientLast = $x; }
	function setPatientMiddle($x){ $this->patientMiddle = $x; }
	function setPatientId($x){ $this->patientId = $x; }
	function setPatientStreet($x){ $this->patientStreet = $x; }
	function setPatientCity($x){ $this->patientCity = $x; }
	function setPatientState($x){ $this->patientState = $x; }
	function setPatientZip($x){ $this->patientZip = $x; }
	function setPatientBirth($x){ $this->patientBirth = $x; }
	function setPatientSex($x){ $this->patientSex = $x; }
	function setPayerName($x){ $this->payerName = $x; }
	function setPayerId($x){ $this->payerId = $x; }
	function setPayer2ndId($x){ $this->payer2ndId = $x; }
	function setPayerStreet1($x){ $this->payerStreet1 = $x; }
	function setPayerStreet2($x){ $this->payerStreet2 = $x; }
	function setPayerCity($x){ $this->payerCity = $x; }
	function setPayerState($x){ $this->payerState = $x; }
	function setPayerZip($x){ $this->payerZip = $x; }
	function setBillingProvider2ndId($x){ $this->billingProvider2ndId = $x; }
	function setClaimId($x){ $this->claimId = $x; }
	function setClaimId2($x){ $this->claimId2 = $x; }
	function setClaimAmount($x){ $this->claimAmount = $x; }
	function setFacilityCode($x){ $this->facilityCode = $x; }
	function setSignature($x){ $this->signature = $x; }
	function setAssignmentCode($x){ $this->assignmentCode = $x; }
	function setAssignmentStatus($x){ $this->assignmentStatus = $x; }
	function setRelease($x){ $this->release = $x; }
	function setServiceDate($x){ $this->serviceDate = $x; }
	function setClaimNote($x){ $this->claimNote = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "ClaimIndex: ".$this->claimIndex;
		$m[] = "ClaimNote: ".$this->claimNote;
/*
		$m[] = "ClaimId: ".$this->claimId;
		$m[] = "ClaimId2: ".$this->claimId2;
		$m[] = "ServiceDate: ".$this->serviceDate;
		$m[] = "PatientFirst: ".$this->patientFirst;
		$m[] = "PatientLast: ".$this->patientLast;
		$m[] = "PatientMiddle: ".$this->patientMiddle;
		$m[] = "PatientId: ".$this->patientId;
		$m[] = "PatientStreet: ".$this->patientStreet;
		$m[] = "PatientCity: ".$this->patientCity;
		$m[] = "PatientState: ".$this->patientState;
		$m[] = "PatientZip: ".$this->patientZip;
		$m[] = "PatientBirth: ".$this->patientBirth;
		$m[] = "PatientSex: ".$this->patientSex;
		$m[] = "PayerName: ".$this->payerName;
		$m[] = "PayerId: ".$this->payerId;
		$m[] = "Payer2ndId: ".$this->payer2ndId;
		$m[] = "PayerStreet1: ".$this->payerStreet1;
		$m[] = "PayerStreet2: ".$this->payerStreet2;
		$m[] = "PayerCity: ".$this->payerCity;
		$m[] = "PayerState: ".$this->payerState;
		$m[] = "PayerZip: ".$this->payerZip;
		$m[] = "BillingProvider2ndId: ".$this->billingProvider2ndId;
		$m[] = "ClaimAmount: ".$this->claimAmount;
		$m[] = "FacilityCode: ".$this->facilityCode;
		$m[] = "Signature: ".$this->signature;
		$m[] = "AssignmentCode: ".$this->assignmentCode;
		$m[] = "AssignmentStatus: ".$this->assignmentStatus;
		$m[] = "Release: ".$this->release;
*/

		$r = implode('<br/>',$m);
		return $r;
	}
}
?>