<?php
	session_start();

	include_once "db.php";

	if(isset($_POST['submit']))
	{	
		if (isset($_GET['client'])) 
		{
			if(checkContact($_POST['contact']))
			{
				$check = $conn->query("SELECT * FROM client WHERE name='".$_POST['name']."'");

				if(!mysqli_num_rows($check))
				{

					$query = "INSERT INTO client (name, address, contact) VALUES('".$_POST['name']."', '".$_POST['address']."', '".$_POST['contact']."')";

					if($conn->query($query))
					{
						echo $_GET['client'];
						$_SESSION['error'] = "";
						header("location: client.php");
					}
				}
				else
				{
					$_SESSION['error'] = "duplicate";
					header("location: client.php");
				}
			}
			else
			{
				$_SESSION['error'] = "contact";
				header("location: client.php");
			}
		}
		else if(isset($_GET['project']))
		{
			$clientName = $_POST['client'];
			$client = $conn->query("SELECT * FROM client WHERE name='".$clientName."'");
			
			if(mysqli_num_rows($client))
			{
				$row = $client->fetch_assoc();
				$query = "INSERT INTO project (location, description, client) VALUES ('".$_POST['location']."', '".$_POST['description']."', ".$row['clientNo'].")";

				if($conn->query($query))
				{
					$_SESSION['error'] = "";
					header("location: project.php");
				}
			}
			else
			{
				$_SESSION['error'] = "client";
				header("location: project.php");
			}
		}
		else if(isset($_GET['schedule']))
		{
			$insert = "INSERT INTO schedule VALUES (".$_POST['project'].", ".$_POST['employee'].", '".$_POST['date']."', '".$_POST['time']."', 'pending')";

			if($conn->query($insert))
			{
				$_SESSION['error'] = "";
				header("location: project.php");
			}
		}
		else if(isset($_GET['employee']))
		{
			if(checkContact($_POST['contact']))
			{
				$check = $conn->query("SELECT * FROM employee WHERE name='".$_POST['name']."' OR employeeID=".$_POST['id']);

				if(!mysqli_num_rows($check))
				{

					$query = "INSERT INTO employee VALUES(".$_POST['id'].", '".$_POST['name']."', '".$_POST['bday']."', '".$_POST['gender']."', '".$_POST['job']."', '".$_POST['address']."', '".$_POST['contact']."')";

					if($conn->query($query))
					{
						$_SESSION['error'] = "";
						$result = $conn->query("SELECT * FROM employee WHERE employeeID=".$_POST['id']);
						$_SESSION['user'] = $result->fetch_assoc();
						header("location: home.php");
					}
				}
				else
				{
					$_SESSION['error'] = "duplicate";
					header("location: index.php");
				}
			}
			else
			{
				$_SESSION['error'] = "contact";
				header("location: index.php");
			}
		}
	}

	function checkContact($contact){
		return $contact[0]==0 && $contact[1]==9 && is_numeric($contact);
	}
?>