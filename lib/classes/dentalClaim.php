<?php
class dentalClaim{

	private $claimIndex;


	function __construct(){
		$this->claimIndex = 69;
	}

	# SETTERS
	function setClaimIndex($x){ $this->claimIndex = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "ClaimIndex: ".$this->claimIndex;
		$r = implode('<br/>',$m);
		return $r;
	}
}
?>