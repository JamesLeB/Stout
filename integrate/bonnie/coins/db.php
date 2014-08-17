<?php
$rushCoin1 = 'pts';
$rushCoin2 = 'qrk';
$where = " where
		(lineTime = '00:00:00'
		or lineTime = '12:00:00'
		or lineTime = '06:00:00'
		or lineTime = '18:00:00')
		and lineDate > '2014-02-17'
		order by lineDate,lineTime
";
	# Connect to DB
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);

	# Get time series
	$TIME = array();
	$rs = mysql_query("select lineDate,lineTime from bter $where");
	while($row = mysql_fetch_assoc($rs)){
		$date = $row{'lineDate'};
		$time = $row{'lineTime'};
		$TIME[] = substr($date,8,2);
	}

	# Get price series
	$LTC = array();
	$DOGE = array();
	$RUSH1 = array();
	$RUSH2 = array();
	$rs = mysql_query("select ltc,doge,$rushCoin1,$rushCoin2 from bter $where ");
	while($row = mysql_fetch_assoc($rs)){
		$LTC[] = $row{'ltc'};
		$DOGE[] = $row{'doge'};
		$RUSH1[] = $row{$rushCoin1};
		$RUSH2[] = $row{$rushCoin2};
	}

	$LTC_P = convert2percent($LTC);
	$DOGE_P = convert2percent($DOGE);
	$RUSH1_P = convert2percent($RUSH1);
	$RUSH2_P = convert2percent($RUSH2);

########################
$max = 8; $min = $max*-1;

# CREATE GRAPH
	include("pChart2.1.4/class/pData.class.php"); 
	include("pChart2.1.4/class/pDraw.class.php"); 
	include("pChart2.1.4/class/pImage.class.php"); 
	# Create and populate the pData object */ 
	$MyData = new pData();   

	$MyData->addPoints($LTC_P,"LTC"); 
	$MyData->addPoints($DOGE_P,"DOGE"); 
	$MyData->addPoints($RUSH1_P,$rushCoin1); 
	#$MyData->addPoints($RUSH2_P,$rushCoin2); 
	$MyData->setPalette('LTC',array("R"=>125,"G"=>125,"B"=>125));
	$MyData->setPalette('DOGE',array("R"=>255,"G"=>160,"B"=>0));
	$MyData->setPalette($rushCoin1,array("R"=>0,"G"=>0,"B"=>255));
	#$MyData->setPalette($rushCoin2,array("R"=>255,"G"=>0,"B"=>0));
	#$MyData->setAxisName(0,"Temperatures"); 
	$MyData->addPoints($TIME,"Labels"); 
	$MyData->setAbscissa("Labels"); 
	# Create the pChart object */ 
	$myPicture = new pImage(1000,400,$MyData); 
	# Set the default font */ 
	$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>12)); 
	# Define the chart area */ 
	$myPicture->setGraphArea(60,40,900,350); 

	# Draw the scale */ 
	#$myPicture->drawScale(); 
 	#$scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
		#"DrawSubTicks"=>true,
 	$scaleSettings = array(
		"GridR"=>10,
		"CycleBackground"=>true,
		"RemoveXAxis"=>false,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 

	# Draw the line chart */ 
	$myPicture->drawLineChart(); 
	# Write the chart legend */ 
	$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
	# Render the picture (choose the best way) */ 
	$myPicture->render(); 
# END GRAPH

function convert2percent($dataSET){
	# Convert price to percent change
	$set1 = array();
	$last = 0;
	foreach($dataSET as $data){
		$previous = $last;
		if($previous == 0){$previous = $data;}
		$change = ($data - $previous) / $previous * 100;
		$set1[] = $change;
		$last = $data;
	}
	return $set1;
}

?>
