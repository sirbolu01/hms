<?php
session_start();
require 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        // Use prepared statements for security
        $stmt = $conn->prepare("
            SELECT * FROM users 
            WHERE email = ? 
            AND role IN ('doctor', 'admin')
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Check password (supports both hashed and plain text)
            $valid_password = false;
            
            // First try password_verify for hashed passwords
            if (password_verify($password, $user['password'])) {
                $valid_password = true;
            } 
            // Fallback for plain text passwords (REMOVE IN PRODUCTION)
            elseif ($password === $user['password']) {
                $valid_password = true;
                
                // Automatically hash the password (optional)
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("
                    UPDATE users 
                    SET password = ? 
                    WHERE id = ?
                ");
                $update_stmt->bind_param("si", $new_hash, $user['id']);
                $update_stmt->execute();
            }

            if ($valid_password) {
                session_regenerate_id(true);
                $_SESSION['doctor_logged_in'] = true;
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['user_name'] = $user['name']; 
                $_SESSION['user_email'] = $user['email']; 
                $_SESSION['user_role'] = $user['role'];
                header("Location: doctor_dashboard.php");
                exit();
            }
        }
        
        $error = "Invalid credentials!";
        sleep(1); // Security: Slow down brute force
    }
}
?>



<!-- doctor_login.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">
   
</head>
<body class="auth-body">

    <!-- Sign Up Page  -->
    <div class="auth-container" id="signupPage">
        <img style="width: 130px; height: 130px;" src="../assets/images/hms_logo.png" alt="HMS Logo" class="logo">
        <h2 style="padding-bottom: 15px;">Doctor Login</h2>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <input type="email" name="email"class="form-control" placeholder="Enter Email Address" required>
            </div>
           
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

    </div>

   


</body>
</html>