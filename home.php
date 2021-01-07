<?php
	session_start();
	if(!isset($_SESSION['user']))
		header("location: index.php");

	if($_SESSION['error'] == "login")
	{
		$_SESSION['error'] = "";	
	}

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
					<a href="project.php" class="btn btn-secondary w-75">Project List</a>
				</div>
			</div>

			<div class="container m-3 p-3" align="center">
				<h1>Schedule List</h1>
			</div>

			<div class="row">
				<a onclick="showElement('new')" class="btn btn-primary w-50 mx-auto">New Schedule</a>
			</div>
			<div class="container w-50 mt-3 p-2 border" id="new" style="display: <?php echo $_SESSION['error']==""?"none":"display"; ?>;">
				<form action="add.php?schedule=0" method="post">

					<div class="form-group">
						<label for="name">Project</label>
						<select class="form-control" name="project" required>
							<option value="" selected disabled hidden>Click to show options</option>
							<?php 
								$query = "SELECT c.name, p.projectNo, p.location, p.description FROM project p INNER JOIN client c ON p.client = c.clientNo ORDER BY c.name";
								$result = $conn->query($query);

								if(mysqli_num_rows($result)){
									while ($row = $result->fetch_assoc()) {
										$option = $row['name']." | ".$row['description']." | ".$row['location'];
										echo "<option value=".$row['projectNo'].">".$option."</option>";
									}	
								}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="address">Employee Assigned</label>
						<select class="form-control" name="employee" required>
							<option value="" selected disabled hidden>Click to show options</option>
							<?php 
								$query = "SELECT * FROM employee ORDER BY name";
								$result = $conn->query($query);

								if(mysqli_num_rows($result)){
									while ($row = $result->fetch_assoc()) {
										echo "<option value=".$row['employeeID'].">".$row['name']." | ".$row['job']."</option>";
									}	
								}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="contact">Date</label>
						<input type="date" name="date" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="contact">Time</label>
						<input type="time" name="time" class="form-control" required>
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
							<th class="col-3">Client</th>
							<th class="col-1">Project</th>
							<th class="col-3">Location</th>
							<th class="col-2">Employee Assigned</th>
							<th class="col-1">Date</th>
							<th class="col-1">Time</th>
						</tr>
					</thead>
				<?php 
					$query = "SELECT client.name AS client, project.description AS project, project.location AS location, employee.name AS employee, schedule.date, schedule.time 
								FROM schedule 
								INNER JOIN project ON project.projectNo = schedule.project
								INNER JOIN employee ON employee.employeeID = schedule.employee
								INNER JOIN client ON client.clientNo = project.client 
								WHERE schedule.status='pending' 
								ORDER BY date, time";
					$Result = $conn->query($query);

					if(mysqli_num_rows($Result)){
						while ($Rows = $Result->fetch_assoc()) 
						{
							$date = new DateTime($Rows['date']);
							$today = new DateTime();
							if($date >= $today)
							{
								?>
								<tbody>
									<tr>
										<td><?php echo $Rows['client']; ?></td>
										<td><?php echo $Rows['project']; ?></td>
										<td><?php echo $Rows['location']; ?></td>
										<td><?php echo $Rows['employee']; ?></td>
										<td><?php
											$date = date("D<\b\\r>M d, Y", strtotime($Rows['date']));
											echo $date; 
										?></td>
										<td><?php 
											$time = date("h:i a", strtotime($Rows['time']));
											echo $time; 
										?></td>

									</tr>
								</tbody>
								<?php
							}
						}
					}
				?>
				</table>
			</div>
		</div>



		<div class="container mt-5 p-3" align="center">
			<button class="btn btn-success" onclick="showElement('doneContainer')">
				<h1>Previous Schedules List</h1>
			</button>
		</div>
		<div class="container border p-3" id="doneContainer" style="display: none;">
			
			<div class="table-responsive-xl">
			<table class="table table-stripped table-hover table-bordered table-sm mt-3">
				<thead>
					<tr>
						<th class="col-3">Client</th>
						<th class="col-1">Project</th>
						<th class="col-3">Location</th>
						<th class="col-2">Employee Assigned</th>
						<th class="col-1">Date</th>
						<th class="col-1">Time</th>
					</tr>
				</thead>
			<?php 
				$query = "SELECT client.name AS client, project.description AS project, project.location AS location, employee.name AS employee, schedule.date, schedule.time 
							FROM schedule 
							INNER JOIN project ON project.projectNo = schedule.project
							INNER JOIN employee ON employee.employeeID = schedule.employee
							INNER JOIN client ON client.clientNo = project.client 
							WHERE schedule.status='pending' 
							ORDER BY date, time";
				$Result = $conn->query($query);

				if(mysqli_num_rows($Result)){
					while ($Rows = $Result->fetch_assoc()) 
					{
						$date = new DateTime($Rows['date']);
						$today = new DateTime();
						if($date < $today)
						{
							?>
							<tbody>
								<tr>
									<td><?php echo $Rows['client']; ?></td>
									<td><?php echo $Rows['project']; ?></td>
									<td><?php echo $Rows['location']; ?></td>
									<td><?php echo $Rows['employee']; ?></td>
									<td><?php
										$date = date("D<\b\\r>M d, Y", strtotime($Rows['date']));
										echo $date; 
									?></td>
									<td><?php 
										$time = date("h:i a", strtotime($Rows['time']));
										echo $time; 
									?></td>
									
								</tr>
							</tbody>
							<?php
							}
						}
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