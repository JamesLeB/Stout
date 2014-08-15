<style>
	#view {
		border : 1px solid blue;
		width : 400px;
	}
	#debug {
		border : 1px solid red;
		width : 400px;
		height : 400px;
	}
</style>
<div id='view'>
	<div>From View</div>
	<a href="user_guide/">User Guide</a>.</p>
</div>
<button onclick='create()'>Create tables</button>
<button onclick='drop()'>Drop tables</button>
<div id='debug'></div>
<script>
	function create(){
		document.getElementById('debug').innerHTML = 'creatething';
	}
	function drop(){
		document.getElementById('debug').innerHTML = 'dropthing';
	}
</script>
