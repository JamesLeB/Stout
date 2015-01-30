<?php

	$html = '';

	$html .= "<div>";
	$html .= "<div>";
	$html .= "<div>Coin</div>";
	$html .= "<div>Slope</div>";
	$html .= "</div>";
	$html .= "</div>";

	$html .= "<div>";
	foreach($list as $item)
	{
		$html .= "<div>";
		$html .= "<div>$item</div>";
		$html .= "<div>x</div>";
		$html .= "</div>";
	}
	$html .= "</div>";

?>
<div id='coinList'>
	<?php echo $html; ?>
</div>
<style>
	#coinList
	{
		margin : 20px;
		border : 1px solid black;
		padding : 20px;
		background : lightgreen;
		border-radius : 25px;
		box-shadow : 2px 2px 2px black;
	}
	#coinList div
	{
		border : dashed 1px gray;
	}
	#coinList > div { border : 2px solid red; }
	#coinList > div > div
	{
		height : 40px;
	}
	#coinList > div > div > div
	{
		width : 100px;
		float : left;
	}
	#coinList > div > div > div:nth-child(1) { width : 200px; }
	#coinList > div > div > div:nth-child(2) { width : 100px; }

	#coinList > div:nth-child(1) > div:nth-child(1) > div
	{
		background : green;
		color : white;
		text-align : center;
	}
	#coinList > div:nth-child(2)
	{
		height : 200px;
		overflow : auto;
	}

</style>
