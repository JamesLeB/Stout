<button id='getCoins'>Get</button>
<button id='getSlope'>GetSlope</button>
<button id='sortCoins'>Sort</button>
<button id='switch'>switch</button>
<div id='trader'></div>
<style>
	#trader
	{
		border : 1px solid black;
		margin : 20px;
		padding : 10px;
	}
</style>
<script>
	$.post('index.php?/trader/getTrader','',function(data){
		$('#trader').html(data);
	});
	$('#switch').click(function(){
		var p = {groot: 'I am a groot'};
		$.post('index.php?/trader/getCoinDetail',p,function(data){
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
	$('#getSlope').click(function(){
		$('#debug').html('ya me');
		var pairs = $('.pair');
		pairs.each(function(index,element){
			$(element).children(':nth-child(2)').children(':nth-child(1)').html('yy');
		});
	});
	$('#getCoins').click(function(){
		$.post('index.php?/trader/getCoinList','',function(data){
			$('#trader').html(data);
/*
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
*/
		});
	});
</script>
