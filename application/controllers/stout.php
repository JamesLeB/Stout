<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stout extends CI_Controller {

	public function logout(){ session_unset(); }
	public function getBter(){
		#ticker
		$tickerJson = file_get_contents('http://data.bter.com/api/1/ticker/BTC_CNY');
		$tickerObj = JSON_decode($tickerJson,true);
		$m = "<h3>Ticker</h3><table>";
		$m .= "<tr>";
		$m .= "<td>Last</td>";
		$m .= "<td>High</td>";
		$m .= "<td>Low</td>";
		$m .= "<td>Avg</td>";
		$m .= "<td>Sell</td>";
		$m .= "<td>Buy</td>";
		$m .= "<td>Vol_btc</td>";
		$m .= "<td>Vol_cny</td>";
		$m .= "</tr>";
		$m .= "<tr>";
		$m .= "<td>".$tickerObj['last']."</td>";
		$m .= "<td>".$tickerObj['high']."</td>";
		$m .= "<td>".$tickerObj['low']."</td>";
		$m .= "<td>".$tickerObj['avg']."</td>";
		$m .= "<td>".$tickerObj['sell']."</td>";
		$m .= "<td>".$tickerObj['buy']."</td>";
		$m .= "<td>".$tickerObj['vol_btc']."</td>";
		$m .= "<td>".$tickerObj['vol_cny']."</td>";
		$m .= "</tr>";
		$m .= "</table>";
		$ticker = $m;
		#depth
		$depthJson = file_get_contents('http://data.bter.com/api/1/depth/btc_cny');
		$depthObj = JSON_decode($depthJson,true);
		$keys = array_keys($depthObj);
		$m = "<table>";
		foreach($keys as $k){
			$d = $depthObj[$k];
			$d = gettype($d);
			$m .= "<tr>";
			$m .= "<td>$k</td>";
			$m .= "<td>$d</td>";
			$m .= "</tr>";
		}
		$m .= "</table>";
		#$depth = "Result: ".$depthObj['result'];
		$depth = "depth";
		#asks
		$asksA = $depthObj['asks'];
		$t = "<h3>Asks</h3><table>";
		foreach($asksA as $a){
			$t .= "<tr>";
			foreach($a as $aa){
				$t .= "<td>$aa</td>";
			}
			$t .= "</tr>";
		}
		$t .= "</table>";
		$asks = $t;
		#bids
		$bidsA = $depthObj['bids'];
		$t = "<h3>Bids</h3><table>";
		foreach($bidsA as $a){
			$t .= "<tr>";
			foreach($a as $aa){
				$t .= "<td>$aa</td>";
			}
			$t .= "</tr>";
		}
		$t .= "</table>";
		$bids = $t;
		#history
		$tradesJson = file_get_contents('http://data.bter.com/api/1/trade/btc_cny');
		$tradesObj = JSON_decode($tradesJson,true);
		$t = "";
		$tradeData = $tradesObj['data'];
		$t .= "<h3>History</h3><table>";
		$t .= "<tr>";
		$t .= "<td>Timestamp</td>";
		$t .= "<td>Price</td>";
		$t .= "<td>Amount</td>";
		$t .= "<td>Tid</td>";
		$t .= "<td>Type</td>";
		$t .= "<td>Date</td>";
		$t .= "</tr>";
		foreach($tradeData as $trade){
			$t .= "<tr>";
			$t .= "<td>".$trade['date']."</td>";
			$t .= "<td>".$trade['price']."</td>";
			$t .= "<td>".$trade['amount']."</td>";
			$t .= "<td>".$trade['tid']."</td>";
			$t .= "<td>".$trade['type']."</td>";
			$t .= "<td>".date('Y-m-d H:i:s',$trade['date'])."</td>";
			$t .= "</tr>";
		}
		$t .= "</table>";
		
		#foreach($tradesObj as $trade){
		#	$t .= gettype($trade);
		#}
		$trades = $t;
		$obj = array($ticker,$asks,$bids,$trades);
		$json = JSON_encode($obj);
		echo $json;
	}
	private function getBterCoinList(){
		$json = file_get_contents('http://data.bter.com/api/1/pairs');
		$obj = json_decode($json,TRUE);
		return $obj;
	}
	public function index()
	{
		$user = $_SESSION['user'];
		if($user == 'james')
		{
			$slide = array();
			$slide[] = array('Worker',     $this->load->view('slides/worker','',true));
			$slide[] = array('Trader',     $this->load->view('slides/trader','',true));
			$slide[] = array('Stage',      $this->load->view('slides/stage','',true));
			$slide[] = array('Grapher',    $this->load->view('grapher','',true));
			$slides['slides'] = $slide;
			$data['slideTray'] = $this->load->view('slideTray',$slides,true);
			$this->load->view('home',$data);
		}
		elseif($user == 'junior')
		{
			$this->load->view('junior/juniorHome');
		}
		elseif($user == 'john')
		{
			$d['user'] = $user;
			$claimList['headings'] = array('Id','Last','First','Date','Amount','Status');
			$this->load->model('denialmangement');
			$claimList['rows'] = $this->denialmangement->getClaimList();
			$d['claims'] = $claimList;
			$this->load->view('claims',$d);
		}elseif($user == 'james1'){
			# Load Character
			$d['charSheet'] = $this->load->view('classes/jform','',true);
			$data['jCharacter'] = $this->load->view('classes/jCharacter',$d,true);
			# Load coins
			$coins['list'] = array();
			#$coins['list'] = $this->getBterCoinList();
			$data['coins'] = "coins";#$this->load->view('classes/coins',$coins,true);
			# Load character Sheet
			$data['characterSheet'] = $this->load->view('classes/characterSheet','',true);
			# Load database controls
			$data['database'] = $this->load->view('classes/localdb','',true);
			# Load Map
			$data['map'] = $this->load->view('classes/map','',true);
			# Load Spash
			$data['splash'] = $this->load->view('slides/splash','',true);
			# Load Laning page
			$this->load->view('landing',$data);
		}
/*
		$development['market']    = $this->load->view('bit/bitMarket','',true);
		$development['buy']       = $this->load->view('bit/bitBuy','',true);
		$development['inventory'] = $this->load->view('bit/bitInventory','',true);
		$development['sales']     = $this->load->view('bit/bitSales','',true);
		$reports['report1'] = 'First Report';
		$reports['report2'] = 'Second Report';
		$reports['report3'] = 'Third Report';
		$reports['report4'] = 'Forth Report';
		$form['block1'] = $this->load->view('dnd/newCharFormBlock1','',true);
		$form['block2'] = $this->load->view('dnd/newCharFormBlock2','',true);
		$slide[] = array('WebGL',      $this->load->view('webgl','',true));
		$slide[] = array('Reports',    $this->load->view('reports',$reports,true));
		$slide[] = array('exchange',   $this->load->view('exchange','',true));
		$slide[] = array('development',$this->load->view('development',$development,true));
		$slide[] = array('production', $this->load->view('production','',true));
		$slide[] = array('Expense',    $this->load->view('slides/expense','',true));
		$slide[] = array('Accounts',   $this->load->view('slides/accounts','',true));
		$slide[] = array('Ledger',     $this->load->view('slides/ledger','',true));
		$slide[] = array('Characters', $this->load->view('dnd/character',$form,true));
*/
	}
}
