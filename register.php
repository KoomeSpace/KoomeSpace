<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $security_question =  mysqli_real_escape_string($con, $_POST['security_question']);
   $security_answer = mysqli_real_escape_string($con, $_POST['security_answer']);


  
    if (!empty($user_name) && !empty($password) && !empty($confirm_password) && !empty($email) && !empty($security_question) && !empty($security_answer) && !is_numeric($user_name)) {
        if ($password === $confirm_password) {
            $password_strength = checkPasswordStrength($password);

            if ($password_strength === 'strong') {
                // Save to database
                $query = "INSERT INTO users (user_id, user_name, password, email, security_question, security_answer) VALUES ('$user_id', '$user_name', '$password', '$email', '$security_question', '$security_answer')";

                if (mysqli_query($con, $query)) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                // Password is not strong
                echo "Password is not strong. " . $password_strength;
            }
        } else {
            echo "Passwords do not match!";
        }
    } else {
        echo "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("security-answer");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.className = "fa fa-eye";
            } else {
                passwordInput.type = "password";
                eyeIcon.className = "fa fa-eye-slash";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form method="POST">
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="email" name="email" placeholder="Email" required>

            <select name="security_question" required>
                <option value="">Select Security Question</option>
                <option value="What is your last name?">What is your last name?</option>
                <option value="Which city were you born in?">Which city were you born in?</option>
                <option value="What is your favorite meal?">What is your favorite meal?</option>
                <option value="Which is your pet's name?">What is your pet's name?</option>
                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            </select>
            <div class="security-answer-container">
                <input type="password" id="security-answer" name="security_answer" placeholder="Security Answer" required>
                <i id="eye-icon" class="fa fa-eye" onclick="togglePasswordVisibility()"></i>
            </div>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

