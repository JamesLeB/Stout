<?php
class mintpal {
	function stage1(){
		$test = `lib/perl/exchange Mintpal`;
		$ms = '';
		$ms .= "...Stage 1...";
		$ms .= "Mech Data<br/>$test<br/>";
		return $ms;
	}
	function stage2(){ return 'stage2'; }
	function stage3(){ return 'stage3'; }
}
?>
