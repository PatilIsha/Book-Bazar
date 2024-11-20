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

		if(empty($unm))
		{
			$_SESSION['error']['unm'] = "Please enter User Name";
		}

		if(empty($pwd) || empty($cpwd))
		{
			$_SESSION['error']['pwd'] = "Please enter Password";
		}
		else if($pwd !== $cpwd)
		{
			$_SESSION['error']['pwd'] = "Passwords don't match";
		}
		else if(strlen($pwd) < 8)
		{
			$_SESSION['error']['pwd'] = "Please enter a password of at least 8 characters";
		}

		if(empty($email))
		{
			$_SESSION['error']['email'] = "Please enter E-Mail Address";
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['error']['email'] = "Please Enter Valid E-Mail Address";
		}

		if(empty($answer))
		{
			$_SESSION['error']['answer'] = "Please Enter Security Answer";
		}

		if(empty($cno))
		{
			$_SESSION['error']['cno'] = "Please Contact Number";
		}
		if(!empty($cno))
		{
			if(!is_numeric($cno))
			{
				$_SESSION['error']['cno'] = "Please Enter Contact Number in Numbers";
			}
		}

		if(!empty($_SESSION['error']))
		{
			foreach($_SESSION['error'] as $er)
			{
				echo '<font color="red">'.$er.'</font><br>';
			}
			header("location:register.php");
			exit;
		}

		include("includes/connection.php");

		$t = time();

		$q = "INSERT INTO register (r_fnm, r_unm, r_pwd, r_cno, r_email, r_question, r_answer, r_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $mysqli->prepare($q);
		$stmt->bind_param("sssssssi", $fnm, $unm, $pwd, $cno, $email, $question, $answer, $t);

		if ($stmt->execute()) {
		    header("location:register.php?register");
		} else {
		    echo "Error: " . $q . "<br>" . $mysqli->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	else
	{
		header("location:register.php");
		exit;
	}
