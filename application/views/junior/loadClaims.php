<div id='loadClaims'>
	<div></div>
	<div><div></div></div>
	<div></div>
</div>
<style>
	#loadClaims
	{
		border : 10px ridge yellow;
		background : lightgreen;
		height : 680px;
		position : relative;
	}
	#loadClaims > div
	{
		border : 1px solid black;
		margin : 20px;
		background : white;
		box-shadow : 2px 2px 2px black;
		height : 300px;
		width : 400px;
		overflow : auto;
		position : absolute;
	}
	#loadClaims > div:nth-child(1) { }
	#loadClaims > div:nth-child(2) { left: 450px; width: 1000px; height: 600px;}
	#loadClaims > div:nth-child(2) > div:nth-child(1) { margin : 10px; }
	#loadClaims > div:nth-child(3) { top: 330px;}
	.claimFile { margin : 10px; margin-left : 20px;}
	.processedClaimFile { margin : 10px; margin-left : 20px;}
</style>
<script>
	function getClaims()
	{
		$.post('index.php?/junior/getNewClaims','',function(data){
			var obj = $.parseJSON(data);
			var list = '';
			obj.forEach(function(o){
				list += '<div class=\'claimFile\'>'+o+'</div>';
			});
			$('#loadClaims > div:nth-child(1)').html(list);
			$('.claimFile').click(function(){
				var fileName = $(this).html();
				var parm = { file: fileName };
				$.post('index.php?/junior/processClaim',parm,function(data){
					$('#loadClaims > div:nth-child(2) div:nth-child(1)').html(data);
					getClaims();
				});
			});
			$('.claimFile').mouseenter(function(){
				$(this).css({background:'yellow'});
			});
			$('.claimFile').mouseleave(function(){
				$(this).css({background:'white'});
			});
		});
		$.post('index.php?/junior/getProcessedClaims','',function(data){
			var obj = $.parseJSON(data);
			var list = '';
			obj.forEach(function(o){
				list += '<div class=\'processedClaimFile\'>'+o+'</div>';
			});
			$('#loadClaims > div:nth-child(3)').html(list);
			$('.processedClaimFile').click(function(){
				var fileName = $(this).html();
				var parm = { file: fileName };
				$.post('index.php?/junior/resetClaim',parm,function(data){
					$('#loadClaims > div:nth-child(2) > div:nth-child(1)').html(data);
					getClaims();
				});
			});
			$('.processedClaimFile').mouseenter(function(){
				$(this).css({background:'yellow'});
			});
			$('.processedClaimFile').mouseleave(function(){
				$(this).css({background:'white'});
			});
		});
	}
	getClaims();
	$('#loadClaims > div:nth-child(2) > div:nth-child(1)').html('Welcome');
</script>
