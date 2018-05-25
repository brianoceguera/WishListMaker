#!/usr/local/bin/php
<?php
	require_once 'password.php';
	$server_sessions_directory = "";
	$timezone = 'America/Los_Angeles';
	//SET default timezone for now.
	date_default_timezone_set($timezone);
	
	$usr = $_POST["username"];
	$pw = $_POST["password"];
	
	//open db for reading
	$db_name = "mylistmaker.db";
	
	try{     
		$db = new SQLite3($db_name);
	}
	catch (Exception $exception){
		echo '<p>There was an error connecting to the database!</p>';
		if ($db){echo $exception->getMessage();}
	}
	
	//Ready table string
	$table = "logins";
	$field3 = "user";
	$field4 = "pass";
	$field5 = "time";
	
	//prepare statements and bind to prevent SQL injection
	$stmt = $db->prepare("SELECT $field4 FROM $table WHERE $field3=?");
	$stmt->bindValue(1, $usr, SQLITE3_TEXT);
	$result = $stmt->execute();
	
	//if there is an entry found
	if($record = $result->fetchArray()){
		//get this password
		$dbpass = $record[0];
		//verify submitted password matches DB password
		$is_valid = password_verify($pw, $dbpass);
		
		if($is_valid){
			//login success, move to dashboard home
			$time = time();
			
			//read out last login time
			$stmt = $db->prepare("SELECT $field5 FROM $table WHERE $field3=?");
			$stmt->bindValue(1, $usr, SQLITE3_TEXT);
			$result = $stmt->execute();
			if($record = $result->fetchArray()){
				$lastlogin = $record[0];
			}
			//write new login time to database
			$stmt = $db->prepare("UPDATE $table SET $field5=? WHERE $field3=?");
			$stmt->bindValue(1, $time, SQLITE3_INTEGER);
			$stmt->bindValue(2, $usr, SQLITE3_TEXT);
			$result = $stmt->execute();
			
			//start up session variables. get last login from DB
			session_save_path($server_sessions_directory);
			session_start();
			$_SESSION["username"] = $usr;
			$_SESSION["loggedin"] = true;
			$_SESSION["time"] = $lastlogin;
			print "true";
		}
		else{
			print "false";
		}
	}
	
	else{
		print "false";
	}
	
	