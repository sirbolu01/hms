-- Insert users
INSERT INTO users (username, email, password, role) VALUES
('admin_user', 'admin@example.com', 'admin123', 'admin'),
('dr_john', 'john.lock@example.com', 'john123', 'doctor'),
('dr_jane', 'jane.doe@example.com', 'jane123', 'doctor'),
('reception_jane', 'jane.drake@example.com', 'jane123', 'receptionist'),
('patient_sahid', 'sahid.khan@example.com', 'sahid123', 'patient'),
('patient_jane', 'jane.smith@example.com', 'jane123', 'patient'),
('patient_patric', 'patric.janes@example.com', 'patric123', 'patient');

-- Insert patients
INSERT INTO patients (patient_id, full_name, gender, date_of_birth, address, phone_number) VALUES
(5, 'Sahid Khan', 'male', '1992-01-02', 'Somewhere in Sherfield England', '123-456-7890'),
(6, 'Jane Smith', 'female', '1985-05-15', '123 Main St, London', '234-567-8901'),
(7, 'Patric Janes', 'male', '1978-11-30', '456 Oak Ave, Manchester', '345-678-9012');

-- Insert doctors
INSERT INTO doctors (doctor_id, full_name) VALUES
(2, 'Dr. John Lock'),
(3, 'Dr. Jane Doe');

-- -- Insert appointments
-- INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status) VALUES
-- (5, 2, '2023-11-15', '10:00:00', 'confirmed'),
-- (5, 2, '2023-11-20', '14:30:00', 'pending'),
-- (6, 3, '2023-11-18', '09:15:00', 'confirmed'),
-- (7, 2, '2023-11-22', '11:45:00', 'pending');

-- Insert medical records
INSERT INTO medical_records (patient_id, record_date, description, created_by) VALUES
(5, '2023-10-01', 'Patient presented with flu-like symptoms. Prescribed Tamiflu.', 2),
(5, '2023-10-15', 'Follow-up visit. Patient recovered. No further treatment needed.', 2),
(6, '2023-09-20', 'Annual check-up. Blood pressure slightly elevated. Advised lifestyle changes.', 3),
(7, '2023-11-01', 'Patient reported chronic back pain. Ordered MRI scan.', 2);

-- Insert prescriptions
INSERT INTO prescriptions (patient_id, doctor_id, prescription_date, drug_name, dosage, instructions) VALUES
(5, 2, '2023-10-01', 'Tamiflu', '75mg', 'Take one capsule twice daily for 5 days'),
(5, 2, '2023-10-01', 'Paracetamol', '500mg', 'Take one tablet every 6 hours as needed for fever'),
(6, 3, '2023-09-20', 'Lisinopril', '10mg', 'Take one tablet daily in the morning'),
(7, 2, '2023-11-01', 'Ibuprofen', '400mg', 'Take one tablet every 8 hours as needed for pain');