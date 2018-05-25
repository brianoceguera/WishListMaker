#!/usr/local/bin/php
<?php
	//start session
	$server_sessions_directory = "";
	$timezone = 'America/Los_Angeles';
	session_save_path($server_sessions_directory);
	session_start();
	// Unset all of the session variables.
	$_SESSION = array();

	//from php reference, need to erase cookies
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Finally, destroy the session.
	//session_destroy();
	header("Location: christmaslist.php");
	die();
	