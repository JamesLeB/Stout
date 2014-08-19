<div id='worker1' class='worker'>
	<form>
		<p>Description of Worker</p> 
		<input type='text' name='value1' />
		<input type='submit' value='submit' />
	</form>
	<button>Clear</button>
	<div class='workerOutput'>
		work output here
	</div>
</div>
<script>
	$('#worker1 form').submit(function(){
		$(this).css('background','#006699');
		var thisForm = this;
		var val1 = this.value1.value;
		this.value1.value = '';
		var target = 'index.php?/Workers/worker/test/'+val1;
		var request=$.post(target,'',function(data){
			$(thisForm).css('background','#808080');
			$(thisForm).nextAll('.workerOutput').html(data);
		});
		return false;
	});
	$('#worker1 button').click(function(){
		$(this).next().html('empty');
	});
</script>
