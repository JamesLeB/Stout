<?php
class EDI837D{

	private $senderId;
	private $senderName;
	private $receiverId;
	private $receiverName;
	private $date;
	private $time;
	private $batch;
	private $format;
	private $ftype;
	private $submitterName;
	private $submitterPhone;
	private $providers;

	function __construct(){
		$this->senderId = '';
		$this->senderName = '';
		$this->receiverId = '';
		$this->receiverName = '';
		$this->date = '';
		$this->time = '';
		$this->batch = '';
		$this->format = '';
		$this->ftype = '';
		$this->submitterName = '';
		$this->submitterPhone = '';
		$this->providers = array();
	}

	# ADDERS
	function addProvider($x){$this->providers[]=$x;}

	#GETTERS
	function getProviders(){return $this->providers;}

	# SETTERS
	function setSenderId($x){ $this->senderId = $x; }
	function setSenderName($x){ $this->senderName = $x; }
	function setReceiverId($x){ $this->receiverId = $x; }
	function setReceiverName($x){ $this->receiverName = $x; }
	function setDate($x){ $this->date = $x; }
	function setTime($x){ $this->time = $x; }
	function setBatch($x){ $this->batch = $x; }
	function setformat($x){
		$this->format = $x;
		if($x=='005010X224A2'){$this->ftype = 'Dental';}else{$this->ftype = 'Error';}
	}
	function setSubmitterName($x){ $this->submitterName = $x; }
	function setSubmitterPhone($x){ $this->submitterPhone = $x; }
	function toText(){
		#to text by defaul create a string ment to be viewed by html
		$m = array();
		$m[] = "SenderId: ".$this->senderId;
		$m[] = "SenderName: ".$this->senderName;
		$m[] = "ReceiverId: ".$this->receiverId;
		$m[] = "ReceiverName: ".$this->receiverName;
		$m[] = "Date: ".$this->date;
		$m[] = "Time: ".$this->time;
		$m[] = "Batch: ".$this->batch;
		$m[] = "Format: ".$this->format;
		$m[] = "ftype: ".$this->ftype;
		$m[] = "SubmitterName: ".$this->submitterName;
		$m[] = "SubmitterPhone: ".$this->submitterPhone;
		$m[] = "ProviderCount: ".sizeof($this->providers);
		$r = implode('<br/>',$m);
		return $r;
	}
}
?>