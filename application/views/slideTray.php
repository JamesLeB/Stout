<?php
	$html = '';
	$html .= '<div id="tabs">';
	$html .= '<ul>';
	$index = 0;
	foreach($slides as $slide){
		$index++;
		$name = $slide[0];
		$html .= "<li><a href='#tab$index'>$name</a></li>";
	}
	$html .= '</ul>';
	$index = 0;
	foreach($slides as $slide){
		$index++;
		$view = $slide[1];
		$html .= "<div id='tab$index'>$view</div>";
	}
	$html .= '</div>';
	echo $html;
/*
<div id='tabs'>
	<ul>

		<li><a href='#grapher'>Grapher</a></li>
		<li><a href='#trader'>Trader</a></li>
		<li><a href='#exchange'>Exchange</a></li>
		<li><a href='#development'>Development</a></li>
		<li><a href='#production'>Production</a></li>
	</ul>
	<div id='grapher'><?php echo $grapher ?></div>
	<div id='exchange'><?php echo $exchange ?></div>
	<div id='trader'><?php echo $trader ?></div>
	<div id='development'><?php echo $development ?></div>
	<div id='production'><?php echo $production ?></div>
</div>
*/
?>
