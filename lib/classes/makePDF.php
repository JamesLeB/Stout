<?php
class makePDF {
	private $sceneCount = 3;
	private $model;
	function __construct($model){
		$this->model = $model;
	}
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
		$ms .= 'Setting up index';
		$_SESSION['index'] = 0;
		$_SESSION['maxIndex'] = 10;
		return $ms;
	}
	function stage2(){
		$chart = '783948';
		$test = $this->model->test($chart);
		$patient = array(
			'chart' => $chart
		);
		$mess = $test[1];
		$ledger = $test[0];
		$this->createPDF($patient,$ledger);
		$ms = "hello from stage 2<br/>$mess";
		return $ms;
	}
	function stage3(){
		$ms = '';
		$index    = $_SESSION['index'];
		$maxIndex = $_SESSION['maxIndex'];
		if($index <= $maxIndex){
			header("status: 1");
		    $scene = $_SESSION['scene'];
			$ms .= "processing $index of $maxIndex";
		    $_SESSION['scene']--;
			$_SESSION['index']++;
		}else{
			$ms .="done processesing";
		}
		return $ms;
	}
	function stage4(){ return 'stage4'; }
	function createPDF($patient,$ledger){
		$chart = $patient['chart'];
		$headings = $ledger[0];
		require('lib/pdf/fpdf.php');
		$pdf = new FPDF();
		$pdf->AddPage('L');
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(128);
		$pdf->Cell(40,10,"Chart Number: $chart",'B');
		$pdf->ln();
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',8);

		$pdf->Cell(30,10,$headings[0]);
		$pdf->Cell(30,10,$headings[1]);
		$pdf->Cell(30,10,$headings[2]);
		$pdf->Cell(30,10,$headings[3]);
		$pdf->Cell(30,10,$headings[4]);
		$pdf->Cell(30,10,$headings[5]);
		$pdf->Cell(30,10,$headings[6]);
		$pdf->Cell(40,10,'XX');

		$pdf->Output("files/$chart.pdf",'F');
	}
}
?>
