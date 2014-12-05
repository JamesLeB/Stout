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
			#coinList{
				border : 1px solid gray;
				box-shadow : 3px 3px 3px;
				padding : 20px;
				border-radius : 20px;
				width : 800px;
				margin : 20px;
				margin-left : auto;
				margin-right : auto;
				background : #F0F0F0;
			}
			#coinList div{
				margin : 10px;
			}
			#coinList > div:nth-child(1){
				padding-left : 50px;
				font-size : 120%;
			}
			#coinList > div:nth-child(2) > div{
				border : 1px solid gray;
				box-shadow : 2px 2px 2px;
				border-radius : 20px;
				margin-bottom : 20px;
				background : white;
			}
			#coinList > div:nth-child(2) > div > div{
				width : 200px;
				margin-left : 20px;
			}
		</style>
	";
	
	echo $style;
	echo $html;
?>
