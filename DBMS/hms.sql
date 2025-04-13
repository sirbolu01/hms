-- Create users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('patient', 'doctor', 'admin', 'receptionist') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create patients table
CREATE TABLE patients (
    patient_id INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    address TEXT,
    phone_number VARCHAR(20),
    FOREIGN KEY (patient_id) REFERENCES users(user_id)
);

-- Create doctors table
CREATE TABLE doctors (
    doctor_id INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    -- specialty VARCHAR(100),
    -- years_of_experience INT,
    FOREIGN KEY (doctor_id) REFERENCES users(user_id)
);

-- Create appointments table
-- CREATE TABLE appointments (
--     appointment_id INT AUTO_INCREMENT PRIMARY KEY,
--     patient_id INT NOT NULL,
--     doctor_id INT NOT NULL,
--     appointment_date DATE NOT NULL,
--     appointment_time TIME NOT NULL,
--     status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
--     FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
-- );

-- Create medical records table
CREATE TABLE medical_records (
    record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    record_date DATE NOT NULL,
    description TEXT,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (created_by) REFERENCES doctors(doctor_id)
);

-- Create prescriptions table
CREATE TABLE prescriptions (
    prescription_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    prescription_date DATE NOT NULL,
    drug_name VARCHAR(100) NOT NULL,
    dosage VARCHAR(50),
    instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id)
);