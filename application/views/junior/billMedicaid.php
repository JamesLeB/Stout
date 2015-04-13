<div id='juniorBiller'>
	<div>
		<div>Medicare</div>
		<div></div>
	</div>
	<div>
		<div>Medicaid</div>
		<div></div>
	</div>
	<div>
		<div>Processed</div>
		<div></div>
	</div>
	<div>
		<div>To Transfer</div>
		<div></div>
	</div>
	<div>
		<div>To Send</div>
		<div></div>
	</div>
	<div id='debug'></div>
	<button>GO</button>
</div>
<style>
	#juniorBiller{
		background : lightgray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		height : 650px;
		position : relative;
	}
	#juniorBiller > div{
		position : absolute;
	}
	#juniorBiller > div:nth-child(1){ width : 250px; top :  20px; left :  50px;}
	#juniorBiller > div:nth-child(2){ width : 250px; top :  20px; left : 350px;}
	#juniorBiller > div:nth-child(3){ width : 250px; top : 320px; left :  50px;}
	#juniorBiller > div:nth-child(4){ width : 250px; top :  20px; left : 650px;}
	#juniorBiller > div:nth-child(5){ width : 250px; top :  20px; left : 950px;}
	#juniorBiller > div > div:nth-child(1){
		font-size : 120%;
		width : 300px;
		margin-left : 20px;
		margin-bottom : 5px;
	}
	#debug{
		padding : 20px;
		height : 250px;
		width : 800px;
		border : 1px inset green;
		top : 320px;
		left : 400px;
		background : white;
		overflow : auto;
	}
</style>
<script>
	$('#juniorBiller button').hide();
	$('#juniorBiller button').click(function(){
		var target = 'index.php?/junior/';
		var func = 'go';
		$.post(target+func,'',function(data){
			var obj = $.parseJSON(data);
			$('#juniorBiller > div:nth-child(1) > div:nth-child(2)').html(obj[0]);
			$('#juniorBiller > div:nth-child(2) > div:nth-child(2)').html(obj[1]);
			$('#juniorBiller > div:nth-child(3) > div:nth-child(2)').html(obj[2]);
			$('#juniorBiller > div:nth-child(4) > div:nth-child(2)').html(obj[3]);
			$('#juniorBiller > div:nth-child(5) > div:nth-child(2)').html(obj[4]);
		});
	});
	$('#juniorBiller button').trigger('click');
</script>