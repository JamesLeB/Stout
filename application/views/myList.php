<?php
	$index = 0;
	$ms = '';
	$ms .= "<div class='myList'>";
	foreach($myList as $item){
		$index++;
		$ms .= "<div class='myHeading'>";
		$ms .= "<button>$index</button>";
		$ms .= $item['Heading'];
		$ms .= "</div>";
		$ms .= "<div class='myBody'>";
		$ms .= $item['Body'];
		$ms .= "</div>";
	}
	$ms .= "</div>";
	echo $ms;
?>
<style>
	.myList{
	}
	.myHeading{
		padding : 5px;
		padding-right : 0px;
		margin-top : 5px;
		background : #434343;
	}
	.myHeading button{
		margin-right : 10px;
	}
	.myBody{
		background : #343434;
		margin-left : 20px;
		margin-bottom : 20px;
		padding : 5px;
		padding-right : 0px;
	}
</style>
