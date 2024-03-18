<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "safe";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname,))
{

	die("failed to connect!");
}

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: home.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

<style type="text/css">

body {
			background-image: url("logo4.jpg"); 
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center center;
			background-attachment: fixed;
			font-family: Arial, sans-serif;
		}

		#box {
			background-color: rgba(34, 31, 31, 0.8);
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			width: 400px;
			padding: 40px;
			text-align: center;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			color: #fff;
		}

		#text {
			height: 25px;
			border-radius: 5px;
			padding: 4px;
			border: solid thin #aaa;
			width: 100%;
			margin-bottom: 10px;
		}

		#button {
			padding: 10px;
			width: 100px;
			color: white;
			background-color: #e50914;
			border: none;
			cursor: pointer;
			transition: background-color 0.3s;
		}

		#button:hover {
			background-color: #b2070a;
		}

		#box a {
			color: #fff;
			text-decoration: none;
		}

		#box a:hover {
			text-decoration: underline;
		}
	</style>



	<div id="box">
		
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Login</div>

			<input id="text" type="text" name="user_name"><br><br>
			<input id="text" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Login"><br><br>

			<a href="register.php">Create an Account</a><br><br>
		</form>
	</div>
</body>
</html>