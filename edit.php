<?php
session_start();

include("connection.php");
include("functions.php");

// Check the connection
if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Failed to connect!");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $accountName = $_POST["account_name"];
    $userName = $_POST["user_name"];
    $password = $_POST["password"];

    // Get the current password from the database
    $query = "SELECT account_password FROM accounts WHERE account_name = '$accountName' AND user_name = '$userName'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPassword = $row['account_password'];

        // Check if the new password is different from the current password
        if ($password != $currentPassword) {
            // Update the password in the database
            $updateQuery = "UPDATE accounts SET account_password = '$password' WHERE account_name = '$accountName' AND user_name = '$userName'";

            if (mysqli_query($conn, $updateQuery)) {
                echo "Password updated successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "New password must be different from the current password.";
        }
    } else {
        echo "Error: Account not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <style>
  body {
    background-image: url("logo4.jpg");
    background-size: cover;
    background-position: center;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  
  .container {
    max-width: 400px;
    margin: 150px auto;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    color: white;
    text-align: center;
  }
  
  h2 {
    color: #e50914;
  }
  
  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: none;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 16px;
    box-sizing: border-box;
  }
  
  input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #e50914;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  
  input[type="submit"]:hover {
    background-color: #bf0812;
  }
    
  .menu-bar {
    position: absolute;
    top: 0;
    left: 0;
    margin: 10px;
  }

  .menu-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background-color: #e50914;
    color: #ffffff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
  }

  .menu-icon:hover {
    background-color: #b4070d;
  }

  .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background-image: url("logo4.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    display: none;
    z-index: 1;
  }

  .dropdown-menu.show {
    display: block;
  }

  .dropdown-item {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    font-size: 14px;
    color: #000000;
    text-decoration: none;
    transition: background-color 0.3s ease-in-out;
  }

  .dropdown-item:hover {
    background-color: #f5f5f5;
  }
  </style>
</head>
<body> 
<div class="menu-bar">
    <div class="menu-icon" onclick="toggleDropdownMenu()">&#9776;</div>
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="home.php" class="dropdown-item">
            <img src="home.png" alt="Home" width="20" height="20">
        </a>
        <a href="search.php" class="dropdown-item">
            <img src="search1.png" alt="Search" width="20" height="20">
        </a>
        <a href="passwords.php" class="dropdown-item">
            <img src="plus.png" alt="Add" width="20" height="20">
        </a>
        <a href="delete.php" class="dropdown-item">
            <img src="remove.png" alt="Forget" width="20" height="20">
        </a>
        <a href="logout.php" class="dropdown-item">
            <img src="power.png" alt="Logout" width="20" height="20">
        </a>
    </div>
</div>
<div class="container">
    <h2>Edit Password</h2>
    <form method="POST">
      <input type="text" name="account_name" placeholder="Account" required>
      <input type="text" name="user_name" placeholder="Username" required>
      <input type="password" name="password" placeholder="New Password" required>
      <input type="submit" value="Update">
    </form>
</div>
<script>
    function toggleDropdownMenu() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }
</script>
</body>
</html>
