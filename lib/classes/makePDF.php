<?php
class makePDF {
	private $sceneCount = 1;
	function getSceneCount(){ return $this->sceneCount; }
	function stage(){
		$ms = '';
		    if($_SESSION['scene'] == 1){$ms .= $this->stage1();}
		elseif($_SESSION['scene'] == 2){$ms .= $this->stage2();}
		elseif($_SESSION['scene'] == 3){$ms .= $this->stage3();}
		elseif($_SESSION['scene'] == 4){$ms .= $this->stage4();}
		else{ $ms .= 'ERROR - invalid scene number!!'; }
		return $ms;
	}
	function stage1(){
		$ms = '';
		$ms .= 'start<br/>';
		$this->createPDF();
		$ms .= 'end<br/>';
		return $ms;
	}
	function stage2(){ return 'stage2'; }
	function stage3(){ return 'stage3'; }
	function stage4(){ return 'stage4'; }
	function createPDF(){
		require('lib/pdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(128);
		$pdf->Cell(40,10,'MEETING TIME','B');
		$pdf->ln();
		$pdf->Cell(40,10,'JR IS BACK');
		$pdf->Output('files/test1.pdf','F');
	}
}
?>
