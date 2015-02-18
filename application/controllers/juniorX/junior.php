<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Junior extends CI_Controller {

	public function getNewClaims()
	{
		$list = scandir('files/edi/sentClaims');
		$out = array();
		foreach($list as $item)
		{
			if(preg_match('/.+.txt/',$item)){ $out[] = $item; }
		}
		echo json_encode($out);
	}
	public function getProcessedClaims()
	{
		$list = scandir('files/edi/processedClaims');
		$out = array();
		foreach($list as $item)
		{
			if(!preg_match('/^\./',$item)){ $out[] = $item; }
		}
		echo json_encode($out);
	}
	public function processClaim()
	{
		ini_set('max_execution_time','6000');
		$file = $_POST['file'];
		$new1 = "files/edi/sentClaims/$file";
		$new2 = "files/edi/processedClaims/$file";
		$new3 = "files/edi/intClaims/$file";
		$m = array();
		$m[] = "File: $file";
		if(file_exists($new2))
		{
			$m[] = "File status: !!We have this file!!";
		}
		else
		{
			$m[] = "File status: New file";
			$f = file_get_contents($new1);
			$m[] = "reading file";
			$line = preg_split('/~/',$f);
			require_once('lib/classes/EDI837.php');
			$obj = new EDI837();
			$t = $obj->loadEDI837D('sentClaims/'.$file);
			$message = $t['message'];
			$status  = $t['status'];
			$batch   = $t['ediObj'];
			$m[] = "Message: $message";
			$m[] = "status: $status";
			$m[] = "";
			if($status == 0)
			{
				file_put_contents($new3,$f);
				unlink($new1);
			}
			elseif($status == 99)
			{
			}
			else
			{
				$batchStuff = $batch->getStuff();
				$batchNumber = $batchStuff['batch'];
				$batchDate   = $batchStuff['date'];
				$providerList = $batch->getProviders();
				foreach($providerList as $provider)
				{
					$providerName = $provider->getBillingProviderName();
					$m[] = $providerName;
					$claimList = $provider->getClaims();
					foreach($claimList as $claim)
					{
						$stuff   = $claim->getStuff();
						$last    = $stuff['last'];
						$first   = $stuff['first'];
						$id      = $stuff['id'];
						$birth   = $stuff['birth'];
						$sex     = $stuff['sex'];
						$claimid = $stuff['claimid'];
						$claimAmount  = $stuff['amount'];
						$tcn     = $stuff['tcn'];
						$payer = $claim->getPayer();
						$m[] = "";
						$serviceList = $claim->getServices();
						foreach($serviceList as $service)
						{
							$serviceData = $service->getStuff();
							$adacode = $serviceData['adacode'];
							$adacode = preg_split('/:/',$adacode);
							$adacode = $adacode[1];
							$amount  = $serviceData['amount'];
							$date    = $serviceData['date'];
							$tooth   = $serviceData['tooth'];
							$lineNum = $serviceData['number'];
							$m[] = "&nbsp$batchNumber,$batchNumber,$last, $first, $id, $birth, $sex, $claimid, $tcn, $lineNum, $adacode, $tooth, $amount, $date, $payer, $providerName";
							$record = array(
								'batchNum'  => $batchNumber,
								'batchDate' => $batchDate,
								'last'      => $last,
								'first'     => $first,
								'id'        => $id,
								'birth'     => $birth,
								'sex'       => $sex,
								'claimid'   => $claimid,
								'tcn'       => $tcn,
								'lineNum'      => $lineNum,
								'adacode'      => $adacode,
								'tooth'        => $tooth,
								'amount'       => $amount,
								'date'         => $date,
								'payer'        => $payer,
								'providerName' => $providerName
							);
							# Load into DB
							$this->load->model('Warehouse');
							$result = $this->Warehouse->loadRecord($record);
							$m[] = "loading: $result";
						} # end service iteration
					} # end claims iteration
					$m[] = "\n";
				} # end providers iteration
				file_put_contents($new2,$f);
				unlink($new1);
			} # end if that checks for correctly loaded 837 object
		}
		echo implode("<br/>",$m);
	}
	public function resetClaim()
	{
		$file = $_POST['file'];
		$new1 = "files/edi/sentClaims/$file";
		$new2 = "files/edi/processedClaims/$file";
		$f = file_get_contents($new2);
		file_put_contents($new1,$f);
		unlink($new2);
		echo "$file copied";
	}
	public function loadBatch()
	{
		$file = $_POST['file'];
		$d['batch'] = $file;
		echo $this->load->view('junior/batchView',$d,true);
	}
	public function get277List(){
		$a = $this->getFTP('get277List','');
		echo $a[1];
	}
	public function saveLog(){
		$file = $_POST['file'];
		$data = $_POST['log'];
		$a = $this->getFTP('saveLog',array($file,$data));
		$b = $a[1];
		echo "<br/>Saving log $file<br/><br/>$data";
	}
	public function transferX12(){
		# This function is going to move the 837I files from local system to ftp server
		$file = $_POST['file'];
				#elseif($task == 'moveFileBack')
		$a = $this->getFTP('moveFileBack',$file);
		$b = $a[1];
		echo "<br/>Transfering $file<br/><br/>$b";
	} # END function transferX12
	public function getBatchFile(){
		$file = $_POST['file'];
		$a = $this->getFTP('moveFile',$file);
		$b = $a[1];
		echo "<br/>Moving $file<br/><br/>$b";
	}
	public function go(){

		# Get ftp batch list
		$a = $this->getFTP('getFtpBatchList','');
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
				if(preg_match('/\.txt$/',$l) && !preg_match('/^log/',$l)){$checkedList[] = $l;}
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

		# Get local To Transfer list
		$list = scandir('files/edi');
		$checkedList = array();
		if(is_array($checkedList)){
			foreach($list as $l){
				if(preg_match('/\.x12/',$l)){$checkedList[] = $l;}
			}
		}
		$d['folderName'] = 'zork3';
		$d['list'] = $checkedList;
		$e3 = $this->load->view('junior/folderView',$d,true);

		# Get ftp x12 folder
		$a = $this->getFTP('getFtpX12List','');
		$list = JSON_decode($a[1],true);
		$checkedList = array();
		if(is_array($list)){
			foreach($list as $l){
				if(preg_match('/\.x12/',$l)){$checkedList[] = $l;}
			}
		}
		$d['folderName'] = 'zork4';
		$d['list'] = $checkedList;
		$e4 = $this->load->view('junior/folderView',$d,true);

		#pack file lists into object
		$obj = array($e,$e1,$e2,$e3,$e4);
		$json = JSON_encode($obj);
		echo $json;
	}
	public function action(){
		$m = array();
		$message = $_POST['message'];
		$m[] = "Action function";
		if($message == 'One'){
			$m[] = '<br/>Testing FTP get';
			$a = $this->getFTP('testGet','');
			$m[] = $a[0];
			$m[] = '<br/>Testing FTP put';
			$a = $this->getFTP('testPut','');
			$m[] = $a[0];
		}
		$m = implode('<br/>',$m); echo $m;
	}
	public function getFtpBatchList(){
		$a = $this->getFTP('getFtpBatchList','');
		echo "$a[1]";
	}
	private function getFTP($task,$data){
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
					$fileList = ftp_nlist($conn,'Batches');
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
				elseif($task == 'getFtpX12List')
				{
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
				elseif($task == 'get277List')
				{
					# Get list of files
					#$fileList = ftp_nlist($conn,'x277');
					$fileList = array('a');
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
				elseif($task == 'moveFile')
				{
					# Move file from ftp server to local disk
					$local_file = "files/edi/$data";
					$remote_file = "Batches/$data";
					if(ftp_get($conn,$local_file,$remote_file,FTP_BINARY)){
						ftp_delete($conn,$remote_file);
						$json = 'Success :)';
					}else{
						$json = 'ERROR!';
					}
					#$d = ftp_nlist($conn,'x12');
				}
				elseif($task == 'moveFileBack')
				{
					# Move file from local disk to ftp server
					$local_file = "files/edi/$data";
					$remote_file = "x12/$data";
					if(ftp_put($conn,$remote_file,$local_file,FTP_BINARY)){
						unlink($local_file);
						$json = 'Success :)';
					}else{
						$json = 'ERROR!';
					}
					#$d = ftp_nlist($conn,'x12');
				}
				elseif($task == 'saveLog')
				{
					# Move file from local disk to ftp server
					$logdata1 = preg_replace('/<br\/>/',"\r\n",$data[1]);
					$logdata2 = preg_replace('/<br\/>/',"\n",$data[1]);
					$local_file1 = "files/edi/logs/w_$data[0]";
					$local_file2 = "files/edi/logs/l_$data[0]";
					file_put_contents($local_file1,$logdata1);
					file_put_contents($local_file2,$logdata2);
					$json = "im here";
					$remote_file = "Logs/$data[0]";
					if(ftp_put($conn,$remote_file,$local_file1,FTP_BINARY)){
						unlink($local_file1);
						$json = 'it worked';
					}else{
						$json = 'DOHHH';
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
