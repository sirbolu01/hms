<?php
// db_connect.php
define('DB_HOST', 'localhost:4306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hms');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>