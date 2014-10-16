<?php
class EDI837{
	public function test(){
		return "hello from EDI837 class";
	}
	public function loadEDI837D(){
		$m = array();
		$m[] = "Step 1..Get x12 file from Axium";
		$m[] = "Step 2..Read file and load into 837D object";
		$m[] = "Step 3..Convert 837D to 837I";
		$m[] = "Step 3..Create x12 file from 837I object";
		$m[] = "Step 4..Write x12 to disk";
		$e = ''; foreach($m as $mm){$e .= "$mm<br/>";}
		return "$e";
	}
}
?>