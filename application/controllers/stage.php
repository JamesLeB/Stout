<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stage extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function test(){
		echo "Starting Test...<br/>";
		$this->load->model('Dentrix');
		$test = $this->Dentrix->test('H0904');
		echo "$test";
		#$arg1 = $this->uri->segment(4);
		#$this->load->model('warehouse');
		echo "Test done :)<br/>";
	}
	public function setup(){
		$thing = new makePDF('');
		header('scene: 1');
		$_SESSION['scene'] = 1;
		$_SESSION['sceneCount'] = $thing->getSceneCount();
		echo "Setting Up Scene<br/>";
	}
	public function running(){
		$ms = array();
		if( $_SESSION['scene'] <= $_SESSION['sceneCount'] ){
			header('scene: 1');
			$this->load->model('Dentrix');
			$model = $this->Dentrix;
			$thing = new makePDF($model);
			$ms[] = $thing->stage();
			#$ms[] = $thing->test();
			$_SESSION['scene']++;
		}else{
			$ms[] = "Scene Done";
		}
		$echo = '';
		foreach($ms as $m){
			$echo .= "$m<br/>";
		}
		echo "$echo";
	}
}

?>
