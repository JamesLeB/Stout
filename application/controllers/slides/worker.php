<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Worker extends CI_Controller {

	#private $model;

	function __construct(){
		parent::__construct();
		#$this->load->model('Character_model');
		#$this->model = $this->Character_model;
	}
	public function test(){
		#$dbtest = $this->model->test();
		echo "Worker Test function<br/>";
	}
}

?>
