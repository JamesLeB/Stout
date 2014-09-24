<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	#private $model;
	private $filePath = 'files/EDIbatches/';

	function __construct(){
		parent::__construct();
		#$this->load->model('Character_model');
		#$this->model = $this->Character_model;
	}
	public function test(){
		$ms = 'Starting test<br/>';
		#$dbtest = $this->model->test();
		$file = 'test.txt';
		$ms .= "Saving file<br/>";
		file_put_contents($this->filePath.$file,"ready to move file and open it lunch time");
		$ms .= "Done Test<br/>";
		echo $ms;
	}
	public function getTestFile(){
		$secret = '';
		if(isset($_REQUEST['secret'])){
			$secret = $_REQUEST['secret'];
		}
		$file = 'a.txt';
		$x12 = file_get_contents($this->filePath.$file);
		$nX12 = $this->processX12($x12);
		$file = 'b.x12';
		file_put_contents($this->filePath.$file,$nX12);
		echo $this->toTextX12($nX12,$secret);
		#echo $this->toTextX12($x12);
	}
	private function toTextX12($x12,$secret){
		$segments = preg_split('/~/',$x12);
		$ms = '';
		foreach($segments as $seg){
			if($secret == 'all'){
				$ms .= "$seg<br/>";
			}elseif($secret == 'claims' && preg_match('/^CLM\*/',$seg)){
				$ms .= "$seg<br/>";
			}
		}
		return $ms;
	}
	private function processX12($x12){
		$segments = preg_split('/~/',$x12);
		$fixed = array();
		foreach($segments as $seg){
			if(preg_match('/^ISA\*00/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp = preg_split('/\*/',$seg);
				$temp[6] = 'F00            ';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^GS\*HC\*/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[2] = 'F00';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*41\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NEW YORK UNIV DENTAL CTR';
				$temp[9] = 'F00';
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*40\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NYSDOH';
				$temp[9] = 141797357;
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*85\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NEW YORK UNIV DENTAL CTR';
				$temp[9] = 1164555124;
				$fixed[] = implode('*',$temp);
			}elseif(preg_match('/^NM1\*PR\*2/',$seg)){
				$temp = preg_split('/\*/',$seg);
				$temp[3] = 'NYSDOH';
				$temp[9] = 141797357;
				$fixed[] = implode('*',$temp);
				#$fixed[] = $seg . ' -----  FLAG';
			}else{
				$fixed[] = $seg;
			}
		}
		return implode('~',$fixed);
	} # END processX12 function
}

?>
