<?php
	session_start();
	if(!isset($_SESSION['user']))
		header("location: index.php");

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
				<a class="btn btn-danger mx-5" href="logout.php">Logout</a>
			</div>
		</div>

		<div class="container border mt-5 p-3">
			<div class="row">
				<div class="col p-1" align="right">
					<a href="client.php" class="btn btn-secondary w-75">Client List</a>
				</div>
				<div class="col p-1" align="left">
					<a href="home.php" class="btn btn-secondary w-75">Schedule List</a>
				</div>
			</div>

			<div class="container m-3 p-3" align="center">
				<h1>Project List</h1>
			</div>

			<div class="row">
				<a onclick="showElement('new')" class="btn btn-primary w-50 mx-auto">New Project</a>
			</div>

			<div class="container w-50 mt-3 p-2 border" id="new" style="display: <?php echo $_SESSION['error']==""?"none":"display"; ?>;">
				<form action="add.php?project=0" method="post">
					<div class="form-group">
						<label for="name">Client</label>
						<input type="text" name="client" class="form-control">
					</div>
					<div class="form-group">
						<label for="address">Location</label>
						<input type="text" name="location" class="form-control">
					</div>
					<div class="form-group">
						<label for="contact">Description</label>
						<input type="text" name="description" class="form-control">
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
								if($_SESSION['error'] == "client")
								{
									echo "Client doesn't exist yet in the system";
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
							<th class="col">Client</th>
							<th class="col">Location</th>
							<th class="col">Description</th>
						</tr>
					</thead>
				<?php 
					$query = "SELECT client.name, project.projectNo, project.location, project.description FROM project INNER JOIN client ON project.client = client.clientNo";
					$Result = $conn->query($query);

					while ($Rows = $Result->fetch_assoc()) 
					{
						?>
						<tbody>
							<tr>
								<td><?php echo $Rows['projectNo']; ?></td>
								<td><?php echo $Rows['name']; ?></td>
								<td><?php echo $Rows['location']; ?></td>
								<td><?php echo $Rows['description']; ?></td>
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