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
				<a class="btn btn-danger mx-5" href="logout.php">Logout</a>
			</div>
		</div>

		<div class="container border mt-5 p-3">
			<div class="row">
				<div class="col p-1">
					<a href="" class="btn btn-secondary w-100">Client List</a>
				</div>
				<div class="col p-1">
					<a href="" class="btn btn-secondary w-100">Project List</a>
				</div>
			</div>

			<div class="row mt-5">
				<!-- <div class="col p-1"> -->
					<a href="" class="btn btn-primary w-50 mx-auto">New Schedule</a>
				<!-- </div> -->
			</div>
			<div class="table-responsive-xl">
				<table class="table table-stripped table-hover table-bordered table-sm mt-3">
					<thead>
						<tr>
							<th class="col-3">Client</th>
							<th class="col-1">Project</th>
							<th class="col-3">Location</th>
							<th class="col-2">Employee Assigned</th>
							<th class="col-2">Date</th>
							<th class="col-1">Time</th>
						</tr>
					</thead>
				<?php 
					$query = "SELECT client.name AS client, project.description AS project, project.location AS location, employee.name AS employee, schedule.date, schedule.time 
								FROM schedule 
								INNER JOIN project ON project.projectNo = schedule.project
								INNER JOIN employee ON employee.employeeID = schedule.employee
								INNER JOIN client ON client.clientNo = project.client 
								WHERE schedule.status='pending'";
					$Result = $conn->query($query);

					while ($Rows = $Result->fetch_assoc()) 
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
				?>
				</table>
			</div>
			
		</div>
	</body>
</html>