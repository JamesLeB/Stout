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
				<button>Mint</button>
				<button>Buys</button>
			</td>
			<td id='trader_View'>View</td>
		</tr>
	</table>
</div>
<style>
/*
		border-color : #007A00;
		border-style : dashed;
		border-width: 1px;
*/
	#trader_Icon{
		background : white;
		text-align : center;
	}
	#trader > table{
		width : 100%;
	}
	#trader_Icon img{
		height : 50px;
	}
	#trader_Status{
		padding-left : 20px;
		border-color : #007A00;
		border-style : dashed;
		border-width: 1px;
		color: white;
	}
	#trader_Controls{
		border-color : #007A00;
		border-style : dashed;
		border-width: 1px;
		vertical-align : top;
		width : 120px;
		text-align : center;
	}
	#trader_Controls button{
		width : 90px;
	}
	#trader_View{
		border-color : #007A00;
		border-style : dashed;
		border-width: 1px;
		vertical-align : top;
		height : 400px;
		text-align : left;
		font-size : 1.5em;
		color : #66AF66;
		padding : 20px;
	}
</style>
<script>
	$('#trader_Controls button').click(function(){
		var target = 'index.php?/slides/trader/';
		var func = '';
		var a = $(this).first().html();
		if(a=='Mint'){
			func = 'mint';
		}else if(a=='Buys'){
			func = 'getBuys';
		}else{
			func = 'test';
		}
		var p = 'Fun with code';
		var parm = {'test':p};
		var request = $.post(target+func,parm,function(data){
			$('#trader_View').html(data);
			var status = request.getResponseHeader('status');
			if( status != null ){
				$('#trader_Status').html(status);
			}else{
				$('#trader_Status').html('no status');
			}
		});
	});
</script>
