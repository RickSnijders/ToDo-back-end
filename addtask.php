<?php 
	session_start();
		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}
	require "db-connect.php";
	
	// Get list information from database
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

	// Adds a task to the chosen list in the database
	function addTask() {
		foreach ($_POST as $key => $value ) {
			$_POST[$key] = htmlspecialchars($value);
		}
		$id = $_POST["listid"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("INSERT INTO tasks (todolistid, title, description, duration)
		VALUES (:id, :title, :description, :duration);");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':description', $_POST["description"]);
		$stmt->bindParam(':title', $_POST["title"]);
		$stmt->bindParam(':duration', $_POST["duration"]);
		$stmt->execute();
		$conn = null;
	    	
	};

	// Checks if all data is filled
	function checkData(){
		if (!isset($_POST['title'])) {
				if(!isset($_POST['description'])){
					echo "<div class='col-6 mx-auto text-center m-1 text-danger'>";
					echo "Please fill in all fields";
					echo "</div>";
				}
			}else if(isset($_POST['description']) && isset($_POST['title']) && isset($_POST['duration']) ){
				if (!empty($_POST['title'])) {
					if(!empty($_POST['description'])){
						if(!empty($_POST['duration']) && is_numeric($_POST["duration"])){
							getList();
	  						addTask();
	  						header( "Location: todo.php" );
	  					}else{
							echo "<div class='col-6 mx-auto text-center m-1 text-danger'>";
							echo "Please fill in all fields";
							echo "</div>";
						}
					}	else{
						echo "<div class='col-6 mx-auto text-center m-1 text-danger'>";
						echo "Please fill in all fields";
						echo "</div>";
					}
				} else{
					echo "<div class='col-6 mx-auto text-center m-1 text-danger'>";
					echo "Please fill in all fields";
					echo "</div>";
				}
				
			}

			else{
				echo "<div class='col-6 mx-auto text-center m-1'>";
				echo "An error has occurred";
				echo "<a class='btn btn-primary ml-1 p-1' href='todo.php'>Go back</a>";
				echo "</div>";
			}


	}

	// var_dump($list);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

	<section class="col-10 mx-auto">
		<div class="bg-light">
			<h1>Add task to '<?php echo $list["name"]; ?>'</h1>
			<form method="POST" action="">
				<input type="hidden" id="deleteListhidden" name="listid" value="<?php echo $_POST["listid"]; ?>">
			  	<div class="form-group">
			    	<label for="title">Title</label>
			    	<input type="text" class="form-control" name="title" placeholder="Title">
			  	</div>
			  	<div class="form-group">
			   		<label for="description">Description</label>
			    	<textarea class="form-control" name="description" rows="3"></textarea>
			  	</div>
			  	<div class="form-group">
			    	<label for="duration">Duration</label>
			    	<input type="number" class="form-control" name="duration" placeholder="Duration">
			  	</div>
				<input class="btn-success btn p-1" type="submit" value="Add task">
			</form>
		</div>
	</section>

	<?php	
		if ($_SESSION["formcheck"] == true){
			checkData();
		}
		$_SESSION["formcheck"] = true;
	?>

</body>
</html>