<?php
session_start();
require 'db_connect.php'; // Use centralized connection

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    }

    // Fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'patient'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password (supports both hashed and plain text)
        if (password_verify($password, $user['password'])) {
            $valid = true;
        } elseif ($password === $user['password']) {
            $valid = true;
        }

        if (isset($valid)) {
            session_regenerate_id(true);
            $_SESSION['patient_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $error = "Invalid credentials!";
    }

    sleep(1); // Security: Slow brute force attempts
}
?>

<!-- patient_login.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">

</head>

<body class="auth-body">

    <!-- Sign Up Page  -->
    <div class="auth-container" id="signupPage">
        <img style="width: 130px; height: 130px;" src="../assets/images/hms_logo.png" alt="HMS Logo" class="logo">
        <h2 style="padding-bottom: 15px;">Welcome Back 😁</h2>
        <p style="margin-bottom: 2rem;">Login to Account</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="auth-links">
            <span>Don't have an account?</span>
            <a href="register.php" onclick="showLogin()">Sign up here</a>
        </div>
    </div>




</body>

</html>