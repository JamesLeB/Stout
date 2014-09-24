<?php
	$index = 0;
	$ms = '';
	$ms .= "<div class='myList'>";
	foreach($myList as $item){
		$index++;
		$ms .= "<div class='myHeading'>";
		$ms .= "<button>$index</button>";
		$ms .= $item['Heading'];
		$ms .= "</div>";
		$ms .= "<div class='myBody'>";
		$ms .= $item['Body'];
		$ms .= "</div>";
	}
	$ms .= "</div>";
	echo $ms;
?>
<style>
	.myList{
		width : 95%;
		margin-left : auto;
		margin-right : auto;
	}
	.myHeading{
		padding : 5px;
		margin-top : 5px;
		background : #434343;
	}
	.myHeading button{
		margin-right : 10px;
	}
	.myBody{
		background : #343434;
		margin-left : 50px;
		margin-bottom : 20px;
		padding : 5px;
	}
</style>
<script>
	$('.myBody').hide();
	$('.myHeading button').click(function(){
		$(this).parent().next().toggle();
	});
</script>
