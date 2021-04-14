<!DOCTYPE html>
<html>
<head>
	<title>Make A To Do</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body onload="addTask()">



	<?php
	// checks if you're logged in
	session_start();
		if($_SESSION["isLoggedIn"] == true){
			echo "logged in ";
		} else{
			header( "Location: login.php" );
		}

		var_dump($_SESSION["isLoggedIn"]);

		$taskNumber = 1;

	?>
	<script type="text/javascript">
		var taskNmbr = 1;

		// adds the task fields
		function addTask(){
			
			var form = document.getElementById("form");
			var container = document.createElement("div");
			form.appendChild(container);

			//Title Task ..
			var newtitle = document.createElement("h4");
			newtitle.innerHTML = "Task "+taskNmbr;
			container.appendChild(newtitle);

			// Div for Title
			var titlediv = document.createElement("div");
			titlediv.classList.add("form-group");
			container.appendChild(titlediv);

			//Label for Title input
			var newtitlelabel = document.createElement("label");
			newtitlelabel.innerHTML = "Title";
			titlediv.appendChild(newtitlelabel);

			//Input for Title
			var titleinput = document.createElement("input");
			titleinput.type = "text";
			titleinput.name = "title"+taskNmbr;
			titleinput.placeholder = "Title";
			titleinput.classList.add("form-control");
			titlediv.appendChild(titleinput);	

			// Div for Description
			var descdiv = document.createElement("div");
			descdiv.classList.add("form-group");
			container.appendChild(descdiv);

			//Label for Description input
			var newdescriptionlabel = document.createElement("label");
			newdescriptionlabel.innerHTML = "Description";
			descdiv.appendChild(newdescriptionlabel);

			//Input for Description
			var descriptioninput = document.createElement("textarea");
			descriptioninput.type = "text";
			descriptioninput.rows = "3";
			descriptioninput.name = "description"+taskNmbr;
			descriptioninput.placeholder = "Description";
			descriptioninput.classList.add("form-control");
			descdiv.appendChild(descriptioninput);


			document.getElementById("count").value = taskNmbr;
			taskNmbr++;
		}

	</script>
	<h1>Make a To Do list</h1>
	
	
	<form id="form" class="col-6 mx-auto" action="addtodolist.php" method="POST">
		<input class="btn btn-success float-right" type="submit" name="submit" value="Submit">
		<div class="form-group">
		    <h3 for="listName">List Name</h3>
		    <input type="text" class="form-control" name="listName" placeholder="Name">
		</div>
		<p class="btn btn-primary float-right" onclick="addTask()">+ New task</p>
		<input type="hidden" id="count" name="taskcount" value="1">
	<!-- 	<div id="container">
			<h4>Task <?php echo $taskNumber ?></h4>
		  	<div class="form-group">
		    	<label for="title" >Title</label>
		    	<input type="text" class="form-control" name="title<?php echo $taskNumber ?>" placeholder="Title">
		  	</div>
		  	<div class="form-group">
		   		<label for="description">Description</label>
		    	<textarea class="form-control" name="description<?php echo $taskNumber ?>" rows="3"></textarea>
		  	</div>
		</div> -->

		
	</form>
	<?php
			// function addTask(){
			// 	$taskNumber++;
			// 	echo "<div id='container'>
			// 			<h4>Task ".$taskNumber. "</h4>
			//   			<div class='form-group'>
			//     			<label for='title'>Title</label>
			//     			<input type='email' class='form-control' name='title".$taskNumber. "' placeholder='Title'>
			//   			</div>
			//   			<div class='form-group'>
			//    				<label for='description'>Description</label>
			//     			<textarea class='form-control' name='description".$taskNumber. "' rows='3'></textarea>
			//   			</div>
			// 		</div>";

			// }
		?>
</body>



</html>