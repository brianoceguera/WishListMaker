#!/usr/local/bin/php
<?php
	//checkusr.php
	
	$attempt = $_GET["username"];
	
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
	
	//prepare statements and bind to prevent SQL injection
	$stmt = $db->prepare("SELECT $field3 FROM $table WHERE $field3=?");
	$stmt->bindValue(1, $attempt, SQLITE3_TEXT);
	$result = $stmt->execute();

	
	//user taken
	if($result->fetchArray(SQLITE3_ASSOC)){
		print "false";
	}
	else{
		print "true";
	}
