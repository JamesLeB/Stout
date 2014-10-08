<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stage extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function setup(){
		#$actor = new actor();
		$this->load->model('Dentrix');
		$actor = new makePDF($this->Dentrix);
		header('scene: 1');
		$_SESSION['scene'] = 1;
		$_SESSION['sceneCount'] = $actor->getSceneCount();
		echo "Setting Up Show<br/>";
	}
	public function running(){
		$ms = array();
		if( $_SESSION['scene'] <= $_SESSION['sceneCount'] ){
			header('scene: 1');
			#$actor = new actor();
			$this->load->model('Dentrix');
			$actor = new makePDF($this->Dentrix);
			$ms[] = $actor->scene();
			$_SESSION['scene']++;
		}else{
			$ms[] = "Show Done";
		}
		$echo = '';
		foreach($ms as $m){
			$echo .= "$m<br/>";
		}
		echo "$echo";
	}
	public function test(){
		echo "Starting Test...<br/>";
		$this->load->model('Dentrix');
		$actor = new makePDF($this->Dentrix);
		$ms = $actor->test();
		echo "$ms<br/>";
		#$test = $this->Dentrix->test('H0904');
		#echo "$test";
		echo "Test done :)<br/>";
	}
}

?>
