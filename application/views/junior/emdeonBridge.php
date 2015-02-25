<div id='emdeonBridge'>
	<div></div>
	<div><div></div></div>
	<div></div>
</div>
<style>
	#emdeonBridge
	{
		border : 10px ridge blue;
		background : lightblue;
		height : 680px;
		position : relative;
	}
	#emdeonBridge > div
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
	#emdeonBridge > div:nth-child(1) { }
	#emdeonBridge > div:nth-child(2) { left: 450px; width: 1000px; height: 600px;}
	#emdeonBridge > div:nth-child(2) > div:nth-child(1) { margin : 10px; }
	#emdeonBridge > div:nth-child(3) { top: 330px;}
	.emdeonFile { margin : 10px; margin-left : 20px;}
	.processedEmdeonFile { margin : 10px; margin-left : 20px;}
</style>
<script>
	function getEmdeonFiles()
	{
		$.post('index.php?/juniorX/emdeonBridge/getNewList','',function(data){
			var obj = $.parseJSON(data);
			var list = '';
			obj.forEach(function(o){
				list += '<div class=\'emdeonFile\'>'+o+'</div>';
			});
			$('#emdeonBridge > div:nth-child(1)').html(list);
			$('.emdeonFile').click(function(){
				switchScreen('');
				var fileName = $(this).html();
				var parm = { file: fileName };
				$.post('index.php?/juniorX/emdeonBridge/readFile',parm,function(data){
					switchBack();
					$('#emdeonBridge > div:nth-child(2) div:nth-child(1)').html(data);
					getEmdeonFiles();
				});
			});
/*
*/
			$('.emdeonFile').mouseenter(function(){
				$(this).css({background:'yellow'});
			});
			$('.emdeonFile').mouseleave(function(){
				$(this).css({background:'white'});
			});
		});
		$.post('index.php?/juniorX/emdeonBridge/getOldList','',function(data){
			var obj = $.parseJSON(data);
			var list = '';
			obj.forEach(function(o){
				list += '<div class=\'processedEmdeonFile\'>'+o+'</div>';
			});
			$('#emdeonBridge > div:nth-child(3)').html(list);
/*
			$('.processedEmdeonFile').click(function(){
				var fileName = $(this).html();
				var parm = { file: fileName };
				$.post('index.php?/junior/resetClaim',parm,function(data){
					$('#emdeonBridge > div:nth-child(2) > div:nth-child(1)').html(data);
					getEmdeonFiles();
				});
			});
*/
			$('.processedEmdeonFile').mouseenter(function(){
				$(this).css({background:'yellow'});
			});
			$('.processedEmdeonFile').mouseleave(function(){
				$(this).css({background:'white'});
			});
		});
	}
	getEmdeonFiles();
	$('#emdeonBridge > div:nth-child(2) > div:nth-child(1)').html('Welcome');
</script>
