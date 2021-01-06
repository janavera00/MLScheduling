<?php
	session_start();

	include_once "db.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

		<title>ML Scheduling</title>
	</head>
	<body>
		<div class="navbar bg-dark">
			<div class="nav-item">
				<h3 class="text-light px-5">
					<?php echo $_SESSION['user']['name']; ?> 
				</h3>
			</div>
			<div class="nav-item ml-auto">
				<button class="btn btn-danger mx-5">Logout</button>
			</div>
		</div>

		
	</body>
</html>