<?php
session_start();
require 'db_connect.php';

// Verify patient authentication
if (!isset($_SESSION['patient_logged_in'])) {
    header("Location: patient_login.php");
    exit();
}

// Fetch patient details
$patient_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

?>

<!-- my_account.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">

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
            <!-- <h2 class="user-name">Sahid Khan</h2>
            <p class="user-email">SahidKhan@gmail.com</p> -->
            <h2 class="user-name"><?= htmlspecialchars($user['name']) ?></h2>
            <p class="user-email"><?= htmlspecialchars($user['email']) ?></p>
        </div>

        <div class="nav-menu">
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="about.php" class="nav-link">
                <i class="fas fa-info-circle"></i>
                <span>About us</span>
            </a>
            <a href="appointment.php" class="nav-link">
                <i class="fas fa-calendar-check"></i>
                <span>My appointment</span>
            </a>
            <a href="medical_history.php" class="nav-link">
                <i class="fas fa-plus-square"></i>
                <span>My medical history</span>
            </a>
            <a href="prescription.php" class="nav-link">
                <i class="fas fa-pills"></i>
                <span>Prescriptions</span>
            </a>

            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out"></i>
                <span>Logout</span>
            </a>

            <div class="nav-divider"></div>

            <a href="#" class="nav-link">
                <i class="fas fa-share-alt"></i>
                <span>Tell your friend</span>
            </a>
            <a href="#" class="nav-link">
                <i class="fas fa-comment-alt"></i>
                <span>Feedback & Contact us</span>
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

    <main class="main-content">
        <h1 class="page-title">My Account</h1>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                </div>
                <div>
                    <!-- <h2> Sahid Khan</h2>
                    <p style="color: var(--text-secondary);">SahidKhan@gmail.com</p> -->
                    <h2><?= htmlspecialchars($user['name']) ?></h2>
                    <p style="color: var(--text-secondary);"><?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <div class="info-content">
                        <h3>Email Address</h3>
                        <!-- <p>SahidKhan@gmail.com</p> -->
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-user"></i>
                    <div class="info-content">
                        <h3>Full Name</h3>
                        <!-- <p> Sahid Khan</p> -->
                        <p><?= htmlspecialchars($user['name']) ?></p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-venus-mars"></i>
                    <div class="info-content">
                        <h3>Gender</h3>
                        <!-- <p>Male</p> -->
                        <p><?= htmlspecialchars($user['gender']) ?></p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fas fa-calendar"></i>
                    <div class="info-content">
                        <h3>Date of Birth</h3>
                        <!-- <p>01-02-1992</p> -->
                        <p><?= htmlspecialchars($user['dob']) ?></p>
                    </div>
                </div>
                <div style="margin-bottom: 50px;" class="info-card" style="grid-column: 1 / -1;">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-content">
                        <h3>Address</h3>
                        <!-- <p>Somewhere in sherfield England</p> -->
                        <p><?= htmlspecialchars($user['address']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

     
    <nav class="bottom-nav">
        <a href="dashboard.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="appointment.php">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span>
        </a>
        <a href="medical_history.php">
            <i class="fas fa-plus"></i>
            <span>Medical History</span>
        </a>
        <a href="my_account.php" class="active">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

   <script src="../assets/js/script.js"></script>
</body>
</html>