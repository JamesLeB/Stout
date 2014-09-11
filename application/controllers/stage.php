<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stage extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function test(){
		#$arg1 = $this->uri->segment(4);
		#$this->load->model('warehouse');
	}
	public function setup(){
		$thing = new makePDF();
		header('scene: 1');
		$scene = 1;
		$_SESSION['scene'] = 1;
		$_SESSION['sceneCount'] = $thing->getSceneCount();
		echo "Setting Up Scene<br/>";
	}
	public function running(){
		$ms = array();
		if( $_SESSION['scene'] <= $_SESSION['sceneCount'] ){
			header('scene: 1');
			$thing = new makePDF();
			$ms[] = $thing->stage();
			$_SESSION['scene']++;
		}else{
			$ms[] = "Scene Done<br/>";
		}
		$echo = '';
		foreach($ms as $m){
			$echo .= "$m<br/>";
		}
		echo "$echo";
	}
}

?>
