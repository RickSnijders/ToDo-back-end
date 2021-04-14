<?php
	require "db-connect.php";
	var_dump($_POST);
		
	echo $_POST["taskcount"];

	echo "list id =  ".$list["listid"];


	// checks if you're logged in
	session_start();
		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}

		var_dump($_SESSION["isLoggedIn"]);
	
		// checks if all fields are filled
	for ($i=1; $i <= $_POST["taskcount"]; $i++) { 
		if(empty ($_POST["title".$i])){
			echo "dit is een test ";
			header( "Location: maketodolist.php" );
		} 
		if(empty ($_POST["description".$i])){
			echo "dit is een test ";
			header( "Location: maketodolist.php" );
		} 
	}
	
	$taskcount = $_POST["taskcount"];
    $id = $_SESSION["userId"];
	$name = $_POST["listName"];


	addList();

	// adds the new list in the database
	function addList(){
		global $id, $name;
		$conn = databaseConnection();
		$stmt = $conn->prepare("INSERT INTO todolists (userid, name)
		VALUES (:userid, :name);");
		$stmt->bindParam(':userid', $id);
		$stmt->bindParam(':name', $name);
		$stmt->execute();
		$conn = null;
		getListid();
	}

	// Gets the id from the list that got inserted
	function getListid(){
		global $id, $name, $list;
		$conn = databaseConnection();
		$stmt = $conn->prepare("SELECT * FROM todolists WHERE name=:name AND userid=:id");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$list = $stmt->fetch();
		$conn = null;
		addTasks();
		return $list;
	}


	// adds the tasks to the database
	function addTasks(){
		global $taskcount, $list, $_POST;
		$listid = $list["listid"];
		for ($i=1; $i <= $taskcount ; $i++) { 
			$title = $_POST["title".$i];
			$description = $_POST["description".$i];

			$conn = databaseConnection();
			$stmt = $conn->prepare("INSERT INTO tasks (todolistid, title, description)
			VALUES (:listid, :title, :description);");
			$stmt->bindParam(':listid', $listid);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':description', $description);
			$stmt->execute();
			$conn = null;
		}

	}

?>