<?php
	# Build Table
	$jtable = "<div id='$jname'>"; #open jtable
	$jtable .= "<div>";            #open heading
	$jtable .= "<div>";            #open heading row
	foreach($heading as $head){
		$jtable .= "<span>$head</span>"; #put heading
	}
	$jtable .= "</div>";                 #close heading row
	$jtable .= "</div>";                 #close heading
	$jtable .= "<div>";                  #open body
	foreach($rows as $row){
		$jtable .= "<div>";              #open body row
		foreach($row as $cell){
			$jtable .= "<span>$cell</span>"; #put cell 
		}
		$jtable .= "<span><button>X</button></span>";      #put delete button 
		$jtable .= "</div>";             #close body row
	}
	$jtable .= "</div>";               #close body
	$jtable .= "</div>";           #close jtable
	echo $jtable;
	# Build CSS to control Column Width
	$colWidthCss = '';
	$i = 0;
	foreach($colWidth as $w){
		$i++;
		$colWidthCss .= "
			#$jname span:nth-child($i){
				width : {$w}px;
			}
		";
	}
	$style = "
	<style>
		#$jname{
			width : {$jWidth}px;
			margin-left : auto;
			margin-right : auto;
			border : 1px solid black;
			border-radius : 10px;
			box-shadow : 3px 3px 3px black;
		}
		#$jname div{
			margin : 0;
			border : none;
		}
		#$jname > div:nth-child(1){
			margin-top : 10px;
		}
		#$jname > div:nth-child(2){
			height : 300px;
			overflow : auto;
			margin-right : 10px;
			margin-bottom : 10px;
		}
		#$jname > div:nth-child(1) > div > span{
			background : blue;
			color : white;
			text-align : center;
			padding-top : 2px;
			padding-bottom : 2px;
		}
		#$jname > div > div > span:nth-child(1){
			margin-left : 20px;
		}
		#$jname span{
			display : inline-block;
			margin : 5px;
		}
		#$jname > div:nth-child(2) span{
			padding-left : 5px;
		}
		$colWidthCss;
	</style>";
	echo $style;
?>
