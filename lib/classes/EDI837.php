<?php
class EDI837{
	public function test(){
		return "hello from EDI837 class";
	}
	public function loadEDI837D(){
		$m = array();
		$m[] = "Step 1..Get x12 file from Axium";
		$m[] = "Step 2..Read file and load into object";
		$m[] = "Step 3..Create 837I";
		$m[] = "Step 4..Write 837I to disk";
		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		return "$e";
	}
}
?>