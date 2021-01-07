<?php
	session_start();
	if(!isset($_SESSION['user']))
		header("location: index.php");

	include_once "db.php";

	$_SESSION['error'] = "";
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
				<a class="btn btn-danger mx-5" href="logout.php">Logout</a>
			</div>
		</div>

		<div class="container border mt-5 p-3">
			<div class="row">
				<div class="col p-1" align="right">
					<a href="home.php" class="btn btn-secondary w-75">Schedule List</a>
				</div>
				<div class="col p-1" align="left">
					<a href="" class="btn btn-secondary w-75">Project List</a>
				</div>
			</div>

			<div class="container m-3 p-3" align="center">
				<h1>Client List</h1>
			</div>

			<div class="row">
				<a onclick="showElement('new')" class="btn btn-primary w-50 mx-auto">New Client</a>
			</div>

			<div class="container w-50 mt-3 p-2 border" id="new" style="display: <?php echo $_SESSION['error']==""?"none":"display"; ?>;">
				<form action="add.php?client" method="post">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input type="text" name="address" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="contact">Contact</label>
						<input type="text" name="contact" class="form-control" maxlength="11" minlength="11" id="numberInput" placeholder="09xxxxxxxxx" required>
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
									echo "Client already exist";
								}
							?>
						</div>
					<?php } ?>
				</form>
			</div>

			<div class="table-responsive-xl">
				<table class="table table-stripped table-hover table-bordered table-sm mt-3">
					<thead>
						<tr>
							<th class="col">No.</th>
							<th class="col">Name</th>
							<th class="col">Address</th>
							<th class="col">Contact</th>
						</tr>
					</thead>
				<?php 
					$query = "SELECT * FROM client";
					$Result = $conn->query($query);

					while ($Rows = $Result->fetch_assoc()) 
					{
						?>
						<tbody>
							<tr>
								<td><?php echo $Rows['clientNo']; ?></td>
								<td><?php echo $Rows['name']; ?></td>
								<td><?php echo $Rows['address']; ?></td>
								<td><?php echo $Rows['contact']; ?></td>
							</tr>
						</tbody>
						<?php
					}
				?>
				</table>
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