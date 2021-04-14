<!DOCTYPE html>
<html>
<head>
	<title>To Do</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<h1>To Do List</h1>
	<a class="btn btn-primary" href="maketodolist.php">+ Add To do</a>
	<?php
	require "db-connect.php";
	// checks if you're logged in
	session_start();
		if($_SESSION["isLoggedIn"] == true){
			echo "logged in";
		} else{
			header( "Location: login.php" );
		}

		var_dump($_SESSION["isLoggedIn"]);
	?>
	<h1 class="text-center">Task Lists</h1>
		<div class="row">
	<!-- <section class="col-3">
		<div class="bg-light">

			<h2 class="text-center">Title</h2>
			<h4 class="text-center">Task list</h4>
			<p class="font-weight-bold pl-4">Title</p>
			<p class="pl-4">Description</p>

		</div>
	</section> -->

		<?php
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
			var_dump($lists);
			// foreach (array_combine($lists, $details) as $list => $detail){



			foreach ($lists as $list){ 
					global $info;
					$conn = databaseConnection();
					$stmt = $conn->prepare("SELECT * FROM tasks WHERE todolistid=:todolistid");
					$stmt->bindParam(':todolistid', $list["listid"]);
					$stmt->execute();
					$info = $stmt->fetchall();
					$conn = null;
					?>

				<section class="col-3">
					<div class="bg-light">

						<h2 class="text-center"><?php echo $list["name"]; ?></h2>
						<h4 class="text-center">Task list</h4>
						<?php foreach ($info as $details){  ?>
							<p class="font-weight-bold pl-4"><?php echo $details["title"]; ?></p>
							<p class="pl-4"><?php echo $details["description"]; ?></p>
						<?php }; ?>
					</div>
				</section>
			<?php 
			}; 
			?>
		</div>
</body>
</html>