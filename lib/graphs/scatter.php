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
$myData->setScatterSerieDescription(0,"Example");
$myPicture = new pImage(600,400,$myData);

#####################################################################
$settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);
$myPicture->drawFilledRectangle(0,0,600,400,$Settings); 

$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
$myPicture->drawGradientArea(0,0,600,400,DIRECTION_VERTICAL,$Settings); 
$myPicture->drawGradientArea(0,0,600,30,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));
$myPicture->setFontProperties(array("FontName"=>"../pChart2.1.4/fonts/Silkscreen.ttf","FontSize"=>8));
$myPicture->drawText(10,13,"drawScatterScale() - Draw the scatter chart scale",array("R"=>255,"G"=>255,"B"=>255));
#####################################################################
	
$myPicture->setFontProperties(array(
	"FontName"=>"../pChart2.1.4/fonts/pf_arma_five.ttf",
	"FontSize"=>10
));
$myPicture->setGraphArea(60,50,500,320);
$myScatter = new pScatter($myPicture,$myData);

#$myScatter->drawScatterScale();
 	$scaleSettings = array(
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(
			0=>array("Min"=>0,"Max"=>10,"Rows"=>10,"RowHeight"=>1),
			1=>array("Min"=>0,"Max"=>9)
		),
		"DrawSubTicks"=>TRUE
	); 
 	$myScatter->drawScatterScale($scaleSettings); 
/*
$axisBound = array(0=>array("Min"=>0,"Max"=>10,"Rows"=>10,"RowHeight"=>1),1=>array("Min"=>0,"Max"=>10));
$scaleSettings = array("Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$axisBound,"DrawSubTicks"=>TRUE);
$myScatter->drawScatterScale($scaleSettings);
*/

$myScatter->drawScatterPlotChart();
$myScatter->drawScatterLegend(260,375,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER));
$myPicture->drawLine(100,300,400,50,array("R"=>0,"G"=>0,"R"=>0));
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
