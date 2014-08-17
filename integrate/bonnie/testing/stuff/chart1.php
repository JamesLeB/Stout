<?php
include("pChart2.1.4/class/pDraw.class.php");
include("pChart2.1.4/class/pImage.class.php");
include("pChart2.1.4/class/pData.class.php");

# Create your data object
$myData = new pData();

# Add data in your dataset
$myData->addPoints(array(1,2,3,4));

# Create a pChart object
$myPicture = new pImage(700,230,$myData);

# Define boundaries
$myPicture->setFontProperies(array("FontName"=>"pChart2.1.4/fonts/Forgotte.tff","FontSize"=>11));

# Set Scale
$myPicture->drawScale();
	
# Draw chart
$myPicture->drawSplineChart();
#$myPicture->drawLineChart(); 

# Render chart
#$myPicture->Stroke();
$myPicture->Render("basic.png");
?>
