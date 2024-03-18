<?php
session_start();

include("connection.php");
include("functions.php");

// Check the connection
if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname,)) {
    die("failed to connect!");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $accountName = $_POST["account_name"];
    $userName = $_POST["user_name"];
    $password = $_POST["password"];

    $sql = "INSERT INTO accounts (account_id, account_name, user_name, account_password) VALUES (?, ?, ?, ?)";
    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);

    // Check if the statement is prepared successfully
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $accountID, $accountName, $userName, $password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Password added successfully! Account ID: " . $accountID;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Failed to prepare the statement.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="passwords.css">
</head>
    <title>Add Password</title>
    <style>

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
            width: 40px;
            height: 40px;
            background-color: #e50914;
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .menu-icon:hover {
            background-color: #b4070d;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
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
<div class="container">
    <div class="menu-bar">
        <div class="menu-icon" onclick="toggleDropdownMenu()">&#9776;</div>
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="home.php" class="dropdown-item">
                <img src="home.png" alt="Home" width="20" height="20">
            </a>
            <a href="search.php" class="dropdown-item">
                <img src="search1.png" alt="Search" width="20" height="20">
      </a>
            <a href="edit.php" class="dropdown-item">
                <img src="edit.png" alt="Edit" width="20" height="20">
            </a>
            <a href="delete.php" class="dropdown-item">
                <img src="remove.png" alt="Forget" width="20" height="20">
            </a>
            <a href="logout.php" class="dropdown-item">
                <img src="power.png" alt="Logout" width="20" height="20">
            </a>
        </div>
    </div>

    <h2>Add Password</h2>
    <form method="POST">
        <input type="text" name="account_name" placeholder="Account" required>
        <input type="text" name="user_name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="ADD">
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
