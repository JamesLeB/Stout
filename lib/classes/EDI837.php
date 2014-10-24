<?php
class EDI837{

	private $filepath;

	function __construct(){
		$this->filepath = 'files/edi/';
	}
	public function test(){
		return "Testing EDI837";
	}
	public function loadEDI837D(){

		$m = array();

		$m[] = "Step 1..Get x12 file from Axium";
		$file = 'a.txt';
		$x12 = file_get_contents($this->filepath.$file);
		$segments = preg_split('/~/',$x12);

		$m[] = "Step 2..Read file and load into 837D object";
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

			while(preg_match('/^HL\*[0-9]+\*\*20\*/',$segments[0])){
				$provider = $this->loadProvider($segments);
				$ediObj->addProvider($provider);
			}

			#LOAD SE
			$seg = array_shift($segments);
			if(preg_match('/^SE\*/',$seg)){
			}else{throw new exception("error loading SE<br/>---<br/>$seg<br/>---");}

			#LOAD GE
			$seg = array_shift($segments);
			if(preg_match('/^GE\*/',$seg)){
			}else{throw new exception("error loading GE<br/>---<br/>$seg<br/>---");}

			#LOAD IEA
			$seg = array_shift($segments);
			if(preg_match('/^IEA\*/',$seg)){
			}else{throw new exception("error loading IEA<br/>---<br/>$seg<br/>---");}

		}catch(exception $e){
			$error = $e->getMessage();
			$m[] = "Error: $error";
		}

		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		return array('message'=>$e,'ediObj'=>$ediObj);
	} # END function loadEDI837D
	private function loadProvider(&$segments){
		$provider = new billingProvider();

		#LOAD HL 
		$seg = array_shift($segments);
		if(preg_match('/^HL\*[0-9]+\*\*20/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setHeader($seg);
		}else{throw new exception("error loading HL Billing Provider<br/>---<br/>$seg<br/>---");}
	
		#LOAD PRV 
		$seg = array_shift($segments);
		if(preg_match('/^PRV\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderSpecialty($temp[3]);
		}else{throw new exception("error loading PRV<br/>---<br/>$seg<br/>---");}
	
		#LOAD NM1 
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*85\*[1-2]\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderName($temp[3]);
			$provider->setBillingProviderNPI($temp[9]);
		}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
	
		#LOAD N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderStreet($temp[1]);
		}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}
	
		#LOAD N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderCity($temp[1]);
			$provider->setBillingProviderState($temp[2]);
			$provider->setBillingProviderZip($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}
	
		#LOAD REF    I think this segment is how axium send the site id to emdeon
		if(preg_match('/^REF\*G5\*/',$segments[0])){
			$seg = array_shift($segments);
		}#else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}
	
		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*EI\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderTaxId($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}
	
		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*0B\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderLicense($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}
	
		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^PER\*IC\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$provider->setBillingProviderContactName($temp[2]);
			$provider->setBillingProviderContactNumber($temp[4]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}
	
		#LOAD NM1
		if(preg_match('/^NM1\*87\*/',$segments[0])){
			$seg = array_shift($segments);
		}#else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}
	
		#LOAD N3
		if(preg_match('/^N3\*/',$segments[0])){
			$seg = array_shift($segments);
			$temp = preg_split('/\*/',$seg);
			$provider->setPay2Name($temp[1]);
			if(isset($temp[2])){$provider->setPay2Street($temp[2]);}
		}#else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}
	
		#LOAD N4
		if(preg_match('/^N4\*/',$segments[0])){
			$seg = array_shift($segments);
			$temp = preg_split('/\*/',$seg);
			$provider->setPay2City($temp[1]);
			$provider->setPay2State($temp[2]);
			$provider->setPay2Zip($temp[3]);
		}#else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		while(preg_match('/^HL\*[0-9]+\*[0-9]+\*22\*/',$segments[0])){
			$claim = $this->loadDentalClaim($segments);
			$provider->addClaim($claim);
		}

		return $provider;
	}
	private function loadDentalClaim(&$segments){

		$claim = new dentalClaim();

		#LOAD HL
		$seg = array_shift($segments);
		if(preg_match('/^HL\*[0-9]+\*[0-9]+\*22\*/',$seg)){
			$claim->setClaimIndex($seg);
		}else{throw new exception("error loading HL<br/>---<br/>$seg<br/>---");}

		#LOAD SBR
		$seg = array_shift($segments);
		if(preg_match('/^SBR\*/',$seg)){
		}else{throw new exception("error loading SBR<br/>---<br/>$seg<br/>---");}

		#LOAD NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*IL\*1\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPatientFirst($temp[4]);
			$claim->setPatientLast($temp[3]);
			$claim->setPatientMiddle($temp[5]);
			$claim->setPatientId($temp[9]);
		}else{throw new exception("error loading SBR<br/>---<br/>$seg<br/>---");}

		#LOAD N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPatientStreet($temp[1]);
		}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}

		#LOAD N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPatientCity($temp[1]);
			$claim->setPatientState($temp[2]);
			$claim->setPatientZip($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		#LOAD DMG
		$seg = array_shift($segments);
		if(preg_match('/^DMG\*D8\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPatientBirth($temp[2]);
			$claim->setPatientSex($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		#LOAD NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*PR\*2\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPayerName($temp[3]);
			$claim->setPayerId($temp[9]);
		}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}

		#LOAD N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPayerStreet1($temp[1]);
			$claim->setPayerStreet2($temp[2]);
		}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}

		#LOAD N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPayerCity($temp[1]);
			$claim->setPayerState($temp[2]);
			$claim->setPayerZip($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*FY\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setPayer2ndId($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*G2\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setBillingProvider2ndId($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		if(preg_match('/^HL\*[0-9]+\*[0-9]+\*23\*/',$segments[0])){
			$patient = $this->loadPatient($segments);
			$claim->setPatient($patient);
		}

		#LOAD CLM
		$seg = array_shift($segments);
		if(preg_match('/^CLM\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setClaimId($temp[1]);
			$claim->setClaimAmount($temp[2]);
			$claim->setFacilityCode($temp[5]);
			$claim->setSignature($temp[6]);
			$claim->setAssignmentCode($temp[7]);
			$claim->setAssignmentStatus($temp[8]);
			$claim->setRelease($temp[9]);
		}else{throw new exception("error loading CLM<br/>---<br/>$seg<br/>---");}

		#LOAD DTP
		$seg = array_shift($segments);
		if(preg_match('/^DTP\*472\*D8\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setServiceDate($temp[3]);
		}else{throw new exception("error loading DTP<br/>---<br/>$seg<br/>---");}

		#LOAD PWK
		if(preg_match('/^PWK\*/',$segments[0])){
			$temp = preg_split('/\*/',$segments[0]);
			$claim->setSupplementalInfo($segments[0]);
			$seg = array_shift($segments);
		}

		#LOAD AMT
		if(preg_match('/^AMT\*F5\*/',$segments[0])){
			$temp = preg_split('/\*/',$segments[0]);
			$claim->setPatientPaid($temp[2]);
			$seg = array_shift($segments);
		}

		#LOAD REF
		if(preg_match('/^REF\*G3\*/',$segments[0])){
			$temp = preg_split('/\*/',$segments[0]);
			$claim->setTcn($temp[2]);
			$seg = array_shift($segments);
		}

		#LOAD REF
		if(preg_match('/^REF\*4N\*/',$segments[0])){
			$temp = preg_split('/\*/',$segments[0]);
			$claim->setExceptionCode($temp[2]);
			$seg = array_shift($segments);
		}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*D9\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setClaimId2($temp[2]);
		}else{throw new exception("error loading REF<br/>---<br/>$seg<br/>---");}

		#LOAD NTE
		$seg = array_shift($segments);
		if(preg_match('/^NTE\*ADD\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setClaimNote($temp[2]);
		}else{throw new exception("error loading NTE<br/>---<br/>$seg<br/>---");}

		#LOAD NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*82\*1\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setProviderName($temp[3]);
			$claim->setProviderId($temp[9]);
		}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}

		#LOAD PRV
		$seg = array_shift($segments);
		if(preg_match('/^PRV\*PE\*PXC\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setProviderTaxonomy($temp[3]);
		}else{throw new exception("error loading PRV<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*G2\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setProviderId2($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}

		#LOAD NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*77\*2\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setFacilityName($temp[3]);
			$claim->setFacilityId($temp[9]);
		}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}

		#LOAD N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setFacilityStreet($temp[1]);
		}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}

		#LOAD N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setFacilityCity($temp[1]);
			$claim->setFacilityState($temp[2]);
			$claim->setFacilityZip($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*0B\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$claim->setFacilityId2($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}

		while(preg_match('/^LX\*/',$segments[0])){
			$service = $this->loadService($segments);
			$claim->addService($service);
		}
		return $claim;
	}# END function loadDentalClaim
	private function loadPatient(&$segments){
		$patient = new patient();

		#LOAD HL
		$seg = array_shift($segments);
		if(preg_match('/^HL\*[0-9]+\*[0-9]+\*23\*/',$seg)){
		}else{throw new exception("error loading HL<br/>---<br/>$seg<br/>---");}

		#LOAD PAT
		$seg = array_shift($segments);
		if(preg_match('/^PAT\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$patient->setRelationship($temp[1]);
		}else{throw new exception("error loading PAT<br/>---<br/>$seg<br/>---");}

		#LOAD NM1
		$seg = array_shift($segments);
		if(preg_match('/^NM1\*QC\*1\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$patient->setFirst($temp[4]);
			$patient->setLast($temp[3]);
		}else{throw new exception("error loading NM1<br/>---<br/>$seg<br/>---");}

		#LOAD N3
		$seg = array_shift($segments);
		if(preg_match('/^N3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$patient->setStreet($temp[1]);
			if(isset($temp[2])){$patient->setStreet2($temp[2]);}
		}else{throw new exception("error loading N3<br/>---<br/>$seg<br/>---");}

		#LOAD N4
		$seg = array_shift($segments);
		if(preg_match('/^N4\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$patient->setCity($temp[1]);
			$patient->setState($temp[2]);
			$patient->setZip($temp[3]);
		}else{throw new exception("error loading N4<br/>---<br/>$seg<br/>---");}

		#LOAD DMG
		$seg = array_shift($segments);
		if(preg_match('/^DMG\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$patient->setBirth($temp[2]);
			$patient->setSex($temp[3]);
		}else{throw new exception("error loading DMG<br/>---<br/>$seg<br/>---");}

		return $patient;
	}# END function loadPatient
	private function loadService(&$segments){

		$service = new service();

		#LOAD LX
		$seg = array_shift($segments);
		if(preg_match('/^LX\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$service->setLineNumber($temp[1]);
		}else{throw new exception("error loading LX<br/>---<br/>$seg<br/>---");}

		#LOAD SV3
		$seg = array_shift($segments);
		if(preg_match('/^SV3\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$service->setAdaCode($temp[1]);
			$service->setLineAmount($temp[2]);
		}else{throw new exception("error loading SV3<br/>---<br/>$seg<br/>---");}

		#LOAD TOO
		if(preg_match('/^TOO\*JP\*/',$segments[0])){
			$temp = preg_split('/\*/',$segments[0]);
			$service->setToothNumber($temp[2]);
			$seg = array_shift($segments);
		}

		#LOAD DTP
		$seg = array_shift($segments);
		if(preg_match('/^DTP\*472\*D8\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$service->setServiceDate($temp[3]);
		}else{throw new exception("error loading DTP<br/>---<br/>$seg<br/>---");}

		#LOAD REF
		$seg = array_shift($segments);
		if(preg_match('/^REF\*6R\*/',$seg)){
			$temp = preg_split('/\*/',$seg);
			$service->setLineControl($temp[2]);
		}else{throw new exception("erroc loading REF<br/>---<br/>$seg<br/>---");}

		return $service;
	}# END function loadService
}
?>