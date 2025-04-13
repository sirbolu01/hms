<?php
session_start();
// Redirect if not logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

require 'db_connect.php';
 

// Handle form submission

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    }

    // Validate role
    $allowed_roles = ['admin', 'doctor', 'receptionist', 'patient'];
    if (!in_array($role, $allowed_roles)) {
        $error = "Invalid role selected!";
    }

    // Check if email exists using prepared statements
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Email already exists!";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user with prepared statement
        $insert_stmt = $conn->prepare("
            INSERT INTO users (name, email, password, phone, role) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $insert_stmt->bind_param(
            "sssss",
            $name,
            $email,
            $hashed_password,
            $phone,
            $role
        );

        if ($insert_stmt->execute()) {
            $success = "User added successfully!";
            // Clear form data
            $_POST = array();
        } else {
            $error = "Database error: " . $insert_stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">
    <style>
        .button-group {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-view {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .btn-cancel {
            background-color: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>

<body>
    <!-- Navigation Overlay -->
    <div class="nav-overlay"></div>

    <!-- Side Navigation -->
    <nav class="side-nav">
        <div class="nav-header">
            <button class="close-btn">
                <i class="fas fa-times"></i>
            </button>
            <div class="logo">
                <img src="../assets/images/user_icon.png" alt="HMS Logo">
            </div>
            <!-- <h2 class="user-name">Helen Needham</h2>
            <p class="user-email">HelenNeedham@gmail.com</p> -->
            <h2 class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'users') ?></h2>
            <p class="user-email"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>

        </div>

        <div class="nav-menu">

            <a href="admin_adduser.php
            " class="nav-link">
                <i class="fas fa-add"></i>
                <span>Add Users</span>
            </a>

            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out"></i>
                <span>Logout</span>
            </a>

        </div>
    </nav>

    <!-- Main Content -->
    <header class="main-header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <img src="../assets/images/hms_logo.png" alt="HMS Logo" style="height: 60px; width: 60px; display: block; margin: auto;">

    </header>

    <div style="margin-top: 100px; margin-bottom: 120px;" class="prescription-container">
        <center>
            <div class="title">New User</div>
        </center>


        <!-- In your HTML -->
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <!-- *<form class="booking-form"> -->
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">

                <input type="text" name="name" class="form-input" placeholder="Name">
            </div>

            <div class="form-group">

                <input type="text" name="email" class="form-input" placeholder="Email Address">
            </div>


            <div class="form-group">

                <input type="number" name="phone" class="form-input" placeholder="Phone Number">
            </div>

            <div class="form-group">
                <label class="form-label">Choose Role</label>
                <select name="role" class="form-input">
                    <option>admin</option>
                    <option>User</option>
                    <option>Doctor</option>
                    <option>Receptionist</option>
                    <option>Patient</option>

                </select>
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-input" placeholder="Default Password">
            </div>



            <button type="submit" class="submit-btn">Add User</button>
        </form>
    </div>



    <script src="../assets/js/script.js"></script>
</body>

</html>