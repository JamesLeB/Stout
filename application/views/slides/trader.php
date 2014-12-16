<div id='controls'>
	<button>Exchanges</button>
	<button>Trades</button>
	<button>Accounts</button>
	<button>Regression</button>
</div>
<div id='trader'>
	<div>
		<div>Heading: Exchange</div>
		<div>Pairs
			<div>Pair</div>
			<div>Pair</div>
			<div>Pair</div>
			<div>Pair</div>
		</div>
	</div>
</div>
<style>
	#controls{
		border : blue solid 1px;
	}
	#controls button{
		margin : 5px;
	}
	#trader{
		border : 5px ridge green;
		margin : 20px;
		height : 500px;
		overflow : auto;
	}
	#trader div{
		border : 1px dotted gray;
		margin : 20px;
		padding : 10px;
	}
</style>
<script>
	var target = 'index.php?/slides/trader/';
	var request = $.post(target,'',function(data){
		//$('#trader').html(data);
	});
	$('#controls button').click(function(){
		var target = 'index.php?/slides/trader/';
		var func = '';
		var a = $(this).first().html();
		     if(a=='Exchanges') {func = 'exchanges';}
		else if(a=='Trades')    {func = '';}
		else if(a=='Accounts')  {func = '';}
		else if(a=='Regression'){func = '';}
		var request = $.post(target+func,'',function(data){
			$('#trader').html(data);
		});
	});
</script>
