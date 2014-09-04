<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grapher extends CI_Controller {

	public function config(){
		echo "configuring graph...<br/>";

		# SET GRAPH CONFIG
		$config = array(
			'max'     => 10,
			'min'     => 0,
			'sizex'   => 600,
			'sizey'   => 300,
			'legendX' => 190,
			'legendY' => 20,
			'padding' => 20
		);
		$json1 = json_encode($config);
		$file1 = 'lib/graphs/config/default.json';
		file_put_contents($file1,$json1);

		# SET DATA SET 1
		$setName = 'DEFAULT';
		$label = array('A','B','C','D','E');
		$color = array(
			"R"=>0,
			"G"=>0,
			"B"=>256
		);
		$data  = array(1,2,3,4,3);
		$dataSet1 = array(
			'setName' => $setName,
			'label'   => $label,
			'color'   => $color,
			'data'    => $data
		);
		$json2 = json_encode($dataSet1);
		$file2 = 'lib/graphs/config/data1.json';
		file_put_contents($file2,$json2);

		echo "config done...<br/>";
	}
}

?>
