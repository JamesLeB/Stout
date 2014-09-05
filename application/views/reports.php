<div id='reports'>
<?php
	$reports = array();
	$reports[] = array('icon'=>'Report1','ID'=>'report1','report'=>$report1);
	$reports[] = array('icon'=>'Report2','ID'=>'report2','report'=>$report2);
	$reports[] = array('icon'=>'Report3','ID'=>'report3','report'=>$report3);
	$reports[] = array('icon'=>'Report4','ID'=>'report4','report'=>$report4);

	$html = '';
	$html .= "<table id='reportsGrid'>";
	$html .= "<tr>";
	$html2 = '';
	foreach($reports as $report){
		$icon   = $report['icon'];
		$ID     = $report['ID'];
		$report = $report['report'];
		$html .= "<td><div class='reportIcon' report='$ID' >$icon</div></td>";
		$html2 .= "<div id='$ID'>";
		$html2 .= "<button class='closeReport'>Close</button>";
		$html2 .= $report;
		$html2 .= "</div>";
	}
	$html .= "</tr>";
	$html .= "</table>";
	$html .= $html2;
	echo $html;
?>
</div>
<style>
	#reportsGrid td {
		background : lightgray;
		color : black;
	}
	.reportIcon {
		background : white;
		border-style : ridge;
		border-color : green;
		border-size : 1px;
		height : 100px;
		width : 100px;
	}
</style>
<script>
	$('.closeReport').parent().hide();
	$('.closeReport').click(function(){
		$(this).parent().hide();
		$('#reportsGrid').show();
	});
	$('.reportIcon').click(function(){
		$('#reportsGrid').hide();
		var x = $(this).attr('report');
		$('#'+x).show();
	});
	$('.reportIcon').mouseenter(function(){
		$(this).css('border-color','yellow');
	});
	$('.reportIcon').mouseleave(function(){
		$(this).css('border-color','green');
	});
</script>
