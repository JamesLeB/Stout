<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stage extends CI_Controller {

	public function index(){ echo "this is the index"; }

	public function test(){
/*
		$arg1 = $this->uri->segment(4);
		echo "Johns controller Incoming = $arg1<br/>";
		$this->load->model('warehouse');
		$data = $this->warehouse->getMedicaidOpenClaims();
		echo "$data<br/>";
		echo "DONE!!<br/>";
*/
	}
	public function getMech(){
		$test = `lib/perl/exchange Mintpal`;
		echo "getting mech data...<br/>$test";
		$thing = new mintpal();
		$test = $thing->stage1();
		echo "testing...$test<br/>";
		$this->setup();
	}
	public function setup(){
		$scene = 1;
		$sceneCount = 3;
		$_SESSION['scene'] = $scene;
		$_SESSION['sceneCount'] = $sceneCount;
		$_SESSION['MAX'] = 10;
		$_SESSION['INDEX'] = 0;
		echo "setting up scene $scene<br/>";
		header('scene: 1');
	}
	public function running(){
		$ms = 'im running<br/>';
		$test = $_SESSION['scene'];
		$ms = "$test<br/>";
/*
		if( $_SESSION['scene'] <= $_SESSION['sceneCount'] ){
			header('scene: 1');
			$thing = new mintpal();
			     if( $_SESSION['scene'] == 1 ){ $ms .= $thing->stage1();
			}elseif( $_SESSION['scene'] == 2 ){ $ms .= $thing->stage2();
			}elseif( $_SESSION['scene'] == 3 ){ $ms .= $thing->stage3();
			}else                             { $ms .= $thing->stage0();
			}
			$_SESSION['scene']++;
		}else{
			$ms .= "scene done<br/>";
		}
*/
		echo "$ms";
	}
	function stage1(){
/*
				$file = file_get_contents("test.csv");
				$lines = explode("\n",$file);
				array_pop($lines);
				$headings = explode(",",array_shift($lines));
				array_unshift($headings,'rowCount');
				array_pop($headings);
				$_SESSION['headings'] = $headings;
				$rows = array();
				$count = 0;
				foreach($lines as $line){
					$count++;
					$row = explode(",",$line);
					array_pop($row);
					array_unshift($row,$count);
					array_push($rows,$row);
				}
				$_SESSION['rows'] = $rows;
*/
	}
}

?>
