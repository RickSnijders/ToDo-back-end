<?php
	require "db-connect.php";
	
	foreach ($_POST as $key => $value ) {
    	$_POST[$key] = htmlspecialchars($value);
	}


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
	
	
	$taskcount = $_POST["taskcount"];
    $id = $_SESSION["userId"];
	$name = $_POST["listName"];

	function checkName(){
		global $id, $name, $data;
		$conn = databaseConnection();
		$stmt = $conn->prepare("SELECT * FROM todolists WHERE name=:name AND userid=:id");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$data = $stmt->fetch();
		$conn = null;
		checkData();
		return $data;
	}
	
 	checkName();


	function checkData(){
		global $name, $_POST, $data;
		var_dump($data);
		if($name != $data["name"]){
			if(!empty($name)){
				for ($i=1; $i <= $_POST["taskcount"]; $i++) { 
					if(empty ($_POST["title".$i])){
						$_SESSION["error"] = "Please fill in all fields";
						header( "Location: maketodolist.php" );
						return;
					}
					if(empty ($_POST["description".$i])){
						$_SESSION["error"] = "Please fill in all fields";
						header( "Location: maketodolist.php" );
						return;
					}
				}
				addList();
			} else{
				// name is not filled
				$_SESSION["error"] = "Please fill in a name";
				header( "Location: maketodolist.php" );

				// echo "no name filled";
			}
		} else{
			// name already exists
			$_SESSION["error"] = "Name already exists";
			header( "Location: maketodolist.php" );
			// echo "name exists";
		}
		
	};
	


	
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
	};

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
	};


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
		header( "Location: todo.php" );
	};

?>