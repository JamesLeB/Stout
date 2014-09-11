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
		#$this->createPDF();
		return $ms;
	}
	function stage2(){
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
	function stage3(){
		$test = $this->model->test();
		$ms = "hello from stage 3 $test";
		return $ms;
	}
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
