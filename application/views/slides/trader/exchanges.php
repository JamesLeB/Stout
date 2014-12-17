<?php
	$html = "";
	$style = "<style>";
	foreach($exchanges as $exchange)
	{
		$exchangeName = $exchange['name'];
		$html .= "<div id='exchange$exchangeName'>";
		$html .= "<div>$exchangeName</div>";
		$html .= "<div>";
		$pairs = $exchange['pairs'];
		foreach($pairs as $pair)
		{
			$pairName = $pair['name'];
			$html .= "<div>";
			$html .= "<div>$pairName</div>";
			$html .= "</div>";
		}
		$html .= "</div>";
		$html .= "</div>";
		$style .= "
			#exchange$exchangeName
			{
				border : 1px solid gray;
				margin : 20px;
				background-image : url('lib/images/wood1.jpg');
				box-shadow : 3px 3px 3px black;
				border-radius : 20px;
				width : 600px;
				margin-left : auto;
				margin-right : auto;
			}
			#exchange$exchangeName div
			{
			}
			#exchange$exchangeName > div:nth-child(1)
			{
				font-family: 'PermanentMarker';
				text-align : center;
				font-size : 200%;
				margin-top : 10px;
				margin-bottom : 10px;
			}
			#exchange$exchangeName > div:nth-child(2)
			{
				border : 2px inset gray;
				margin-bottom : 30px;
				margin-right  : 30px;
				margin-left   : 30px;
				height : 300px;
				overflow : auto;
			}
			#exchange$exchangeName > div:nth-child(2) > div
			{
				border : 1px solid gray;
				background-image : url('lib/images/slate1.jpg');
				margin : 20px;
				box-shadow : 2px 2px 2px black;
				border-radius : 20px;
			}
			#exchange$exchangeName > div:nth-child(2) > div > div:nth-child(1)
			{
				width : 150px;
				color : white;
				font-family: 'rocksalt';
				font-size : 120%;
				margin-left : 20px;
			}
		";

	}
	$style .= "</style>";
	echo $html.$style;
	
?>
