#!/usr/local/bin/php
<?php
	//if already logged in, redirect to dashboard.
	$server_sessions_directory = "";
	$timezone = 'America/Los_Angeles';
	session_save_path($server_sessions_directory);
	session_start();
	if($_SESSION["loggedin"] == true){
		header("Location: dashboard.php");
		die();
	}
	date_default_timezone_set($timezone);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/>
<title>My Christmas List - Login</title>
<link rel="stylesheet" type="text/css" href="home.css" />
<script type="text/javascript" src="jshome.js"></script>
</head>

<body onload="formvalid()">
<div class="container">
<div id="welcome">
	<h2>Welcome to My List Maker!</h2>
	<p>This free app allows you to create and manage a wishlist or purchase list.</p>
	<p>Login to manage your list, or create a new account.</p>
</div>

<div class="flex">
<div class="login">
<form action="#" method="post">
  <h2>Login</h2>
  <input type="text" class="usr"  name="username" placeholder="Username" pattern=".{2,}" maxlength="20" required="required"/><br/>
  <span id="logusr" aria-live="polite">Username must be 2 to 20 characters long.</span>
  <input type="password" class="pw" name="password" placeholder="Password" pattern=".{6,}" required="required"/><br/>
  <span id="logpw" aria-live="polite">Password must be at least 6 characters long.</span>
  <input type="button" class="submit" value="Submit" onclick="process_log_form()"/><br/>
  <span id="logfail" aria-live="polite">Username or password incorrect.</span>
</form>
</div>

<div class="register">
<form action="#" method="post">
  <h2>Register</h2>
  <input type="text" id="fname" name="firstname" placeholder="First Name" pattern=".{1,}" maxlength="20" required="required" /><br/>
  <span id="regfn" aria-live="polite">Do not leave this field blank.</span>
  <input type="text" id="lname" name="lastname" placeholder="Last Name" pattern=".{1,}" maxlength="20" required="required"/><br/>
  <span id="regln" aria-live="polite">Do not leave this field blank.</span>
  <input type="text" class="usr" name="username" placeholder="Username" pattern=".{2,20}" maxlength="20" required="required"/><br/>
  <span id="regusr" aria-live="polite">Username must be 2 to 20 characters long.</span>
  <span id="usrtaken" aria-live="polite">Username is taken.</span>
  <input type="password" class="pw" name="password" placeholder="Password" pattern=".{6,}" required="required"/><br/>
  <span id="regpw" aria-live="polite">Password must be at least 6 characters long.</span>
  <input type="button" class="submit" value="Submit" onclick="process_reg_form()"/><br/>
  <span id="success" aria-live="polite">Registration successful!</span>
  <span id="fail" aria-live="polite">Registration failed.</span>
</form>
</div>
</div>
</div>
</body>
</html>
