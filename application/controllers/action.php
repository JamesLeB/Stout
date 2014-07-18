<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

	public function index(){
		echo "Default return from Action controller";
	}
	public function test(){
		echo "Hello from test function<br/>";
		echo "ready to test db connections<br/>";
		$db = $this->load->database('dentrix',true);
		$rs = $db->query("
			select
				claimid
			from
				DDB_CLAIM
			where
				dateofclaim = '2014-06-22'
		");
		$a = array();
		foreach($rs->result_array() as $row){
			$x = array();
			$x[] = $row['claimid'];
			$a[] = $x;
		}
		$h = array('claimid');
		renderTable($h,$a);
		echo "Yay passed the test :)<br/>";

		#header('kara: 1');
		#$james = "hello' world ' waht ";
		#$what = preg_replace('/\'/',' ',$james);
	}
	public function kara(){
		#header('kara: 1');
	}
}

?>
