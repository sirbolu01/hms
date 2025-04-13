<?php
session_start();
require 'db_connect.php';

// Verify patient authentication
if (!isset($_SESSION['patient_logged_in'])) {
    header("Location: patient_login.php");
    exit();
}

// Fetch user details
$patient_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!-- about.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Healthcare Management System</title>
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

    <div style="margin-bottom: 100px;" class="about-container">
     <div class="title">About Us</div>
     <center><div style="margin-top: 100px; margin-bottom: 50px;" class="title">About Us</div></center>
    
        <div class="about-content">
          <div class="main-content">
            <div class="section-title">Welcome to Our Practice</div>
            <p class="about-text">
              Founded in 2010, our medical practice is dedicated to providing exceptional healthcare services with a patient-centered approach. We combine advanced medical expertise with compassionate care to ensure the best possible outcomes for our patients.
            </p>
            <p class="about-text">
              Our state-of-the-art facility is equipped with the latest medical technology, and our team of experienced healthcare professionals is committed to delivering personalized care that meets the unique needs of each patient.
            </p>
    
            <div class="section-title">Our Doctors</div>
            <div class="doctor-profile">
              <img src="../assets/images/profile.jpg" alt="Dr. John Lock" class="doctor-image">
              <div class="doctor-info">
                <div class="doctor-name">Dr. John Lock</div>
                <div class="doctor-specialty">Family Medicine • 15 years experience</div>
              </div>
            </div>
    
           
          </div>
    
          <div class="sidebar">
            <div class="section-title">Hours & Location</div>
            <ul class="hours-list">
              <li class="hours-item">
                <span>Monday - Friday</span>
                <span>8:00 AM - 6:00 PM</span>
              </li>
              <li class="hours-item">
                <span>Saturday</span>
                <span>9:00 AM - 2:00 PM</span>
              </li>
              <li class="hours-item">
                <span>Sunday</span>
                <span>Closed</span>
              </li>
            </ul>
    
            <div class="contact-info">
              <div class="section-title">Contact Us</div>
              <div class="contact-item">📞 (555) 123-4567</div>
              <div class="contact-item">📧 info@hmssherfield.com</div>
              <div class="contact-item">📍 123 Healthcare Ave, Medical District</div>
            </div>
          </div>
        </div>
        <div class="credits">
            Profile image by <a href="https://www.freepik.com" target="_blank" rel="noopener noreferrer">Freepik</a>
          </div>
      </div>

      

     
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
        <a href="my_account.php">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </a>
    </nav>

   <script src="../assets/js/script.js"></script>
</body>
</html>