<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Junior extends CI_Controller {

	public function go(){
		# Get ftp batch list
		$a = $this->getFTP('getFtpBatchList');
		$list = JSON_decode($a[1],true);
		$checkedList = array();
		if(is_array($list)){
			foreach($list as $l){$checkedList[]=$l;}
		}
		$d['folderName'] = 'zork';
		$d['list'] = $checkedList;
		$e = $this->load->view('junior/folderView',$d,true);
		# Get local unproccesed list
		$list = scandir('files/edi');
		$checkedList = array();
		if(is_array($list)){
			foreach($list as $l){
				if(preg_match('/\.x12/',$l)){$checkedList[] = $l;}
			}
		}
		$d['folderName'] = 'zork1';
		$d['list'] = $checkedList;
		$e1 = $this->load->view('junior/folderView',$d,true);
		# Get local proccessed list
		$list = scandir('files/edi/SENT');
		$checkedList = array();
		if(is_array($checkedList)){
			foreach($list as $l){
				if(preg_match('/\.x12/',$l)){$checkedList[] = $l;}
			}
		}
		$d['folderName'] = 'zork2';
		$d['list'] = $checkedList;
		$e2 = $this->load->view('junior/folderView',$d,true);
		# Get ftp x12 folder
		$a = $this->getFTP('getFtpX12List');
		$list = JSON_decode($a[1],true);
		$checkedList = array();
		if(is_array($list)){
			foreach($list as $l){
				if(preg_match('/\.x12/',$l)){$checkedList[] = $l;}
			}
		}
		$d['folderName'] = 'zork3';
		$d['list'] = $checkedList;
		$e3 = $this->load->view('junior/folderView',$d,true);
		#pack file lists into object
		$obj = array($e,$e1,$e2,$e3);
		$json = JSON_encode($obj);
		echo $json;
	}
	public function action(){
		$m = array();
		$message = $_POST['message'];
		$m[] = "Action function";
		if($message == 'One'){
			$m[] = '<br/>Testing FTP get';
			$a = $this->getFTP('testGet');
			$m[] = $a[0];
			$m[] = '<br/>Testing FTP put';
			$a = $this->getFTP('testPut');
			$m[] = $a[0];
		}
		$m = implode('<br/>',$m); echo $m;
	}
	public function getFtpBatchList(){
		$a = $this->getFTP('getFtpBatchList');
		echo "$a[1]";
	}
	private function getFTP($task){
		$m = array();
		$json = 'json here';
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
				if($task == 'testGet'){
					# Get file from FTP server
					$local_file = 'files/zork';
					$remote_file = 'README.txt';
					if(ftp_get($conn,$local_file,$remote_file,FTP_BINARY)){
						$m[] = "File retrieved";
					}else{
						$m[] = "Failed to retrieve file";
					}
				}elseif($task == 'testPut'){
					# Put file on FTP server
					$local_file = 'files/york';
					$remote_file = 'test.txt';
					if(ftp_put($conn,$remote_file,$local_file,FTP_BINARY)){
						$m[] = "File Uploaded";
					}else{
						$m[] = "Failed to Upload file";
					}
				}elseif($task == 'getFtpBatchList'){
					# Get list of files
					$fileList = ftp_nlist($conn,'batches');
					if($fileList){
						$m[] = "YES list";
						foreach($fileList as $f){
							$m[] = "$f";
						}
						$json = json_encode($fileList);
					}else{
						$m[] = "NO list";
					}
				}elseif($task == 'getFtpX12List'){
					# Get list of files
					$fileList = ftp_nlist($conn,'x12');
					if($fileList){
						$m[] = "YES list";
						foreach($fileList as $f){
							$m[] = "$f";
						}
						$json = json_encode($fileList);
					}else{
						$m[] = "NO list";
					}
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
		$m = implode('<br/>',$m); return array($m,$json);
	}
}
