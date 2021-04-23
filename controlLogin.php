<?php
	session_start();
	require "db-connect.php";
	$email = $_POST["email"];
	$password = $_POST["password"];
	$_SESSION["isLoggedIn"] = false;

	echo $email."\n";
	echo $password;
	var_dump($password);

	// checks if all fields are filled
	if (isset($_POST["email"]) && isset($_POST["password"])) {
		if (empty ($email)) {
        	echo "Vul een email in <br />";
        	$_SESSION["loginError"] = "Fill in an email";
        	header( "Location: login.php" );
    	}
    	if (empty ($password)) {
        	echo "Vul een wachtwoord in <br />";
        	$_SESSION["loginError"] = "Fill in a password";
        	header( "Location: login.php" );
    	} 
    	if (empty ($password) && empty ($email)) {
        	$_SESSION["loginError"] = "Fill in an email and password";
        	header( "Location: login.php" );
    	} 

    	else{
    		echo "\nName and Password are filled\n";
			getDetails();
    	}
		
	} else {
		echo "Fill in both fields";
	};
	
	// var_dump($email);
	// var_dump($email);
	// var_dump($password);

	// Gets the details from the chosen email from the database
	function getDetails(){
		global $email, $password, $user;
		$conn = databaseConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch();
		$conn = null;
		echo "excecuted ";
		checkDetails();
		return $user;
	}

	// Checks if the password is correct
	function checkDetails(){
		global $user;
		var_dump($user);
		if( $_POST["password"] == $user["password"]){
			echo "inloggen gelukt";
			$_SESSION["isLoggedIn"] = true;
			$_SESSION["userId"] = $user["id"];
			header( "Location: todo.php" );
		} else{
			echo "inloggen mislukt";
			$_SESSION["loginError"] = "Wrong credentials";
        	header( "Location: login.php" );
		}
	}

	
?>