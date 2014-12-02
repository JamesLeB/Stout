<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Junior extends CI_Controller {

	public function action(){
		$m = array();
		$message = $_POST['message'];
		$m[] = "Hello from Junior action function";
		$m[] = $message;
		if($message == 'One'){
			$m[] = 'Testing FTP';
			$m[] = $this->getFTP();
		}
		$m = implode('<br/>',$m); echo $m;
	}
	private function getFTP(){
		$m = array();
		$c = file_get_contents('files/config/juniorFTPpass');
		$c = preg_split('/\s/',$c);
		$ftp_server    = $c[0];
		$ftp_user_name = $c[1];
		$ftp_user_pass = $c[2];
		set_error_handler(function(){});
		$conn = ftp_connect($ftp_server);
		if($conn){
			$m[] = "Connection Success";
			$login = ftp_login($conn,$ftp_user_name,$ftp_user_pass);
			if($login){
				$m[] = "Login Success";
				# Get file from FTP server
				$local_file = 'files/zork';
				$remote_file = 'README.txt';
				if(ftp_get($conn,$local_file,$remote_file,FTP_BINARY)){
					$m[] = "File retrieved";
				}else{
					$m[] = "Failed to retrieve file";
				}
				# Put file on FTP server
				$local_file = 'files/york';
				$remote_file = 'test.txt';
				if(ftp_put($conn,$remote_file,$local_file,FTP_BINARY)){
					$m[] = "File Uploaded";
				}else{
					$m[] = "Failed to Upload file";
				}
				# Close FTP connection
				if(ftp_close($conn)){
					$m[] = "Connection Closed";
				}else{
					$m[] = "Connection Failed to Close";
				}
			}else{
				$m[] = "Login Failed";
			}
		}else{
			$m[] = "Connection Failed";
		}
		restore_error_handler();
		$m = implode('<br/>',$m); return $m;
	}
}
