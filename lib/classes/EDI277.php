<?php
class EDI277{

	private $filepath;
	private $batch;
	private $receiverStatus = '';
	private $receiverAmount = '';
	private $acceptedCount = '';
	private $rejectedCount = '';
	private $acceptedAmount = '';
	private $rejectedAmount = '';
	private $subscribers = array();

	function __construct(){
		$this->filepath = 'files/edi/277/';
		$this->batch = '';
		$this->receiverStatus = '';
		$this->receiverAmount = '';
		$this->acceptedCount = '';
		$this->rejectedCount = '';
		$this->acceptedAmount = '';
		$this->rejectedAmount = '';
	}

	public function getSubscribersData(){
		$heading = array(
			'LastName',
			'FirstName',
			'ID',
			'Chart',
			'ClaimId',
			'Status',
			'Amount',
			'TCN',
			'Date',
			'Line'
		);
		$data = array();
		foreach($this->subscribers as $subscriber){
			$row = array();
			$row[] = $subscriber['last'];
			$row[] = $subscriber['first'];
			$row[] = $subscriber['id'];
			$row[] = $subscriber['chart'];
			$row[] = $subscriber['claimId'];
			$row[] = $subscriber['status'];
			$row[] = $subscriber['amount'];
			$row[] = $subscriber['tcn'];
			$row[] = $subscriber['dos'];
			$row[] = $subscriber['line'];
			$data[] = $row;
		}
		return renderTable($heading,$data);
	}
	public function getSubscribers(){return $this->subscribers;}
	public function test(){
		return "Testing EDI837";
	}
	public function saveExcel(){
		$xls = '';
		$xls .= "LastName\t";
		$xls .=	"FirstName\t";
		$xls .=	"ID\t";
		$xls .=	"Chart\t";
		$xls .=	"ClaimId\t";
		$xls .=	"Status\t";
		$xls .=	"Amount\t";
		$xls .=	"TCN\t";
		$xls .=	"Date\t";
		$xls .=	"Line\n";
		foreach($this->subscribers as $subscriber){
			$row = array();
			$row[] = $subscriber['last'];
			$row[] = $subscriber['first'];
			$row[] = $subscriber['id'];
			$row[] = $subscriber['chart'];
			$row[] = $subscriber['claimId'];
			$row[] = $subscriber['status'];
			$row[] = $subscriber['amount'];
			$row[] = $subscriber['tcn'];
			$row[] = $subscriber['dos'];
			$row[] = $subscriber['line'];
			$xls .= implode("\t",$row)."\n";
		}
		file_put_contents($this->filepath.$this->batch.'.xls',$xls);
	}
	public function load277(){
		$m = array();
		try{
			$m[] = "loading 277";
			$x12 = file_get_contents($this->filepath.'a.x12');
			$x12 = preg_replace('/\r\n/','',$x12);
			$segments = preg_split('/~/',$x12);

			#LOAD ISA
			$seg = array_shift($segments);
			if(preg_match('/^ISA\*/',$seg)){
			}else{throw new exception("Loading ISA<br/>---<br/>$seg<br/>---");}

			#LOAD GS
			$seg = array_shift($segments);
			if(preg_match('/^GS\*/',$seg)){
			}else{throw new exception("Loading GS<br/>---<br/>$seg<br/>---");}

			#LOAD ST
			$seg = array_shift($segments);
			if(preg_match('/^ST\*/',$seg)){
			}else{throw new exception("Loading ST<br/>---<br/>$seg<br/>---");}

			#LOAD BHT
			$seg = array_shift($segments);
			if(preg_match('/^BHT\*0085\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$this->batch = $temp[3];
			}else{throw new exception("Loading BHT<br/>---<br/>$seg<br/>---");}

			#LOAD Source Level
			$seg = array_shift($segments);
			if(preg_match('/^HL\*1\*/',$seg)){
			}else{throw new exception("Loading Source Level<br/>---<br/>$seg<br/>---");}

			#LOAD Payer Name
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*PR\*2\*/',$seg)){
			}else{throw new exception("Loading Payer Name<br/>---<br/>$seg<br/>---");}

			#LOAD TRN
			$seg = array_shift($segments);
			if(preg_match('/^TRN\*1\*/',$seg)){
			}else{throw new exception("Loading TRN<br/>---<br/>$seg<br/>---");}

			#LOAD DTP
			$seg = array_shift($segments);
			if(preg_match('/^DTP\*050\*/',$seg)){
			}else{throw new exception("Loading DTP<br/>---<br/>$seg<br/>---");}

			#LOAD DTP
			$seg = array_shift($segments);
			if(preg_match('/^DTP\*009\*/',$seg)){
			}else{throw new exception("Loading DTP<br/>---<br/>$seg<br/>---");}

			#LOAD Receiver 
			$seg = array_shift($segments);
			if(preg_match('/^HL\*[0-9]+\*[0-9]+\*21\*/',$seg)){
			}else{throw new exception("Loading Receiver<br/>---<br/>$seg<br/>---");}

			#LOAD Receiver Name
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*41\*2\*/',$seg)){
			}else{throw new exception("Loading Receiver Name<br/>---<br/>$seg<br/>---");}

			#LOAD TRN
			$seg = array_shift($segments);
			if(preg_match('/^TRN\*2\*/',$seg)){
			}else{throw new exception("Loading TRN<br/>---<br/>$seg<br/>---");}

			#LOAD Receiver Status
			$seg = array_shift($segments);
			if(preg_match('/^STC\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$this->receiverStatus = $temp[1];
				$this->receiverAmount = $temp[4];
			}else{throw new exception("Loading Receiver Status<br/>---<br/>$seg<br/>---");}

			#LOAD accedpted count
			$seg = array_shift($segments);
			if(preg_match('/^QTY\*90\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$this->acceptedCount = $temp[2];
			}else{throw new exception("Loading accepted count<br/>---<br/>$seg<br/>---");}

			#LOAD rejected count
			if(preg_match('/^QTY\*AA\*/',$segments[0])){
				$seg = array_shift($segments);
				$temp = preg_split('/\*/',$seg);
				$this->rejectedCount = $temp[2];
			}#else{throw new exception("Loading rejected count<br/>---<br/>$seg<br/>---");}

			#LOAD accepted amount
			$seg = array_shift($segments);
			if(preg_match('/^AMT\*YU\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$this->acceptedAmount = $temp[2];
			}else{throw new exception("Loading accepted amount<br/>---<br/>$seg<br/>---");}

			#LOAD rejected amount
			if(preg_match('/^AMT\*YY\*/',$segments[0])){
				$seg = array_shift($segments);
				$temp = preg_split('/\*/',$seg);
				$this->rejectedAmount = $temp[2];
			}#else{throw new exception("Loading rejected amount<br/>---<br/>$seg<br/>---");}

			#LOAD Provider 
			$seg = array_shift($segments);
			if(preg_match('/^HL\*[0-9]+\*[0-9]+\*19\*/',$seg)){
			}else{throw new exception("Loading Provider<br/>---<br/>$seg<br/>---");}

			#LOAD Provider Name
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*85\*2\*/',$seg)){
			}else{throw new exception("Loading Provider Name<br/>---<br/>$seg<br/>---");}

			#LOAD TRN
			$seg = array_shift($segments);
			if(preg_match('/^TRN\*1\*/',$seg)){
			}else{throw new exception("Loading TRN<br/>---<br/>$seg<br/>---");}

			#LOAD Subscriber 
			while(preg_match('/^HL\*[0-9]+\*[0-9]+\*PT/',$segments[0])){
				$subscriber = $this->loadSubscriber($segments);
				$this->subscribers[] = $subscriber[0];
			}

			#LOAD SE
			$seg = array_shift($segments);
			if(preg_match('/^SE\*/',$seg)){
			}else{throw new exception("Loading SE<br/>---<br/>$seg<br/>---");}

			#LOAD GE
			$seg = array_shift($segments);
			if(preg_match('/^GE\*/',$seg)){
			}else{throw new exception("Loading GE<br/>---<br/>$seg<br/>---");}

			#LOAD IEA
			$seg = array_shift($segments);
			if(preg_match('/^IEA\*/',$seg)){
			}else{throw new exception("error loading IEA<br/>---<br/>$seg<br/>---");}

			#file_put_contents($this->filepath.$this->batch.'.x12',$x12);

		}catch(exception $e){
			$error = $e->getMessage();
			$m[] = "Error: $error";
		}
		#$e='';foreach($m as $mm){$e .= "$mm<br/>";}return $e;
		return implode('<br/>',$m);

		
	} # END function loadEDI837D

	private function loadSubscriber(&$segments){
		$subscriber = array(
			'last'    => '',
			'first'   => '',
			'id'      => '',
			'chart'   => '',
			'claimId' => '',
			'status'  => '',
			'amount'  => '',
			'tcn'     => '',
			'dos'     => '',
			'line'    => '',
		);

			#LOAD Subscriber 
			$seg = array_shift($segments);
			if(preg_match('/^HL\*[0-9]+\*[0-9]+\*PT/',$seg)){
			}else{throw new exception("Loading Subscriber<br/>---<br/>$seg<br/>---");}

			#LOAD Subscriber Demo
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*QC\*1\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$subscriber['last'] = $temp[3];
				$subscriber['first'] = $temp[4];
				$subscriber['id'] = $temp[9];
			}else{throw new exception("Loading rejected amount<br/>---<br/>$seg<br/>---");}

			#LOAD Subscriber Chart and ClaimId
			$seg = array_shift($segments);
			if(preg_match('/^TRN\*2\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$clm = preg_split('/-/',$temp[2]);
				$subscriber['chart'] = $clm[0];
				$subscriber['claimId'] = $clm[1];
			}else{throw new exception("Loading Chart and ClaimId id<br/>---<br/>$seg<br/>---");}

			#LOAD Claim Status
			$seg = array_shift($segments);
			if(preg_match('/^STC\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$subscriber['status'] = $temp[1];
				$subscriber['amount'] = $temp[4];
			}else{throw new exception("Loading Claim Status<br/>---<br/>$seg<br/>---");}

			#LOAD Claim TCN
			$seg = array_shift($segments);
			if(preg_match('/^REF\*1K\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$subscriber['tcn'] = $temp[2];
			}else{throw new exception("Loading Claim TCN<br/>---<br/>$seg<br/>---");}

			#LOAD Bill Type
			$seg = array_shift($segments);
			if(preg_match('/^REF\*BLT\*/',$seg)){
			}else{throw new exception("Loading Bill Type<br/>---<br/>$seg<br/>---");}

			#LOAD Claim Date
			$seg = array_shift($segments);
			if(preg_match('/^DTP\*472\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$subscriber['dos'] = $temp[3];
			}else{throw new exception("Loading Claim Date<br/>---<br/>$seg<br/>---");}

			# LOAD Service line data
			$line = array();
			while(preg_match('/^SVC\*/',$segments[0])){
				if(preg_match('/^SVC\*/',$segments[0])){
					$seg = array_shift($segments);
					$temp = preg_split('/\*/',$seg);
					$line[] = $temp[1];
				}
				if(preg_match('/^STC\*/',$segments[0])){
					$seg = array_shift($segments);
					$temp = preg_split('/\*/',$seg);
					$line[] = $temp[1];
				}
				if(preg_match('/^REF\*/',$segments[0])){
					$seg = array_shift($segments);
				}
				if(preg_match('/^DTP\*/',$segments[0])){
					$seg = array_shift($segments);
				}
			}
			$subscriber['line'] = implode('|',$line);

			return array($subscriber,$seg);

	} # END function loadSubsciber

	public function toText(){
		$heading = array('Key','Value');
		$m = array();
		$m[] = array("Batch",$this->batch);
		$m[] = array("RecStatus",$this->receiverStatus);
		$m[] = array("RecAmount",$this->receiverAmount);
		$m[] = array("AccCount",$this->acceptedCount);
		$m[] = array("AccAmount",$this->acceptedAmount);
		$m[] = array("RejCount",$this->rejectedCount);
		$m[] = array("RejAmount",$this->rejectedAmount);
		return renderTable($heading,$m);
	}
	public function toTextSubscriber($subscriber){
		$m = array();
		$m[] = "SubscriberLast: ".$subscriber['last'];
		$m[] = "SubscriberFirst: ".$subscriber['first'];
		$m[] = "SubscriberId: ".$subscriber['id'];
		$m[] = "Chart: ".$subscriber['chart'];
		$m[] = "ClaimId: ".$subscriber['claimId'];
		$m[] = "ClaimStatus: ".$subscriber['status'];
		$m[] = "ClaimAmount: ".$subscriber['amount'];
		$m[] = "ClaimTCN: ".$subscriber['tcn'];
		$m[] = "ClaimDate: ".$subscriber['dos'];
		$e='';foreach($m as $mm){$e .= "$mm<br/>";}return $e;
	}
}
?>