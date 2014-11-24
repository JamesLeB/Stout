<?php
	# args = $objName, $tables

	$tableHtml = '';
	foreach($tables as $t){
		$name   = $t['name'];
		$status = $t['status'];
		$tableHtml .= "<div class='databaseTable'>";
		$tableHtml .= "<div>$name</div>";
		$tableHtml .= "<div>$status</div>";
		$tableHtml .= "<div><button>Create</button></div>";
		$tableHtml .= "<div><button>Delete</button></div>";
		$tableHtml .= "</div>";
	}
	$html = "
		<div id='$objName'>
			<div>Database Tables</div>
			$tableHtml
			<div class='debug'></div>
		</div>
	";
	$style = "
		<style>
		#$objName{
			background : lightgreen;
			border-radius : 10px;
			box-shadow : 2px 2px 2px gray;
			padding : 10px;
		}
		#$objName > div{
			margin : 10px;
		}
		#$objName > div.databaseTable{
			background : lightgray;
			border-radius : 10px;
			box-shadow : 2px 2px 2px gray;
		}
		#$objName > div > div{
			display : inline-block;
			padding : 5px;
			margin : 5px;
		}
		#$objName > div > div:nth-child(1){ width : 150px; }
		#$objName > div > div:nth-child(2){ width : 100px; }
		</style>
	";
	$script = "
		<script>
			$('#$objName button').click(function(){
				var n = $(this).first().html();
				var t = $(this).parent().parent().children().first().html();
				var parm = { table:t, action:n };
				$.post('index.php?/classes/characterSheet/create',parm,function(data){
					$('#$objName .debug').html(data);
				});
			});
		</script>
	";
	echo $html;
	echo $style;
	echo $script;
?>
