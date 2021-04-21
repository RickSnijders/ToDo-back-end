<?php 
	require "db-connect.php";
	session_start();
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
	var_dump($list);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<section class="col-10 mx-auto">
		<div class="bg-light">
			<h2 class="text-center">List: </h2>
			<h4 class="text-center">Task: </h4>
			<form method="POST" action="">
				<input type="hidden" id="deleteListhidden" name="taskid" value="<?php echo $_POST["taskid"]; ?>">
			  	<div class="form-group">
			    	<label for="title">Title</label>
			    	<input type="text" class="form-control" name="title" value="<?php echo $task["title"] ?>" placeholder="Title">
			  	</div>
			  	<div class="form-group">
			   		<label for="description">Description</label>
			    	<textarea class="form-control" name="description" rows="3"><?php echo $task["description"] ?></textarea>
			  	</div>
				<input class="btn-success btn p-1" type="submit" value="Add task">
			</form>
		</div>
	</section>

	<?php
		function editTask() {
			$id = $_POST["taskid"];
	    	if($_POST["title"] == "" || $_POST["description"] == ""){
	    		echo "Please fill in the field";
	    	} else{
	    		$title = htmlspecialchars($_POST['title']);
	    		$description = htmlspecialchars($_POST['description']);
				$conn = databaseConnection();
				$stmt = $conn->prepare("UPDATE tasks
						SET title = :title, description = :description
						WHERE taskid= :id;");
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':description', $description);
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$conn = null;
				header( "Location: todo.php" );
	    	};	
		};

		if(isset($_POST['title']))
		{
			editTask();
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