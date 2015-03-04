$(document).ready(function(){
	var eTime = 0;
	setInterval(function(){
		eTime++;
		$('#clock').html(eTime);
		$('#status').css('background','gray');
		$.post('time.php','',function(data){
			$('#status').css('background','lightgreen');
			var obj = $.parseJSON(data);
			$('#status').html(obj.status);
		});
	},1000);
});
