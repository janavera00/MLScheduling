<?php
	session_start();
	if(!isset($_SESSION['error']))
		$_SESSION['error'] = "";

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
		<div class="container border mt-5 p-5">
			<h1 class="display-3 text-center">ML Scheduling</h1>

			<div class="container">
				<form action="index.php" method="post">
					<div class="container">
						<div class="col form-group p-5">
							<div class="row">
								<label for="idNum" class="m-2">ID Number:</label>
							</div>
							<div class="row">
								<div class="col">
									<input type="text" name="idNum" id="idNum" class="form-control m-2">
								</div>
								<div class="col-2">
									<input type="submit" name="submit" value="Login" class="btn btn-primary m-2">
								</div>
							</div>
						</div>
					

						<?php if($_SESSION['error'] == "login"){ ?>
							<div class="alert alert-danger">
								<strong>Login Error:</strong> Employee not found
							</div>
						<?php } ?>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	// session_destroy();
	if (isset($_POST['submit'])) {
		if(is_numeric($_POST['idNum']))
		{	
			$result = $conn->query("SELECT * FROM employee WHERE employeeID=".$_POST['idNum']);

			if(mysqli_num_rows($result))
			{
				$_SESSION['user'] = $result->fetch_assoc();
				header("location: home.php");
			}
			else
			{	
				$_SESSION['error'] = "login";
			}
		}
		else
		{
			$_SESSION['error'] = "login";
		}
	}
?>