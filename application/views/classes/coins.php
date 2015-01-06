<?php
	$coinList = '';
/*
	foreach($list as $coin){
		$coinList .= "
			<div>
				<div>$coin</div>
			</div>";
	}
*/
	$html = "
		<div id='coinExchange'>
			<div id='aptTesting'>
				<button>TEST</button>
				<div></div>
			</div>
			<div id='coinList'>
				<div>Coin List</div>
				<div>$coinList</div>
			</div>
			<div id='coinData'>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	";
	$style = "
		<style>
			#coinExchange{
				border : 1px solid gray;
				border-radius : 20px;
				position : relative;
				height : 650px;
				box-shadow : 3px 3px 3px black;
			}
			#coinData table td{
				background : lightgray;
				padding : 10px;
			}
			#coinData > div{
				border : 1px inset gray;
				width : 750px;
				margin : 20px;
				padding : 10px;
				overflow : auto;
				position : absolute;
			}
			#coinData > div:nth-child(1){
				height : 250px;
			}
			#coinData > div:nth-child(2){
				height : 250px;
				width  : 350px;
				top    : 300px;
				left   : 800px;
			}
			#coinData > div:nth-child(3){
				height : 250px;
				width  : 350px;
				left   : 800px;
			}
			#coinData > div:nth-child(4){
				height : 250px;
				width  : 750px;
				top    : 300px;
			}
			#aptTesting{
				width : 400px;
				float : right;
				margin : 20px;
			}
			#aptTesting > div{
				height : 300px;
				overflow : auto;
				padding : 5px;
				border : 2px inset gray;
			}
			#aptTesting > button{
				background : blue;
				color : white;
				margin : 10px;
			}
			#coinList{
				border : 1px solid gray;
				box-shadow : 3px 3px 3px;
				border-radius : 20px;
				width : 600px;
				margin : 20px;
				background-image : url('lib/images/wood1.jpg');
			}
			#coinList > div:nth-child(1){
				font-family: 'PermanentMarker';
				font-size : 200%;
				text-align : center;
				padding : 10px;
			}
			#coinList > div:nth-child(2){
				overflow : auto;
				height : 400px;
				border : 2px gray inset;
				margin-left : 20px;
				margin-right : 20px;
				margin-bottom : 20px;
				padding-top : 20px;
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
	$script = "
		<script>
			$.post('index.php?/stout/getBter','',function(data){
				var obj = $.parseJSON(data)
				$('#coinData > div:nth-child(1)').html(obj[0]);
				$('#coinData > div:nth-child(2)').html(obj[1]);
				$('#coinData > div:nth-child(3)').html(obj[2]);
				$('#coinData > div:nth-child(4)').html(obj[3]);
			});
/*
			$('#coinData > div:nth-child(1)').hide();
			$('#coinData > div:nth-child(2)').hide();
			$('#coinData > div:nth-child(3)').hide();
			$('#coinData > div:nth-child(4)').hide();
			$('#coinData > div:nth-child(5)').hide();
*/
			$('#aptTesting').hide();
			$('#aptTesting').click(function(){
				$('#aptTesting > div').html('testing');
/*
				$.post('index.php?/stout/getBter','',function(data){
					$('#aptTesting > div').html(data);
				});
*/
			});
			$('#coinList').hide();
		</script>
	";
	#echo $style;
	#echo $html;
	#echo $script;
	echo "Time to build the coin list view";
?>
