<?php
class makePDF {
	private $sceneCount = 3;
	private $model;
	private $index = 0;
	private $maxIndex = 10;
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
		$index = $this->index;
		$maxIndex = $this->maxIndex;
		$ms = '';
		$ms .= 'Stage 1<br/>';
		$ms .= '-- Setting up index<br/>';
		$ms .= "-- Index is $index<br/>";
		$ms .= "-- Max Index is $maxIndex<br/>";
		$_SESSION['index'] = $index;
		$_SESSION['maxIndex'] = $maxIndex;
		$ms .= '-- Stage 1 Complete...';
		return $ms;
	}
	function stage2(){
		$ms = '';
		$ms .= 'Stage 2<br/>';
		$ms .= '-- Loading chart list onto session<br/>';
		$_SESSION['chartList'] = $this->model->getCharts();
		$ms .= '-- Stage 2 Complete...';
		return $ms;
	}
	function stage3(){
		$ms = '';
		$ms .= 'Stage 3<br/>';
		$index    = $_SESSION['index'];
		$maxIndex = $_SESSION['maxIndex'];
		if($index <= $maxIndex){
			$ms .= '-- Processing List<br/>';

			#$chart = $_SESSION['chartList'][$index];
$chart = '072569';
			#$test = $this->model->go($chart);
			$patient = array(
				'chart' => $chart
			);
			#$ledger = $test[0];
			#$this->createPDF($patient,$ledger);

			header("status: 1");
		    #$scene = $_SESSION['scene'];
			$ms .= "processing $index of $maxIndex";
		    $_SESSION['scene']--;
			$_SESSION['index']++;
		}else{
			$ms .= "-- Stage 3 complete...";
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
