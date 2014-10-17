<?php
class EDI837{

	private $filepath;

	function __construct(){
		$this->filepath = 'files/EDIbatches/';
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
#foreach($segments as $seg){ $m[] = $seg; }
try{
	$seg = array_shift($segments);
	if(preg_match('/^ISA\*/',$seg)){
		$temp = preg_split('/\*/',$seg);
		$etin =  $temp[6];
		$prov =  $temp[8];
		$date =  $temp[9];
		$time =  $temp[10];
		$batch = $temp[13];
		$m[] = $seg;
		$m[] = "Etin:  $etin";
		$m[] = "Prov:  $prov";
		$m[] = "Date:  $date";
		$m[] = "Time:  $time";
		$m[] = "Batch: $batch";
	}else{throw new exception('error loading ISA');}
}catch(exception $e){
	$error = $e->getMessage();
	$m[] = "Error: $error";
}
/*
		$m[] = "Step 2..Read file and load into 837D object";
		$m[] = "Step 3..Convert 837D to 837I";
		$m[] = "Step 3..Create x12 file from 837I object";
		$m[] = "Step 4..Write x12 to disk";
*/
		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		return "$e";
	}
}
?>