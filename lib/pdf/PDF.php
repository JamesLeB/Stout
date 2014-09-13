<?php

class PDF extends FPDF{
	function Header(){

		$json = file_get_contents('files/pdfheader');
		$obj = json_decode($json,true);

		$headings = $obj[0];
		$patient  = $obj[1];
		$colwidth = $obj[2];
		$align    = $obj[3];
		$chart = $patient['chart'];

		$this->SetTextColor(0);

		$this->SetFont('Arial','B',16);
		$this->Cell(30,10,'Patient Ledger');
		$this->ln(10);

		$this->SetFont('Arial','',14);
		$this->Cell(140,10,"Chart Number: $chart",'B');
		$this->ln(15);

		$this->SetTextColor(0);
		$this->SetFont('Arial','B',8);
		$this->Cell($colwidth[0],10,$headings[0],0,0,$align[0]);
		$this->Cell($colwidth[1],10,$headings[1],0,0,$align[1]);
		$this->Cell($colwidth[2],10,$headings[2],0,0,$align[2]);
		$this->Cell($colwidth[3],10,$headings[3],0,0,$align[3]);
		$this->Cell($colwidth[4],10,$headings[4],0,0,$align[4]);
		$this->Cell($colwidth[5],10,'');
		$this->Cell($colwidth[6],10,$headings[5],0,0,$align[5]);
		$this->Cell($colwidth[7],10,$headings[6],0,0,$align[6]);
		$this->ln();
	}
}

?>
