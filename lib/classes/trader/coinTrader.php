<?php
class coinTrader
{ 
	private $test = 'default';
	function __construct()
	{
		define('__TRADER__','lib/classes/trader'); #defines a constant
		$this->test = 'constructed';
	}
	function test()
	{
		return "test=".$this->test." ".__TRADER__;
	}
}
?>