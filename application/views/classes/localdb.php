<?php
	$tableList = array('Characters','Inventory');
	$tableHtml = "";
	foreach($tableList as $t){
		$tableHtml .= "
			<div>
				<div>$t</div>
				<div></div>
				<div><button>Create</button></div>
				<div><button>Drop</button></div>
			</div>
		";
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
				border : 1px solid gray;
				background : #e0e0e0;
				border-radius : 20px;
				box-shadow : 3px 3px 3px black;
				padding : 10px;
			}
			#localDbTables > div:nth-child(1){
				margin-top : 10px;
			}
			#localDbTables > div:nth-child(1) > button{
				margin-left : 30px;
			}
			#localDbTables > div:nth-child(2) > div > div{
				width : 150px;
				height : 30px;
				float : left;
				margin-top : 10px;
			}
			#localDbTables > div:nth-child(2) > div{
				height : 50px;
				border : 1px solid gray;
				border-radius : 20px;
				box-shadow : 1px 1px 1px gray;
				padding-left : 20px;
				margin : 20px;
			}
			#error{margin-top: 20px;}
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
					$('#localDbTables > div:nth-child(1) > button:nth-child(1)').trigger('click');
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
						var tableStatus = 'Missing';
						obj.forEach(function(f){
							if(f == tableX){
								tableStatus = 'Active';
							}
						});
						if(tableStatus == 'Active'){
							$(e).css('background','lightGreen');
						}else{
							$(e).css('background','pink');
						}
						$(e).children(':nth-child(2)').html(tableStatus);
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
