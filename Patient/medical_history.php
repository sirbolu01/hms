
<?php
session_start();
require 'db_connect.php';

// Verify patient authentication
if (!isset($_SESSION['patient_logged_in'])) {
    header("Location: patient_login.php");
    exit();
}

// Fetch patient ID
$patient_id = $_SESSION['user_id'];

// Get medical records for this patient
$stmt = $conn->prepare("SELECT * FROM medical_records WHERE patient_id = ? ORDER BY record_date DESC");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!-- medical_history.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Medical History - Healthcare Management System</title>
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

            <h2 class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Patient') ?></h2>
            <p class="user-email"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>

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

    <div style="margin-top: 100px; margin-bottom: 120px;"  class="prescription-container">
         <center><div class="title">My Medical History</div></center>
    
        <!-- <div style="margin-top: 100px;"  class="prescription-group">
          <div class="date-range">08/02/2025 - 09/03/2025</div>
          <div class="drug-item">
            <div class="drug-name">Why do we use it?
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</div>
          </div>
          
        </div>
    
        <div style="margin-top: 100px;"  class="prescription-group">
            <div class="date-range">08/02/2025 - 09/03/2025</div>
            <div class="drug-item">
              <div class="drug-name">Why do we use it?
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</div>
            </div>
            
          </div>

       
    </div> -->

    <?php if (empty($records)): ?>
            <div class="alert alert-info">No medical records found</div>
        <?php else: ?>
            <?php foreach ($records as $record): ?>
                <div class="prescription-group">
                    <div class="date-range"><?= date("d/m/Y", strtotime($record['record_date'])) ?></div>
                    <div class="drug-item">
                        <div class="drug-name"><?= nl2br(htmlspecialchars($record['description'])) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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