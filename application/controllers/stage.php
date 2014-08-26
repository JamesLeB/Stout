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
	public function setup(){
		header('scene: 1');
		$scene = 1;
		$sceneCount = 3;
		$_SESSION['scene'] = $scene;
		$_SESSION['sceneCount'] = $sceneCount;
		$_SESSION['MAX'] = 10;
		$_SESSION['INDEX'] = 0;
		echo "Setting Up Scene<br/><br/>";
	}
	public function running(){
		$ms = array();
		if( $_SESSION['scene'] <= $_SESSION['sceneCount'] ){
			header('scene: 1');
			$thing = new mintpal();

			     if( $_SESSION['scene'] == 1 ){ $ms[] = $thing->stage1();
			}elseif( $_SESSION['scene'] == 2 ){ $ms[] = $thing->stage2();
			}elseif( $_SESSION['scene'] == 3 ){ $ms[] = $thing->stage3();
			}else                             { $ms[] = $thing->stage0();
			}

			$_SESSION['scene']++;
		}else{
			$ms[] = "Scene Done<br/>";
		}
		$echo = '';
		foreach($ms as $m){
			$echo .= "$m<br/>";
		}
		echo "$echo";
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
