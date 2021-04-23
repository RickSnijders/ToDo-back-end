<?php 
	require "db-connect.php";
	session_start();

		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}

	// Gets the information of the list from the database
	function getList(){
			global $list;
			$id = $_POST["listid"];
			$conn = databaseConnection();
			$stmt = $conn->prepare("SELECT * FROM todolists WHERE listid=:listid");
			$stmt->bindParam(':listid', $id);
			$stmt->execute();
			$list = $stmt->fetch();
			$conn = null;
			return $list;
		};
	getList();
	// var_dump($list);

	// Deletes the chosen list from the database
	function deleteList() {
		$id = $_POST["listid"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("DELETE FROM todolists WHERE listid = :id;");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$conn = null;
		deleteTasks();
	    	
	}

	// Deletes all the tasks of the chosen list from the database
	function deleteTasks(){
		$id = $_POST["listid"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("DELETE FROM tasks WHERE todolistid = :id;");
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
			<h1 class="text-center mt-3">Are you sure you want to delete the <?php echo $list["name"]; ?> list</h1>
			<div class=" col-12 row justify-content-center">
				<form method="POST" action="">
					<input type="hidden" id="deleteListhidden" name="listid" value="<?php echo $_POST["listid"]; ?>">
					<input type="hidden" id="deleteList" name="deletelist" value="true">
					<input class="btn-success btn pl-4 pr-4 p-2 m-2" type="submit" value="Yes">
				</form>
				<a  href="todo.php" class="btn btn-danger pl-4 pr-4 p-2 m-2">No</a>
			</div>
		</div>
	</section>

	<?php


		

		if(isset($_POST['deletelist']))
		{
			getList();
	  		deleteList();
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