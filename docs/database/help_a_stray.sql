-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 09:51 PM
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
-- Database: `help_a_stray`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `created_at`) VALUES
(3, 'admin', '$2y$10$m8z9yH7wJUKD.UCm/ylLYeM.hkoR3mwi9F4vJ3vM93MN801MISGXa', '2026-06-09 17:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `animal_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Available','Reserved','Adopted') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animal_id`, `name`, `species`, `breed`, `age`, `gender`, `description`, `image`, `status`, `created_at`) VALUES
(2, 'Sunshine', 'Cat', 'Domestic Short Hair', 1, 'Male', 'Calm and affectionate cat suitable for a quiet home.', '1781374367_baa0c873-5223-4fa7-82d1-cb82fabde077 (1).jpg', 'Available', '2026-06-04 19:49:37'),
(3, 'Bobby', 'Cat', 'Brittish Short Hair', 5, 'Male', 'Friendly and curious cat who enjoys interactive play and exploring indoor spaces.', '1781374624_e9b71ec3-dd8c-45af-9d56-a0729e1514f7.jpg', 'Available', '2026-06-04 19:49:37'),
(4, 'Icey', 'Cat', 'Domestic Short Hair', 3, 'Male', 'A gentle and friendly cat looking for a caring family.', '1781374272_93bf0ced-288e-4a02-b18a-33ec4e0c2c5a.jpg', 'Reserved', '2026-06-09 18:56:35'),
(7, 'Luna', 'Dog', 'Mixed breed', 4, 'Female', 'Female mixed-breed dog found as a stray. Owner unknown. Currently safe and awaiting identification or adoption.', '1781375955_b14138a0-f4d3-4175-aacf-d552aeccab6b.jpg', 'Available', '2026-06-13 18:39:15'),
(8, 'Milo', 'Dog', 'Mixed breed', 1, 'Male', 'Friendly 2-month-old male puppy. Playful, affectionate, and full of energy. Looking for a caring family that can provide love, attention, and a safe home.', '1781376753_6b71a114-cbf3-49bc-89d2-87b5d5ada856.jpg', 'Adopted', '2026-06-13 18:52:33'),
(9, 'Daisy', 'Dog', 'Mixed breed', 1, 'Female', 'Sweet and friendly 3-month-old mixed-breed puppy. Playful, affectionate, and full of energy. Looking for a loving forever home.', '1781377095_01110b83-5ad3-4ba4-a2cd-df81a0c26ca7.jpg', 'Adopted', '2026-06-13 18:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `housing_type` varchar(100) DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `animal_id`, `full_name`, `email`, `phone`, `address`, `housing_type`, `experience`, `status`, `application_date`) VALUES
(2, 2, 'Emily Carter', 'emily.carter@example.com', '07123456789', '12 Rose Street, Coventry', 'Flat, owned', 'I have previously cared for cats and understand the importance of regular feeding, grooming and veterinary care.', 'Pending', '2026-06-13 19:10:05'),
(3, 3, 'James Wilson', 'james.wilson@example.com', '07234567890', '45 Oak Avenue, Birmingham', 'House with garden', 'I have experience caring for rescue animals and can provide a stable and safe home environment.', 'Approved', '2026-06-13 19:11:02'),
(4, 7, 'Sarah Thompson', 'sarah.thompson@example.com', '07345678901', '8 Maple Road, Leicester', 'Rented flat', 'I have limited previous pet experience but I am interested in adopting and learning more.', 'Rejected', '2026-06-13 19:11:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animal_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `fk_application_animal` (`animal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_application_animal` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`animal_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
