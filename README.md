# Healthcare Management System (HMS)

## Overview

The **Healthcare Management System (HMS)** is a web-based application developed using PHP, MySQL, and HTML/CSS/JavaScript. It is designed to manage healthcare operations efficiently, offering role-based functionalities for patients, doctors, administrators, and receptionists. Key features include user authentication, appointment scheduling, medical record management, and prescription tracking, all supported by a secure and user-friendly interface.

This system aims to simplify interactions between healthcare providers and patients while maintaining a robust backend for data management.

---

## Features

- **User Authentication**: Secure login system with role-based access for patients, doctors, admins, and receptionists.
- **Patient Dashboard**: Access to appointments, medical history, and prescriptions.
- **Doctor Dashboard**: Tools to manage patient records, write prescriptions, and review appointments.
- **Admin Capabilities**: Oversight of users, doctors, and system operations.
- **Receptionist Role**: Support for front-desk tasks like patient check-ins and appointment coordination.
- **Medical Records**: Storage and retrieval of patient medical histories with timestamps and doctor details.
- **Prescriptions**: Management of patient medications, including dosage and instructions.
- **Responsive Design**: Mobile-friendly interface with intuitive navigation.

---

## Prerequisites

Ensure the following are installed before setting up the project:

- **PHP**: Version 8.2.12 or higher
- **MySQL**: Version 10.4.32-MariaDB or compatible
- **Web Server**: Apache (e.g., XAMPP, WAMP, or LAMP)
- **phpMyAdmin**: Optional but recommended for database management
- **Browser**: Modern browser (e.g., Chrome, Firefox) for testing

---

## Installation

### 1. Clone or Download the Project
- Download the ZIP file:
  
- Extract the project to your web server directory (e.g., `C:\xampp\htdocs\HMS_31_03_25`).

### 2. Set Up the Database
1. Open phpMyAdmin or your MySQL client.
2. Create a new database named `hms`:
   ```sql
   CREATE DATABASE hms;
   ```
3. Import the SQL dump file (`hms.sql`) into the `hms` database:
   - In phpMyAdmin: Select the `hms` database, go to "Import," and upload `hms.sql`.
   - Via MySQL command line:
     ```bash
     mysql -u your_username -p hms < path/to/hms.sql
     ```

