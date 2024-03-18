<?php

function check_login($con)
{

	if(isset($_SESSION['user_id']))
	{

		$id = $_SESSION['user_id'];
		$query = "select * from users where user_id = '$id' limit 1";

		$result = mysqli_query($con,$query);
		if($result && mysqli_num_rows($result) > 0)
		{

			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: login.php");
	die;
}
  // Function to check password strength
  function checkPasswordStrength($password)
  {
	  // Check password strength

	  if (strlen($password) < 8) {
		  return 'Your password should be at least 8 characters long.';
	  }

	  if (!preg_match("#[0-9]+#", $password)) {
		  return 'Your password should contain at least one digit.';
	  }

	  if (!preg_match("#[A-Z]+#", $password)) {
		  return 'Your password should contain at least one uppercase letter.';
	  }

	  if (!preg_match("#[a-z]+#", $password)) {
		  return 'Your password should contain at least one lowercase letter.';
	  }

	  if (!preg_match("#[\W]+#", $password)) {
		  return 'Your password should contain at least one special character.';
	  }

	  // If all criteria are met
	  return 'strong';
	} 
 

