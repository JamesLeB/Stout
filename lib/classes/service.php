<?php
class service{

	private $lineNumber;
	private $adaCode;
	private $lineAmount;
	private $serviceDate;
	private $lineControl;
	private $toothNumber;

	function __construct(){
		$this->lineNumber = '';
		$this->adaCode = '';
		$this->lineAmount = '';
		$this->serviceDate = '';
		$this->lineControl = '';
		$this->toothNumber = '';
	}

	# GETTERS
	function getStuff(){
		return array(
			'number'  => $this->lineNumber,
			'adacode' => $this->adaCode,
			'amount'  => $this->lineAmount,
			'date'    => $this->serviceDate,
			'tooth'   => $this->toothNumber
		);
	}

	# SETTERS
	function setLineNumber($x){ $this->lineNumber = $x; }
	function setAdaCode($x){ $this->adaCode = $x; }
	function setLineAmount($x){ $this->lineAmount = $x; }
	function setServiceDate($x){ $this->serviceDate = $x; }
	function setLineControl($x){ $this->lineControl = $x; }
	function setToothNumber($x){ $this->toothNumber = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "LineNumber: ".$this->lineNumber;
		$m[] = "adaCode: ".$this->adaCode;
		$m[] = "LineAmount: ".$this->lineAmount;
		$m[] = "ServiceDate: ".$this->serviceDate;
		$m[] = "LineControl: ".$this->lineControl;
		$m[] = "ToothNumber: ".$this->toothNumber;
		$r = implode('<br/>',$m);
		return $r;
	}
}
?>
