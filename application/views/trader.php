<div id='trader'>
	<table>
		<tr>
			<td id='trader_Icon'>
				<img src='lib/images/cricket.png' />
			</td>
			<td id='trader_Status'>Status</td>
		</tr>
		<tr>
			<td id='trader_Controls'>
				<button>TEST</button>
			</td>
			<td id='trader_View'>View</td>
		</tr>
	</table>
</div>
<style>
	#trader td{
		border-color : #007A00;
		border-style : dashed;
		border-width: 1px;
		padding : 5px;
	}
	#trader_Icon{
		background : white;
		text-align : center;
	}
	#trader_Icon img{
		height : 50px;
	}
	#trader_Controls{
		vertical-align : top;
		width : 120px;
		text-align : center;
	}
	#trader_Controls button{
		width : 90px;
	}
	#trader_View{
		vertical-align : top;
		height : 400px;
		width : 800px;
		text-align : left;
		font-size : 1.5em;
		color : #66AF66;
	}
</style>
<script>
	var trader_Target = 'index.php?/slides/trader/';
	// Test button
	$('#trader_Controls button:nth-child(1)').click(function(){
		/*
		var func = 'test';
		var request = $.post(workerTarget+func,'',function(data){
			$('#workerView').html(data);
			//$('#workerView').html('TEST Button disabled');
			//var scene = request.getResponseHeader('scene');
			//if( scene == 1 ){stage();}
		});
		*/
			$('#trader_View').html('TEST Button disabled');
	});
</script>
