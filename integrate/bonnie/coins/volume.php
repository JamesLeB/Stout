<?php
	$coin1 = 'ltc';
	$coin2 = 'doge';
	$coin3 = 'pts';
	$coin4 = 'qrk';
	$where = "where time like '%:00:00'";
	# Connect to DB
	$link = mysql_connect('localhost','doger','sorcier');
	mysql_select_db('ticker',$link);
	$TIME = array();
	$COIN1 = array();
	$COIN2 = array();
	$COIN3 = array();
	$COIN4 = array();
	$rs = mysql_query("select date,time,
		$coin1,
		$coin2,
		$coin3,
		$coin4
		from btcvol $where");
	while($row = mysql_fetch_assoc($rs)){
		$TIME[] = substr($row{'time'},0,2);
		$COIN1[] = $row{$coin1};
		$COIN2[] = $row{$coin2};
		$COIN3[] = $row{$coin3};
		$COIN4[] = $row{$coin4};
	}
########################
$max = 600;
$min = 0;

# CREATE GRAPH
	include("pChart2.1.4/class/pData.class.php"); 
	include("pChart2.1.4/class/pDraw.class.php"); 
	include("pChart2.1.4/class/pImage.class.php"); 
	# Create and populate the pData object */ 
	$MyData = new pData();   
	$MyData->addPoints($COIN1,$coin1); 
	$MyData->addPoints($COIN2,$coin2); 
	$MyData->addPoints($COIN3,$coin3); 
	#$MyData->addPoints($COIN4,$coin4); 
	$MyData->setPalette($coin1,array("R"=>125,"G"=>125,"B"=>125));
	$MyData->setPalette($coin2,array("R"=>255,"G"=>125,"B"=>0));
	$MyData->setPalette($coin3,array("R"=>0,"G"=>0,"B"=>255));
	#$MyData->setPalette($coin4,array("R"=>255,"G"=>0,"B"=>0));
	$MyData->addPoints($TIME,"Labels"); 
	$MyData->setAbscissa("Labels"); 
	$myPicture = new pImage(1000,400,$MyData); 
	$myPicture->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/pf_arma_five.ttf","FontSize"=>12)); 
	$myPicture->setGraphArea(60,40,850,350); 
 	$scaleSettings = array(
		"GridR"=>10,
		"CycleBackground"=>true,
		"RemoveXAxis"=>false,
		"Mode"=>SCALE_MODE_MANUAL,
		"ManualScale"=>array(0=>array("Min"=>$min,"Max"=>$max))
	); 
 	$myPicture->drawScale($scaleSettings); 
	$myPicture->drawLineChart(); 
	$myPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
	$myPicture->render(); 
# END GRAPH

?>
