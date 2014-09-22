<?php
/* pChart library inclusions */
include("../pChart2.1.4/class/pData.class.php");
include("../pChart2.1.4/class/pDraw.class.php");
include("../pChart2.1.4/class/pImage.class.php");
include("../pChart2.1.4/class/pScatter.class.php");

/* Settings */
$imageWidth  = 600;
$imageHeight = 400;
$titleHeight = 30;
$titleFont = array("FontName"=>"../pChart2.1.4/fonts/Silkscreen.ttf","FontSize"=>10);
$titleColor = array("R"=>255,"G"=>255,"B"=>0);
$titleTop  = 20;
$titleLeft = 30;
$titleText = 'Chart Title';
$borderColor = array("R"=>255,"G"=>255,"B"=>0);
$graphFont = array("FontName"=>"../pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>10);
$graphLeft  = 80;
$graphTop   = 80;
$graphRight = 500;
$graphBot   = 320;
$legendLeft = 260;
$legendTop = 375;
$legendSettings = array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER);

$buyColor = array("R"=>255,"G"=>255,"B"=>0);

/*
$obj = array();
$obj[] = array(
	'time'  => 1,
	'price' => 2
);
$obj[] = array(
	'time'  => 2,
	'price' => 2
);
$obj[] = array(
	'time'  => 3,
	'price' => 3
);
$obj[] = array(
	'time'  => 5,
	'price' => 7
);
$json = json_encode($obj);
file_put_contents($file,$json);
*/
$file = 'data/sample1.json';
$json = file_get_contents($file);
$obj = json_decode($json,TRUE);

$timeA  = array();
$priceA = array();
$priceMin = $obj[0]['price'];
$priceMax = $obj[0]['price'];
$timeMin  = 0;
$timeMax  = $obj[0]['time'];
foreach($obj as $o){
	$timeA[]  = $o['time'];
	$priceA[] = $o['price'];
	if($o['price'] < $priceMin){$priceMin = $o['price'];}
	if($o['price'] > $priceMax){$priceMax = $o['price'];}
	if($o['time'] > $timeMax){$timeMax = $o['time'];}
}
$titleText = "Price min=$priceMin max=$priceMax time max=$timeMax";
 
/* Create the pData object */
$myData = new pData();  
 
/* Create the X axis and the binded series */
$myData->addPoints($timeA,"Time");
$myData->setAxisName(0,"TIME");
$myData->setAxisXY(0,AXIS_X);
$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);
 
/* Create the Y axis and the binded series */
$myData->addPoints($priceA,"Buy");
#$myData->addPoints(array(1,1,1,1),"Sell");
$myData->setSerieOnAxis("Buy",1);
#$myData->setSerieOnAxis("Sell",1);
$myData->setAxisName(1,"PRICE");
$myData->setAxisXY(1,AXIS_Y);
$myData->setAxisUnit(1," $");
$myData->setAxisPosition(1,AXIS_POSITION_LEFT);
 
/* Create the 1st scatter chart binding */
$myData->setScatterSerie("Time","Buy",0);
$myData->setScatterSerieDescription(0,"Buy");
$myData->setScatterSerieColor(0,$buyColor);
 
/* Create the 2nd scatter chart binding */
#$myData->setScatterSerie("Time","Sell",1);
#$myData->setScatterSerieDescription(1,"Sell");
#$myData->setScatterSerieColor(1,array("R"=>100,"G"=>100,"B"=>100));
#$myData->setScatterSeriePicture(1,"../pChart2.1.4/examples/resources/accept.png");
 
/* Create the pChart object */
$myPicture = new pImage($imageWidth,$imageHeight,$myData);
 
/* Draw the background */
$Settings = array(
	"R"=>170,
	"G"=>183,
	"B"=>87,
	"Dash"=>1,
	"DashR"=>190,
	"DashG"=>203,
	"DashB"=>107
); // the dash is a diagonal line that gives the background texture
$myPicture->drawFilledRectangle(0,0,$imageWidth,$imageHeight,$Settings);
 
/* Overlay with a gradient */
$Settings = array(
	"StartR"=>119,
	"StartG"=>231,
	"StartB"=>139,
	"EndR"=>1,
	"EndG"=>138,
	"EndB"=>68,
	"Alpha"=>50
);
$myPicture->drawGradientArea(0,0,$imageWidth,$imageHeight,DIRECTION_VERTICAL,$Settings);
$settings = array(
	"StartR"=>0,
	"StartG"=>0,
	"StartB"=>0,
	"EndR"=>50,
	"EndG"=>50,
	"EndB"=>50,
	"Alpha"=>80
);
$myPicture->drawGradientArea(0,0,$imageWidth,$titleHeight,DIRECTION_VERTICAL,$settings);
 
/* Write the picture title */ 
$myPicture->setFontProperties($titleFont);
$myPicture->drawText($titleLeft,$titleTop,$titleText,$titleColor);
 
/* Add a border to the picture */
$myPicture->drawRectangle(0,0,$imageWidth-1,$imageHeight-1,$borderColor);
 
/* Set the default font */
$myPicture->setFontProperties($graphFont);
 
/* Set the graph area */
$myPicture->setGraphArea($graphLeft,$graphTop,$graphRight,$graphBot);
 
/* Create the Scatter chart object */
$myScatter = new pScatter($myPicture,$myData);
 
/* Draw the scale */
$scaleSettings = array(
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(
			0=>array('Min'=>$timeMin,'Max'=>$timeMax),
			1=>array('Min'=>$priceMin,'Max'=>$priceMax),
		)
);
$myScatter->drawScatterScale($scaleSettings);
 
/* Turn on shadow computing */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 
/* Draw a scatter plot chart */
$myScatter->drawScatterPlotChart();
 
/* Draw the legend */
$myScatter->drawScatterLegend($legendLeft,$legendTop,$legendSettings);

/* Draw trend line */
#$myPicture->DrawLine($graphLeft,$graphBot,$graphRight,$graphTop,array('R'=>0,'G'=>0,'B'=>0));
 
/* Render the picture (choose the best way) */
$myPicture->stroke();
?>
