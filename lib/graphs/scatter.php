<?php
include("../pChart2.1.4/class/pData.class.php");
include("../pChart2.1.4/class/pDraw.class.php");
include("../pChart2.1.4/class/pImage.class.php");
include("../pChart2.1.4/class/pScatter.class.php");
$myData = new pData();  
$myData->addPoints(array(1,2,3,4),"X");
$myData->setAxisName(0,"X axis");
$myData->setAxisXY(0,AXIS_X);
$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);
$myData->addPoints(array(1,2,3,2),"Y");
$myData->setSerieOnAxis("Y",1);
$myData->setAxisName(1,"Y axis");
$myData->setAxisXY(1,AXIS_Y);
$myData->setAxisPosition(1,AXIS_POSITION_LEFT);
$myData->setScatterSerie("X","Y",0);
$myPicture = new pImage(600,400,$myData);
$myPicture->setFontProperties(array(
	"FontName"=>"../pChart2.1.4/fonts/pf_arma_five.ttf",
	"FontSize"=>10
));
$myPicture->setGraphArea(100,50,400,300);
$myScatter = new pScatter($myPicture,$myData);
$myScatter->drawScatterScale();
$myScatter->drawScatterPlotChart();
$myScatter->drawScatterLegend(260,375,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
$myPicture->stroke(); 
##################################################################

/*
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
*/

?>
