<?php
class EDI837{

	private $filepath;

	function __construct(){
		$this->filepath = 'files/EDIbatches/';
		require('lib/classes/EDI837D.php');
	}

	public function test(){
		return "Testing EDI837";
	}
	public function loadEDI837D(){

		$m = array();

		$m[] = "Step 1..Get x12 file from Axium";
		$file = 'a.x12';
		$x12 = file_get_contents($this->filepath.$file);
		$segments = preg_split('/~/',$x12);

		$m[] = "Step 2..Read file and load into 837D object";
		#foreach($segments as $seg){ $m[] = $seg; }
		$ediObj = new EDI837D();
		try{
		
			#LOAD ISA
			$seg = array_shift($segments);
			if(preg_match('/^ISA\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setSenderId($temp[6]);
				$ediObj->setReceiverId($temp[8]);
				$ediObj->setDate($temp[9]);
				$ediObj->setTime($temp[10]);
				$ediObj->setBatch($temp[13]);
			}else{throw new exception("error loading ISA<br/>---<br/>$seg<br/>---");}
		
			#LOAD GS
			$seg = array_shift($segments);
			if(preg_match('/^GS\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setFormat($temp[8]);
			}else{throw new exception("error loading GS<br/>---<br/>$seg<br/>---");}
		
			#LOAD ST 
			$seg = array_shift($segments);
			if(preg_match('/^ST\*/',$seg)){
			}else{throw new exception("error loading ST<br/>---<br/>$seg<br/>---");}
		
			#LOAD BHT 
			$seg = array_shift($segments);
			if(preg_match('/^BHT\*/',$seg)){
			}else{throw new exception("error loading BHT<br/>---<br/>$seg<br/>---");}
		
			#LOAD NM1 
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setSenderName($temp[3]);
			}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
		
			#LOAD PER 
			$seg = array_shift($segments);
			if(preg_match('/^PER\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setSubmitterName($temp[2]);
				$ediObj->setSubmitterPhone($temp[4]);
			}else{throw new exception("error loading PER<br/>---<br/>$seg<br/>---");}
		
			#LOAD NM1 
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setReceiverName($temp[3]);
			}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
		
			#LOAD HL 
			$seg = array_shift($segments);
			if(preg_match('/^HL\*/',$seg)){
			}else{throw new exception("error loading HL<br/>---<br/>$seg<br/>---");}
		
			#LOAD PRV 
			$seg = array_shift($segments);
			if(preg_match('/^PRV\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderSpecialty($temp[3]);
			}else{throw new exception("error loading PRV<br/>---<br/>$seg<br/>---");}
		
			#LOAD NM1 
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*85\*2\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderName($temp[3]);
				$ediObj->setBillingProviderNPI($temp[9]);
			}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
		
			#LOAD N3
			$seg = array_shift($segments);
			if(preg_match('/^N3\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderStreet($temp[1]);
			}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}
		
			#LOAD N4
			$seg = array_shift($segments);
			if(preg_match('/^N4\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderCity($temp[1]);
				$ediObj->setBillingProviderState($temp[2]);
				$ediObj->setBillingProviderZip($temp[3]);
			}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}
		
			#LOAD REF    I think this segment is how axium send the site id to emdeon
			$seg = array_shift($segments);
			if(preg_match('/^REF\*G5\*/',$seg)){
			}else{throw new exception("error loading REF<br/>---<br/>$seg<br/>---");}
		
			#LOAD REF
			$seg = array_shift($segments);
			if(preg_match('/^REF\*EI\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderTaxId($temp[2]);
			}else{throw new exception("error loading REF<br/>---<br/>$seg<br/>---");}
		
			#LOAD REF
			$seg = array_shift($segments);
			if(preg_match('/^REF\*0B\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderLicense($temp[2]);
			}else{throw new exception("error loading REF<br/>---<br/>$seg<br/>---");}
		
			#LOAD REF
			$seg = array_shift($segments);
			if(preg_match('/^PER\*IC\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setBillingProviderContactName($temp[2]);
				$ediObj->setBillingProviderContactNumber($temp[4]);
			}else{throw new exception("error loading REF<br/>---<br/>$seg<br/>---");}
		
			#LOAD NM1
			$seg = array_shift($segments);
			if(preg_match('/^NM1\*87\*/',$seg)){
			}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
		
			#LOAD N3
			$seg = array_shift($segments);
			if(preg_match('/^N3\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setPay2Name($temp[1]);
				$ediObj->setPay2Street($temp[2]);
			}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}
		
			#LOAD N4
			$seg = array_shift($segments);
			if(preg_match('/^N4\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$ediObj->setPay2City($temp[1]);
				$ediObj->setPay2State($temp[2]);
				$ediObj->setPay2Zip($temp[3]);
			}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}
		
			while(preg_match('/^HL\*2\*/',$segments[0])){
				$this->loadDentalClaim($segments);
			}

		###################################################
			#LOAD IEA
			$seg = array_shift($segments);
			if(preg_match('/^IEA\*/',$seg)){
			}else{throw new exception("error loading IEA<br/>---<br/>$seg<br/>---");}
		
		}catch(exception $e){
			$error = $e->getMessage();
			$m[] = "Error: $error";
		}
		$m[] = '-----------------';
		$m[] = 'EDI Object Output';
		$text = $ediObj->toText();
		$m[] = $text;
/*
		$m[] = "Step 3..Convert 837D to 837I";
		$m[] = "Step 3..Create x12 file from 837I object";
		$m[] = "Step 4..Write x12 to disk";
*/
		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		return "$e";
	}
	private function loadDentalClaim(&$segments){
		#LOAD HL
		$seg = array_shift($segments);
		if(preg_match('/^HL\*/',$seg)){
		}else{throw new exception("error loading HL<br/>---<br/>$seg<br/>---");}

		return 0;
	}
}
?>