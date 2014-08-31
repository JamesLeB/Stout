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
?>
