<div id='sheet'>
	<div>
		<div>Name</div>
		<div>Race</div>
		<div>Class</div>
	</div>
	<div>
		<div>
			Str
		</div>
		<div>
			Dex
		</div>
		<div>
			Con
		</div>
		<div>
			Int
		</div>
		<div>
			Wis
		</div>
		<div>
			Cha
		</div>
	</div>
</div>
<style>
	#sheet
	{
		border : 1px solid gray;
	}
	#sheet div
	{
		border : 1px dotted gray;
		margin : 5px;
	}
	#sheet > div
	{
		border : 1px solid gray;
		margin : 10px;
		border-radius : 20px;
		padding : 10px;
		box-shadow : 2px 2px 2px black;
	}
	#sheet > div:nth-child(1)
	{
		width : 200px;
	}
	#sheet > div:nth-child(2)
	{
		width : 300px;
	}
</style>
