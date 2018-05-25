#!/usr/local/bin/php
<?php
$server_sessions_directory = "";
session_save_path($server_sessions_directory);
session_start();
if($_SESSION["loggedin"] == false){
	header("Location: christmaslist.php");
	die();
}

$item_name = $_GET["item"];
$item_link = $_GET["link"];
$item_price = (float)$_GET["price"];

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
$field1 = "item";
$field2 = "link";
$field3 = "cost";

//write to database and output successful registration.
$stmt = $db->prepare("INSERT INTO $table ($field1, $field2, $field3) VALUES(?,?,?)");
$stmt->bindValue(1, $item_name, SQLITE3_TEXT);
$stmt->bindValue(2, $item_link, SQLITE3_TEXT);
$stmt->bindValue(3, $item_price, SQLITE3_FLOAT);
$result = $stmt->execute();

print "true";