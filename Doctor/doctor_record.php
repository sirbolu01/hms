<?php
session_start();
require 'db_connect.php';

// Verify doctor authentication
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

//  Fetch all patients with their latest record
$stmt = $conn->prepare("
    SELECT u.id, u.name, u.email, 
           MAX(mr.record_date) AS last_record_date,
           COUNT(mr.id) AS total_records
    FROM users u
    LEFT JOIN medical_records mr ON u.id = mr.patient_id
    WHERE u.role = 'patient'
    GROUP BY u.id
    ORDER BY u.name
");
$stmt->execute();
$patients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!-- doctor_record.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Records - Healthcare Management System</title>
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

    <section style="margin-top: 10px; margin-bottom: 120px;" class="patient-info">
        <div class="items-section">
        <div style="margin-top: 20px; margin-bottom: 20px;" class="header-section">
            <center><h2 class="section-title">Patient Records</h2></center>
        </div>
        <!-- <div class="record-container">
        <div class="title">Patient Records</div> -->
        
        <?php if (empty($patients)): ?>
            <div class="alert alert-info">No patients found</div>
        <?php else: ?>
            <div class="patient-list">
                <?php foreach ($patients as $patient): ?>
                    <div class="patient-card">
                        <div class="patient-header">
                            <div class="patient-name"><?= htmlspecialchars($patient['name']) ?></div>
                            <div class="patient-email"><?= htmlspecialchars($patient['email']) ?></div>
                        </div>
                        <div class="patient-details">
                            <div>Last Record: 
                                <?= $patient['last_record_date'] 
                                    ? htmlspecialchars($patient['last_record_date']) 
                                    : 'No records yet' 
                                ?>
                            </div>
                            <div>Total Records: <?= $patient['total_records'] ?></div>
                        </div>
                        <div class="patient-actions">
                            <a href="doctor_viewrecord.php?patient_id=<?= $patient['id'] ?>" 
                               class="btn btn-view">View Records</a>
                            <a href="doctor_addrecord.php" 
                               class="btn btn-add">Add Record</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
            <!-- <div class="items-container">

                <div class="item-card">
                    <h2 class="item-title">Sahid Khan</h2>
                    <a href="doctor_viewrecord.html" class="item-button">View Record</a>
                    <a href="doctor_addrecord.html" class="right-button">Add Record</a>
                </div>

                <div class="item-card">
                    <h2 class="item-title">Jane Doe</h2>
                    <a href="doctor_viewrecord.html" class="item-button">View Record</a>
                    <a href="doctor_addrecord.html" class="right-button">Add Record</a>
                </div>

                <div class="item-card">
                    <h2 class="item-title">Patric Janes</h2>
                    <a href="doctor_viewrecord.html" class="item-button">View Record</a>
                    <a href="doctor_addrecord.html" class="right-button">Add Record</a>
                </div>

            </div> -->

    </section>

     
     <nav class="bottom-nav">
        <a href="doctor_dashboard.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
       
        <a href="doctor_record.php" class="active">
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