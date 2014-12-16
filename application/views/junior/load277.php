<div id='load277'>
	<div>
		<button>GO</button>
		<button>Test</button>
	</div>
	<div>
		<div>Results</div>
		<div>data</div>
	</div>
	<div>
		<div>277 List</div>
		<div></div>
	</div>
</div>
<style>
	#load277
	{
		position : relative;
		border : 1px solid gray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		background : lightgray;
		height : 400px;
		width  : 90%;
		margin-left  : auto;
		margin-right : auto;
	}
	#load277 > div
	{
		position : absolute;
	}
	#load277 > div:nth-child(1)
	{
		top    : 20px;
		left   : 50px;
	}
	#load277 > div:nth-child(2)
	{
		width  : 500px;
		height : 300px;
		top    :  70px;
		left   : 450px;
	}
	#load277 > div:nth-child(2) > div:nth-child(1)
	{
		text-align : center;
		margin-bottom : 10px;
	}
	#load277 > div:nth-child(2) > div:nth-child(2)
	{
		width  : 80%;
		height : 200px;
		background : white;
		margin-left  : auto;
		margin-right : auto;
		border : 2px gray inset;
		padding : 10px;
		overflow : auto;
	}
	#load277 > div:nth-child(3)
	{
		width  : 300px;
		height : 300px;
		top    :  70px;
		left   :  50px;
	}
	#load277 > div:nth-child(3) > div:nth-child(1)
	{
		text-align : center;
		margin-bottom : 10px;
	}
	#load277 > div:nth-child(3) > div:nth-child(2)
	{
		width  : 80%;
		height : 200px;
		background : white;
		margin-left  : auto;
		margin-right : auto;
		border : 2px gray inset;
		padding : 10px;
		overflow : auto;
	}
</style>
<script>
	$('#load277 > div:nth-child(1) > button:nth-child(1)').hide();
	$('#load277 button').click(function(){
		var action = $(this).html();
		if(action ==  'GO')
		{
			$('#load277 > div:nth-child(2) > div:nth-child(2)').html('Initial Load');
			var target = 'index.php?/junior/get277List';
			$.post(target,'',function(data){
				var list = $.parseJSON(data);
				var rtn = '';
				list.forEach(function(item){
					rtn += '<div>'+item+'</div>';
				});
				$('#load277 > div:nth-child(3) > div:nth-child(2)').html(rtn);
				$('#load277 > div:nth-child(3) > div:nth-child(2) > div').mouseenter(function(){
					$(this).css('background','yellow');
				});
				$('#load277 > div:nth-child(3) > div:nth-child(2) > div').mouseleave(function(){
					$(this).css('background','white');
				});
				$('#load277 > div:nth-child(3) > div:nth-child(2) > div').click(function(){
					var fileName = $(this).html();
					$('#load277 > div:nth-child(2) > div:nth-child(2)').html('Loading ' + fileName);
				});
			});
		}
		else
		{
			$('#load277 > div:nth-child(2) > div:nth-child(2)').html('Result for '+action);
		}
	});
	$('#load277 button:nth-child(1)').trigger('click');
</script>