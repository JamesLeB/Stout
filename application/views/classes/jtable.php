<?php
	$heading = array('Name','Address','Sex');
	$row = array('James','New York','Male');
	$rows = array();
	for($i=0;$i<100;$i++){
		$rows[] = $row;
	}
	$jtable = "<div id='jtable'>"; #open jtable
	$jtable .= "<div>"; #open heading
	$jtable .= "<div>"; #open heading row
	foreach($heading as $head){
		$jtable .= "<span>$head</span>"; #put heading
	}
	$jtable .= "</div>"; #close heading row
	$jtable .= "</div>"; #close heading
	$jtable .= "<div>"; #open body
	foreach($rows as $row){
		$jtable .= "<div>"; #open body row
		foreach($row as $cell){
			$jtable .= "<span>$cell</span>"; #put cell 
		}
		$jtable .= "</div>"; #close body row
	}
	$jtable .= "</div>"; #close body
	$jtable .= "</div>"; #jtable
	echo $jtable;
?>
<style>
	#jtable{
		width : 500px;
		margin-left : auto;
		margin-right : auto;
		border : 1px solid black;
		border-radius : 10px;
		box-shadow : 3px 3px 3px black;
	}
	#jtable div{
		margin : 0;
		border : none;
	}
	#jtable > div:nth-child(1){
		margin-top : 10px;
	}
	#jtable > div:nth-child(2){
		height : 300px;
		overflow : auto;
		margin-right : 10px;
		margin-bottom : 10px;
	}
	#jtable > div:nth-child(1) > div > span{
		background : blue;
		color : white;
		text-align : center;
		padding-top : 2px;
		padding-bottom : 2px;
	}
	#jtable > div > div > span:nth-child(1){
		margin-left : 20px;
	}
	#jtable span{
		display : inline-block;
		margin : 5px;
	}
	#jtable > div:nth-child(2) span{
		padding-left : 5px;
	}
	#jtable span:nth-child(1){
		width : 100px;
	}
	#jtable span:nth-child(2){
		width : 200px;
	}
	#jtable span:nth-child(3){
		width : 100px;
	}
</style>
