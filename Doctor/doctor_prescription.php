<?php
session_start();
require 'db_connect.php';

// Verify doctor authentication
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

// Fetch all patients
$stmt = $conn->prepare("SELECT id, name FROM users WHERE role = 'patient'");
$stmt->execute();
$patients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>




<!-- doctor_prescription -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptions - Healthcare Management System</title>
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
            
            <h2 class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Doctor') ?></h2>
            <p class="user-email"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
            
            <!-- <h2 class="user-name">John Lock</h2>
            <p class="user-email">Johnlock@gmail.com</p> -->
     

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

    <section style="margin-top: 10px; margin-bottom: 120px;" class="patient-info">
        <div class="items-section">
        <div style="margin-top: 20px; margin-bottom: 20px;" class="header-section">
            <center><h2 class="section-title">Prescription</h2></center>
        </div>

            <div class="items-container">

                <?php foreach ($patients as $patient): ?>
                    <div class="item-card">
                        <h2 class="item-title"><?= htmlspecialchars($patient['name']) ?></>
                         <a href="doctor_prescription_1.php?patient_id=<?= $patient['id'] ?>" 
                        class="item-button">New Prescription</a>
                     </div>
                <?php endforeach; ?>


                <!-- <div class="item-card">
                    <h2 class="item-title">Sahid Khan</h2>
                    <a href="doctor_prescription_1.html" class="item-button">New Prescription</a>
                </div>

                <div class="item-card">
                    <h2 class="item-title">Jane Doe</h2>
                    <a href="doctor_prescription_1.html" class="item-button">New Prescription</a>
                </div>

                <div class="item-card">
                    <h2 class="item-title">Patric Janes</h2>
                    <a href="doctor_prescription_1.html" class="item-button">New Prescription</a>
                </div> -->

            </div>
    </section>
     
    <nav class="bottom-nav">
        <a href="doctor_dashboard.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
       
        <a href="doctor_record.php">
            <i class="fas fa-file"></i>
            <span>Patient Records</span>
        </a>

        <a href="doctor_prescription.php" class="active">
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