#!/usr/local/bin/php
<?php
	//if user came from login good.
	//otherwise, redirect to christmaslist.php
	$server_sessions_directory = "";
	$timezone = 'America/Los_Angeles';
	session_save_path($server_sessions_directory);
	session_start();
	if($_SESSION["loggedin"] == false){
		header("Location: christmaslist.php");
		die();
	}
	//SET default timezone for now.
	date_default_timezone_set($timezone);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/>
<title>My Christmas List - Dashboard</title>
<link rel="stylesheet" type="text/css" href="home.css" />
<script type="text/javascript" src="dash.js"></script>
</head>

<body onload="addListeners()">
<div id="welcome">
<div>
	<h2>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]);?>!</h2>
	<p>You last logged in: <?php echo date("F j, Y, g:i a T" , $_SESSION["time"]);?>.</p>
	<p>This free app allows you to create and manage a wishlist or purchase list.</p>
	<input type="button" class="submit" name="logout" value="Log Out" onclick="log_out()"/>
</div>
</div>

<div class="dashtable">
<h2>My List</h2>
<?php
	//open db to read in list
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
	$stmt = $db->prepare("SELECT * FROM $table");
	$result = $stmt->execute();
	
	//record exists
	if($result !=null){
		print "<table>" . PHP_EOL;
		print "<tr><th>Item</th><th>Cost</th><th></th></tr>" . PHP_EOL;
		while($record = $result->fetchArray()){
			//add a conditional to check if link field is empty
			if($record[$field2] !=null){
				//enforce an absolute url
				if(strpos($record[$field2], 'http') === FALSE){
					$link = 'http://' . $record[$field2];
					print '<tr><td class="titem">' . '<a target="_blank" href="' . $link . '">' . htmlspecialchars($record[$field1]) . '</a></td>';
				}
				else{
				print '<tr><td class="titem">' . '<a target="_blank" href="' . $record[$field2] . '">' . htmlspecialchars($record[$field1]) . '</a></td>';
				}
			}
			else{
				print '<tr><td class="titem">' . htmlspecialchars($record[$field1]) . '</td>';
			}
			
			if($record[$field3] > 0){
				print '<td class="tprice">' . '$' . $record[$field3] . '</td>';
			}
			else{
				print '<td class="tprice">' . '$' . '0' . '</td>';
			}
			print '<td><input type="button" class="del" value="Delete"/></td>';
			print '</tr>' . PHP_EOL;
		}
		print '</table>' . PHP_EOL;
	}
	
	else{
		//no records in DB
		print '<p id="emptytable">Your list is currently empty. Add items!</p>';
	}
?>
<form action="#" method="get">
	<input type="text" class="dashinput" name="itemname" placeholder="Item Name" required="required"/><br/>
	<input type="text" class="dashinput" name="itemlink" placeholder="Item Link"/><br/>
	<span id="dollar">$</span><input type="number" id="price" name="price" min="0" max="1e12" step="0.01" placeholder="Price"/><br/>
	<input type="button" class="submit" onclick="process_dash_form()" value="Submit"/>
</form>
</div>

</body>
</html>

	