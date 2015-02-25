<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EmdeonBridge extends CI_Controller {

	public function test()
	{
		$o = $this->getFTP('getList','');
		echo "hello from test<br/>";
		echo $o[0];
	}
	public function getNewList()
	{
		$o = $this->getFTP('getList','axiumBridge');
		echo $o[1];
	}
	public function getOldList()
	{
		$o = $this->getFTP('getList','axiumBridge\done');
		echo $o[1];
	}
	public function readFile()
	{
		$file = $_POST['file'];
		$o = $this->getFTP('getFile',"axiumBridge\\$file");
		$doc = $o[1];
		$lines = preg_split('/\n/',$doc);
		$result = "Start reading emdeon file<br/>";
		$processed = array();

$stop = "YES";
while(sizeof($lines) > 0)
{
	if(preg_match('/^From/',$lines[0]))
	{
		$proc = $this->readAck($lines,$processed);
		$result .= "<br/>ReadAck<br/>".$proc[0];
	}
	else if(preg_match('/^\.*$/',$lines[0]))
	{
		$line = array_shift($lines); $processed[] = $line;
	}
	else if(preg_match('/^1/',$lines[0]))
	{
		//$processed = array();
		$proc = $this->readClaimStatus($lines,$processed);
		$result .= "ReadClaimStatus<br/>".$proc[0];
		$stop = "NO";
		break;
	}
	else
	{
		$result .= "Still have data to process";
		$stop = "NO";
		break;
	}
}
if($stop == "YES")
{
	$o = $this->getFTP('putFile',array($file,$doc));
	$result .= "<br/>Done moving file";
}

		$processed[] = "-------------------------------------------------------";
		$processed[] = "$result";
		$processed[] = "-------------------------------------------------------";
		foreach($lines as $line)
		{
			$processed[] = $line;
		}
		$processed[] = "-------------------------------------------------------";
		echo implode('<br/>',$processed);
	}

	private function readClaimStatus(&$lines,&$processed)
	{
		try
		{
			$a = 'default';
			$b = 'default';
			if(preg_match('/^1\s*$/',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('Something went wrong e1'); }

			if(preg_match('/^x/',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('Something went wrong e2'); }

			$line = array_shift($lines); $processed[] = $line;

/*
			$this->load->model('Warehouse');
			$r = $this->Warehouse->setEmdeonRef($Reference,$fileName);
*/

			$message = "
				SUCESS :)<br/>
				A: $a<br/>
				B: $b<br/>
			";
		}
		catch(exception $e)
		{
			$error = $e->getMessage();
			$message =  "error reading ack file: $error";
		}
		return array($message);
	}
	private function readAck(&$lines,&$processed)
	{
		$message = '';
		try
		{
			$Reference = 'default';
			$fileName = 'default';
			if(preg_match('/^From:  Emdeon Business Services/',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e1'); }

			if(preg_match('/^To:/',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e2'); }

			if(preg_match('/^Subject:  Acknowledgement of receipt/',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e3'); }

			if(preg_match('/^Reference:  /',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
				$d = preg_split('/  /',$line);
				$Reference = $d[1];
			}else{ throw new exception('something went wrong e4'); }

			if(preg_match('/^Date:  /',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e5'); }

			if(preg_match('/^Size:  /',$lines[0]))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e6'); }

			$line = array_shift($lines); $processed[] = $line;

			if(preg_match('/^Your file (.+) was received for processing by Emdeon/',$lines[0],$match))
			{
				$line = array_shift($lines); $processed[] = $line;
				$fileName = $match[1];
			}else{ throw new exception('something went wrong e7'); }

			$line = array_shift($lines); $processed[] = $line;

			if(preg_match('/^This file has been assigned tracking number .+\.  P/',$lines[0],$match))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e8'); }

			if(preg_match('/^tracking number for your communications with Customer S/',$lines[0],$match))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e9'); }

			if(preg_match('/^\s/',$lines[0],$match))
			{
				$line = array_shift($lines); $processed[] = $line;
			}else{ throw new exception('something went wrong e10'); }

			$this->load->model('Warehouse');
			$r = $this->Warehouse->setEmdeonRef($Reference,$fileName);

			$message = "
				SUCESS :)<br/>
				Ref: $Reference<br/>
				File: $fileName<br/>
				R: $r<br/><br/>
			";
		}
		catch(exception $e)
		{
			$error = $e->getMessage();
			$message =  "error reading ack file: $error";
		}
		return array($message);
	}
	private function getFTP($task,$file){
		$m = array();
		$json = '';
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
				if($task == 'getFile')
				{
					# Get file from FTP server
					$local_file = 'files/edi/z';
					if(ftp_get($conn,$local_file,$file,FTP_BINARY)){
						$m[] = "File retrieved";
					}else{
						$m[] = "Failed to retrieve file";
					}
					$json = file_get_contents($local_file);
					unlink($local_file);
				}
				elseif($task == 'putFile')
				{
					$text = $file[1];
					$local_file = 'files/edi/z';
					file_put_contents($local_file,$text);
					# Put file on FTP server
					$remote_file = 'axiumBridge\done\\'.$file[0];
					if(ftp_put($conn,$remote_file,$local_file,FTP_BINARY)){
						$m[] = "File Uploaded";
					}else{
						$m[] = "Failed to Upload file";
					}
					$remote_file = 'axiumBridge\\'.$file[0];
					ftp_delete($conn,$remote_file);
					unlink($local_file);
				}
				elseif($task == 'getList')
				{
					# Get list of files
					$fileList = ftp_nlist($conn,$file);
					if($fileList){
						$m[] = "YES list";
						$json = json_encode($fileList);
					}else{
						$m[] = "NO list";
					}
				}
				elseif($task == 'deleteFile')
				{
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
/*
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
*/
}
