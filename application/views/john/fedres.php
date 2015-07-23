<button id='fuckthis'>GO</button>
<div id='someshit'>Stuff</div>
<div id='someothershit'>Other Stuff</div>
<script>

function stage()
{
	$.post('index.php?/john/fedres1','',function(d)
	{
		var o = $.parseJSON(d);
		if( o[0] == 'true' )
		{
			$('#someothershit').html(o[1]);
			stage();
		} else 
		{
			$('#someothershit').html(o[1]);
		}
	});
}
	$('#fuckthis').click(function(){
		$.post('index.php?/john/fedres','',function(d)
		{
			var o = $.parseJSON(d);
			if( o[0] == 'true' )
			{
				$('#someshit').html(o[1]);
				stage();
			} else 
			{
				$('#someshit').html(o[1]);
			}
		});
	});
</script>
