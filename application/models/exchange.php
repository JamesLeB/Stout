<?php
class Exchange extends CI_Model{

	#private $db;

	function __construct(){
		parent::__construct();
		#$this->db = $this->load->database('dentrix',true);
	}
	public function index(){
		return "message from exchange model";
	}
}
?>
