<?php
	require "db-connect.php";
	// checks if you're logged in
	session_start();
		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}

		$_SESSION["error"] = "";
		$_SESSION["formcheck"] = false;
		// var_dump($_SESSION["isLoggedIn"]);

		// Get all lists from database
		function getLists(){
			global $lists;
			$conn = databaseConnection();
			$stmt = $conn->prepare("SELECT * FROM todolists");
			$stmt->execute();
			$lists = $stmt->fetchall();
			$conn = null;
			return $lists;
		};
		getLists();

		// Get all tasks from database
		function getTasks($id){
			global $info;
			$conn = databaseConnection();
			$stmt = $conn->prepare("SELECT * FROM tasks WHERE todolistid=:todolistid");
			$stmt->bindParam(':todolistid', $id);
			$stmt->execute();
			$info = $stmt->fetchall();
			$conn = null;
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title>To Do</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	
</head>
<body class="col-12">
	<div class="bg-light">
		<h1 class="ml-4">To Do List</h1>
		<a class="btn btn-secondary d-block mx-auto float-right" href="maketodolist.php">+ Add To do</a>
		<h2 class="ml-4">Task Lists</h2>
	</div>
		<div class='wrapper1 m-0'>    
			<div class='content mb-2'> 
			<?php
				
				// var_dump($lists);
				// foreach (array_combine($lists, $details) as $list => $detail){


				foreach ($lists as $list){ 
						getTasks($list["listid"]);
						?>

					<section class="col-3">
						<div class="bg-light">
							<h2 class="text-center"><?php echo $list["name"]; ?></h2>
							<h4 class="text-center">Task list</h4>
							<form class=" col-12 row">
								<select name="filter" class="p-1">
									<option value="duration">Duration</option>
									<option value="status">Status</option>
								</select>
								<input class="btn-primary btn p-1" type="submit" value="Filter">
							</form>
							<div class="taskcontainer">
								<?php foreach ($info as $details){  ?>
						
								<?php  
									if($details["status"] == "red"){
										echo '<section id="taskbox" class="bg-white m-1 borderleft taskbox redborder">';
										
	        						} else if ($details["status"] == "green"){
										echo '<section id="taskbox" class="bg-white m-1 borderleft taskbox greenborder">';
										
	        						} else if ($details["status"] == "orange"){
										echo '<section id="taskbox" class="bg-white m-1 borderleft taskbox orangeborder">';
										
	        						} else if ($details["status"] == "yellow"){
										echo '<section id="taskbox" class="bg-white m-1 borderleft taskbox yellowborder">';
						
	        						} else if ($details["status"] == "" || $details["status"] == "lightgrey"){
										echo '<section id="taskbox" class="bg-white m-1 borderleft taskbox emptyborder">';
										
	        						}

								
        						?>
								<div class="dropdown">
								<?php
									if($details["status"] == "red"){
										echo '<button class="dropbtn redstatus">Status</button>';
										
	        						} else if ($details["status"] == "green"){
										echo '<button class="dropbtn greenstatus">Status</button>';
										
	        						} else if ($details["status"] == "orange"){
										echo '<button class="dropbtn orangestatus">Status</button>';
										
	        						} else if ($details["status"] == "yellow"){
										echo '<button class="dropbtn yellowstatus">Status</button>';
						
	        						} else if ($details["status"] == "" || $details["status"] == "lightgrey"){
										echo '<button class="dropbtn nostatus">Status</button>';
										
	        						}

								?>
							  		<div class="dropdown-content">
							    		<form class="m-0" method="POST" action="changestatus.php">
							    			<input type="hidden"  name="taskid" value="<?php echo $details["taskid"]; ?>">
							    			<input type="hidden"  name="status" value="lightgrey">
							    			<input class="nostatus col-12" type="submit" value="No status">
							    		</form>
							    		<form class="m-0" method="POST" action="changestatus.php">
							    			<input type="hidden"  name="taskid" value="<?php echo $details["taskid"]; ?>">
							    			<input type="hidden"  name="status" value="red">
							    			<input class="redstatus col-12" type="submit" value="Start later">
							    		</form>
							    		<form class="m-0" method="POST" action="changestatus.php">
							    			<input type="hidden"  name="taskid" value="<?php echo $details["taskid"]; ?>">
							    			<input type="hidden"  name="status" value="orange">
							    			<input class="orangestatus col-12" type="submit" value="Not Started">
							    		</form>
							    		<form class="m-0" method="POST" action="changestatus.php">
							    			<input type="hidden"  name="taskid" value="<?php echo $details["taskid"]; ?>">
							    			<input type="hidden"  name="status" value="yellow">
							    			<input class="yellowstatus col-12" type="submit" value="Started">
							    		</form>
							    		<form class="m-0" method="POST" action="changestatus.php">
							    			<input type="hidden"  name="taskid" value="<?php echo $details["taskid"]; ?>">
							    			<input type="hidden"  name="status" value="green">
							    			<input class="greenstatus col-12" type="submit" value="Done">
							    		</form>
							  		</div>
								</div>
								<h5 class=" pl-4"><?php echo $details["title"]; ?></h5>
								<hr class=" ml-3 mr-3 mt-0">
								<p class="pl-4 mb-0"><?php echo $details["description"]; ?></p>
								<hr class=" ml-3 mr-3 mt-0">
								<p class="pl-4 mb-0">Duration: <?php echo $details["duration"]; ?></p>
								<hr class=" ml-3 mr-3 mt-0">
								<div class="mx-auto col-12 row justify-content-center">
									<form class="m-1" method="POST" action="edittask.php">
										<input type="hidden" id="editTask" name="taskid" value="<?php echo $details["taskid"]; ?>">
										<input class="btn-secondary btn p-1" type="submit" value="Edit Task">
									</form>
									<form class="m-1" method="POST" action="deletetask.php">
										<input type="hidden" id="deleteTask" name="taskid" value="<?php echo $details["taskid"]; ?>">
										<input class="btn-secondary btn p-1" type="submit" value="Delete Task">
									</form>
								</div>
								</section>
								<?php }; ?>
							</div>
							<div  class="col-12 row justify-content-center m-0">
								<form class="m-2" method="POST" action="editlist.php">
									<input type="hidden" id="editList" name="listid" value="<?php echo $list["listid"]; ?>">
									<input class="btn-primary btn p-1" type="submit" value="Edit List">
								</form>
								<form class="m-2" method="POST" action="addtask.php">
									<input type="hidden" id="addTask" name="listid" value="<?php echo $list["listid"]; ?>">
									<input class="btn-primary btn p-1" type="submit" value="Add Task">
								</form>
								<form class="m-2" method="POST" action="deletelist.php">
									<input type="hidden" id="addTask" name="listid" value="<?php echo $list["listid"]; ?>">
									<input class="btn-primary btn p-1" type="submit" value="Delete List">
								</form>
							</div>
						</div>
					</section>
			<?php 
				}; 
			?>
			</div>
		</div>
</body>
</html>