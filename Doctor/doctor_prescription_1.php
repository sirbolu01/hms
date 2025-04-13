<?php
session_start();
require 'db_connect.php';

// Verify doctor authentication
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

$error = '';
$success = '';
$doctor_id = $_SESSION['user_id'];
$patient_id = $_GET['patient_id'] ?? null;

// Validate patient ID
if (!$patient_id || !ctype_digit($patient_id)) {
    die("Invalid patient ID");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drug = $_POST['drug'] ?? '';
    $date_range = $_POST['date_range'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validate date range format (YYYY-MM-DD to YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2} to \d{4}-\d{2}-\d{2}$/", $date_range)) {
        $error = "Invalid date format! Use YYYY-MM-DD to YYYY-MM-DD";
    } else {
        list($start_date, $end_date) = explode(" to ", $date_range);

        // Validate extracted dates
        if (!strtotime($start_date) || !strtotime($end_date)) {
            $error = "Invalid start or end date!";
        } else {
            // Insert prescription into database
            $stmt = $conn->prepare("
                INSERT INTO prescriptions 
                (patient_id, doctor_id, prescription_date, start_date, end_date, drugs, description) 
                VALUES (?, ?, CURDATE(), ?, ?, ?, ?)
            ");
            $stmt->bind_param("iissss", $patient_id, $doctor_id, $start_date, $end_date, $drug, $description);

            if ($stmt->execute()) {
                $success = "Prescription added successfully!";
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}
?>


<!-- doctor_prescription_1 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescriptions - Healthcare Management System</title>
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

    <div style="margin-top: 100px; margin-bottom: 120px;"  class="prescription-container">
         <center><div class="title">Prescription</div></center>
    
         <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

         <form method="POST" action="<?= $_SERVER['PHP_SELF'] . "?patient_id=$patient_id" ?>">

            <div class="form-group">
                <label class="form-label">Name of Drug</label>
                <input type="text" name="drug" class="form-input" placeholder="Name of Drug">
            </div>

            <!-- <div class="form-group">
                <label class="form-label">Start & End Date</label>
                <input type="text" name="date" class="form-input" placeholder="Start & End Date">
            </div> -->
            <div class="form-group">
    <label class="form-label">Start & End Date</label>
    <input type="text" id="dateRangePicker" name="date_range" class="form-input" placeholder="YYYY-MM-DD to YYYY-MM-DD" required>
</div>


            <div class="form-group">
                <textarea class="form-control" name="description" placeholder="Description" required rows="3"></textarea>
            </div>   

            <button type="submit" class="submit-btn">Add Prescription</button>
        </form>
       
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