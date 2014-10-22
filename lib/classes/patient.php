<?php
class patient{

	private $relationship;
	private $first;
	private $last;
	private $street;
	private $street2;
	private $city;
	private $state;
	private $zip;
	private $birth;
	private $sex;

	function __construct(){
		$this->relationship = '';
		$this->first = '';
		$this->last = '';
		$this->street = '';
		$this->street2 = '';
		$this->city = '';
		$this->state = '';
		$this->zip = '';
		$this->birth = '';
		$this->sex = '';
	}

	# SETTERS
	function setRelationship($x){ $this->relationship = $x; }
	function setFirst($x){ $this->first = $x; }
	function setLast($x){ $this->last = $x; }
	function setStreet($x){ $this->street = $x; }
	function setStreet2($x){ $this->street2 = $x; }
	function setCity($x){ $this->city = $x; }
	function setState($x){ $this->state = $x; }
	function setZip($x){ $this->zip = $x; }
	function setBirth($x){ $this->birth = $x; }
	function setSex($x){ $this->sex = $x; }

	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "Relationship: ".$this->relationship;
		$m[] = "First: ".$this->first;
		$m[] = "Last: ".$this->last;
		$m[] = "Street: ".$this->street;
		$m[] = "Street2: ".$this->street2;
		$m[] = "City: ".$this->city;
		$m[] = "State: ".$this->state;
		$m[] = "Zip: ".$this->zip;
		$m[] = "Birth: ".$this->birth;
		$m[] = "Sex: ".$this->sex;
		$r = implode('<br/>',$m);
		return $r;
	}
}
?>
