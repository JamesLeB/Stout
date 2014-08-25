<?php
	include("pChart2.1.4/class/pData.class.php"); 
	include("pChart2.1.4/class/pDraw.class.php"); 
	include("pChart2.1.4/class/pImage.class.php"); 
	$max = 10;
	$min = 0;
	$sizex = 200;
	$sizey = 200;
	$padding = 30;
	#$coin = 'ltc';
	$color = array("R"=>125,"G"=>125,"B"=>125);
	$graph_top   = $padding;
	$graph_bot   = $sizey - $padding;
	$graph_left  = $padding*2.5;
	$graph_right = $sizex - $padding;
/*
	$file = 'where.sql';
	$fh = fopen($file,'r');
	$where = fread($fh,filesize($file));
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);
	$LTC = array();
	$rs = mysql_query("select $coin from bter $where");
	while($row = mysql_fetch_assoc($rs)){
		$LTC[] = $row{'ltc'};
	}
*/
	$test = array(1,2,3,4);
	$MyData = new pData();   
	$MyData->addPoints($test,"TEST"); 
	$MyData->setPalette('TEST',$color);
	$myPicture = new pImage($sizex,$sizey,$MyData); 
	$myPicture->setFontProperties(
		array(
			"FontName"=>"pChart2.1.4/fonts/pf_arma_five.ttf",
			"FontSize"=>12
		)
	); 
	$myPicture->setGraphArea($graph_left,$graph_top,$graph_right,$graph_bot); 
 	$scaleSettings = array(
		"GridR"=>false,
		"CycleBackground"=>true,
		"RemoveXAxis"=>true,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 
	$myPicture->drawLineChart(); 
	$myPicture->render(); 

?>
