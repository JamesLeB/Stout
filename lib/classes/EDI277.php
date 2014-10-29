<?php
class EDI277{

	private $filepath;

	function __construct(){
		$this->filepath = 'files/edi/';
	}
	public function test(){
		return "Testing EDI837";
	}
	public function load277(){

			#LOAD GS
			#$seg = array_shift($segments);
			#if(preg_match('/^GS\*/',$seg)){
				#$temp = preg_split('/\*/',$seg);
				#$ediObj->setFormat($temp[8]);
			#}else{throw new exception("error loading GS<br/>---<br/>$seg<br/>---");}
		
	} # END function loadEDI837D
	public function toText(){
		return "to texting";
	}
}
?>