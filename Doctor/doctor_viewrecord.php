<?php
session_start();
require 'db_connect.php';

// Verify doctor authentication
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];
$patient_id = $_GET['patient_id'] ?? null;

// Validate patient ID
if (!$patient_id || !ctype_digit($patient_id)) {
    die("Invalid patient ID");
}

// Fetch patient records
$stmt = $conn->prepare("
    SELECT mr.*, u.name AS patient_name 
    FROM medical_records mr
    JOIN users u ON mr.patient_id = u.id
    WHERE mr.patient_id = ?
    ORDER BY mr.record_date DESC
");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get patient details for title
$patient = $records ? reset($records) : null;
?>


<!-- doctor_viewrecord.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">

</head>
<body>
    <!-- Navigation Overlay -->
    <div class="nav-overlay"></div>

    <nav class="side-nav">
        <div class="nav-header">
            <button class="close-btn">
                <i class="fas fa-times"></i>
            </button>
            <div class="logo">
                <img src="../assets/images/user_icon.png" alt="HMS Logo">
            </div>
            <!-- <h2 class="user-name">John Lock</h2>
            <p class="user-email">Johnlock@gmail.com</p> -->

            <h2 class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Doctor') ?></h2>
            <p class="user-email"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
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

    <div style="margin-top: 100px; margin-bottom: 120px;"  class="prescription-container">
         <center><div class="title">My Medical Records</div></center>
    
         <div class="title"><?= $patient ? htmlspecialchars($patient['patient_name']) : 'Patient' ?> Records</div>
        
        <?php if (empty($records)): ?>
            <div class="alert alert-info">No medical records found</div>
        <?php else: ?>
            <?php foreach ($records as $record): ?>
                <div class="prescription-group">
                    <div class="date-range"><?= htmlspecialchars($record['record_date']) ?></div>
                    <div class="drug-item">
                        <?= nl2br(htmlspecialchars($record['description'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
        
        
         <!-- <div style="margin-top: 100px;"  class="prescription-group">
          <div class="date-range">08/02/2025 - 09/03/2025</div>
          <div class="drug-item">
            <div class="drug-name">Why do we use it?
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</div>
          </div>
          
        </div> -->
    
        <!-- <div style="margin-top: 100px;"  class="prescription-group">
            <div class="date-range">08/02/2025 - 09/03/2025</div>
            <div class="drug-item">
              <div class="drug-name">Why do we use it?
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</div>
            </div>
            
          </div> -->

       
    </div>
    
     
     <nav class="bottom-nav">
        <a href="doctor_dashboard.php">
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