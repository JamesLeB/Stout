<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<script src='js/jquery-1.11.1.js'></script>
	<script src='js/jquery-ui-1.11.2.custom/jquery-ui.js'></script>
	<link  href='js/jquery-ui-1.11.2.custom/jquery-ui.css' rel='stylesheet'/>
	<script>
		$(document).ready(function(){
			//alert('Document Ready');
			$('#logout').click(function(){
				$.post('index.php?/stout/logout','',function(data){
					window.location.href = "index.php";
				});
			});
			$('#tabs').tabs();
			$('#juniorTasks > div:nth-child(1) > button').click(function(){
				var action = $(this).first().html();
				if(action == 'Clear'){
					$('#juniorTasks > div:nth-child(2)').html('');
				}else{
					$('#juniorTasks').css('background','lightgray');
					var target = 'index.php?/junior/';
					var func = 'action';
					var parm = {message: action};
					var request = $.post(target+func,parm,function(data){
						$('#juniorTasks').css('background','white');
						$('#juniorTasks > div:nth-child(2)').html(data);
					});
				}
			});
		});
	</script>
	<style>
/*
		div{
			border : dashed 1px gray;
			margin : 5px;
		}
*/
		#wrapper{
			border : 1px solid green;
			background : white;
			padding : 5px;
			width : 95%;
			margin-left : auto;
			margin-right : auto;
		}
		#wrapper div:nth-child(1) > img{
			/* Incon size */
			height :50px;
		}
		#logout{
			float : right;
			margin-right : 20px;
		}
		#logout img{
			height : 40px;
		}
		#screen{
			position : fixed;
			margin : 0px;
			top : 0;
			left : 0;
			width : 100%;
			height : 100%;
			z-index : -1;
			background : gray;
		}
		#juniorTasks{
			border : 1px solid gray;
			border-radius : 20px;
			box-shadow : 3px 3px 3px black;
			height : 300px;
			margin : 20px;
		}
		#juniorTasks > div{
			height : 200px;
			float : left;
			margin-top : 40px;
		}
		#juniorTasks > div:nth-child(1){
			width : 120px;
			margin-left : 100px;
			padding-top : 20px;
		}
		#juniorTasks > div:nth-child(2){
			width : 500px;
			margin-left : 10px;
			border : 2px inset gray;
			background : white;
			padding : 10px;
		}
		#juniorTasks > div:nth-child(1) > button{
			width : 100px;
			margin-bottom : 15px;
		}
	</style>
</head>
<body>
	<div id='screen'></div>
	<div id='wrapper'>
		<div>
			<img src='lib/images/nyu.jpg'>
			<button id='logout'><img src='lib/images/exit.png'></button>
		</div>
		<div>
			<div id='tabs'>
				<ul>
					<li><a href='#tab1'>One</a></li>
					<li><a href='#tab2'>Two</a></li>
					<li><a href='#tab3'>Three</a></li>
				</ul>
				<div id='tab1'>
<!-- START Junior page 1 -->
					<div id='juniorTasks'>
						<div>
							<button>One</button>
							<button>Two</button>
							<button>Clear</button>
						</div>
						<div></div>
					</div>
<!-- END Junior page 1 -->
				</div>
				<div id='tab2'>
					Second
				</div>
				<div id='tab3'>
					Third
				</div>
			</div>
		</div>
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
<html>
