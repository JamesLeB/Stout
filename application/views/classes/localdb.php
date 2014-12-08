<?php
	$tableList = array('Characters','Inventory');
	$tableHtml = "";
	foreach($tableList as $t){
		$tableHtml .= "<div>";
		$tableHtml .= "<div>$t</div>";
		$tableHtml .= "<div></div>";
		$tableHtml .= "<div><button>Create</button></div>";
		$tableHtml .= "<div><button>Drop</button></div>";
		$tableHtml .= "</div>";
	}
	$html = "
		<div id='localDbTables'>
			<div>
				<button>GO</button>
				<button>Test</button>
			</div>
			<div>$tableHtml</div>
		</div>
		<div id='error'></div>
	";
	$style = "
		<style>
			#localDbTables{
				border : 1px solid blue;
			}
			#localDbTables div{
				border : 1px dotted gray;
				margin : 10px;
			}
			#localDbTables > div:nth-child(2) > div{
				height : 50px;
			}
			#localDbTables > div:nth-child(2) > div > div{
				width : 150px;
				height : 30px;
				float : left;
			}
			#localDbTables > div:nth-child(2) > div{
				border : 1px solid red;
			}
		</style>
	";
	$script = "
		<script>
			$('#localDbTables > div:nth-child(2) button').click(function(){
				var target = 'index.php?/classes/database/';
				var func = '';
				var a = $(this).html();
				var t = $(this).parent().parent().children().first().html();
				var parm = {table: t};
				     if(a=='Create'){func = 'create';}
				else if(a=='Drop')  {func = 'drop';}
				$.post(target+func,parm,function(data){
					$('#error').html(data);
				});
			});
			$('#localDbTables > div:nth-child(1) > button:nth-child(1)').click(function(){
				var target = 'index.php?/classes/database/';
				var func = 'go';
				$.post(target+func,'',function(data){
					obj = $.parseJSON(data);
					$('#localDbTables > div:nth-child(2) > div').each(function(i,e){
						var tableX = $(e).children().first().html();
						var test = 'false';
						obj.forEach(function(e){
							if(e == tableX){test = 'true';}
						});
						$(e).children(':nth-child(2)').html(test);
					});
				});
			});
			$('#localDbTables > div:nth-child(1) > button:nth-child(2)').click(function(){
				var target = 'index.php?/classes/database/';
				var func = 'test';
				$.post(target+func,'',function(data){
					$('#error').html(data);
				});
			});
			$('#localDbTables > div:nth-child(1) > button:nth-child(1)').trigger('click');
		</script>
	";
	echo $html;
	echo $style;
	echo $script;
?>
