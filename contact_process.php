<?php
	
	session_start();

	if(!empty($_POST))
	{
		extract($_POST);
		$_SESSION['error'] = array();

		if(empty($fnm))
		{
			$_SESSION['error']['fnm'] = "Please enter Full Name";
		}
		
		if(empty($mno))
		{
			$_SESSION['error']['mno'] = "Please enter Mobile Number";
		}
		else if(!is_numeric($mno))
		{
			$_SESSION['error']['mno'] = "Please enter Numeric Mobile Number";
		}

		if(empty($msg))
		{
			$_SESSION['error']['msg'] = "Please enter Message";
		}	

		if(empty($email))
		{
			$_SESSION['error']['email'] = "Please enter E-Mail ID";
		}

		if(!empty($_SESSION['error']))
		{
			foreach($_SESSION['error'] as $er)
			{
				echo '<font color="red">'.$er.'</font><br>';
			}
			header("location:contact.php");
			exit;
		}
		else
		{
			include("includes/connection.php");

			$t = time();

			$q = "INSERT INTO contact (c_fnm, c_mno, c_email, c_msg, c_time) VALUES (?, ?, ?, ?, ?)";

			$stmt = $mysqli->prepare($q);
			$stmt->bind_param("ssssi", $fnm, $mno, $email, $msg, $t);

			if ($stmt->execute()) {
				header("location:contact.php");
				exit;
			} else {
				echo "Error: " . $q . "<br>" . $mysqli->error;
			}
			$stmt->close();
		}
	}
	else
	{
		header("location:contact.php");
		exit;
	}
