<?php
	session_start();

	include_once "db.php";
	if (isset($_GET['client'])) {
		if(isset($_POST['submit']))
		{
			if(checkContact($_POST['contact']))
			{
				$check = $conn->query("SELECT * FROM client WHERE name='".$_POST['name']."'");

				if(!mysqli_num_rows($check))
				{
					$query = "INSERT INTO client (name, address, contact) VALUES('".$_POST['name']."', '".$_POST['address']."', '".$_POST['contact']."'')";
					$insert = $conn->query($query);
					
					echo "Success";
					$_SESSION['error'] = "";
					header("location: client.php");
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
	}


	function checkContact($contact){
		return $contact[0]==0 && $contact[1]==9 && is_numeric($contact);
	}
?>