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
		$_SESSION['chartList'] = $this->model->getCharts();
		#$_SESSION['chartList'] = '';
		$_SESSION['index'] = 0;
		$_SESSION['maxIndex'] = 10;
		return $ms;
	}
	function stage2(){
		$ms = 'stage 2';
/*
		$chart = '783948';
		$test = $this->model->test($chart);
		$patient = array(
			'chart' => $chart
		);
		$mess = $test[1];
		$ledger = $test[0];
		$this->createPDF($patient,$ledger);
		$ms = "hello from stage 2<br/>$mess";
*/
		return $ms;
	}
	function stage3(){
		$ms = '';
		$index    = $_SESSION['index'];
		$maxIndex = $_SESSION['maxIndex'];
		if($index <= $maxIndex){

			$chart = $_SESSION['chartList'][$index];
			$test = $this->model->test($chart);
			$patient = array(
				'chart' => $chart
			);
			$ledger = $test[0];
			$this->createPDF($patient,$ledger);

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
		$records = $ledger[1];
		$colwidth = array(25,25,25,10,30,70,20,50);
		$obj = array();
		$obj[] = $headings;
		$obj[] = $patient;
		$obj[] = $colwidth;
		$json = json_encode($obj);
		file_put_contents('files/pdfheader',$json);

		require('lib/pdf/fpdf.php');
		require('lib/pdf/PDF.php');

		$pdf = new PDF();
		$pdf->AddPage('L');
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',8);
		foreach($records as $record){
			$pdf->Cell($colwidth[0],10,$record[0]);
			$pdf->Cell($colwidth[1],10,$record[1]);
			$pdf->Cell($colwidth[2],10,$record[2],0,0,'R');
			$pdf->Cell($colwidth[3],10,'');
			$pdf->Cell($colwidth[4],10,$record[3]);
			$pdf->Cell($colwidth[5],10,$record[4]);
			$pdf->Cell($colwidth[6],10,$record[5]);
			$pdf->Cell($colwidth[7],10,$record[6]);
			$pdf->ln();
		}

		$pdf->Output("files/ledgers/$chart.pdf",'F');
	}
}
?>
