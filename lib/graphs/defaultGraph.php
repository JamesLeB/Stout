<?php

	include("../pChart2.1.4/class/pData.class.php"); 
	include("../pChart2.1.4/class/pDraw.class.php"); 
	include("../pChart2.1.4/class/pImage.class.php"); 

	$max = 10;
	$min = 0;
	$sizex = 400;
	$sizey = 300;
	$padding = 20;

	$graph_top   = $padding + 50;
	$graph_bot   = $sizey - $padding - 25;
	$graph_left  = $padding*2.5;
	$graph_right = $sizex - $padding;

	$color = array("R"=>125,"G"=>125,"B"=>125);
	$test = array(1,2,3,4,3);
	$label = array('aa','b','c','d','e');

	$MyData = new pData();   
	$MyData->addPoints($test,"TEST"); 
	$MyData->addPoints($label,"Labels"); 
	$MyData->setAbscissa('Labels');
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
		#"RemoveXAxis"=>true,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 
	$myPicture->drawLineChart(); 
	$myPicture->drawLegend(20,20,array('Style'=>LEGEND_NOBORDER,'Mode'=>LEGEND_HORIZONTAL));
	$myPicture->render(); 

?>
