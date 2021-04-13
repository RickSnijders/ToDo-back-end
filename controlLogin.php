<?php

	require "db-connect.php";
	$email = $_POST["email"];
	$password = $_POST["password"];


	echo $email."\n";
	echo $password;

	if (isset($_POST["email"]) && isset($_POST["password"])) {
		if (empty ($email)) {
        echo "Vul een email in <br />";
    	}
    	if (empty ($password)) {
        echo "Vul een wachtwoord in <br />";
    	} else{
    		echo "\nName and Password are filled\n";
			getDetails();
    	}
		
	} else {
		echo "Fill in both fields";
	};
	
	// var_dump($email);
	// var_dump($email);
	// var_dump($password);

	function getDetails(){
		global $email, $password, $user;
		$conn = databaseConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch();
		$conn = null;
		echo "excecuted ";
		return $user;
	}

	checkDetails();
	function checkDetails(){
		global $user;
		var_dump($user);
		if( $_POST["password"] == $user["password"]){
			echo "inloggen gelukt";
		} else{
			echo "inloggen mislukt";
		}
	}

	
?>