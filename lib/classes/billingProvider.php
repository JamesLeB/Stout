<?php
class billingProvider{

	private $billingProviderSpecialty;
	private $billingProviderName;
	private $billingProviderNPI;
	private $billingProviderStreet;
	private $billingProviderCity;
	private $billingProviderState;
	private $billingProviderZip;
	private $billingProviderTaxId;
	private $billingProviderLicense;
	private $billingProviderContactName;
	private $billingProviderContactNumber;
	private $pay2Name;
	private $pay2Street;
	private $pay2City;
	private $pay2State;
	private $pay2Zip;


	function __construct(){
		$this->billingProviderSpecialty = '';
		$this->billingProviderName = '';
		$this->billingProviderNPI = '';
		$this->billingProviderStreet = '';
		$this->billingProviderCity = '';
		$this->billingProviderState = '';
		$this->billingProviderZip = '';
		$this->billingProviderTaxId = '';
		$this->billingProviderLicense = '';
		$this->billingProviderContactName = '';
		$this->billingProviderContactNumber = '';
		$this->pay2Name = '';
		$this->pay2Street = '';
		$this->pay2City = '';
		$this->pay2State = '';
		$this->pay2Zip = '';
	}

	# SETTERS
	function setBillingProviderSpecialty($x){ $this->billingProviderSpecialty = $x; }
	function setBillingProviderName($x){ $this->billingProviderName = $x; }
	function setBillingProviderNPI($x){ $this->billingProviderNPI = $x; }
	function setBillingProviderStreet($x){ $this->billingProviderStreet = $x; }
	function setBillingProviderCity($x){ $this->billingProviderCity = $x; }
	function setBillingProviderState($x){ $this->billingProviderState = $x; }
	function setBillingProviderZip($x){ $this->billingProviderZip = $x; }
	function setBillingProviderTaxId($x){ $this->billingProviderTaxId = $x; }
	function setBillingProviderLicense($x){ $this->billingProviderLicense = $x; }
	function setBillingProviderContactName($x){ $this->billingProviderContactName = $x; }
	function setBillingProviderContactNumber($x){ $this->billingProviderContactNumber = $x; }
	function setPay2Name($x){ $this->pay2Name = $x; }
	function setPay2Street($x){ $this->pay2Street = $x; }
	function setPay2City($x){ $this->pay2City = $x; }
	function setPay2State($x){ $this->pay2State = $x; }
	function setPay2Zip($x){ $this->pay2Zip = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "BillingProviderSpecialty: ".$this->billingProviderSpecialty;
		$m[] = "BillingProviderName: ".$this->billingProviderName;
		$m[] = "BillingProviderNPI: ".$this->billingProviderNPI;
		$m[] = "BillingProviderStreet: ".$this->billingProviderStreet;
		$m[] = "BillingProviderCity: ".$this->billingProviderCity;
		$m[] = "BillingProviderState: ".$this->billingProviderState;
		$m[] = "BillingProviderZip: ".$this->billingProviderZip;
		$m[] = "BillingProviderTaxId: ".$this->billingProviderTaxId;
		$m[] = "BillingProviderLicense: ".$this->billingProviderLicense;
		$m[] = "BillingProviderContactName: ".$this->billingProviderContactName;
		$m[] = "BillingProviderContactNumber: ".$this->billingProviderContactNumber;
		$m[] = "Pay2Name: ".$this->pay2Name;
		$m[] = "Pay2Street: ".$this->pay2Street;
		$m[] = "Pay2City: ".$this->pay2City;
		$m[] = "Pay2State: ".$this->pay2State;
		$m[] = "Pay2Zip: ".$this->pay2Zip;
		$r = implode('<br/>',$m);
		return $r;
	}
}
?>
