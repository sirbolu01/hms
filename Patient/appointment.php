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
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments - Healthcare Management System</title>
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
            <a href="#" class="nav-link">
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

    <div style="margin-bottom: 50px;" class="appointment-container">
          <center><div style="margin-top: 100px; margin-bottom: 50px;" class="title">My Appointment</div></center>
       
        <div class="appointment-content">
         
            <div class="calendly-wrapper">
                <!-- Calendly inline widget begin -->
                <div class="calendly-inline-widget" 
                     data-url="https://calendly.com/bfagbolagun1/30min?primary_color=009688&text_color=333333&background_color=ffffff&hide_landing_page_details=1&hide_gdpr_banner=1"
                     style="min-width:320px;height:700px;">
                </div>
                <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                <!-- Calendly inline widget end -->
            </div>
            
           
            <div style="margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-radius: var(--border-radius);">
                <h4 style="color: var(--primary-color); margin-bottom: 10px;">Appointment Guidelines</h4>
                <ul style="padding-left: 20px; color: #555;">
                    <li>Please arrive 15 minutes before your scheduled appointment</li>
                    <li>Bring your insurance card and ID</li>
                    <li>You can reschedule up to 24 hours before your appointment</li>
                    <li>For urgent matters, please call our emergency line</li>
                </ul>
            </div>
          
        </div>
      </div>

     
    <nav class="bottom-nav">
        <a href="dashboard.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="appointment.php" class="active">
            <i class="fas fa-calendar-check"></i>
            <span>Appointments</span>
        </a>
        <a href="medical_history.php">
            <i class="fas fa-plus"></i>
            <span>Medical History</span>
        </a>
        <a href="my_account.php">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

   <script src="../assets/js/script.js"></script>
</body>
</html>