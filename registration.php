#!/usr/local/bin/php
<?php
	require_once 'password.php';
	$timezone = 'America/Los_Angeles';
	//SET default timezone for now.
	date_default_timezone_set($timezone);
	
	//open db for reading
	$db_name = "mylistmaker.db";
	
	try{     
		$db = new SQLite3($db_name);
	}
	catch (Exception $exception){
		echo '<p>There was an error connecting to the database!</p>';
		if ($db){echo $exception->getMessage();}
	}
	
	//ready table string
	$table = "logins";
	$field1 = "first";
	$field2 = "last";
	$field3 = "user";
	$field4 = "pass";
	$field5 = "time";
	
	//get form data
	$fn = $_POST["firstname"];
	$ln = $_POST["lastname"];
	$usr = $_POST["username"];
	$pw = $_POST["password"];
	
	//hash pw and store it
	$hashpw = password_hash($pw, PASSWORD_BCRYPT);
	$time = time();
	
	
	//read db to make enforce unique username	
	$stmt = $db->prepare("SELECT $field3 FROM $table WHERE $field3=?");
	$stmt->bindValue(1, $usr, SQLITE3_TEXT);
	$result = $stmt->execute();

	//fetchArray runs the execute statement again, but there is no harm because it is SELECT query
	if($result->fetchArray(SQLITE3_ASSOC)){
		//failed registration. user taken.
		print "false";
	}
	else{
		//write to database and output successful registration.
		$stmt = $db->prepare("INSERT INTO $table ($field1, $field2, $field3, $field4, $field5) VALUES(?,?,?,?,?)");
		$stmt->bindValue(1, $fn, SQLITE3_TEXT);
		$stmt->bindValue(2, $ln, SQLITE3_TEXT);
		$stmt->bindValue(3, $usr, SQLITE3_TEXT);
		$stmt->bindValue(4, $hashpw, SQLITE3_TEXT);
		$stmt->bindValue(5, $time, SQLITE3_INTEGER);
		$result = $stmt->execute();
		
		//create a user table for storing lists
		$stmt = $db->prepare("CREATE TABLE IF NOT EXISTS $usr (item varchar(100), link varchar(255), cost float(14,2))");
		$stmt->bindValue(1, $usr, SQLITE3_TEXT);
		$result = $stmt->execute();
			
		print "true";
	}
	