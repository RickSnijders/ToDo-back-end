<?php 
	require "db-connect.php";
	session_start();

		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}

	function getTask(){
		global $task;
		$id = $_POST["taskid"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("SELECT * FROM tasks WHERE taskid=:taskid");
		$stmt->bindParam(':taskid', $id);
		$stmt->execute();
		$task = $stmt->fetch();
		$conn = null;
		return $task;
	};
	getTask();
	// var_dump($list);
	
	function deleteTask(){
		$id = $_POST["taskid"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("DELETE FROM tasks WHERE taskid = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$conn = null;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete list</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<section class="col-10 mx-auto">
		<div class="bg-light">
			<h1 class="text-center mt-3">Are you sure you want to delete the <?php echo $task["title"]; ?> task</h1>
			<p>Description: <?php echo $task["description"]; ?></p>
			<div class=" col-12 row justify-content-center">
				<form method="POST" action="">
					<input type="hidden" id="deleteTaskhidden" name="taskid" value="<?php echo $_POST["taskid"]; ?>">
					<input type="hidden" id="deleteTask" name="deletetask" value="true">
					<input class="btn-success btn pl-4 pr-4 p-2 m-2" type="submit" value="Yes">
				</form>
				<a  href="todo.php" class="btn btn-danger pl-4 pr-4 p-2 m-2">No</a>
			</div>
		</div>
	</section>

	<?php





		if(isset($_POST['deletetask']))
		{
			getTask();
	  		deleteTask();
	  		header( "Location: todo.php" );
		} else{
			if ($_SESSION["formcheck"] == true){
				echo "<div class='col-6 mx-auto text-center m-1'>";
				echo "An error has occurred";
				echo "<a class='btn btn-primary ml-1 p-1' href='todo.php'>Go back</a>";
				echo "</div>";
			}
				
		}
		$_SESSION["formcheck"] = true;

	?>

</body>
</html>