### 3. Configure Database Connection
1. Locate and edit `db_connect.php` in the project root:
   ```php
   <?php
   $host = "localhost:add MySQL port no";
   $username = "root"; // Update with your MySQL username
   $password = "";     // Update with your MySQL password
   $database = "hms";

   $conn = new mysqli($host, $username, $password, $database);

   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

### 4. Start the Web Server
- Using XAMPP:
  1. Launch Apache and MySQL from the XAMPP Control Panel.
  2. Place the project folder in `C:\xampp\htdocs\`.
- Access the project in your browser:
  ```
  http://localhost/hms/
  ```

### 5. Test Default Credentials
- **Admin**: `admin@example.com` / `admin123`
- **Doctor**: `john.lock@example.com` / (hashed password; reset if needed)
- **Patient**: `sahid.khan@example.com` / `sahid123`
- Modify credentials or add users via the `users` table as required.

---

## Project Structure

```
HMS/
├── assets/
│   ├── css/
│   │   └── style.css        # Application stylesheet
│   ├── js/
│   │   └── script.js        # JavaScript for interactivity
│   └── images/
│       ├── hms_logo.png     # HMS logo
│       ├── user_icon.png    # Profile icon
│       └── icon.png         # Favicon
├── Doctor/
│   ├── doctor_addrecord.php # Add medical records
│   ├── doctor_dashboard.php # Doctor dashboard
│   └── ...                  # Additional doctor files
├── Patient/
│   ├── prescription.php     # View prescriptions
│   ├── dashboard.php        # Patient dashboard
│   └── ...                  # Additional patient files
├── db_connect.php           # Database connection script
└── ...                      # Other files (e.g., login, logout)
```

---

## Database Schema

The `hms` database includes the following tables:

### `users`
- Stores all users and their roles.
- **Columns**: `id`, `name`, `email`, `password`, `role`, `created_at`, `phone`, `gender`, `dob`, `address`

### `doctors`
- Links to doctor-specific details.
- **Columns**: `doctor_id` (FK to `users.id`), `full_name`

### `patients`
- Contains patient information.
- **Columns**: `id` (FK to `users.id`), `name`, `gender`, `dob`, `address`, `phone_number`, `email`

### `medical_records`
- Tracks patient medical history.
- **Columns**: `id`, `patient_id` (FK to `patients.id`), `record_date`, `description`, `created_by` (FK to `doctors.doctor_id`), `created_at`

### `prescriptions`
- Manages patient prescriptions.
- **Columns**: `prescription_id`, `patient_id` (FK to `patients.id`), `doctor_id` (FK to `doctors.doctor_id`), `prescription_date`, `drugs`, `dosage`, `instructions`, `created_at`, `start_date`, `end_date`, `description`

---

## Usage

1. **Login**: Use the appropriate login page (e.g., `patient_login.php` or `doctor_login.php`).
2. **Patient Features**:
   - View prescriptions at `Patient/prescription.php`.
   - Access medical history or appointments as implemented.
3. **Doctor Features**:
   - Add records via `Doctor/doctor_addrecord.php`.
   - Manage prescriptions and appointments.
4. **Admin/Receptionist**: Extend functionality based on your implementation.

---

## Common Issues and Troubleshooting

Running HMS on a local server with XAMPP may present challenges. Below are common issues and their solutions:

### Port Conflicts
- **Problem**: Apache (port 80/443) or MySQL (port 3306) fails to start due to another application using these ports (e.g., Skype, IIS).
- **Solution**:
  1. Check port usage:
     - Windows: `netstat -aon | findstr :80`
     - macOS/Linux: `lsof -i :80`
  2. Change ports in XAMPP:
     - Apache: Edit `C:\xampp\apache\conf\httpd.conf`, change `Listen 80` to `Listen 8080`.
     - MySQL: Edit `C:\xampp\mysql\bin\my.ini`, change `port=3306` to `port=3307`.
  3. Access HMS at `http://localhost:8080/HMS_31_03_25/` if port changed.

### XAMPP Services Not Starting
- **Problem**: Apache or MySQL fails with errors like "Apache shutdown unexpectedly."
- **Solution**:
  1. Check logs:
     - Apache: `C:\xampp\apache\logs\error.log`
     - MySQL: `C:\xampp\mysql\data\mysql_error.log`
  2. Kill conflicting processes via Task Manager or reinstall XAMPP if corrupted.

### Database Connection Issues
- **Problem**: Errors like "Access denied for user" or "Unknown database 'hms'."
- **Solution**:
  1. Verify `db_connect.php` credentials match your MySQL setup.
  2. Ensure the `hms` database is created and the SQL dump is imported via phpMyAdmin.

### PHP Version Mismatch
- **Problem**: HMS requires PHP 8.2.12, but XAMPP runs a different version.
- **Solution**: Install a XAMPP version with PHP 8.2.12 or adjust HMS code for compatibility.

### File Path or Permission Errors
- **Problem**: "404 Not Found" or permission denied errors.
- **Solution**:
  1. Confirm project is in `C:\xampp\htdocs\HMS_31_03_25`.
  2. Set folder permissions (Windows: Properties > Security; Linux/macOS: `chmod -R 755`).

### Firewall/Antivirus Blocking
- **Problem**: Localhost inaccessible despite services running.
- **Solution**: Add firewall exceptions for `httpd.exe` (Apache) and `mysqld.exe` (MySQL), or temporarily disable antivirus.

---

## Future Enhancements

- Add appointment scheduling features.
- Implement email notifications for appointments and prescriptions.
- Upgrade security with password hashing.
- Develop a full admin panel for system management.
- Enhance the UI with frameworks like Bootstrap.

