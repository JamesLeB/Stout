<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grapher extends CI_Controller {

	public function index(){
		echo "Default return from Action controller";
	}
	public function config(){
		echo "configuring graph<br/>";
		$config = array(
			'max'     => 10,
			'min'     => 0,
			'sizex'   => 600,
			'sizey'   => 300,
			'padding' => 20
		);
		$json = json_encode($config);
		$file = 'lib/graphs/config/default.json';
		file_put_contents($file,$json);
		echo "$json";
	}
}

?>
