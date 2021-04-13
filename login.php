<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
	<form class="col-6 mx-auto" action="controlLogin.php" method="POST">
		<section class="row col-3 mx-auto">
			<label class="p-0" for="email">Email:</label>
			<input type="email" name="email">
			<label class="p-0" for="password">Password:</label>
			<input type="password" name="password">	
			<input class="col-6" type="submit" name="submit" value="submit">
		</section>
	</form>

</body>
</html>