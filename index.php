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

			<div class="container border p-3">
				<p class="text-secondary">For Testing Purposes:</p>
				<div class="row">
					<a onclick="showElement('new')" class="btn btn-secondary w-25 mx-auto">Register new user</a>
				</div>

				<div class="container w-50 mt-3 p-2 border" id="new" style="display: <?php echo $_SESSION['error']==""?"none":"display"; ?>;">
					<form action="add.php?employee=0" method="post">
						<div class="form-group">
							<label>EmployeeID</label>
							<input type="text" name="id" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Birthdate</label>
							<input type="date" name="bday" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Gender</label>
							<select name="gender" class="form-control" required>
								<option value="" selected disabled hidden>Click to show options</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>
						</div>
						<div class="form-group">
							<label>Job</label>
							<input type="text" name="job" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Contact</label>
							<input type="text" name="contact" class="form-control" minlength="11" maxlength="11" placeholder="09xxxxxxxxx" required>
						</div>
						<div class="row form-group mt-3">
							<div class="col">	
								<input type="reset" class="btn btn-danger form-control">
							</div>
							<div class="col">	
								<input type="submit" name="submit" class="btn btn-success form-control">
							</div>
						</div>
						<?php if($_SESSION['error'] != ""){ ?>
							<div class="alert alert-danger m-3">
								<strong>Register Error:</strong> 
								<?php
									if($_SESSION['error'] == "contact")
									{
										echo "Please enter a valid contact number";
									}
									else if($_SESSION['error'] == "duplicate")
									{
										echo "Employee already exist in the system";
									}
								?>
							</div>
						<?php } ?>
					</form>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			function showElement(id)
			{
				var disp = document.getElementById(id).style.display; 
				
				if(disp == "none")
				{
					document.getElementById(id).style.display = "block";
				}
				else
				{
					document.getElementById(id).style.display = "none";
				}
			}
		</script>
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
				$_SESSION['error'] = "";
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