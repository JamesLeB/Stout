<?php
	$coinList = '';
	foreach($list as $coin){
		$coinList .= "
			<div>
				<div>$coin</div>
			</div>";
	}
	$html = "
		<div id='coinList'>
			<div>Coin List</div>
			<div>$coinList</div>
		</div>
	";
	$style = "
		<style>
			@font-face{
				font-family: 'rocksalt';
				src : url('lib/fonts/rocksalt.ttf')
			}
			@font-face{
				font-family: 'PermanentMarker';
				src : url('lib/fonts/PermanentMarker.ttf')
			}
			#coinList{
				border : 1px solid gray;
				box-shadow : 3px 3px 3px;
				border-radius : 20px;
				width : 600px;
				margin : 20px;
				margin-left : auto;
				margin-right : auto;
				background-image : url('lib/images/wood1.jpg');
				padding-bottom : 20px;
			}
			#coinList > div:nth-child(1){
				font-family: 'PermanentMarker';
				font-size : 200%;
				margin-top : 10px;
				margin-bottom : 10px;
				text-align : center;
			}
			#coinList > div:nth-child(2) > div{
				border : 1px solid gray;
				box-shadow : 2px 2px 2px;
				border-radius : 20px;
				margin-bottom : 25px;
				margin-left : auto;
				margin-right : auto;
				background : white;
				background-image : url('lib/images/slate1.jpg');
				width : 85%;
			}
			#coinList > div:nth-child(2) > div > div{
				width : 200px;
				margin-left : 30px;
				font-family: 'rocksalt';
				font-size : 120%;
				color : white;
			}
		</style>
	";
	echo $style;
	echo $html;
?>
