<?php
session_start();
require 'db_connect.php';
 

// Verify doctor authentication
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

// Get doctor details from database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
?>


<!-- doctor_dashboard.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Healthcare Management System</title>
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
            <h2 class="user-name"><?= htmlspecialchars($doctor['name']) ?></h2>
            <p class="user-email"><?= htmlspecialchars($doctor['email']) ?></p>
        </div>

        <div class="nav-menu">
            <a href="doctor_dashboard.php" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>

            <a href="doctor_appointment.php" class="nav-link">
                <i class="fas fa-calendar-check"></i>
                <span>View Appointments</span>
            </a>
            <a href="doctor_prescription.php" class="nav-link">
                <i class="fas fa-pen"></i>
                <span>Write Prescriptions</span>
            </a>
           <a href="doctor_record.php" class="nav-link">
                <i class="fas fa-file"></i>
                <span>Patient Records</span>
            </a>
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out"></i>
                <span>Logout</span>
            </a>
            <div class="nav-divider"></div>

            
            
        </div>
    </nav>

    <!-- Main Content -->
    <header class="main-header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <img src="../assets/images/hms_logo.png" alt="HMS Logo" style="height: 60px; width: 60px; display: block; margin: auto;">

    </header>


    <div style="margin-top: 100px; margin-bottom: 120px;"  class="dashboard-container">
        
        <div style="margin-top: 120px;" class="profile-section">
          <div class="profile-icon">
            <img src="../assets/images/user_icon.png" alt="Medical cross icon">
          </div>
          <h2 class="user-name"><?= htmlspecialchars($doctor['name']) ?></h2>
          <p class="user-email"><?= htmlspecialchars($doctor['email']) ?></p>
        </div>
    
        <ul class="menu-list">
         <a style="text-decoration: none;" href="doctor_appointment.php"> <li class="menu-item">
            <span class="menu-icon">📅</span>
            <span class="menu-text">Appointments</span>
            <span class="menu-arrow">›</span>
          </li></a>
          
          <a style="text-decoration: none;" href="doctor_record.php">
          <li class="menu-item">
            <span class="menu-icon">🏥</span>
            <span class="menu-text">Patient Records</span>
            <span class="menu-arrow">›</span>
          </li>
          </a>
          <a style="text-decoration: none;" href="doctor_prescription.php">
          <li class="menu-item">
            <span class="menu-icon">🖊️</span>
            <span class="menu-text">Write Prescription</span>
            <span class="menu-arrow">›</span>
          </li>
          </a>
        </ul>
      </div>
     
     <nav class="bottom-nav">
        <a href="doctor_dashboard.php" class="active">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
       
        <a href="doctor_record.php">
            <i class="fas fa-file"></i>
            <span>Patient Records</span>
        </a>

        <a href="doctor_prescription.php">
            <i class="fas fa-pen"></i>
            <span>Write Prescriptions</span>
        </a>

        <a href="logout.php">
            <i class="fas fa-sign-out"></i>
            <span>Logout</span>
        </a>
    </nav>

   <script src="../assets/js/script.js"></script>
</body>
</html>