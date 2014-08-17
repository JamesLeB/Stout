<?php

# CREATE GRAPH
	include("pChart2.1.4/class/pData.class.php"); 
	include("pChart2.1.4/class/pDraw.class.php"); 
	include("pChart2.1.4/class/pImage.class.php"); 
	# Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->addPoints(array(3,12,15,8,5,-5),"Probe 2"); 
	$MyData->setAxisName(0,"Temperatures"); 
	$MyData->addPoints(array("Jan","Feb","Mar","Apr","May","Jun"),"Labels"); 
	$MyData->setAbscissa("Labels"); 
	# Create the pChart object */ 
	$myPicture = new pImage(700,230,$MyData); 
	# Set the default font */ 
	$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>8)); 
	# Define the chart area */ 
	$myPicture->setGraphArea(60,40,650,200); 
	# Draw the scale */ 
	$myPicture->drawScale(); 
	# Draw the line chart */ 
	$myPicture->drawLineChart(); 
	# Write the chart legend */ 
	$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
	# Render the picture (choose the best way) */ 
	$myPicture->render(); 
# END GRAPH

?>
