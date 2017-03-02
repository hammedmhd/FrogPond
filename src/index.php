<?php
include 'functions.php';
session_name('FROG');
session_start();
//user login initialize
if(isset($_POST['user'])){
	$user = sanitizeString($_POST['user']);
	$pass = sanitizeString($_POST['pass']);
	$result = queryMysql("SELECT * FROM members WHERE Username='$user' AND Password='$pass'");

	if($result->num_rows !== 0){
		$loggedIn = true;
		$_SESSION['user'] = $user;
		$_SESSION['pass'] = $pass;
	}else{
		$loggedIn = false;
	}
}
//user logout
if(isset($_GET['logout'])){
	if(count($_SESSION) > 0){
		destroySession();
	}	
}
//new user
if(isset($_POST['usern'])){
	$currentuser = $_SESSION['user'];
	$currentpass = $_SESSION['pass'];
	$edituser = sanitizeString($_POST['usern']);
	$editpass = sanitizeString($_POST['passw']);

	$result = queryMysql("SELECT * FROM members WHERE Username='$currentuser' AND Password='$currentpass'");
	if($result->num_rows !== 0){
	$result = queryMysql("UPDATE members SET Username='$edituser', Password='$editpass' WHERE Username='$currentuser'");
	}

}

if(isset($_POST['newuser'])){ // registering new account.
	$user = $_POST['newuser'];
	$pass = $_POST['newpassw'];

	$result = queryMysql("INSERT INTO members VALUES('$user','$pass')");
	//$result = queryMysql("SELECT * FROM members WHERE Username='$user' AND Password='$pass'");
}
//deleting user account
if(isset($_POST['deleteuser'])){
	$result = queryMysql("DELETE FROM members WHERE Username='".$_SESSION['user']."'");
}

