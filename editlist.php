<!DOCTYPE html>
<html>
<head>
	<title>Edit list</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<?php 
		require "db-connect.php";
		session_start();
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
		var_dump($list);
	?>
	<section class="col-10 mx-auto">
		<div class="bg-light">
			<h2 class="text-center"><?php echo $list["name"]; ?></h2>
			<h4 class="text-center">Task list</h4>
			<p class="font-weight-bold pl-4"><?php echo $details["title"]; ?></p>
			<p class="pl-4"><?php echo $details["description"]; ?></p>
			<form method="POST" action="">
				<label>Change title:</label>
				<input type="text" id="editList" name="newName" value="<?php echo $list["name"]; ?>">
				<input type="hidden" id="editListhidden" name="listid" value="<?php echo $_POST["listid"]; ?>">
				<input class="btn-warning btn p-1" type="submit" value="Save">
			</form>
		</div>
	</section>

	<?php
		function changeName() {
			$id = $_POST["listid"];
	    	if($_POST["newName"] == ""){
	    		echo "Please fill in the field";
	    	} else{
	    		$name = htmlspecialchars($_POST['newName']);
				$conn = databaseConnection();
				$stmt = $conn->prepare("UPDATE todolists
						SET name = :name
						WHERE listid= :id;");
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$conn = null;

	    	};	
		};

		if(isset($_POST['newName']))
		{
			getList();
	  		changeName();
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