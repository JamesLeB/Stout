<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class John extends CI_Controller {

	private $conn;

	public function __construct()
	{
		$c = preg_split('/\s/',file_get_contents('files/config/juniorFTPpass'));
		$server = $c[0];
		$user   = $c[1];
		$pass   = $c[2];
		set_error_handler(function(){});
		$conn = ftp_connect($server);
		ftp_login($conn,$user,$pass);
		$this->conn = $conn;
	}
	public function getNewList()
	{
		$list = ftp_nlist($this->conn,'3rdParty\New');
		echo json_encode($list);
	}
	public function getNewFile()
	{
		$file = $_POST['file'];
		$remoteFile = '3rdParty\New\\'.$file;
		$localFile = 'files/temp/a';
		ftp_get($this->conn,$localFile,$remoteFile,FTP_BINARY);
		$a = file_get_contents($localFile);
		$_SESSION['activeClaimFile'] = $a;
		echo "Got File";
	}
}

?>
