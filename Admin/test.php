<?php
require 'db_connect.php';

// Update admin password
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = 'admin@hms.com'");
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
$stmt->bind_param('s', $hashed_password);
$stmt->execute();

echo "Passwords updated successfully!";
?>