<?php

	include("../pChart2.1.4/class/pData.class.php"); 
	include("../pChart2.1.4/class/pDraw.class.php"); 
	include("../pChart2.1.4/class/pImage.class.php"); 

	#header('Content-Type:image/png');

	# GET CONFIG FILE
	$json1 = file_get_contents('config/default.json');
	$config = json_decode($json1,true);
	$max     = $config['max'];
	$min     = $config['min'];
	$sizex   = $config['sizex'];
	$sizey   = $config['sizey'];
	$legendX = $config['legendX'];
	$legendY = $config['legendY'];
	$padding = $config['padding'];

	# SET CONFIG VARIABLES
	$graph_top   = $padding + 50;
	$graph_bot   = $sizey - $padding - 25;
	$graph_left  = $padding*2.5;
	$graph_right = $sizex - $padding;

	# GET DATA SET
	$json2 = file_get_contents('config/data1.json');
	$dataSet1 = json_decode($json2,true);
	$setName = $dataSet1['setName'];
	$label   = $dataSet1['label'];
	$color   = $dataSet1['color'];
	$data1   = $dataSet1['data'];

	$MyData = new pData();   
	$MyData->addPoints($label,"Labels"); 
	$MyData->setAbscissa('Labels');
	$MyData->addPoints($data1,$setName); 
	$MyData->setPalette($setName,$color);

	$myPicture = new pImage($sizex,$sizey,$MyData); 
	$myPicture->setFontProperties(
		array(
			"FontName"=>"../pChart2.1.4/fonts/pf_arma_five.ttf",
			"FontSize"=>12
		)
	); 
	$myPicture->setGraphArea($graph_left,$graph_top,$graph_right,$graph_bot); 
 	$scaleSettings = array(
		"GridR"=>false,
		"CycleBackground"=>true,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 
	$myPicture->drawLineChart(); 
	$myPicture->drawLegend($legendX,$legendY,array('Style'=>LEGEND_NOBORDER,'Mode'=>LEGEND_HORIZONTAL));
	#$myPicture->render(); 
	$myPicture->stroke(); 

?>
