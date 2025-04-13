<?php
session_start();
require 'db_connect.php'; // Use centralized connection

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $dob = $_POST['dob'] ?? '';
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($gender) || empty($dob) || empty($address)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        $error = "Invalid date format! Use YYYY-MM-DD";
    }

    if (empty($error)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new patient
            $stmt = $conn->prepare("
                INSERT INTO users (name, email, password, gender, dob, address, role)
                VALUES (?, ?, ?, ?, ?, ?, 'patient')
            ");
            $stmt->bind_param("ssssss", $name, $email, $hashed_password, $gender, $dob, $address);

            if ($stmt->execute()) {
                $success = "Account created successfully! Please log in.";
                // Clear form data
                $_POST = [];
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}
?>

<!-- register.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account - Register Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">
   
</head>
<body class="auth-body">

    <!-- Sign Up Page  -->
    <div class="auth-container" id="signupPage">
        <img style="width: 130px; height: 130px;" src="../assets/images/hms_logo.png" alt="HMS Logo" class="logo">
        <h2>New Here?</h2>
        <p style="margin-bottom: 2rem;">Create an account</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required>
            </div>
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="gender"class="form-control" placeholder="Enter Gender" required>
            </div>
            <div class="form-group">
                <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required>
            </div>
            <div class="form-group">
                <textarea name="address" class="form-control" placeholder="Enter Address" required rows="3"></textarea>
            </div>            
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <div class="auth-links">
            <span>Already have an account?</span>
            <a href="patient_login.php" onclick="showLogin()">Login</a>
        </div>
    </div>

   


</body>
</html>