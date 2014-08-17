<?php
/*
	$link = mssql_connect('dentrix','jl149','l3tm31n');
	$rs = mssql_query('select rscid from DDB_rsc');
	while($row = mssql_fetch_array($rs)){
		$data = $row{'rscid'};
		echo "$data<br/>";
	}
*/
	# Connect to DB
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);

	# Get time series
	$TIME = array();
	$rs = mysql_query("select lineDate,lineTime from bter where
		lineTime = '00:00:00'
		or lineTime = '12:00:00'
		or lineTime = '06:00:00'
		or lineTime = '18:00:00'
		order by lineDate,lineTime
	");
	while($row = mysql_fetch_assoc($rs)){
		$date = $row{'lineDate'};
		$time = $row{'lineTime'};
		$TIME[] = substr($date,8,2);
	}

	# Get price series
	$LTC = array();
	$DOGE = array();
	$FTC = array();
	$QRK = array();
	$WDC = array();
	$rs = mysql_query("select ltc,doge,ftc,qrk,wdc,pts,frc from bter where 
		lineTime like '00:00:00'
		or lineTime like '12:00:00'
		or lineTime = '06:00:00'
		or lineTime = '18:00:00'
		order by lineDate,lineTime
	");
	while($row = mysql_fetch_assoc($rs)){
		$LTC[] = $row{'ltc'};
		$DOGE[] = $row{'doge'};
		$FTC[] = $row{'ftc'};
		$QRK[] = $row{'qrk'};
		$WDC[] = $row{'wdc'};
		$PTS[] = $row{'pts'};
		$FRC[] = $row{'frc'};
	}

	$LTC_P = convert2percent($LTC);
	$DOGE_P = convert2percent($DOGE);
	$FTC_P = convert2percent($FTC);
	$QRK_P = convert2percent($QRK);
	$WDC_P = convert2percent($WDC);
	$PTS_P = convert2percent($PTS);
	$FRC_P = convert2percent($FRC);

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
	$MyData->addPoints($FTC_P,"FTC"); 
	#$MyData->addPoints($QRK_P,"QRK"); 
	#$MyData->addPoints($WDC_P,"WDC"); 
	$MyData->addPoints($PTS_P,"PTS"); 
	#$MyData->addPoints($FRC_P,"FRC"); 

$MyData->setPalette('LTC',array("R"=>125,"G"=>125,"B"=>125));
$MyData->setPalette('DOGE',array("R"=>255,"G"=>0,"B"=>0));
$MyData->setPalette('FTC',array("R"=>0,"G"=>255,"B"=>0));
$MyData->setPalette('PTS',array("R"=>0,"G"=>0,"B"=>255));
$MyData->setPalette('FRC',array("R"=>0,"G"=>0,"B"=>0));
	#$MyData->setAxisName(0,"Temperatures"); 
	$MyData->addPoints($TIME,"Labels"); 
	$MyData->setAbscissa("Labels"); 
	# Create the pChart object */ 
	$myPicture = new pImage(1400,400,$MyData); 
	# Set the default font */ 
	$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>8)); 
	# Define the chart area */ 
	$myPicture->setGraphArea(60,40,1300,350); 

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