//LOGGED IN VIEW
if(isset($_SESSION['user'])){
	$user = $_SESSION['user'];
	$result = queryMysql("SELECT * FROM data WHERE gender='M'");
	$male = $num = $result->num_rows;
	$result = queryMysql("SELECT * FROM data WHERE gender='F'");
	$female = $num = $result->num_rows;
	echo "<!DOCTYPE html>
		<html>
			<title>Frog Pond</title>
			<head>
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, inital-scale=1.0'>
			<link rel='stylesheet' href='css/bootstrap.css?0.3'>
			<link rel='stylesheet' href='css/style.css?2.6'>
			<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
			<link rel='shortcut icon' href='img/mm.png' type='image/x-icon'>
			</head>
			<body>
			<script src='js/jquery-3.1.1.js'></script>
			<script src='js/bootstrap.min.js'></script>
			<nav class='navbar navbar-default'>
				<div class='navbar-header'>
					<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#dropmenu' aria-expanded='false'>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
					</button>
					<p class='navbar-brand'><a style='color:black' href='index.php'>Frog City</a></p>
				</div>
				<div class='collapse navbar-collapse' id='dropmenu'>
					<ul class='nav navbar-nav navbar-right'>
					<li><a style='font-size:14px'>M <span class='badge green'>$male</span></a></li>
					<li><a style='font-size:14px'>F <span class='badge deepPink'>$female</span></a></li>
					<li><a href='index.php?logout'>Sign Out</a></li>
					</ul>
				</div>
			</nav><br>
			<p class='alert-success note text-center' style='display:none; position:fixed; top:70px; width:100%; height:30px; transform:translate(0,-20px)'><span style='line-height:30px' id='interact'></span></p>
			<div id='userView' style='transform:translate(0,-60px)' class='col-xs-8 col-xs-offset-2'>
			<div class='page-header'>
				<i style='transform:translate(0,40px); color:green;cursor:pointer' class='fa fa-user-circle-o fa-2x' onclick='editUser()'></i>
				<i style='float:right; transform:translate(0,40px);color:green;cursor:pointer' class='fa fa-user-plus fa-2x' onclick='newUser()'></i>	
				<h4 class='text-center head'>".ucfirst($user)."'s area</h4>
			</div>
			<div id='deletePanel' class='panel panel-success' style='padding-bottom:15px; border-radius:10px;'>
  				<p class='panel-heading text-center'>Delete ".ucfirst($_SESSION['user'])." Account?</p> 
  				<div class='text-center'>
		  		<button style='min-width:80px' type='button' class='btn btn-lg btn-primary fa fa-check fa-2x' onclick='deleteUser()'></button>
		  		<button style='min-width:80px' type='button' class='btn btn-lg btn-primary fa fa-times fa-2x' onclick='editUser()'></button>
	  			</div>
  			</div>
			<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='newUser' class='text-center panel panel-success' method='post'>
			<p class='panel-heading'>New User</p>
  				<input style='width:30%' autofocus='on' class='text-center fixInput' type='text' id='newuser2' name='newuser' placeholder='Username'><br><br>
  				<input style='width:30%' class='fixInput text-center' type='password' id='newpass2' name='newpassw' placeholder='Password'><br><br>
  				<input type='submit' name='newUser' value='Add' class='btn btn-success' onclick='submitNewUser()'>
  			</form>
			<form autocomplete='off' style='padding-bottom:15px; border-radius:10px;' id='updateUserInfo' class='text-center panel panel-success' method='post'>
			<p class='panel-heading'><i style='cursor:pointer; float:left' class='fa fa-user-times fa-2x' onclick='DeletePanel()'></i>Edit Your Account</p>
  				<input style='width:30%' autofocus='on' class='fixInput text-center' type='text' id='usern' name='usern' placeholder='Update username'><br><br>
  				<input style='width:30%' class='fixInput text-center' type='password' id='passw' name='passw' placeholder='Update or Enter current password'><br><br>
  				<input type='submit' value='Update' class='btn btn-success' onclick='submitUserUpdate()'>
  			</form>
				<div class='label1 text-center'>
					<img id='myfrogs.php' style='width:110px; height:90px; cursor:pointer' src='img/fr.png' alt='Frog' onclick='loadPage(this.id)'>
					<br><p class='caption caption1' style='color:black;'><b>My Frogs</b></p>
				</div>
				<div class='label2 text-center col-sm-2 col-sm-push-2 col-md-2 col-md-push-3'>
					<img id='searchfrogs.php' style='width:110px; height:90px; cursor:pointer' src='img/pinkf.png' alt='Frog' onclick='loadPage(this.id)'>
					<br><p class='caption caption2' style='whitespace:nowrap; color:black;'><b>Search My Frogs</b></p>
				</div>
				<div class='label3 text-center col-sm-2 col-sm-push-5 col-md-2 col-md-push-5'>
					<img id='frogpond.php' style='width:110px; height:90px; cursor:pointer' src='img/goldf.png' alt='Frog' onclick='loadPage(this.id)'>
					<br><p class='caption caption3' style='color:black;'><b>Types of frogs</b></p>
				</div>
			</div>
			<script src='js/script.js?2.3'></script>
			</body>
		</html>";
}else{// LOGGED OUT VIEW
	echo "<!DOCTYPE html>
	<html>
		<title>
		Frog Pond
		</title>
		<head>
		<meta charset='utf-8'>
		<meta http-equiv='X-UA-Compatible' content='IE=edge'>
		<meta name='viewport' content='width=device-width, inital-scale=1.0'>
		<link rel='stylesheet' href='css/bootstrap.min.css'>
		<link rel='stylesheet' href='css/style.css?2.7'>
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
		<link rel='shortcut icon' href='img/mm.png' type='image/x-icon'>
		</head>
		<body>
		<script src='js/jquery-3.1.1.js'></script>
		<script src='js/bootstrap.min.js'></script> 
		<nav class='navbar navbar-default'>
				<div class='navbar-header'>
					<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#dropmenu' aria-expanded='false'>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
						<span class='icon-bar'></span>
					</button>
					<p class='navbar-brand'>Frog City</p>
				</div>
				<div class='collapse navbar-collapse' id='dropmenu'>
					<ul class='nav navbar-nav navbar-right'>
					<li style='padding:0' class='dropdown'>
						<i class='dropdown-toggle' data-toggle='dropdown' role='button'>Sign In</i>
						<div class='dropdown-menu login'>
						<form autocomplete='off' id='logmein' method='post' action='index.php'>
						<input autofocus='on' style='padding:6px 10px 6px 10px; width:200px; border-radius:3px; border:1px solid lightgrey' type='text' name='user' placeholder='Username'><br><br>
						<input style='padding:6px 10px 6px 10px; width:200px; border-radius:3px; border:1px solid lightgrey' type='password' name='pass' placeholder='Password'>
						<input type='submit' name='logIn' value='Sign In' style='margin-top:16px; float:right' class='btn btn-default submitlogin'>
						</form>
						</div>
					</ul>
				</div>
			</nav>
		</body>
	</html>";
}
?>