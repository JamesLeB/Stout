<?php session_start(); ?>
<html>
<head>
	<title>Login</title>
	<style>
		#login{
			height : 270px;
			width  : 350px;
			margin-left  : auto;
			margin-right : auto;
			margin-top   : 50px;
			box-shadow : 5px 5px 7px black;
			border : 1px solid black;
			border-radius : 20px;
			background : #F0F0F0;
			padding-top : 20px;
			font-size : 20px;
		}
		#login div{
			margin : 20px;
			height : 30px;
		}
		#login div *{
			position : relative;
			left : 20px;
		}
		#login div span{
			display : inline-block;
			width : 85px;
		}
		#login div input{
			font-size : 18px;
			height : 30px;
			top : -2px;
		}
		#login div input[type='textbox']{
			width : 170px;
		}
		#login div input[type='password']{
			width : 170px;
		}
		#login div input[type='submit']{
			background : blue;
			color : white;
			width : 100px;
			top : 10px;
			left : 100px;
			padding-left : 5px;
		}
		#login div:nth-child(1) span{
			left : 120px;
			font-size : 24;
		}
		#login div:nth-child(5){
			color : red;
			padding-left : 20px;
			padding-top : 10px;
		}
	</style>
</head>
<body>
	<form method="post" action="validateUser.php">
		<div id='login'>
			<div>
				<span>Login</span>
			</div>
			<div>
				<span>User</span>
				<input type='textbox' maxlength='16' name='user'/>
			</div>
			<div>
				<span>Password</span>
				<input type='password' maxlength='16' name='pass'/>
			</div>
			<div>
				<input type='submit' />
			</div>
			<div>
				<?php #echo $_SESSION['mess']; ?>
			</div>
		</div>
	</form>
</body>
</html>
