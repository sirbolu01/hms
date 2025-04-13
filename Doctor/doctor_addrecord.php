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

// Fetch doctor details
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

if (!$doctor) {
    $doctor = ['name' => 'Unknown', 'email' => 'Not Available']; // Default values to avoid errors
}


// Handle form submission
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Validate inputs
//     $patient_id = $_POST['patient_id'] ?? '';
//     $record_date = $_POST['record_date'] ?? '';
//     $description = $_POST['description'] ?? '';

//     if (empty($patient_id) || empty($record_date) || empty($description)) {
//         $error = "All fields are required!";
//     } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
//         $error = "Invalid date format! Use YYYY-MM-DD";
//     } else {
//         // Insert record
//         $stmt = $conn->prepare("
//             INSERT INTO medical_records (patient_id, record_date, description)
//             VALUES (?, ?, ?)
//         ");
//         $stmt->bind_param("iss", $patient_id, $record_date, $description);

//         if ($stmt->execute()) {
//             $success = "Record added successfully!";
//         } else {
//             $error = "Database error: " . $stmt->error;
//         }
//     }
// }
 
// Handle form submission
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Validate inputs
//     $patient_id = $_POST['patient_id'] ?? '';
//     $record_date = $_POST['record_date'] ?? '';
//     $description = $_POST['description'] ?? '';

//     if (empty($patient_id) || empty($record_date) || empty($description)) {
//         $error = "All fields are required!";
//     } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
//         $error = "Invalid date format! Use YYYY-MM-DD";
//     } else {
//         // Validate patient_id before inserting
//         $stmt = $conn->prepare("SELECT id FROM patients WHERE id = ?");
//         $stmt->bind_param("i", $patient_id);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows === 0) {
//             $error = "Error: The selected patient does not exist.";
//         } else {
//             // Insert record
//             $stmt = $conn->prepare("
//                 INSERT INTO medical_records (patient_id, record_date, description)
//                 VALUES (?, ?, ?)
//             ");
//             $stmt->bind_param("iss", $patient_id, $record_date, $description);

//             if ($stmt->execute()) {
//                 $success = "Record added successfully!";
//             } else {
//                 $error = "Database error: " . $stmt->error;
//             }
//         }
//     }
// }


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Validate inputs
//     $patient_id = $_POST['patient_id'] ?? '';
//     $record_date = $_POST['record_date'] ?? '';
//     $description = $_POST['description'] ?? '';

//     if (empty($patient_id) || empty($record_date) || empty($description)) {
//         $error = "All fields are required!";
//     } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
//         $error = "Invalid date format! Use YYYY-MM-DD";
//     } else {
//         // Validate patient_id before inserting
//         $stmt = $conn->prepare("SELECT id FROM patients WHERE id = ?");
//         $stmt->bind_param("i", $patient_id);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows === 0) {
//             $error = "Error: The selected patient does not exist.";
//         } else {
//             // Ensure doctor ID exists
//             $stmt = $conn->prepare("SELECT doctor_id FROM doctors WHERE doctor_id = ?");
//             $stmt->bind_param("i", $doctor_id);
//             $stmt->execute();
//             $result = $stmt->get_result();

//             if ($result->num_rows === 0) {
//                 $error = "Error: Doctor not found in the database.";
//             } else {
//                 // Insert record with created_by (doctor_id)
//                 $stmt = $conn->prepare("
//                     INSERT INTO medical_records (patient_id, record_date, description, created_by)
//                     VALUES (?, ?, ?, ?)
//                 ");
//                 $stmt->bind_param("issi", $patient_id, $record_date, $description, $doctor_id);

//                 if ($stmt->execute()) {
//                     $success = "Record added successfully!";
//                 } else {
//                     $error = "Database error: " . $stmt->error;
//                 }
//             }
//         }
//     }
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $patient_id = $_POST['patient_id'] ?? '';
    $record_date = $_POST['record_date'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($patient_id) || empty($record_date) || empty($description)) {
        $error = "All fields are required!";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
        $error = "Invalid date format! Use YYYY-MM-DD";
    } else {
        // Validate patient existence in both `users` and `patients`
        $stmt = $conn->prepare("
            SELECT u.id AS user_id, p.id AS patient_id 
            FROM users u 
            LEFT JOIN patients p ON u.id = p.id 
            WHERE u.id = ? AND u.role = 'patient'
        ");
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $patient_data = $result->fetch_assoc();

        if (!$patient_data || !$patient_data['user_id']) {
            $error = "Error: Patient does not exist in users table.";
        } elseif (!$patient_data['patient_id']) {
            // Auto-insert patient into `patients` table if missing
            $insert_stmt = $conn->prepare("
                INSERT INTO patients (id, name, gender)
                SELECT id, name, 'unknown' FROM users WHERE id = ?
            ");
            $insert_stmt->bind_param("i", $patient_id);
            if ($insert_stmt->execute()) {
                $success = "Patient was missing in 'patients' table but has been added.";
            } else {
                $error = "Error adding patient to 'patients' table: " . $insert_stmt->error;
                exit;
            }
        }

        // Validate doctor existence and insert medical record
        if (!$error) {
            $stmt = $conn->prepare("SELECT doctor_id FROM doctors WHERE doctor_id = ?");
            $stmt->bind_param("i", $doctor_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $error = "Error: Doctor not found in the database.";
            } else {
                // Insert medical record
                $stmt = $conn->prepare("
                    INSERT INTO medical_records (patient_id, record_date, description, created_by)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bind_param("issi", $patient_id, $record_date, $description, $doctor_id);

                if ($stmt->execute()) {
                    $success = "Record added successfully!";
                } else {
                    $error = "Database error: " . $stmt->error;
                }
            }
        }
    }
}
// Get list of patients for dropdown
$patients = [];
$result = $conn->query("SELECT id, name FROM users WHERE role = 'patient'");
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}
?>

?>

<!-- doctor_addrecord.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Record - Healthcare Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/icon.png" type="image/x-icon">


      <!-- Custom Alert Styles -->
      <style>
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin: 16px 0;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>


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

            <!-- <div class="profile-name">Hello <?= htmlspecialchars($doctor['name']) ?></div>
            <div class="profile-email"><?= htmlspecialchars($doctor['email']) ?></div> -->
            <div class="profile-name">Hello <?= htmlspecialchars($doctor['name']) ?></div>
<div class="profile-email"><?= htmlspecialchars($doctor['email']) ?></div>

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
         <center><div class="title">Add to Record</div></center>

         <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
    
          <!-- <form class="booking-form"> -->
            <!-- <div class="section-title">New Record</div>  -->
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label>Patient</label>
                <select name="patient_id" class="form-input" required>
                    <option value="">Select Patient</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient['id'] ?>"><?= $patient['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Date</label>
                <input type="date" name="record_date" class="form-input" placeholder="Date">
            </div>

            <div class="form-group">
                <textarea name="description"class="form-control" placeholder="Description" required rows="5"></textarea>
            </div>   

            <button type="submit" class="submit-btn">Add to Record</button>
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

   <script>
        // Optional: Auto-hide messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => alert.style.display = 'none');
        }, 5000);
    </script>
</body>
</html>