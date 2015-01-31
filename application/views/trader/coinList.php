<?php

	$html = '';

	$html .= "<div>";
	$html .= "<div>";
	$html .= "<div><div>Coin</div></div>";
	$html .= "<div><div>Slope</div></div>";
	$html .= "<div><div>Slope48</div></div>";
	$html .= "<div><div>Slope24</div></div>";
	$html .= "<div><div>Volume</div></div>";
	$html .= "</div>";
	$html .= "</div>";

	$html .= "<div>";
	foreach($list as $item)
	{
		$html .= "<div class='pair'>";
		$html .= "<div><div>$item</div></div>";
		$html .= "<div><div>x</div></div>";
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
	#coinList > div > div
	{
		height : 35px;
	}
	#coinList > div > div > div
	{
		float : left;
		margin-right : 10px;
	}
	#coinList > div > div > div:nth-child(1) { width : 150px; }
	#coinList > div > div > div:nth-child(2) { width : 100px; }
	#coinList > div > div > div:nth-child(3) { width : 100px; }
	#coinList > div > div > div:nth-child(4) { width : 100px; }
	#coinList > div > div > div:nth-child(5) { width : 100px; }

	#coinList > div:nth-child(1) > div > div
	{
		background : green;
		color : white;
		height : 30px;
	}
	#coinList > div:nth-child(1) > div > div > div
	{
		text-align : center;
		margin-top : 5px;
	}
	#coinList > div:nth-child(2) > div > div > div
	{
		margin-left : 20px;
		margin-top : 5px;
		height : 30px;
	}
	#coinList > div:nth-child(2)
	{
		height : 200px;
		overflow : auto;
	}
	#coinList > div:nth-child(2) > div > div:nth-child(1) > div
	{
	}

</style>
<script>
	$('#coinList > div:nth-child(2) > div > div:nth-child(1) > div').mouseenter(function(){
		$(this).css('color','blue');
	});
	$('#coinList > div:nth-child(2) > div > div:nth-child(1) > div').mouseleave(function(){
		$(this).css('color','black');
	});
	$('#coinList > div:nth-child(2) > div > div:nth-child(1) > div').click(function(){

var b = '';
var pairs = $('.pair');
pairs.each(function(index,element){
	var coin = $(element).children(':nth-child(1)').children(':nth-child(1)').html();
	b += coin + '_<br/>';
});

		var parm = {groot: b};
		$.post('index.php?/trader/getCoinDetail',parm,function(data){
			switchScreen(data);
		});
	});
</script>
