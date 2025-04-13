<?php
session_start();
require 'db_connect.php'; // Use centralized connection

// Initialize variables
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT * FROM users 
        WHERE email = ? 
        AND role = 'receptionist'
    ");
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
            $_SESSION['receptionist_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            header("Location: receptionist_appointment.html");
            
            exit();
        }
    }
    
    $error = "Invalid credentials!";
    // sleep(1); // Security: Slow brute force attacks
}
?>



<!-- receptionist_login -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Login - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">
   
</head>
<body class="auth-body">

    <!-- Sign Up Page  -->
    <div class="auth-container" id="signupPage">
        <img style="width: 130px; height: 130px;" src="../assets/images/hms_logo.png" alt="HMS Logo" class="logo">
        <h2 style="padding-bottom: 15px;">Receptionist Login</h2>


        <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="form-group">
            <input type="email" name="email" class="form-control" 
                   placeholder="Enter Email Address" required autofocus>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" 
                   placeholder="Enter Password" required>   
 `          <button type="submit" class="btn btn-primary">Login</button>
        <!-- <form action="#" method="post">
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Enter Email Address" required>
            </div>
           
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter Password" required>
            </div>
           
        </form> -->

    </div>

   


</body>
</html>