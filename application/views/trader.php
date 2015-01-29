<button id='getCoins'>Get</button>
<button id='sortCoins'>Sort</button>
<button id='switch'>switch</button>
<div id='trader'></div>
<style>
	/* background-image : url('lib/images/wood1.jpg'); */
	#trader
	{
		margin-top : 15px;
		background : lightgreen;
		border : 2px solid black;
		height : 600px;
		overflow : auto;
	}
	.pair
	{
		background-image : url('lib/images/slate1.jpg');
		border : 1px solid gray;
		margin  : 20px;
		padding : 10px;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		color : white;
		height : 20px;
	}
	.pair > div { float: left; }
	.pair > div:nth-child(1) { width : 150px; margin-left : 10px;}
	.pair > div:nth-child(2) { width : 150px; }
	.pair > div:nth-child(3) { width : 150px; }
	.pair > div:nth-child(4) { width : 150px; }
</style>
<script>
	$('#switch').click(function(){
		$.post('index.php?/trader/getCoinDetail','',function(data){
			switchScreen(data);
		});
	});
	$('#sortCoins').click(function(){
		var mylist = $('.pair');
		mylist.detach();
		mylist.sort(function(a,b){
			var aa = $(a).children(':nth-child(4)').html();
			var bb = $(b).children(':nth-child(4)').html();
			/* if( aa < bb ) { return 1; } else { return -1; } */
			return bb - aa;
		});
		$('#trader').html(mylist);
	});
	$('#getCoins').click(function(){
		$.post('index.php?/trader/getCoinList','',function(data){
			var obj = $.parseJSON(data)
			var html = '';
			obj.forEach(function(a){
				html += '<div class=\'pair\'>';
				  html += '<div>' + a + '</div>';
				html += '</div>';
			});
			$('#trader').html(html);
			var pairs = $('.pair');
			var count = 0;
			var total = pairs.length;
			pairs.each(function(index,element){
				var j = $(element).children(':nth-child(1)').html();
				var parm = { coin: j };
				$.post('index.php?/trader/getCoinSlope',parm,function(slope){
					count++;
					$('#debug').html(count + ' of ' + total);
					var so = $.parseJSON(slope);
					var factor = 10000000;
					var slopeAl = so[0]*factor;
					var slope48 = so[1]*factor;
					var slope24 = so[2]*factor;
					var volum24 = Number(so[3]);
					var ht = '';
					ht += '<div>'+slopeAl.toFixed(6)+'</div>';
					ht += '<div>'+slope48.toFixed(6)+'</div>';
					ht += '<div>'+slope24.toFixed(6)+'</div>';
					ht += '<div>'+volum24.toFixed(6)+'</div>';
					$(element).append(ht);
				});
			});
		});
	});
</script>
