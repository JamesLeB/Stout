<?php
class actor {
	private $aName;
	private $sceneCount = 3;

	function __construct(){
		$this->aName = 'Tom';
	}
	function getSceneCount(){
		return $this->sceneCount;
	}
	function scene(){
		$ms = '';
		    if($_SESSION['scene'] == 1){$ms .= $this->scene1();}
		elseif($_SESSION['scene'] == 2){$ms .= $this->scene2();}
		elseif($_SESSION['scene'] == 3){$ms .= $this->scene3();}
		else{ $ms .= 'ERROR - invalid scene number!!'; }
		return $ms;
	}
	function scene1(){
		$ms  = '';
		$ms .= 'Scene 1<br/>';
		$ms .= '-- Scene 1 Complete...';
		return $ms;
	}
	function scene2(){
		$ms  = '';
		$ms .= 'Scene 2<br/>';
		$ms .= '-- Setting up stage loop<br/>';
		$_SESSION['current'] = 1;
		$_SESSION['final']   = 100;
		$ms .= '-- Stage 2 Complete...';
		return $ms;
	}
	function scene3(){
		$ms = '';
		$ms .= 'Scene 3<br/>';
		$current = $_SESSION['current'];
		$final   = $_SESSION['final'];
		if($current <= $final){
			$ms .= "--- Processing $current of $final";
			header("status: 1");
		    $_SESSION['scene']--;
			$_SESSION['current']++;
		}else{
			$ms .= "-- Scene 3 complete...";
		}
		return $ms;
	}
	function test(){
		return "Testing Actor";
	}
}
?>
