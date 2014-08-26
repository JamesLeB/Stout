<div>
	<div>
		<button id='kbutton'>List</button>
		<button>Sumary</button>
		<button>Coins</button>
	</div>
	<div>
		Coin Summary
	</div>
	<div>
		Coin List
	</div>
	<div>
		My Coins
	</div>
</div>
<script>
	// List button
	$('#exchange > div > :nth-child(1) > :nth-child(1)').click(function(){
		var msg = '';
		msg += '<select>';
		msg += '<option value="first test val">number1</option>';
		msg += '<option value="second">number2</option>';
		msg += '<option value="third">number3</option>';
		msg += '</select>';
		$('#exchange > div > :nth-child(3)').html(msg);
	});
	// Summary button
	$('#exchange > div > :nth-child(1) > :nth-child(2)').click(function(){
		var msg = 'get coin summary<br/>';
		var coin = $('#exchange > div > :nth-child(3) select').val();
		msg += coin;
		$('#exchange > div > :nth-child(2)').html(msg);
	});
	// My Coins button
	$('#exchange > div > :nth-child(1) > :nth-child(3)').click(function(){
		var target = 'index.php?/stage/getMech';
		var request = $.post(target,'',function(data){
			var msg = data;
			$('#exchange > div > :nth-child(4)').html(msg);
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
		});
	});
	function stage(){
		var target = 'index.php?/stage/running';
		var request = $.post(target,'',function(data){
			$('#exchange > div > :nth-child(4)').append(data);
			var scene = request.getResponseHeader('scene');
			if( scene == 1 ){stage();}
		});
	}
</script>
<style>
	#exchange div {
		padding : 10px;
		margin : 10px;
		background : black;
		border-style : ridge;
		border-width : 5px;
	}
	#exchange > div {
		background : gray;
		border-color : blue;
		height : 400px;
	}
	/* Buttons */
	#exchange > div > :nth-child(1) {
		border-color : purple;
	}
	/* Coin Summary */
	#exchange > div > :nth-child(2) {
		border-color : yellow;
		width : 300px;
		height : 200px;
		position : relative;
		top : -10;
		float : right;
	}
	/* Coin List */
	#exchange > div > :nth-child(3) {
		border-color : red;
		width : 400px;
	}
	/* My Coin List */
	#exchange > div > :nth-child(4) {
		border-color : green;
		width : 400px;
		height : 200px;
	}
</style>
