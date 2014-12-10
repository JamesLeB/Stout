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
			$('#tabs').tabs({active:2});
			$('#juniorTasks > div:nth-child(1) > button').click(function(){
				var action = $(this).first().html();
				if(action == 'Clear'){
					$('#juniorTasks > div:nth-child(2) > div').html('');
					$('#juniorTasks > div:nth-child(3) > div').html('');
				}else if(action == 'Two'){
					$('#juniorTasks').css('background','lightgray');
					var target = 'index.php?/junior/';
					var func = 'getFtpBatchList';
					var request = $.post(target+func,parm,function(data){
						var obj = $.parseJSON(data);
						var html = '<div>';
						obj.forEach(function(e){
							var test = e.match(/\./);
							if(test){html += '<div>'+e+'</div>';}
						});
						html += '</div>';
						$('#juniorTasks').css('background','white');
						$('#juniorTasks > div:nth-child(3) > div').html(html);
						$('#juniorTasks > div:nth-child(3) > div > div > div').unbind('mouseover');
						$('#juniorTasks > div:nth-child(3) > div > div > div').unbind('mouseout');
						$('#juniorTasks > div:nth-child(3) > div > div > div').unbind('click');
						$('#juniorTasks > div:nth-child(3) > div > div > div').mouseover(function(){
							$(this).css({'background':'blue','color':'white'});
						});
						$('#juniorTasks > div:nth-child(3) > div > div > div').mouseout(function(){
							$(this).css({'background':'white','color':'black'});
						});
						$('#juniorTasks > div:nth-child(3) > div > div > div').click(function(){
							alert('here we go');
						});
					});
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
			});// END Button click function
			$('#juniorTasks > div:nth-child(1) > button:nth-child(2)').trigger('click');
			$('#juniorTasks > div:nth-child(2)').hide();
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
			height : 500px;
			margin : 20px;
		}
		#juniorTasks div{
			/*
			border : 1px gray dashed;
			*/
		}
		#juniorTasks > div{
			height : 300px;
			float : left;
			margin-top : 40px;
		}
		#juniorTasks > div:nth-child(1){
			width : 120px;
			margin-left : 50px;
		}
		#juniorTasks > div:nth-child(1) > button{
			width : 100px;
			margin-bottom : 15px;
			margin-left : 10px;
		}
		#juniorTasks > div:nth-child(1) > button:nth-child(1){
			margin-top : 30px;
		}
		#juniorTasks > div:nth-child(2) > span{
			padding-left : 60px;
		}
		#juniorTasks > div:nth-child(2) > div{
			width : 400px;
			height : 200px;
			margin-left : 10px;
			border : 2px inset gray;
			background : white;
			padding : 10px;
			overflow : auto;
		}
		#juniorTasks > div:nth-child(3) > span{
			padding-left : 60px;
		}
		#juniorTasks > div:nth-child(3) > div{
			width : 300px;
			height : 200px;
			margin-left : 20px;
			border : 2px inset gray;
			background : white;
			padding : 10px;
		}
		#juniorTasks > div:nth-child(3) > div > div > div{
			width : 200px;
			margin-bottom : 5px;
			padding : 2px;
		}
		li{
			margin-top : 10px;
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
					<li><a href='#tab1'>Tasks</a></li>
					<li><a href='#tab2'>ToDo</a></li>
					<li><a href='#tab3'>DEV</a></li>
				</ul>
				<div id='tab1'>
<!-- START Junior page 1 -->
					<div id='juniorTasks'>
						<div>
							<button>One</button>
							<button>Two</button>
							<button>Clear</button>
						</div>
						<div><span>Name</span><div></div></div>
						<div><span>File List</span><div></div></div>
					</div>
<!-- END Junior page 1 -->
				</div>
				<div id='tab2'>
					<h3>Stuff to do</h3>
					<ul>
						<li>Move axium batch sheet to google drive</li>
						<li>Develop function to move selected file</li>
						<li>Develop function to convert select file</li>
						<li>Develop function to move file to ftp server</li>
						<li></li>
					</ul>
				</div>
<!-- Start Dev CSS --!>
<style>
	#juniorBiller{
		background : lightgray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		height : 600px;
		position : relative;
	}
	#juniorBiller > div{
		width : 250px;
		position : absolute;
	}
	#juniorBiller > div:nth-child(1){ top : 20px; left :  50px;}
	#juniorBiller > div:nth-child(2){ top : 20px; left : 350px;}
	#juniorBiller > div:nth-child(3){ top : 20px; left : 650px;}
	#juniorBiller > div:nth-child(4){ top : 20px; left : 950px;}
	#juniorBiller > div > div:nth-child(1){
		font-size : 120%;
		width : 300px;
		margin-left : 20px;
		margin-bottom : 5px;
	}
</style>
<!-- End Dev CSS --!>
				<div id='tab3'>
<!-- Start Dev Html--!>
					<div id='juniorBiller'>
						<div>
							<div>Batch</div>
							<div></div>
						</div>
						<div>
							<div>To Process</div>
							<div></div>
						</div>
						<div>
							<div>Processed</div>
							<div></div>
						</div>
						<div>
							<div>To Send</div>
							<div></div>
						</div>
					</div>
<!-- End Dev Html--!>
				</div>
<!-- Start Dev --!>
<script>
	var target = 'index.php?/junior/';
	var func = 'go';
	$.post(target+func,'',function(data){
		var obj = $.parseJSON(data);
		$('#juniorBiller > div:nth-child(1) > div:nth-child(2)').html(obj[0]);
		$('#juniorBiller > div:nth-child(2) > div:nth-child(2)').html(obj[1]);
		$('#juniorBiller > div:nth-child(3) > div:nth-child(2)').html(obj[2]);
		$('#juniorBiller > div:nth-child(4) > div:nth-child(2)').html(obj[3]);
	});
</script>
<!-- End Dev --!>
			</div>
		</div>
		<div>
			<span>Footer</span>
		</div>
	</div>
</body>
<html>
