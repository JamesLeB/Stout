<?php
class dentalClaim{

	private $claimIndex;
	private $tcn;
	private $patient; #this is for the strange extra patient in some claims
						#   look for HL loop   HL*x*x*23*0
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
	private $facilityName;
	private $facilityId;
	private $facilityId2;
	private $facilityStreet;
	private $facilityCity;
	private $facilityState;
	private $facilityZip;
	private $signature;
	private $assignmentCode;
	private $assignmentStatus;
	private $release;
	private $serviceDate;
	private $claimNote;
	private $providerName;
	private $providerId;
	private $providerId2;
	private $providerTaxonomy;
	private $services;
	private $exceptionCode;
	private $patientPaid;
	private $supplementalInfo;

	function __construct(){
		$this->claimIndex = '';
		$this->tcn = '';
		$this->supplementalInfo = '';
		$this->patient = '';
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
		$this->facilityName = '';
		$this->facilityId = '';
		$this->facilityId2 = '';
		$this->facilityStreet = '';
		$this->facilityCity = '';
		$this->facilityState = '';
		$this->facilityZip = '';
		$this->signature = '';
		$this->assignmentCode = '';
		$this->assignmentStatus = '';
		$this->release = '';
		$this->serviceDate = '';
		$this->claimNote = '';
		$this->providerName = '';
		$this->providerId = '';
		$this->providerId2 = '';
		$this->providerTaxonomy = '';
		$this->services = array();
		$this->exceptionCode = '';
		$this->patientPaid = '';
	}
	
	# ADDERS
	function addService($x){$this->services[] = $x;}

	# GETTERS
	function getServices(){ return $this->services; }
	function getPatient(){ return $this->patient; }
	function getStuff(){
		return array(
			'last'    => $this->patientLast,
			'first'   => $this->patientFirst,
			'id'      => $this->patientId,
			'birth'   => $this->patientBirth,
			'sex'     => $this->patientSex,
			'claimid' => $this->claimId,
			'date'    => $this->serviceDate,
			'amount'  => $this->claimAmount
		);
	}

	# SETTERS
	function setPatientPaid($x){ $this->patientPaid = $x; }
	function setTcn($x){ $this->tcn = $x; }
	function setSupplementalInfo($x){ $this->supplementalInfo = $x; }
	function setClaimIndex($x){ $this->claimIndex = $x; }
	function setPatient($x){ $this->patient = $x; }
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
	function setFacilityName($x){ $this->facilityName = $x; }
	function setFacilityId($x){ $this->facilityId = $x; }
	function setFacilityId2($x){ $this->facilityId2 = $x; }
	function setFacilityStreet($x){ $this->facilityStreet = $x; }
	function setFacilityCity($x){ $this->facilityCity = $x; }
	function setFacilityState($x){ $this->facilityState = $x; }
	function setFacilityZip($x){ $this->facilityZip = $x; }
	function setSignature($x){ $this->signature = $x; }
	function setAssignmentCode($x){ $this->assignmentCode = $x; }
	function setAssignmentStatus($x){ $this->assignmentStatus = $x; }
	function setRelease($x){ $this->release = $x; }
	function setServiceDate($x){ $this->serviceDate = $x; }
	function setClaimNote($x){ $this->claimNote = $x; }
	function setProviderName($x){ $this->providerName = $x; }
	function setProviderId($x){ $this->providerId = $x; }
	function setProviderId2($x){ $this->providerId2 = $x; }
	function setProviderTaxonomy($x){ $this->providerTaxonomy = $x; }
	function setExceptionCode($x){ $this->exceptionCode = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "ClaimIndex: ".$this->claimIndex;
		$m[] = "ClaimId: ".$this->claimId;
		$m[] = "TCN: ".$this->tcn;
		$m[] = "SupplementalInfo: ".$this->supplementalInfo;
# Subscriber
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
# Payer
		$m[] = "PayerName: ".$this->payerName;
		$m[] = "PayerId: ".$this->payerId;
		$m[] = "Payer2ndId: ".$this->payer2ndId;
		$m[] = "PayerStreet1: ".$this->payerStreet1;
		$m[] = "PayerStreet2: ".$this->payerStreet2;
		$m[] = "PayerCity: ".$this->payerCity;
		$m[] = "PayerState: ".$this->payerState;
		$m[] = "PayerZip: ".$this->payerZip;
# Claim
		$m[] = "PatientPaid: ".$this->patientPaid;
		$m[] = "ExceptionCode: ".$this->exceptionCode;
		$m[] = "ClaimId2: ".$this->claimId2;
		$m[] = "ClaimNote: ".$this->claimNote;
		$m[] = "ServiceDate: ".$this->serviceDate;
		$m[] = "ClaimAmount: ".$this->claimAmount;
		$m[] = "Signature: ".$this->signature;
		$m[] = "AssignmentCode: ".$this->assignmentCode;
		$m[] = "AssignmentStatus: ".$this->assignmentStatus;
		$m[] = "Release: ".$this->release;
# Provider
		$m[] = "ProviderName: ".$this->providerName;
		$m[] = "ProviderId: ".$this->providerId;
		$m[] = "ProviderId2: ".$this->providerId2;
		$m[] = "ProviderTaxonomy: ".$this->providerTaxonomy;
# Facility
		$m[] = "FacilityCode: ".$this->facilityCode;
		$m[] = "FacilityName: ".$this->facilityName;
		$m[] = "FacilityId: ".$this->facilityId;
		$m[] = "FacilityId2: ".$this->facilityId2;
		$m[] = "FacilityStreet: ".$this->facilityStreet;
		$m[] = "FacilityCity: ".$this->facilityCity;
		$m[] = "FacilityState: ".$this->facilityState;
		$m[] = "FacilityZip: ".$this->facilityZip;
		$m[] = "BillingProvider2ndId: ".$this->billingProvider2ndId;

		$r = implode('<br/>',$m);
		return $r;
	}
}
?>