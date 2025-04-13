-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 02:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `full_name`) VALUES
(2, 'Dr. John Lock'),
(3, 'Dr. Jane Doe');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `patient_id`, `record_date`, `description`, `created_by`, `created_at`) VALUES
(1, 5, '2023-10-01', 'Patient presented with flu-like symptoms. Prescribed Tamiflu.', 2, '2025-03-26 13:03:31'),
(2, 5, '2023-10-15', 'Follow-up visit. Patient recovered. No further treatment needed.', 2, '2025-03-26 13:03:31'),
(3, 6, '2023-09-20', 'Annual check-up. Blood pressure slightly elevated. Advised lifestyle changes.', 3, '2025-03-26 13:03:31'),
(4, 7, '2023-11-01', 'Patient reported chronic back pain. Ordered MRI scan.', 2, '2025-03-26 13:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `gender`, `dob`, `address`, `phone_number`, `email`) VALUES
(5, 'Sahid Khan', 'male', '1992-01-02', 'Somewhere in Sherfield England', '123-456-7890', ''),
(6, 'Jane Smith', 'female', '1985-05-15', '123 Main St, London', '234-567-8901', ''),
(7, 'Patric Janes', 'male', '1978-11-30', '456 Oak Ave, Manchester', '345-678-9012', '');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `prescription_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `prescription_date` date NOT NULL,
  `drugs` varchar(100) NOT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`prescription_id`, `patient_id`, `doctor_id`, `prescription_date`, `drugs`, `dosage`, `instructions`, `created_at`, `start_date`, `end_date`, `description`) VALUES
(1, 5, 2, '2023-10-01', 'Tamiflu', '75mg', 'Take one capsule twice daily for 5 days', '2025-03-26 13:03:31', NULL, NULL, '0'),
(2, 5, 2, '2023-10-01', 'Paracetamol', '500mg', 'Take one tablet every 6 hours as needed for fever', '2025-03-26 13:03:31', NULL, NULL, '0'),
(3, 6, 3, '2023-09-20', 'Lisinopril', '10mg', 'Take one tablet daily in the morning', '2025-03-26 13:03:31', NULL, NULL, '0'),
(4, 7, 2, '2023-11-01', 'Ibuprofen', '400mg', 'Take one tablet every 8 hours as needed for pain', '2025-03-26 13:03:31', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('patient','doctor','admin','receptionist') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` int(11) NOT NULL,
  `gender` varchar(55) NOT NULL,
  `dob` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `phone`, `gender`, `dob`, `address`) VALUES
(1, 'admin_user_001', 'admin@example.com', 'admin123', 'admin', '2025-03-26 13:02:29', 0, '', '', ''),
(2, 'dr_john_001', 'john.lock@example.com', '$2y$10$HRiNiPcVVjk3WYYlLxWHdemK6C9GgdkmlctNB3I7dSwbafVsB72ua', 'doctor', '2025-03-26 13:02:29', 0, '', '', ''),
(3, 'dr_jane_001', 'jane.doe@example.com', 'jane123', 'doctor', '2025-03-26 13:02:29', 0, '', '', ''),
(4, 'reception_jane_001', 'jane.drake@example.com', 'jane123', 'receptionist', '2025-03-26 13:02:29', 0, '', '', ''),
(5, 'patient_sahid_001', 'sahid.khan@example.com', 'sahid123', 'patient', '2025-03-26 13:02:29', 0, '', '', ''),
(6, 'patient_jane_001', 'jane.smith@example.com', 'jane123', 'patient', '2025-03-26 13:02:29', 0, '', '', ''),
(7, 'patient_patric_001', 'patric.janes@example.com', 'patric123', 'patient', '2025-03-26 13:02:29', 0, '', '', ''),
(15, 'Gasper Samuel', 'gasperwonder@gmail.com', '$2y$10$wZdIeSDsDi9Jna4jog5csuwZvFdVQeNKZfPqJzlvY5lGz.LPEq59O', 'admin', '2025-03-31 22:00:50', 2147483647, '', '', ''),
(16, 'Wonder Samuel', 'wondergasper@gmail.com', '$2y$10$gK8q/gV47kvVH3HaWcIFauZ91Dqf/1sHeGI5HikOXLi/HGeF6BiVm', 'patient', '2025-03-31 22:32:27', 0, 'male', '2025-03-31', 'Redemption camp pastor lodge block1b'),
(17, 'emma love', 'emmalove@gmail.com', '$2y$10$SSEswTdq8gKaEJnMOzTF0eZoM3xHP/DAny82c9BphY9G/WkmTh3wG', 'patient', '2025-04-01 10:50:38', 123456789, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`prescription_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `medical_records_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `doctors` (`doctor_id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
