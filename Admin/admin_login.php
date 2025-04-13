<?php
session_start();
require 'db_connect.php';
 
// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // if (password_verify($password, $user['password'])) 
        // if ($password === $user['password'])
        // Try password_verify first (for hashed passwords)
        if (password_verify($password, $user['password'])) {
            $valid_password = true;
        }
        // Fallback to plain text comparison (REMOVE IN PRODUCTION!)
        elseif ($password === $user['password']) {
            $valid_password = true;
        }
        if (isset($valid_password)) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['id'] = $user['id'];
            header("Location: admin_adduser.php");
            exit();
        }
    }
    $error = "Invalid email or password!";
}
?>

<!-- admin_login.html -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">

</head>

<body class="auth-body">

    <!-- Sign Up Page  -->
    <div class="auth-container" id="signupPage">
        <img style="width: 130px; height: 130px;" src="../assets/images/hms_logo.png" alt="HMS Logo" class="logo">
        <h2 style="padding-bottom: 15px;">Admin Login</h2>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

    </div>




</body>

</html>