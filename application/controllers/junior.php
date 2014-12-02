<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Junior extends CI_Controller {

	public function action(){
		$m = array();
		$message = $_POST['message'];
		$m[] = "Hello from Junior action function";
		$m[] = $message;
		$m = implode('<br/>',$m); echo $m;
	}
}
