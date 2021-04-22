<?php
// checks if you're logged in
session_start();
	if($_SESSION["isLoggedIn"] == true){
		echo "logged in ";
	} else{
		header( "Location: login.php" );
	}

	$taskNumber = 1;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Make A To Do</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body onload="addTask()">

	<h1 class="text-center">Make a To Do list</h1>
	<form id="form" class="col-6 mx-auto" action="addtodolist.php" method="POST">
		<input class="btn btn-success float-right" type="submit" name="submit" value="Submit">
		<div class="form-group">
			<div class="text-danger"><?php echo $_SESSION["error"];?></div>
		    <h3 for="listName">List Name</h3>
		    <input type="text" class="form-control" name="listName" placeholder="Name">
		</div>
		<p class="btn btn-primary float-right" onclick="addTask()">+ New task</p>
		<input type="hidden" id="count" name="taskcount" value="1">
	</form>

	<script src="script.js"></script>
</body>



</html>