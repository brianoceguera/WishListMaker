#!/usr/local/bin/php
<?php
$server_sessions_directory = "";
session_save_path($server_sessions_directory);
session_start();
if($_SESSION["loggedin"] == false){
	header("Location: christmaslist.php");
	die();
}

$field = "";
$bind = "";
$item = $_GET["item"];
$link = $_GET["link"];

if(strlen($item) == 0){
	$field = "link";
	$bind = $link;
}
else{
	$field = "item";
	$bind = $item;
}

//open db for writing
$db_name = "mylistmaker.db";
	
try{     
	$db = new SQLite3($db_name);
}
catch (Exception $exception){
	echo '<p>There was an error connecting to the database!</p>';
	if ($db){echo $exception->getMessage();}
}

//ready table string
$table = $_SESSION["username"];

//write to database and output successful registration.
$stmt = $db->prepare("DELETE FROM $table WHERE $field=?");
$stmt->bindValue(1, $bind, SQLITE3_TEXT);
$result = $stmt->execute();

print "true";