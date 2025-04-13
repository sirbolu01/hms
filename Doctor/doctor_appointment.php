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

 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment - Healthcare Management System</title>
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
            <a href="#" class="nav-link">
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


    <div class="view-appointment-container">
  
 <div style="margin-top: 20px; margin-bottom: 20px;" class="header-section">
            <h2 class="section-title">View Appointment</h2>
            
        </div>

        <div class="mainillustration-content">
            <div class="illustration-container">
                <h1 class="title">Calendly</h1>
                <p style="padding-top: 10px;" class="subtitle">Login to Calendly to view and manage your appointments</p>
                
                <div style="padding-top: 12px;" class="button-container">
                    <a href="https://calendly.com/app/scheduled_events/user/me" target="_blank">
                    <button class="btn btn-primary">Login to Calendly</button>
                    </a>
                    
                </div>
                <div style="text-align: center; font-family: Arial, sans-serif; padding: 20px;">
                    <div style="background-color: #009688; padding: 20px; border-radius: 8px; display: inline-block;">
                        <div style="margin-bottom: 15px;">
                            <strong style="display: block; margin-bottom: 5px;">Email:</strong>
                            <input 
                                type="text" 
                                value="bfagbolagun1@gmail.com" 
                                readonly 
                                style="width: 250px; padding: 8px; border: 1px solid #009688; background-color: #fff; cursor: copy;"
                                onclick="this.select(); document.execCommand('copy');"
                            >
                        </div>
                        <div>
                            <strong style="display: block; margin-bottom: 5px;">Password:</strong>
                            <input 
                                type="text" 
                                value="-cWmm@&GpA52zsq" 
                                readonly 
                                style="width: 250px; padding: 8px; border: 1px solid #ddd; background-color: #fff; cursor: copy;"
                                onclick="this.select(); document.execCommand('copy');"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    
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

        <a href="#">
            <i class="fas fa-sign-out"></i>
            <span>Logout</span>
        </a>
    </nav>

   <script src="../assets/js/script.js"></script>
</body>
</html>