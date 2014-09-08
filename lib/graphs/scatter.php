<?php

/* pChart library inclusions */
include("../pChart2.1.4/class/pData.class.php");
include("../pChart2.1.4/class/pDraw.class.php");
include("../pChart2.1.4/class/pImage.class.php");
include("../pChart2.1.4/class/pScatter.class.php");
 
/* Create the pData object */
$myData = new pData();  
 
/* Create the X axis and the binded series */
for ($i=0;$i<=360;$i=$i+10) { $myData->addPoints(cos(deg2rad($i))*20,"Probe 1"); }
for ($i=0;$i<=360;$i=$i+10) { $myData->addPoints(sin(deg2rad($i))*20,"Probe 2"); }
$myData->setAxisName(0,"Index");
$myData->setAxisXY(0,AXIS_X);
$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);
 
/* Create the Y axis and the binded series */
for ($i=0;$i<=360;$i=$i+10) { $myData->addPoints($i,"Probe 3"); }
$myData->setSerieOnAxis("Probe 3",1);
#$myData->setAxisName(1,"Degree");
$myData->setAxisXY(1,AXIS_Y);
#$myData->setAxisUnit(1,"°");
$myData->setAxisPosition(1,AXIS_POSITION_LEFT);
 
/* Create the 1st scatter chart binding */
$myData->setScatterSerie("Probe 1","Probe 3",0);
#$myData->setScatterSerieDescription(0,"This year");
#$myData->setScatterSerieColor(0,array("R"=>0,"G"=>0,"B"=>0));
 
/* Create the 2nd scatter chart binding */
#$myData->setScatterSerie("Probe 2","Probe 3",1);
#$myData->setScatterSerieDescription(1,"Last Year");
#$myData->setScatterSeriePicture(1,"resources/accept.png");
 
/* Create the pChart object */
$myPicture = new pImage(400,400,$myData);
 
/* Draw the background */
#$Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
#$myPicture->drawFilledRectangle(0,0,400,400,$Settings);
 
/* Overlay with a gradient */
#$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
#$myPicture->drawGradientArea(0,0,400,400,DIRECTION_VERTICAL,$Settings);
#$myPicture->drawGradientArea(0,0,400,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
 
/* Write the picture title */ 
$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.4/fonts/Silkscreen.ttf","FontSize"=>6));
$myPicture->drawText(10,13,"drawScatterPlotChart() - Draw a scatter plot chart",array("R"=>0,"G"=>255,"B"=>255));
 
/* Add a border to the picture */
$myPicture->drawRectangle(0,0,399,399,array("R"=>255,"G"=>0,"B"=>0));
 
/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>6));
 
/* Set the graph area */
$myPicture->setGraphArea(50,50,350,350);
 
/* Create the Scatter chart object */
$myScatter = new pScatter($myPicture,$myData);
 
/* Draw the scale */
$myScatter->drawScatterScale();
 
/* Turn on shadow computing */
#$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 
/* Draw a scatter plot chart */
$myScatter->drawScatterPlotChart();
 
/* Draw the legend */
$myScatter->drawScatterLegend(260,375,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
 
/* Render the picture (choose the best way) */
#$myPicture->autoOutput("pictures/example.drawScatterPlotChart.png");
$myPicture->stroke(); 
#$myPicture->render(); 

##################################################################

/*

	include("../pChart2.1.4/class/pData.class.php"); 
	include("../pChart2.1.4/class/pDraw.class.php"); 
	include("../pChart2.1.4/class/pImage.class.php"); 
	include("../pChart2.1.4/class/pScatter.class.php"); 

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
	//$MyData->addPoints($label,"Labels"); 
	$MyData->addPoints(array(1,2,3),"X"); 
	$MyData->setAxisName(0,"james");
	$MyData->setAxisXY(0,AXIS_X);
	$MyData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

	$MyData->addPoints(array(1,2,3),"Y"); 
	$MyData->setSerieOnAxis("Y",1);
	$MyData->setAxisName(1,"kara");
	$MyData->setAxisXY(1,AXIS_Y);
	$MyData->setAxisPosition(1,AXIS_POSITION_RIGHT);
	
	$MyData->setScatterSerie("X","Y",0);
	$MyData->setScatterSerieDescription(0,"This Year");
	$MyData->setScatterSerieColor(0,array("R"=>0,"G"=>0,"B"=>0));
	
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
	$myScatter = new pScatter($myPicture,$MyData);
 	$myPicture->drawScatterScale(); 
	$myScatter->drawScatterPlotChart();
 	$scaleSettings = array(
		"GridR"=>false,
		"CycleBackground"=>true,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 
	$myPicture->drawLineChart(); 
	$myPicture->drawLegend($legendX,$legendY,array('Style'=>LEGEND_NOBORDER,'Mode'=>LEGEND_HORIZONTAL));
*/
	#$myPicture->render(); 
	#$myPicture->stroke(); 

?>
