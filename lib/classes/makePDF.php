<?php
class makePDF {
	private $sceneCount = 4;
	function getSceneCount(){ return $this->sceneCount; }
	function stage(){
		$ms = '';
		    if($_SESSION['scene'] == 1){$ms .= $this->stage1();}
		elseif($_SESSION['scene'] == 2){$ms .= $this->stage2();}
		elseif($_SESSION['scene'] == 3){$ms .= $this->stage3();}
		elseif($_SESSION['scene'] == 4){$ms .= $this->stage4();}
		else{ $ms .= 'ERROR - invalid scene number!!'; }
		return $ms;
	}
	function stage1(){ return 'stage1'; }
	function stage2(){ return 'stage2'; }
	function stage3(){ return 'stage3'; }
	function stage4(){ return 'stage4'; }
}
?>
