<?php
	var_dump($_POST);
	require "db-connect.php";
	function changeStatus(){
		$id = $_POST["taskid"];
		$status = $_POST["status"];
		$conn = databaseConnection();
		$stmt = $conn->prepare("UPDATE tasks
				SET status = :status
				WHERE taskid=:id;");
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$conn = null;
		header( "Location: todo.php" );
	}
	changeStatus();
	

?>