<div id='dbtables'>
	<div>
		<div>Denial Mangement</div>
		<div>
			<div><div>Claims</div></div>
			<div><div>Services</div></div>
		</div>
	</div>
	<div>
		<div>Warehouse</div>
		<div>
			<div><div>All_Claims</div></div>
			<div><div>AR_Ledger</div></div>
			<div><div>checks</div></div>
			<div><div>claimLines</div></div>
			<div><div>claims</div></div>
			<div><div>claims2bill</div></div>
			<div><div>claims2billLines</div></div>
			<div><div>jclaims</div></div>
			<div><div>jFamily</div></div>
			<div><div>jLedger</div></div>
			<div><div>myClaims</div></div>
			<div><div>sentClaimLines</div></div>
			<div><div>sentClaims</div></div>
			<div><div>test</div></div>
		</div>
	</div>
</div>
<style>
	#dbtables
	{
		background : lightgray;
		border : 1px solid gray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		position : relative;
		height : 500px;
	}
	#dbtables > div
	{
		border : 1px solid gray;
		background-image : url('lib/images/wood1.jpg');
		width : 500px;
		position : absolute;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
	}
	#dbtables > div:nth-child(1)
	{
		left : 600px;
		top  :  30px;
	}
	#dbtables > div:nth-child(2)
	{
		left :  30px;
		top  :  30px;
	}
	#dbtables > div > div:nth-child(1)
	{
		margin-top : 10px;
		text-align : center;
		font-size : 150%;
	}
	#dbtables > div > div:nth-child(2)
	{
		height : 300px;
		overflow : auto;
		margin-top    : 10px;
		margin-bottom : 30px;
		margin-right  : 30px;
		margin-left   : 30px;
		border : 2px gray inset;
	}
	#dbtables > div > div:nth-child(2) > div
	{
		background-image : url('lib/images/slate1.jpg');
		border : 1px solid black;
		border-radius : 20px;
		box-shadow : 2px 2px 2px black;
		margin : 15px;
	}
	#dbtables > div > div:nth-child(2) > div > div:nth-child(1)
	{
		margin : 10px;
		margin-left : 20px;
		width : 200px;
	}
</style>
<script>
	$('#dbtables > div > div:nth-child(2) > div').click(function(){
		var table = $(this).children().html();
		alert('Load '+table);
	});
	$(document).ready(function(){
		var list = ['checks','claims','All_Claims'];
		$('#dbtables > div > div > div').each(function(){
			var table = $(this).children().html();
			var check = 0;
			for(i=0;i<list.length;i++)
			{
				if(list[i] == table)
				{
					check = 1;
				}
			}
			if(check == 1)
			{
				$(this).css('color','White');
			}
			else
			{
				$(this).css('color','yellow');
			}
		});
	});
</script>
