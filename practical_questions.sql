-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2024 at 07:57 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ch_cbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `practical_questions`
--

CREATE TABLE `practical_questions` (
  `id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mark` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `practical_questions`
--

INSERT INTO `practical_questions` (`id`, `section_id`, `name`, `mark`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Explanation of purpose and procedure', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(2, 1, 'Taking of complaint and ascertain the client\'s age and locate the appropirate section', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(3, 1, 'Look up the client\'s condition in the table of content under the section and turn to the appropirate age', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(4, 1, 'Adequate history taking and recording (always elicit all the signs and symtoms in the complaint column)', 4, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(5, 1, 'Hand washing with soap, water and proper drying ', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(6, 1, 'Perform all the examinations as listed in the exmination column', 5, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(7, 1, 'Compitence in use of the examination instruments(diagnostic set)', 5, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(8, 1, 'Assemble and record all significant information including negative ones', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(9, 1, 'Based on your findings make clinical judgement', 5, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(10, 1, 'Take appropirate action based on clinical judgement(it may be necessary to refer to more than one section in standing orders to completely manage all the conditions ith which the client presents', 4, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(11, 1, 'Record correct drugs and dosage in the treatment card of home-based record', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(12, 1, 'Give appropirate instruction on medication and health education', 3, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(13, 1, 'Certify your treatement by appending your signature, date, designation and give back home-based records to the client/care giver', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(14, 1, 'Give instruction and follow-up visits', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(15, 2, 'Hand washing with soap, water and proper drying ', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(16, 2, 'Explanation of purpose and procedure to the client', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(17, 2, 'Checking of auriscope to ensure light is bright and speculum for the client', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(18, 2, 'Choosing the right size of speculum for the client', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(19, 2, 'Instruct the client to keep head steady', 1, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(20, 2, 'Inspection of the lobes for shape, infection, sores, discharge and foreign body', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(21, 2, 'inspect the ear for crusts, blood, scores, discharge and foreign body', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(22, 2, 'Correctly pulling the ear lobe to locate the ear drum', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(23, 2, 'Correct description of the normal ear drum as grey and shinny', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(24, 2, 'Recording of findings in the client\'s card', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(25, 2, 'Interpretation of findings', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35'),
(26, 2, 'Follow up instruction to patient', 2, 1, '2024-09-20 13:41:35', '2024-09-20 13:41:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `practical_questions`
--
ALTER TABLE `practical_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `practical_questions`
--
ALTER TABLE `practical_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
