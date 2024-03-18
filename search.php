<?php
include("connection.php");

if (!$con) {
    die("failed to connect!");
}

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the user data from the database
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    header("Location: login.php");
    exit;
}

$searchResults = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $securityAnswer = $_POST['security_answer'];

    // Validate the security answer
    $storedAnswer = $user_data['security_answer'];

    if ($securityAnswer !== $storedAnswer) {
        echo "<p style='text-align:center'>Incorrect security answer. Please try again.</p>";
        mysqli_close($con);
        exit;
    }

    // Perform the database query using the search term
    $searchTerm = $_POST['search'];
    if (!empty($searchTerm)) {
        $query = "SELECT account_name, user_name, account_password FROM accounts WHERE account_name LIKE '%$searchTerm%'";
        $result = mysqli_query($con, $query);

        // Process the search results
        if ($result) {
            $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            echo "<p style='text-align:center'>Query execution failed.</p>";
        }
    }
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Item Search</title>
    <style>
        /* CSS styles for the form */
        body {
            background-image: url('logo4.jpg');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            height: 100vh; /* Set the height of the body to 100% of the viewport height */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .search-form {
            text-align: center;
            margin-top: 100px;
        }

        .search-input {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            outline: none;
        }

        .search-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-button:hover {
            background-color: #d60000;
        }

        .search-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-image: url('search1.png');
            background-size: cover;
            vertical-align: middle;
            margin-left: 10px;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: red;
        }

        .account-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .account-details h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .account-details p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        hr {
            border: none;
            border-top: 1px solid rgba(0, 0, 0, 0.2);
            margin-top: 10px;
            margin-bottom: 10px;
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
<div class="container">
    <div class="menu-bar">
        <div class="menu-icon" onclick="toggleDropdownMenu()">&#9776;</div>
        <div class="dropdown-menu" id="dropdown-menu">
            <a href="home.php" class="dropdown-item">
                <img src="home.png" alt="Home" width="20" height="20">
            </a>
            <a href="passwords.php" class="dropdown-item">
                <img src="plus.png" alt="Add" width="20" height="20">
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
<div class="search-form">
    <form action="search.php" method="POST">
        <input type="text" name="security_answer" class="search-input" placeholder="Security Answer" required>
        <input type="text" name="search" class="search-input" placeholder="Search..." required>
        <button type="submit" class="search-button">Search<span class="search-icon"></span></button>
    </form>
</div>

<?php if (!empty($searchResults)): ?>
    <?php foreach ($searchResults as $row): ?>
        <div class="account-details">
            <h3>Account Name: <?= $row['account_name'] ?></h3>
            <p>Username: <?= $row['user_name'] ?></p>
            <p>Password: <?= $row['account_password'] ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p class="message">No results found.</p>
<?php endif; ?>
<script>
    function toggleDropdownMenu() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('show');
    }
</script>

</body>
</html>
