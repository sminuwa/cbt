-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 02, 2024 at 10:35 PM
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
-- Table structure for table `answeroptions_temps`
--

CREATE TABLE `answeroptions_temps` (
  `id` int(11) NOT NULL,
  `question_option` text DEFAULT NULL,
  `question_bank_temp_id` int(11) DEFAULT NULL,
  `correctness` enum('1','0') DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `answer_options`
--

CREATE TABLE `answer_options` (
  `id` int(11) NOT NULL,
  `question_option` text DEFAULT NULL,
  `question_bank_id` int(11) DEFAULT NULL,
  `correctness` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer_options`
--

INSERT INTO `answer_options` (`id`, `question_option`, `question_bank_id`, `correctness`, `created_at`, `updated_at`) VALUES
(1, 'Providing healthcare services to individuals and families.', 1, 1, '2024-09-10 12:17:10', '2024-09-10 12:17:10'),
(2, 'Developing new medical procedures.', 1, 0, '2024-09-10 12:17:10', '2024-09-10 12:17:10'),
(3, 'Conducting scientific research.', 1, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(4, 'Teaching medical students.', 1, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(5, 'Preventative care and health education.', 2, 1, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(6, 'Specialized medical treatment.', 2, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(7, 'Emergency care.', 2, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(8, 'Hospital-based services.', 2, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(9, 'Tuberculosis.', 3, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(10, 'Diabetes.', 3, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(11, 'Influenza.', 3, 1, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(12, 'Hypertension.', 3, 0, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(13, 'Respiratory infections.', 4, 1, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(14, 'Genetic disorders.', 4, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(15, 'Nutritional deficiencies.', 4, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(16, 'Chronic diseases.', 4, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(17, 'Education.', 5, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(18, 'Employment.', 5, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(19, 'Genetics.', 5, 1, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(20, 'Housing.', 5, 0, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(21, 'Body Mass Index.', 6, 1, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(22, 'Blood Measurement Indicator.', 6, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(23, 'Brain Mass Index.', 6, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(24, 'Bone Measurement Indicator.', 6, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(25, 'Vitamin A.', 7, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(26, 'Vitamin B.', 7, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(27, 'Vitamin C.', 7, 0, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(28, 'Vitamin D.', 7, 1, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(29, 'Malaria.', 8, 1, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(30, 'Diabetes.', 8, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(31, 'Hypertension.', 8, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(32, 'Asthma.', 8, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(33, 'Vitamin A.', 9, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(34, 'Vitamin B12.', 9, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(35, 'Vitamin K.', 9, 1, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(36, 'Vitamin C.', 9, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(37, 'Perceived susceptibility.', 10, 0, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(38, 'Perceived severity.', 10, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(39, 'Perceived benefits.', 10, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(40, 'Perceived intelligence.', 10, 1, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(41, 'Cataracts.', 11, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(42, 'Vitamin A deficiency.', 11, 1, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(43, 'Glaucoma.', 11, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(44, 'Diabetes.', 11, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(45, 'Heart disease.', 12, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(46, 'Tuberculosis.', 12, 1, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(47, 'Diabetes.', 12, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(48, 'Osteoporosis.', 12, 0, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(49, 'Kidney.', 13, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(50, 'Heart.', 13, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(51, 'Liver.', 13, 1, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(52, 'Brain.', 13, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(53, 'Vaccination.', 14, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(54, 'Proper sanitation.', 14, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(55, 'Use of mosquito nets.', 14, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(56, 'Isolation of infected individuals.', 14, 1, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(57, 'High blood pressure.', 15, 0, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(58, 'Low weight for age.', 15, 1, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(59, 'High cholesterol levels.', 15, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(60, 'Increased appetite.', 15, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(61, 'Hypertension.', 16, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(62, 'Cancer.', 16, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(63, 'Tuberculosis.', 16, 1, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(64, 'Diabetes.', 16, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(65, 'Skin.', 17, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(66, 'Bones.', 17, 1, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(67, 'Muscles.', 17, 0, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(68, 'Eyes.', 17, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(69, 'Malaria.', 18, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(70, 'Cholera.', 18, 1, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(71, 'Influenza.', 18, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(72, 'Tetanus.', 18, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(73, '1-2 days.', 19, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(74, '1-2 weeks.', 19, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(75, '1-6 months.', 19, 1, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(76, '1-2 years.', 19, 0, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(77, 'Disease prevention.', 20, 0, '2024-09-10 12:17:19', '2024-09-10 12:17:19'),
(78, 'Health promotion.', 20, 0, '2024-09-10 12:17:19', '2024-09-10 12:17:19'),
(79, 'Individualized patient care.', 20, 1, '2024-09-10 12:17:19', '2024-09-10 12:17:19'),
(80, 'Health policy development.', 20, 0, '2024-09-10 12:17:19', '2024-09-10 12:17:19'),
(101, 'Chemotherapy.', 26, 0, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(102, 'Vaccination.', 26, 1, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(103, 'Rehabilitation.', 26, 0, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(104, 'Surgery.', 26, 0, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(105, 'Virus.', 27, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(106, 'Bacterium.', 27, 1, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(107, 'Fungus.', 27, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(108, 'Parasite.', 27, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(109, '40-60 mg/dL.', 28, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(110, '70-100 mg/dL.', 28, 1, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(111, '120-140 mg/dL.', 28, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(112, '160-180 mg/dL.', 28, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(113, 'Health education.', 29, 0, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(114, 'Early diagnosis and treatment.', 29, 1, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(115, 'Rehabilitation.', 29, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(116, 'Palliative care.', 29, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(117, 'Asthma.', 30, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(118, 'Stroke.', 30, 1, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(119, 'Osteoporosis.', 30, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(120, 'Tuberculosis.', 30, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(121, 'Vitamin A.', 31, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(122, 'Vitamin B12.', 31, 1, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(123, 'Vitamin C.', 31, 0, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(124, 'Vitamin D.', 31, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(125, 'Chest pain.', 32, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(126, 'Chronic cough with sputum production.', 32, 1, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(127, 'Abdominal pain.', 32, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(128, 'Blurred vision.', 32, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(129, 'Regular exercise.', 33, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(130, 'High cholesterol levels.', 33, 1, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(131, 'Balanced diet.', 33, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(132, 'Adequate sleep.', 33, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(133, 'Airborne transmission.', 34, 0, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(134, 'Blood and bodily fluids.', 34, 1, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(135, 'Waterborne transmission.', 34, 0, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(136, 'Vector-borne transmission.', 34, 0, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(137, 'Heart.', 35, 0, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(138, 'Liver.', 35, 1, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(139, 'Kidney.', 35, 0, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(140, 'Pancreas.', 35, 0, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(189, 'Pumping blood throughout the body.', 48, 1, '2024-09-10 12:17:30', '2024-09-10 12:17:30'),
(190, 'Producing hormones.', 48, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(191, 'Digesting food.', 48, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(192, 'Filtering waste from the blood.', 48, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(193, 'Vitamin A.', 49, 1, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(194, 'Vitamin B12.', 49, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(195, 'Vitamin C.', 49, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(196, 'Vitamin D.', 49, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(197, '36.5-37.5&deg;C.', 50, 1, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(198, '32-34&deg;C.', 50, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(199, '40-42&deg;C.', 50, 0, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(200, '28-30&deg;C.', 50, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(201, 'Liver.', 51, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(202, 'Heart.', 51, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(203, 'Kidney.', 51, 1, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(204, 'Lungs.', 51, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(205, 'Frequent urination.', 52, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(206, 'Dry mouth.', 52, 1, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(207, 'High blood pressure.', 52, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(208, 'Increased appetite.', 52, 0, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(209, 'To treat diseases.', 53, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(210, 'To diagnose diseases.', 53, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(211, 'To prevent diseases.', 53, 1, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(212, 'To cure diseases.', 53, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(213, 'Iron.', 54, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(214, 'Calcium.', 54, 1, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(215, 'Potassium.', 54, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(216, 'Magnesium.', 54, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(217, 'Chest pain.', 55, 0, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(218, 'Fever.', 55, 1, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(219, 'High blood sugar.', 55, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(220, 'Joint swelling.', 55, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(221, 'Human Immunodeficiency Virus.', 56, 1, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(222, 'Human Infectious Virus.', 56, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(223, 'High Immune Virus.', 56, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(224, 'Health-Inducing Virus.', 56, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(225, 'Vitamin A.', 57, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(226, 'Vitamin D.', 57, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(227, 'Vitamin C.', 57, 1, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(228, 'Vitamin E.', 57, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(229, '90/60 mmHg.', 58, 0, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(230, '120/80 mmHg.', 58, 1, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(231, '140/90 mmHg.', 58, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(232, '160/100 mmHg.', 58, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(233, 'Oxygen exchange.', 59, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(234, 'Carbon dioxide removal.', 59, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(235, 'Blood filtration.', 59, 1, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(236, 'Breathing regulation.', 59, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(237, 'Liver.', 60, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(238, 'Pancreas.', 60, 1, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(239, 'Kidney.', 60, 0, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(240, 'Heart.', 60, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(241, 'Hemoglobin.', 61, 1, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(242, 'Plasma.', 61, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(243, 'White blood cells.', 61, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(244, 'Platelets.', 61, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(245, 'Veins.', 62, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(246, 'Arteries.', 62, 1, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(247, 'Capillaries.', 62, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(248, 'Venules.', 62, 0, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(381, 'Heart.', 96, 0, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(382, 'Skin.', 96, 1, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(383, 'Liver.', 96, 0, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(384, 'Lungs.', 96, 0, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(385, 'To fight infections.', 97, 0, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(386, 'To transport oxygen.', 97, 1, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(387, 'To clot blood.', 97, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(388, 'To regulate body temperature.', 97, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(389, 'Nephron.', 98, 1, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(390, 'Neuron.', 98, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(391, 'Alveoli.', 98, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(392, 'Osteon.', 98, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(393, 'A.', 99, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(394, 'B.', 99, 0, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(395, 'AB.', 99, 0, '2024-09-10 12:17:55', '2024-09-10 12:17:55'),
(396, 'O.', 99, 1, '2024-09-10 12:17:55', '2024-09-10 12:17:55'),
(397, 'Thyroxine.', 100, 0, '2024-09-10 12:17:55', '2024-09-10 12:17:55'),
(398, 'Insulin.', 100, 1, '2024-09-10 12:17:55', '2024-09-10 12:17:55'),
(399, 'Adrenaline.', 100, 0, '2024-09-10 12:17:55', '2024-09-10 12:17:55'),
(400, 'Estrogen.', 100, 0, '2024-09-10 12:17:55', '2024-09-10 12:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_candidate_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `candidate_id` bigint(20) NOT NULL,
  `paper_id` bigint(20) UNSIGNED NOT NULL,
  `sign_in` int(10) DEFAULT 0,
  `sign_out` int(10) NOT NULL DEFAULT 0,
  `remark` varchar(100) DEFAULT NULL,
  `year` int(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_remarks`
--

CREATE TABLE `attendance_remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_remarks`
--

INSERT INTO `attendance_remarks` (`id`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'AE', 'Absent with Excuse', '2023-09-26 10:20:01', '2023-09-26 10:20:01'),
(2, 'AW', 'Absent without Excuse', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(3, 'ABS', 'Absenteeism', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(4, 'S', 'Sick', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(5, 'PI', 'Project Incomplete', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(6, 'VW', 'Voluntary Withdraw', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(7, 'SO', 'Spill Over', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(8, 'EM', 'Exams Malpractice', '2023-09-26 10:23:38', '2023-09-26 10:23:38'),
(9, 'VS', 'Violence against Staff/Student', '2023-09-26 10:23:38', '2023-09-26 10:23:38');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) UNSIGNED NOT NULL,
  `indexing` varchar(50) DEFAULT NULL,
  `programme_id` bigint(20) NOT NULL,
  `firstname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_names` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Female','Male') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(23) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lga_id` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `exam_year` int(11) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_subjects`
--

CREATE TABLE `candidate_subjects` (
  `id` bigint(20) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `scheduled_candidate_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` int(11) NOT NULL COMMENT 'indicate the subjects to be taken by the candidate in case of multisubject exams. eg putme',
  `add_index` int(20) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `centres`
--

CREATE TABLE `centres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `api_key` varchar(100) DEFAULT NULL,
  `secret_key` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sample_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `centres`
--

INSERT INTO `centres` (`id`, `name`, `location`, `status`, `api_key`, `secret_key`, `password`, `remember_token`, `api_token`, `created_at`, `updated_at`, `sample_token`) VALUES
(1, '066 - EMIRATE COLLEGE OF HEALTH TECHNOLOGY, KANO (echt66)', '066 - EMIRATE COLLEGE OF HEALTH TECHNOLOGY, KANO (echt66)', 'Active', 'echt066', '660thce', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:36:51', '2024-09-10 07:36:51', NULL),
(2, '149 - ILA COLLEGE OF HEALTH TECHNOLOGY KUJE (ichtk149)', '149 - ILA COLLEGE OF HEALTH TECHNOLOGY KUJE (ichtk149)', 'Active', 'ichtk149', '149ichtk', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:37:11', '2024-09-10 07:37:11', NULL),
(3, '201 - AL\'UMMA COLLEGE OF HEALTH AND SOCIAL SCIENCES (achss201)', '201 - AL\'UMMA COLLEGE OF HEALTH AND SOCIAL SCIENCES (achss201)', 'Active', 'achss201', '201achss', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:40:39', '2024-09-10 07:40:39', NULL),
(4, '092 - JUBILATION COLLEGE OF HEALTH TECHNOLOGY, MASAKA (jchtm092)', '092 - JUBILATION COLLEGE OF HEALTH TECHNOLOGY, MASAKA (jchtm092)', 'Active', 'jchtm092', '092jchtm', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:49:03', '2024-09-10 07:49:03', NULL),
(5, '022 - SCHOOL OF HEALTH TECHNOLOGY,KANO (sht022)', '022 - SCHOOL OF HEALTH TECHNOLOGY,KANO (sht022)', 'Active', 'sht022', '022sht', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:37:11', '2024-09-10 07:37:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `dept_type` int(1) NOT NULL DEFAULT 0 COMMENT '0 for degree awarding, 1 for others, 2 for both',
  `department_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `other_names` varchar(30) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `date_of_first_appointment` date NOT NULL,
  `rank_on_employment` int(11) NOT NULL,
  `salary_on_appointment` varchar(5) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality` int(11) NOT NULL DEFAULT 156,
  `lga` int(11) DEFAULT 100,
  `place_of_birth` varchar(45) DEFAULT NULL,
  `marital_status` enum('Married','Single','Divorced','Widow','Separated') DEFAULT NULL,
  `gender` enum('Female','Male') NOT NULL,
  `permanent_address` varchar(100) DEFAULT NULL,
  `personnel_no` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `endorsements`
--

CREATE TABLE `endorsements` (
  `id` int(11) NOT NULL,
  `scheduled_candidate_id` bigint(20) UNSIGNED NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `pass_key` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams_dates`
--

CREATE TABLE `exams_dates` (
  `id` int(20) UNSIGNED NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams_date_faculty_mappings`
--

CREATE TABLE `exams_date_faculty_mappings` (
  `id` int(20) UNSIGNED NOT NULL,
  `scheduling_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams_date_programme_mappings`
--

CREATE TABLE `exams_date_programme_mappings` (
  `id` int(20) UNSIGNED NOT NULL,
  `scheduling_id` int(11) DEFAULT NULL,
  `programme_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exams_date_state_mappings`
--

CREATE TABLE `exams_date_state_mappings` (
  `id` int(20) UNSIGNED NOT NULL,
  `scheduling_id` int(11) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` int(11) NOT NULL COMMENT 'this table stores types of candidate eg utme, student, employment  applicant, employee promotion',
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'CHPRBN National Examination', '2024-10-02 14:57:24', '2024-10-02 14:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `complex_id` int(11) NOT NULL,
  `is_other_institutes` tinyint(1) DEFAULT NULL,
  `faculty_code` varchar(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `complex_id`, `is_other_institutes`, `faculty_code`, `created_at`, `updated_at`) VALUES
(1, 'Faculty A', 1, NULL, 'FA', '2024-06-10 10:36:33', '2024-06-10 10:36:33'),
(2, 'Faculty B', 1, NULL, 'FB', '2024-06-10 10:36:33', '2024-06-10 10:36:33'),
(3, 'Faculty C', 1, NULL, 'FC', '2024-06-10 10:36:33', '2024-06-10 10:36:33'),
(4, 'Faculty D', 1, NULL, 'FD', '2024-06-10 10:36:33', '2024-06-10 10:36:33'),
(5, 'Faculty E', 1, NULL, 'FE', '2024-06-10 10:36:33', '2024-06-10 10:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_schedule_mappings`
--

CREATE TABLE `faculty_schedule_mappings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `scheduling_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_schedule_mappings`
--

INSERT INTO `faculty_schedule_mappings` (`id`, `faculty_id`, `scheduling_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-06-10 10:52:43', '2024-06-10 10:52:43'),
(4, 2, 1, '2024-06-10 11:39:39', '2024-06-10 11:39:39'),
(5, 3, 2, '2024-06-10 12:58:09', '2024-06-10 12:58:09'),
(6, 4, 2, '2024-06-10 12:58:09', '2024-06-10 12:58:09'),
(7, 5, 2, '2024-06-10 12:58:09', '2024-06-10 12:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feed_backs`
--

CREATE TABLE `feed_backs` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `scheduled_candidate_id` bigint(20) UNSIGNED NOT NULL,
  `comments` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE `hosts` (
  `id` int(11) NOT NULL,
  `ip_uv` varchar(50) DEFAULT NULL,
  `ip_lv` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hosts`
--

INSERT INTO `hosts` (`id`, `ip_uv`, `ip_lv`, `created_at`, `updated_at`) VALUES
(1, '934', '890', '2024-06-08 19:34:31', '2024-06-08 19:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `jambs`
--

CREATE TABLE `jambs` (
  `id` int(11) NOT NULL,
  `reg_number` varchar(100) NOT NULL,
  `candidate_name` varchar(100) NOT NULL,
  `state_id` varchar(100) NOT NULL,
  `lga_id` varchar(100) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `age` int(50) NOT NULL,
  `eng_score` int(50) NOT NULL,
  `subj_2` varchar(50) NOT NULL,
  `subj_2_Score` int(50) NOT NULL,
  `subj_3` varchar(50) NOT NULL,
  `subj_3_Score` int(50) NOT NULL,
  `subj_4` varchar(50) NOT NULL,
  `subj_4_Score` int(50) NOT NULL,
  `total_Score` int(50) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `programme_id` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lgas`
--

CREATE TABLE `lgas` (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `state_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_30_105437_create_answer_options_table', 0),
(5, '2024_03_30_105437_create_answeroptions_temps_table', 0),
(6, '2024_03_30_105437_create_cache_table', 0),
(7, '2024_03_30_105437_create_cache_locks_table', 0),
(8, '2024_03_30_105437_create_candidate_students_table', 0),
(9, '2024_03_30_105437_create_centres_table', 0),
(10, '2024_03_30_105437_create_departments_table', 0),
(11, '2024_03_30_105437_create_employees_table', 0),
(12, '2024_03_30_105437_create_endorsements_table', 0),
(13, '2024_03_30_105437_create_exam_types_table', 0),
(14, '2024_03_30_105437_create_exams_date_faculty_mappings_table', 0),
(15, '2024_03_30_105437_create_exams_date_programme_mappings_table', 0),
(16, '2024_03_30_105437_create_exams_date_state_mappings_table', 0),
(17, '2024_03_30_105437_create_exams_dates_table', 0),
(18, '2024_03_30_105437_create_faculties_table', 0),
(19, '2024_03_30_105437_create_faculty_schedule_mappings_table', 0),
(20, '2024_03_30_105437_create_failed_jobs_table', 0),
(21, '2024_03_30_105437_create_feed_backs_table', 0),
(22, '2024_03_30_105437_create_hosts_table', 0),
(23, '2024_03_30_105437_create_jambs_table', 0),
(24, '2024_03_30_105437_create_job_batches_table', 0),
(25, '2024_03_30_105437_create_jobs_table', 0),
(26, '2024_03_30_105437_create_lgas_table', 0),
(27, '2024_03_30_105437_create_login_datas_table', 0),
(28, '2024_03_30_105437_create_password_reset_tokens_table', 0),
(29, '2024_03_30_105437_create_permissions_table', 0),
(30, '2024_03_30_105437_create_programme_types_table', 0),
(31, '2024_03_30_105437_create_programmes_table', 0),
(32, '2024_03_30_105437_create_question_bank_temps_table', 0),
(33, '2024_03_30_105437_create_question_banks_table', 0),
(34, '2024_03_30_105437_create_role_permissions_table', 0),
(35, '2024_03_30_105437_create_roles_table', 0),
(36, '2024_03_30_105437_create_sbrs_groups_table', 0),
(37, '2024_03_30_105437_create_sbrs_students_table', 0),
(38, '2024_03_30_105437_create_scheduled_candidates_table', 0),
(39, '2024_03_30_105437_create_schedulings_table', 0),
(40, '2024_03_30_105437_create_sessions_table', 0),
(41, '2024_03_30_105437_create_states_table', 0),
(42, '2024_03_30_105437_create_subjects_table', 0),
(43, '2024_03_30_105437_create_test_codes_table', 0),
(44, '2024_03_30_105437_create_test_compositors_table', 0),
(45, '2024_03_30_105437_create_test_configs_table', 0),
(46, '2024_03_30_105437_create_test_invigilators_table', 0),
(47, '2024_03_30_105437_create_test_questions_table', 0),
(48, '2024_03_30_105437_create_test_sections_table', 0),
(49, '2024_03_30_105437_create_test_subjects_table', 0),
(50, '2024_03_30_105437_create_test_types_table', 0),
(51, '2024_03_30_105437_create_time_controls_table', 0),
(52, '2024_03_30_105437_create_topics_table', 0),
(53, '2024_03_30_105437_create_user_permissions_table', 0),
(54, '2024_03_30_105437_create_user_roles_table', 0),
(55, '2024_03_30_105437_create_users_table', 0),
(56, '2024_03_30_105437_create_venue_computers_table', 0),
(57, '2024_03_30_105437_create_venues_table', 0),
(58, '2024_03_30_105440_add_foreign_keys_to_answer_options_table', 0),
(59, '2024_03_30_105440_add_foreign_keys_to_candidate_students_table', 0),
(60, '2024_03_30_105440_add_foreign_keys_to_departments_table', 0),
(61, '2024_03_30_105440_add_foreign_keys_to_employees_table', 0),
(62, '2024_03_30_105440_add_foreign_keys_to_endorsements_table', 0),
(63, '2024_03_30_105440_add_foreign_keys_to_exams_date_faculty_mappings_table', 0),
(64, '2024_03_30_105440_add_foreign_keys_to_exams_date_programme_mappings_table', 0),
(65, '2024_03_30_105440_add_foreign_keys_to_exams_date_state_mappings_table', 0),
(66, '2024_03_30_105440_add_foreign_keys_to_exams_dates_table', 0),
(67, '2024_03_30_105440_add_foreign_keys_to_faculty_schedule_mappings_table', 0),
(68, '2024_03_30_105440_add_foreign_keys_to_feed_backs_table', 0),
(69, '2024_03_30_105440_add_foreign_keys_to_lgas_table', 0),
(70, '2024_03_30_105440_add_foreign_keys_to_programmes_table', 0),
(71, '2024_03_30_105440_add_foreign_keys_to_question_banks_table', 0),
(72, '2024_03_30_105440_add_foreign_keys_to_role_permissions_table', 0),
(73, '2024_03_30_105440_add_foreign_keys_to_scheduled_candidates_table', 0),
(74, '2024_03_30_105440_add_foreign_keys_to_schedulings_table', 0),
(75, '2024_03_30_105440_add_foreign_keys_to_subjects_table', 0),
(76, '2024_03_30_105440_add_foreign_keys_to_test_compositors_table', 0),
(77, '2024_03_30_105440_add_foreign_keys_to_test_configs_table', 0),
(78, '2024_03_30_105440_add_foreign_keys_to_test_invigilators_table', 0),
(79, '2024_03_30_105440_add_foreign_keys_to_test_questions_table', 0),
(80, '2024_03_30_105440_add_foreign_keys_to_test_sections_table', 0),
(81, '2024_03_30_105440_add_foreign_keys_to_test_subjects_table', 0),
(82, '2024_03_30_105440_add_foreign_keys_to_time_controls_table', 0),
(83, '2024_03_30_105440_add_foreign_keys_to_topics_table', 0),
(84, '2024_03_30_105440_add_foreign_keys_to_user_permissions_table', 0),
(85, '2024_03_30_105440_add_foreign_keys_to_user_roles_table', 0),
(86, '2024_03_30_105440_add_foreign_keys_to_venues_table', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin.exams.setup.index', 'admin.exams.setup.index', NULL, NULL),
(2, 'toolbox.invigilator.index', 'toolbox.invigilator.index', NULL, NULL),
(3, 'admin.exams.setup.push', 'admin.exams.setup.push', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `expires_at`, `last_used_at`, `created_at`, `updated_at`) VALUES
(56, 'App\\Models\\Admin\\User', 1, 'token-name', 'f2b902df37e5373f35f24d344f4e2757d462eb655884e28fe489b0d11e1dec76', '[\"server:mobile-app\"]', NULL, '2023-12-31 17:31:24', '2023-12-31 17:31:23', '2023-12-31 17:31:24'),
(78, 'App\\Models\\Practitioner\\Practitioner', 1, 'mobile-app-access', '0c97b3aa0fed868b1dedcbeda36e0aae909aa993e689d1ff31a2a7e2482d6046', '[\"server:mobile-app\"]', NULL, '2024-01-04 15:42:23', '2024-01-04 15:20:59', '2024-01-04 15:42:23'),
(81, 'App\\Models\\Centre', 1, 'mobile-app-access', 'aa5a1699db0d965d692340239e28d84476918d68438fd614995b27c04d58395e', '[\"server:mobile-app\"]', NULL, '2024-09-17 13:28:06', '2024-09-17 10:53:46', '2024-09-17 13:28:06'),
(82, 'App\\Models\\Centre', 2, 'mobile-app-access', '289286f2d54a61ee6f631ff8b935b54911966968c33d0bc4c2a518345a638f5b', '[\"server:mobile-app\"]', NULL, '2024-09-17 13:28:38', '2024-09-17 13:28:28', '2024-09-17 13:28:38'),
(86, 'App\\Models\\Centre', 18, 'mobile-app-access', '07a12a7ac9c17f963a2e30750a32a8bfaa576e586ba7b298af0d201b4730561d', '[\"server:mobile-app\"]', NULL, '2024-09-20 23:14:51', '2024-09-20 14:57:27', '2024-09-20 23:14:51'),
(87, 'App\\Models\\Centre', 1, 'mobile-app-access', '9de4c9ea2f45b010fe8dc7965d95d05aba27ff0476c59885d85c816d4023b2af', '[\"server:mobile-app\"]', NULL, NULL, '2024-10-02 13:30:56', '2024-10-02 13:30:56'),
(88, 'App\\Models\\Centre', 1, 'mobile-app-access', '8bc3ffbce3b131c9216b8c6c3376e4bf142f568a0fcbd99c8f8d7d2d709106ce', '[\"server:mobile-app\"]', NULL, '2024-10-02 18:07:30', '2024-10-02 16:32:31', '2024-10-02 18:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `practical_examinations`
--

CREATE TABLE `practical_examinations` (
  `id` bigint(20) NOT NULL,
  `scheduled_candidate_id` bigint(20) NOT NULL,
  `candidate_id` bigint(20) NOT NULL,
  `practical_question_id` bigint(20) NOT NULL,
  `paper_id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `score` decimal(10,2) NOT NULL,
  `examiner` bigint(20) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `practical_sections`
--

CREATE TABLE `practical_sections` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `practical_sections`
--

INSERT INTO `practical_sections` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MANAGEMENT OF COMMON COMPLAINTS USING STANDING ORDERS', 1, '2024-09-20 13:38:45', '2024-09-20 13:38:45'),
(2, 'USE OF AURISCOPE FOR EAR EXAMINATION', 1, '2024-09-20 13:38:45', '2024-09-20 13:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `presentations`
--

CREATE TABLE `presentations` (
  `id` bigint(20) NOT NULL,
  `scheduled_candidate_id` bigint(20) NOT NULL,
  `test_config_id` bigint(20) NOT NULL,
  `test_section_id` bigint(20) UNSIGNED NOT NULL,
  `question_bank_id` bigint(20) NOT NULL,
  `answer_option_id` bigint(20) NOT NULL,
  `pushed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

CREATE TABLE `programmes` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `duration` varchar(15) NOT NULL,
  `programme_type_id` int(11) NOT NULL,
  `art_science` varchar(8) DEFAULT NULL,
  `hprog_type_code` varchar(2) DEFAULT NULL,
  `pcode` varchar(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `programme_types`
--

CREATE TABLE `programme_types` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_assessments`
--

CREATE TABLE `project_assessments` (
  `id` bigint(20) NOT NULL,
  `scheduled_candidate_id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `candidate_id` bigint(20) NOT NULL,
  `paper_id` bigint(20) NOT NULL,
  `score` decimal(10,2) NOT NULL DEFAULT 0.00,
  `examiner` bigint(20) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pull_statuses`
--

CREATE TABLE `pull_statuses` (
  `⁠ id ⁠` int(11) NOT NULL,
  `resource` varchar(255) DEFAULT NULL,
  `pull_date` datetime DEFAULT NULL,
  `status` enum('SUCCESS','FAILURE','PENDING') DEFAULT 'PENDING',
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_banks`
--

CREATE TABLE `question_banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `difficulty_level` enum('simple','difficult','moderate') DEFAULT 'simple',
  `questiontime` datetime DEFAULT NULL,
  `active` enum('true','false') DEFAULT 'true',
  `author` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `topic` varchar(45) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_banks`
--

INSERT INTO `question_banks` (`id`, `title`, `difficulty_level`, `questiontime`, `active`, `author`, `subject_id`, `topic`, `topic_id`, `created_at`, `updated_at`) VALUES
(1, 'Which of the following is a primary role of a community health practitioner? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:10', '2024-09-10 12:17:10'),
(2, 'What is the main focus of primary healthcare? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(3, 'Which of the following diseases is primarily prevented through vaccination? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:11', '2024-09-10 12:17:11'),
(4, 'Hand hygiene is important in preventing the spread of which type of infections? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(5, 'Which of the following is NOT a social determinant of health? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:12', '2024-09-10 12:17:12'),
(6, 'What does BMI stand for in health assessments? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(7, 'Which vitamin is crucial for the prevention of rickets? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:13', '2024-09-10 12:17:13'),
(8, 'Which of the following is a vector-borne disease? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(9, 'Which nutrient is essential for blood clotting? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(10, 'Which of the following is NOT a component of the health belief model? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:14', '2024-09-10 12:17:14'),
(11, 'What is the leading cause of preventable blindness in children worldwide? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(12, 'Which of the following is an example of a communicable disease? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:15', '2024-09-10 12:17:15'),
(13, 'Which body organ is primarily affected by hepatitis? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(14, 'What is the primary method of preventing the spread of tuberculosis? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(15, 'Which of the following is a key indicator of malnutrition in children? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:16', '2024-09-10 12:17:16'),
(16, 'Which of the following is NOT a non-communicable disease? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(17, 'Which part of the body is most commonly affected by osteoporosis? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:17', '2024-09-10 12:17:17'),
(18, 'Which of the following is a waterborne disease? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(19, 'What is the incubation period for hepatitis B? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:18', '2024-09-10 12:17:18'),
(20, 'Which of the following is NOT a function of public health? :', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:19', '2024-09-10 12:17:19'),
(26, 'Which of the following is an example of primary prevention? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(27, 'Which infectious agent causes tuberculosis? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:21', '2024-09-10 12:17:21'),
(28, 'What is the normal range for fasting blood glucose levels in adults? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(29, 'Which of the following interventions is part of secondary prevention? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:22', '2024-09-10 12:17:22'),
(30, 'Which of the following is a complication of uncontrolled hypertension? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(31, 'Which vitamin deficiency is associated with pernicious anemia? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:23', '2024-09-10 12:17:23'),
(32, 'Which of the following is a primary symptom of chronic obstructive pulmonary disease (COPD)? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(33, 'Which of the following is a risk factor for cardiovascular diseases? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(34, 'What is the primary mode of transmission for HIV? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:24', '2024-09-10 12:17:24'),
(35, 'Which organ is primarily affected by hepatitis C? :', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:25', '2024-09-10 12:17:25'),
(48, 'What is the primary function of the heart? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:30', '2024-09-10 12:17:30'),
(49, 'Which vitamin is essential for vision? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(50, 'What is the normal body temperature in degrees Celsius? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:31', '2024-09-10 12:17:31'),
(51, 'Which organ is responsible for filtering blood in the human body? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(52, 'Which of the following is a symptom of dehydration? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(53, 'What is the main purpose of vaccination? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:32', '2024-09-10 12:17:32'),
(54, 'Which mineral is important for strong bones and teeth? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(55, 'Which of the following is a common symptom of the flu? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:33', '2024-09-10 12:17:33'),
(56, 'What does HIV stand for? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(57, 'Which of the following is a water-soluble vitamin? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(58, 'What is the normal blood pressure range for adults? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:34', '2024-09-10 12:17:34'),
(59, 'Which of the following is NOT a primary function of the respiratory system? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(60, 'Which organ produces insulin? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:35', '2024-09-10 12:17:35'),
(61, 'What is the main component of red blood cells? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(62, 'Which type of blood vessel carries blood away from the heart? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:36', '2024-09-10 12:17:36'),
(96, 'What is the largest organ in the human body? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(97, 'What is the function of red blood cells? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:53', '2024-09-10 12:17:53'),
(98, 'What is the basic structural unit of the kidney? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(99, 'Which blood type is known as the universal donor? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:54', '2024-09-10 12:17:54'),
(100, 'Which hormone regulates blood sugar levels? :', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-09-10 12:17:55', '2024-09-10 12:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank_temps`
--

CREATE TABLE `question_bank_temps` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `difficulty_level` enum('simple','moderate','difficult') DEFAULT 'simple',
  `questiontime` datetime DEFAULT NULL,
  `active` enum('true','false') DEFAULT 'true',
  `author` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `topic` varchar(45) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question_previewers`
--

CREATE TABLE `question_previewers` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `test_config_id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_previewers`
--

INSERT INTO `question_previewers` (`id`, `user_id`, `test_config_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(3, 1, 4, 4, '2024-06-21 19:13:53', '2024-06-21 19:13:53'),
(4, 1, 4, 5, '2024-06-21 19:13:53', '2024-06-21 19:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'System Admin', '2024-08-16 09:58:18', '2024-08-16 09:58:18'),
(2, 'staff', 'staff', '2024-09-10 19:35:24', '2024-09-10 19:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-08-17 09:09:56', '2024-08-17 09:09:56'),
(2, 1, 2, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(3, 1, 3, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(4, 1, 4, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(5, 1, 5, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(6, 1, 6, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(7, 1, 7, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(8, 1, 8, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(9, 1, 9, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(10, 1, 10, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(11, 1, 11, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(12, 1, 12, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(13, 1, 13, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(14, 1, 14, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(15, 1, 15, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(16, 1, 16, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(17, 1, 17, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(18, 1, 18, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(19, 2, 1, '2024-08-17 09:09:56', '2024-08-17 09:09:56'),
(20, 2, 2, '2024-08-17 12:37:00', '2024-08-17 12:37:00'),
(21, 2, 3, '2024-08-17 12:37:00', '2024-08-17 12:37:00');

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_candidates`
--

CREATE TABLE `scheduled_candidates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_type_id` int(11) DEFAULT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `candidate_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `schedulings`
--

CREATE TABLE `schedulings` (
  `id` int(11) NOT NULL,
  `test_config_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `maximum_batch` int(11) NOT NULL DEFAULT -1,
  `no_per_schedule` int(11) DEFAULT NULL,
  `daily_start_time` varchar(50) DEFAULT NULL,
  `daily_end_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_candidate_id` bigint(20) NOT NULL DEFAULT 0,
  `test_config_id` bigint(20) UNSIGNED NOT NULL,
  `question_bank_id` bigint(20) NOT NULL DEFAULT 0,
  `answer_option_id` bigint(20) NOT NULL DEFAULT 0,
  `time_elapse` datetime DEFAULT NULL,
  `scoring_mode` enum('negetive','normal') DEFAULT 'normal',
  `point_scored` decimal(10,2) DEFAULT NULL,
  `pushed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('j6hoFhQrgrgbtX51pwW2rwcz80HEPDLgPg2NlW2k', 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVzlVaFFDVHRMbHFsRUJKRDJleU9sWXpRRE8xRTFubThDSHRCeGpFUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3JlcG9ydHMvc3VtbWFyeS9yZXBvcnQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1727886224),
('wjoZnwFbdPjbtngegiZwUEq0uYtFGqv8riN08p2O', 146, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiT0RhMDQ1cVpvcFRjcnhkZ3IzOThTMzBaTjRRbHRodWtzOFc5T21EbSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY2FuZGlkYXRlL3Rlc3QvaW5zdHJ1Y3Rpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9jYW5kaWRhdGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDY7czo5OiJjYW5kaWRhdGUiO086MjA6IkFwcFxNb2RlbHNcQ2FuZGlkYXRlIjozMjp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czoxMDoiY2FuZGlkYXRlcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE4OntzOjI6ImlkIjtpOjE0NjtzOjg6ImluZGV4aW5nIjtzOjEyOiJCLzA2Ni8wMDIvMjEiO3M6MTI6InByb2dyYW1tZV9pZCI7aToyO3M6OToiZmlyc3RuYW1lIjtzOjU6IkFJU0hBIjtzOjc6InN1cm5hbWUiO3M6NToiQUhNQUQiO3M6MTE6Im90aGVyX25hbWVzIjtzOjQ6IlVNQVIiO3M6NjoiZ2VuZGVyIjtzOjY6IkZlbWFsZSI7czozOiJkb2IiO3M6MTA6IjIwMDEtMDUtMjEiO3M6NjoibGdhX2lkIjtOO3M6MTA6ImNvdW50cnlfaWQiO2k6MDtzOjk6ImV4YW1feWVhciI7aToyMDI0O3M6ODoicGFzc3dvcmQiO3M6NjA6IiQyeSQxMiRkZkFsSnFiVWtRNjlnRFVhYi9yLmF1OWlONHpkdUVQVmpVMzhackdjRDBYZjR6Zkd0eFBQaSI7czozOiJuaW4iO047czoxNDoicmVtZW1iZXJfdG9rZW4iO047czo5OiJhcGlfdG9rZW4iO047czo3OiJlbmFibGVkIjtzOjM6IlllcyI7czoxMDoiY3JlYXRlZF9hdCI7TjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAyIDIxOjE3OjM2Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6MTg6e3M6MjoiaWQiO2k6MTQ2O3M6ODoiaW5kZXhpbmciO3M6MTI6IkIvMDY2LzAwMi8yMSI7czoxMjoicHJvZ3JhbW1lX2lkIjtpOjI7czo5OiJmaXJzdG5hbWUiO3M6NToiQUlTSEEiO3M6Nzoic3VybmFtZSI7czo1OiJBSE1BRCI7czoxMToib3RoZXJfbmFtZXMiO3M6NDoiVU1BUiI7czo2OiJnZW5kZXIiO3M6NjoiRmVtYWxlIjtzOjM6ImRvYiI7czoxMDoiMjAwMS0wNS0yMSI7czo2OiJsZ2FfaWQiO047czoxMDoiY291bnRyeV9pZCI7aTowO3M6OToiZXhhbV95ZWFyIjtpOjIwMjQ7czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEyJGRmQWxKcWJVa1E2OWdEVWFiL3IuYXU5aU40emR1RVBWalUzOFpyR2NEMFhmNHpmR3R4UFBpIjtzOjM6Im5pbiI7TjtzOjE0OiJyZW1lbWJlcl90b2tlbiI7TjtzOjk6ImFwaV90b2tlbiI7TjtzOjc6ImVuYWJsZWQiO3M6MzoiWWVzIjtzOjEwOiJjcmVhdGVkX2F0IjtOO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDIgMjE6MTc6MzYiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjA6e31zOjE5OiIAKgBhdXRoUGFzc3dvcmROYW1lIjtzOjg6InBhc3N3b3JkIjtzOjIwOiIAKgByZW1lbWJlclRva2VuTmFtZSI7czoxNDoicmVtZW1iZXJfdG9rZW4iO31zOjE5OiJzY2hlZHVsZWRfY2FuZGlkYXRlIjtPOjI5OiJBcHBcTW9kZWxzXFNjaGVkdWxlZENhbmRpZGF0ZSI6MzA6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6MjA6InNjaGVkdWxlZF9jYW5kaWRhdGVzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6Njp7czoyOiJpZCI7aToyO3M6MTI6ImV4YW1fdHlwZV9pZCI7aToxO3M6MTE6InNjaGVkdWxlX2lkIjtpOjE7czoxMjoiY2FuZGlkYXRlX2lkIjtpOjE0NjtzOjEwOiJjcmVhdGVkX2F0IjtOO3M6MTA6InVwZGF0ZWRfYXQiO047fXM6MTE6IgAqAG9yaWdpbmFsIjthOjY6e3M6MjoiaWQiO2k6MjtzOjEyOiJleGFtX3R5cGVfaWQiO2k6MTtzOjExOiJzY2hlZHVsZV9pZCI7aToxO3M6MTI6ImNhbmRpZGF0ZV9pZCI7aToxNDY7czoxMDoiY3JlYXRlZF9hdCI7TjtzOjEwOiJ1cGRhdGVkX2F0IjtOO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjE6e3M6MTc6ImNhbmRpZGF0ZV90eXBlX2lkIjtzOjM6ImludCI7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YTowOnt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YToxOntzOjk6ImV4YW1fdHlwZSI7TzoxOToiQXBwXE1vZGVsc1xFeGFtVHlwZSI6MzA6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6MTA6ImV4YW1fdHlwZXMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YTo0OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjI3OiJDSFBSQk4gTmF0aW9uYWwgRXhhbWluYXRpb24iO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDIgMTU6NTc6MjQiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDIgMTU6NTc6MjQiO31zOjExOiIAKgBvcmlnaW5hbCI7YTo0OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjI3OiJDSFBSQk4gTmF0aW9uYWwgRXhhbWluYXRpb24iO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDIgMTU6NTc6MjQiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDIgMTU6NTc6MjQiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjA6e319fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjM6e2k6MDtzOjI6ImlkIjtpOjE7czoxNzoiY2FuZGlkYXRlX3R5cGVfaWQiO2k6MjtzOjEwOiJyZWdfbnVtYmVyIjt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9fXM6MTg6ImNhbmRpZGF0ZV9zdWJqZWN0cyI7TzozOToiSWxsdW1pbmF0ZVxEYXRhYmFzZVxFbG9xdWVudFxDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjE6e2k6MDtPOjI5OiJBcHBcTW9kZWxzXFNjaGVkdWxlZENhbmRpZGF0ZSI6MzA6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6MjA6InNjaGVkdWxlZF9jYW5kaWRhdGVzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6Nzp7czoyOiJpZCI7aToyO3M6MTI6ImNhbmRpZGF0ZV9pZCI7aToxNDY7czoxMToic2NoZWR1bGVfaWQiO2k6MTtzOjEwOiJzdWJqZWN0X2lkIjtpOjE7czoyMDoiY29uZGlkYXRlX3N1YmplY3RfaWQiO2k6MjtzOjQ6Im5hbWUiO3M6NzoiUGFwZXIgMSI7czo5OiJleGFtX3R5cGUiO3M6Mjc6IkNIUFJCTiBOYXRpb25hbCBFeGFtaW5hdGlvbiI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjc6e3M6MjoiaWQiO2k6MjtzOjEyOiJjYW5kaWRhdGVfaWQiO2k6MTQ2O3M6MTE6InNjaGVkdWxlX2lkIjtpOjE7czoxMDoic3ViamVjdF9pZCI7aToxO3M6MjA6ImNvbmRpZGF0ZV9zdWJqZWN0X2lkIjtpOjI7czo0OiJuYW1lIjtzOjc6IlBhcGVyIDEiO3M6OToiZXhhbV90eXBlIjtzOjI3OiJDSFBSQk4gTmF0aW9uYWwgRXhhbWluYXRpb24iO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjE6e3M6MTc6ImNhbmRpZGF0ZV90eXBlX2lkIjtzOjM6ImludCI7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YTowOnt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMiO2I6MDtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMToiACoAZmlsbGFibGUiO2E6Mzp7aTowO3M6MjoiaWQiO2k6MTtzOjE3OiJjYW5kaWRhdGVfdHlwZV9pZCI7aToyO3M6MTA6InJlZ19udW1iZXIiO31zOjEwOiIAKgBndWFyZGVkIjthOjE6e2k6MDtzOjE6IioiO319fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9czo0OiJ0ZXN0IjtPOjIxOiJBcHBcTW9kZWxzXFRlc3RDb25maWciOjMwOntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjEyOiJ0ZXN0X2NvbmZpZ3MiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YTozMDp7czoyOiJpZCI7aToyO3M6NToidGl0bGUiO3M6MjoiUDEiO3M6MTI6ImV4YW1fdHlwZV9pZCI7aToxO3M6MTM6InRlc3RfY2F0ZWdvcnkiO3M6MTQ6IlNpbmdsZSBTdWJqZWN0IjtzOjEwOiJ0b3RhbF9tYXJrIjtkOjA7czoxMjoidGVzdF9jb2RlX2lkIjtpOjI7czoxMjoidGVzdF90eXBlX2lkIjtpOjE7czo3OiJzZXNzaW9uIjtpOjIwMjQ7czo4OiJzZW1lc3RlciI7aToyO3M6MTY6ImRhaWx5X3N0YXJ0X3RpbWUiO047czoxNDoiZGFpbHlfZW5kX3RpbWUiO047czo4OiJkdXJhdGlvbiI7aTo0MDtzOjEzOiJzdGFydGluZ19tb2RlIjtzOjg6Im9uIGxvZ2luIjtzOjEyOiJkaXNwbGF5X21vZGUiO3M6MTU6InNpbmdsZSBxdWVzdGlvbiI7czoyMzoicXVlc3Rpb25fYWRtaW5pc3RyYXRpb24iO3M6NjoicmFuZG9tIjtzOjIxOiJvcHRpb25fYWRtaW5pc3RyYXRpb24iO3M6NjoicmFuZG9tIjtzOjg6InZlcnNpb25zIjtpOjE7czoxNDoiYWN0aXZlX3ZlcnNpb24iO2k6MTtzOjEyOiJpbml0aWF0ZWRfYnkiO2k6MTtzOjE0OiJkYXRlX2luaXRpYXRlZCI7czoxMDoiMjAyNC0wOS0yNCI7czo2OiJzdGF0dXMiO2k6MTtzOjExOiJlbmRvcnNlbWVudCI7czoyOiJubyI7czo4OiJwYXNzX2tleSI7czozOiJjYnQiO3M6MTI6InRpbWVfcGFkZGluZyI7aToyO3M6MTA6ImFsbG93X2NhbGMiO2k6MDtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTA5LTI1IDA1OjQxOjM1IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTA5LTI1IDA1OjQyOjI0IjtzOjQ6ImNvZGUiO3M6NDoiQ0hFVyI7czo0OiJ0eXBlIjtzOjk6Ik1vY2sgRXhhbSI7czoxMToic2NoZWR1bGVfaWQiO2k6MTt9czoxMToiACoAb3JpZ2luYWwiO2E6MzA6e3M6MjoiaWQiO2k6MjtzOjU6InRpdGxlIjtzOjI6IlAxIjtzOjEyOiJleGFtX3R5cGVfaWQiO2k6MTtzOjEzOiJ0ZXN0X2NhdGVnb3J5IjtzOjE0OiJTaW5nbGUgU3ViamVjdCI7czoxMDoidG90YWxfbWFyayI7ZDowO3M6MTI6InRlc3RfY29kZV9pZCI7aToyO3M6MTI6InRlc3RfdHlwZV9pZCI7aToxO3M6Nzoic2Vzc2lvbiI7aToyMDI0O3M6ODoic2VtZXN0ZXIiO2k6MjtzOjE2OiJkYWlseV9zdGFydF90aW1lIjtOO3M6MTQ6ImRhaWx5X2VuZF90aW1lIjtOO3M6ODoiZHVyYXRpb24iO2k6NDA7czoxMzoic3RhcnRpbmdfbW9kZSI7czo4OiJvbiBsb2dpbiI7czoxMjoiZGlzcGxheV9tb2RlIjtzOjE1OiJzaW5nbGUgcXVlc3Rpb24iO3M6MjM6InF1ZXN0aW9uX2FkbWluaXN0cmF0aW9uIjtzOjY6InJhbmRvbSI7czoyMToib3B0aW9uX2FkbWluaXN0cmF0aW9uIjtzOjY6InJhbmRvbSI7czo4OiJ2ZXJzaW9ucyI7aToxO3M6MTQ6ImFjdGl2ZV92ZXJzaW9uIjtpOjE7czoxMjoiaW5pdGlhdGVkX2J5IjtpOjE7czoxNDoiZGF0ZV9pbml0aWF0ZWQiO3M6MTA6IjIwMjQtMDktMjQiO3M6Njoic3RhdHVzIjtpOjE7czoxMToiZW5kb3JzZW1lbnQiO3M6Mjoibm8iO3M6ODoicGFzc19rZXkiO3M6MzoiY2J0IjtzOjEyOiJ0aW1lX3BhZGRpbmciO2k6MjtzOjEwOiJhbGxvd19jYWxjIjtpOjA7czox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', 1727900563);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_code` varchar(15) NOT NULL,
  `exam_type_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `exam_type_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'P1', 1, 'Paper 1', '2024-10-02 14:57:27', '2024-10-02 14:57:27'),
(2, 'P2', 1, 'Paper 2', '2024-10-02 14:57:27', '2024-10-02 14:57:27'),
(3, 'P3', 1, 'Paper 3', '2024-10-02 14:57:27', '2024-10-02 14:57:27'),
(4, 'PE', 1, 'Practical Examination', '2024-09-19 16:49:29', '2024-09-19 16:49:29'),
(5, 'PA', 1, 'Project Assessment', '2024-09-19 16:49:47', '2024-09-19 16:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `test_codes`
--

CREATE TABLE `test_codes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT 'describe the code for the exams. eg PUTME, COSC101,MATH105',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_codes`
--

INSERT INTO `test_codes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'JCHEW', '2024-04-23 12:35:30', '2024-04-23 12:35:30'),
(2, 'CHEW', '2024-04-23 12:35:30', '2024-04-23 12:35:30'),
(3, 'CHO', '2024-04-23 12:35:30', '2024-04-23 12:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `test_compositors`
--

CREATE TABLE `test_compositors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_configs`
--

CREATE TABLE `test_configs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `exam_type_id` bigint(20) DEFAULT NULL,
  `test_category` enum('Single Subject','Multi-Subject') NOT NULL,
  `total_mark` float NOT NULL DEFAULT 100,
  `test_code_id` int(11) DEFAULT NULL,
  `test_type_id` int(11) DEFAULT NULL,
  `session` int(11) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `daily_start_time` time DEFAULT NULL,
  `daily_end_time` time DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `starting_mode` enum('on login','on starttime') DEFAULT 'on login',
  `display_mode` enum('All','single question') DEFAULT 'All',
  `question_administration` enum('random','linear') DEFAULT 'random',
  `option_administration` enum('random','linear') DEFAULT 'random',
  `versions` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'indicates the number of version of every subject registered in the test',
  `active_version` int(11) DEFAULT 1,
  `initiated_by` int(11) NOT NULL COMMENT 'The user that initiated the test',
  `date_initiated` date NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `endorsement` enum('no','yes') NOT NULL DEFAULT 'no',
  `pass_key` varchar(6) NOT NULL DEFAULT 'cbt',
  `time_padding` int(11) NOT NULL DEFAULT 0,
  `allow_calc` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_configs`
--

INSERT INTO `test_configs` (`id`, `title`, `exam_type_id`, `test_category`, `total_mark`, `test_code_id`, `test_type_id`, `session`, `semester`, `daily_start_time`, `daily_end_time`, `duration`, `starting_mode`, `display_mode`, `question_administration`, `option_administration`, `versions`, `active_version`, `initiated_by`, `date_initiated`, `status`, `endorsement`, `pass_key`, `time_padding`, `allow_calc`, `created_at`, `updated_at`) VALUES
(1, 'P1', 1, 'Single Subject', 0, 1, 1, 2024, 2, NULL, NULL, 40, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-09-24', 1, 'no', 'cbt', 2, 0, '2024-09-25 04:41:24', '2024-09-25 04:42:44'),
(2, 'P1', 1, 'Single Subject', 0, 2, 1, 2024, 2, NULL, NULL, 40, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-09-24', 1, 'no', 'cbt', 2, 0, '2024-09-25 04:41:35', '2024-09-25 04:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `test_invigilators`
--

CREATE TABLE `test_invigilators` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `scheduling_id` int(11) NOT NULL,
  `pass_key` char(3) NOT NULL DEFAULT 'abc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test_questions`
--

CREATE TABLE `test_questions` (
  `id` int(11) NOT NULL,
  `test_section_id` int(11) NOT NULL,
  `question_bank_id` int(11) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`id`, `test_section_id`, `question_bank_id`, `version`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(2, 1, 2, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(3, 1, 3, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(4, 1, 4, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(5, 1, 5, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(6, 1, 6, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(7, 1, 7, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(8, 1, 8, 1, '2024-09-25 04:56:58', '2024-09-25 04:56:58'),
(9, 1, 9, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(10, 1, 10, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(11, 1, 48, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(12, 1, 49, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(13, 1, 50, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(14, 1, 51, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(15, 1, 52, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(16, 1, 53, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(17, 1, 54, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(18, 1, 55, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(19, 1, 56, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(20, 1, 57, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(21, 1, 58, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(22, 1, 59, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(23, 1, 60, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(24, 1, 61, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(25, 1, 62, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(26, 1, 96, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(27, 1, 97, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(28, 1, 98, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(29, 1, 99, 1, '2024-09-25 04:56:59', '2024-09-25 04:56:59'),
(30, 1, 100, 1, '2024-09-25 04:57:00', '2024-09-25 04:57:00'),
(31, 1, 11, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(32, 1, 12, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(33, 1, 13, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(34, 1, 14, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(35, 1, 15, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(36, 1, 16, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(37, 1, 17, 1, '2024-09-25 04:57:29', '2024-09-25 04:57:29'),
(38, 1, 18, 1, '2024-09-25 04:57:30', '2024-09-25 04:57:30'),
(39, 1, 19, 1, '2024-09-25 04:57:30', '2024-09-25 04:57:30'),
(40, 1, 20, 1, '2024-09-25 04:57:30', '2024-09-25 04:57:30'),
(41, 1, 26, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(42, 1, 27, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(43, 1, 28, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(44, 1, 29, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(45, 1, 30, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(46, 1, 31, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(47, 1, 32, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(48, 1, 33, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(49, 1, 34, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(50, 1, 35, 1, '2024-09-25 04:57:42', '2024-09-25 04:57:42'),
(51, 4, 1, 1, '2024-09-25 05:00:35', '2024-09-25 05:00:35'),
(52, 4, 2, 1, '2024-09-25 05:00:35', '2024-09-25 05:00:35'),
(53, 4, 3, 1, '2024-09-25 05:00:35', '2024-09-25 05:00:35'),
(54, 4, 4, 1, '2024-09-25 05:00:35', '2024-09-25 05:00:35'),
(55, 4, 5, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(56, 4, 6, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(57, 4, 7, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(58, 4, 8, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(59, 4, 9, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(60, 4, 10, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(61, 4, 48, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(62, 4, 49, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(63, 4, 50, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(64, 4, 51, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(65, 4, 52, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(66, 4, 53, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(67, 4, 54, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(68, 4, 55, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(69, 4, 56, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(70, 4, 57, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(71, 4, 58, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(72, 4, 59, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(73, 4, 60, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(74, 4, 61, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(75, 4, 62, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(76, 4, 96, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(77, 4, 97, 1, '2024-09-25 05:00:36', '2024-09-25 05:00:36'),
(78, 4, 98, 1, '2024-09-25 05:00:37', '2024-09-25 05:00:37'),
(79, 4, 99, 1, '2024-09-25 05:00:37', '2024-09-25 05:00:37'),
(80, 4, 100, 1, '2024-09-25 05:00:37', '2024-09-25 05:00:37'),
(81, 4, 11, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(82, 4, 12, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(83, 4, 13, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(84, 4, 14, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(85, 4, 15, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(86, 4, 16, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(87, 4, 17, 1, '2024-09-25 05:01:11', '2024-09-25 05:01:11'),
(88, 4, 18, 1, '2024-09-25 05:01:12', '2024-09-25 05:01:12'),
(89, 4, 19, 1, '2024-09-25 05:01:12', '2024-09-25 05:01:12'),
(90, 4, 20, 1, '2024-09-25 05:01:12', '2024-09-25 05:01:12'),
(91, 4, 26, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(92, 4, 27, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(93, 4, 28, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(94, 4, 29, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(95, 4, 30, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(96, 4, 31, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(97, 4, 32, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(98, 4, 33, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(99, 4, 34, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22'),
(100, 4, 35, 1, '2024-09-25 05:01:22', '2024-09-25 05:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `test_sections`
--

CREATE TABLE `test_sections` (
  `id` int(11) NOT NULL,
  `test_subject_id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `instruction` text DEFAULT NULL,
  `mark_per_question` float DEFAULT NULL,
  `num_to_answer` int(11) DEFAULT NULL,
  `num_of_easy` int(11) DEFAULT NULL,
  `num_of_moderate` int(11) DEFAULT NULL,
  `num_of_difficult` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_sections`
--

INSERT INTO `test_sections` (`id`, `test_subject_id`, `title`, `instruction`, `mark_per_question`, `num_to_answer`, `num_of_easy`, `num_of_moderate`, `num_of_difficult`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECTION A', '<p>Answer all questions</p>', 2, 50, 30, 10, 10, '2024-09-25 04:54:04', '2024-09-25 04:54:04'),
(4, 4, 'SECTION A', '<p>Answer ALL questions</p>', 2, 50, 30, 10, 10, '2024-09-25 04:59:53', '2024-09-25 05:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `test_subjects`
--

CREATE TABLE `test_subjects` (
  `id` int(11) NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `instruction` varchar(45) DEFAULT NULL,
  `total_mark` float DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_subjects`
--

INSERT INTO `test_subjects` (`id`, `test_config_id`, `subject_id`, `title`, `instruction`, `total_mark`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, NULL, 100, '2024-09-25 04:51:54', '2024-09-25 04:51:54'),
(4, 1, 1, NULL, NULL, 100, '2024-09-25 04:52:53', '2024-09-25 04:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `test_types`
--

CREATE TABLE `test_types` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'describe the type of test such as exam, test1, test2, labtest1, labtest2,studiotest....',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test_types`
--

INSERT INTO `test_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mock Exam', '2024-05-01 19:48:04', '2024-05-01 19:48:04'),
(2, 'Regular Exam', '2024-05-01 19:48:04', '2024-05-01 19:48:04'),
(3, 'Resit Exam', '2024-05-01 19:48:04', '2024-05-01 19:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `time_controls`
--

CREATE TABLE `time_controls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_config_id` int(11) NOT NULL,
  `scheduled_candidate_id` bigint(20) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'keep track if the student has completed orr not',
  `start_time` time NOT NULL,
  `current_time` time NOT NULL,
  `elapsed` int(11) NOT NULL COMMENT 'keep the total number of second elapsed',
  `ip` varchar(20) NOT NULL,
  `pushed` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `subject_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Professional Ethics', '2024-07-23 20:28:16', '2024-07-23 20:28:16'),
(2, 1, 'Intro. to Health & PHC', '2024-07-23 20:33:38', '2024-07-23 20:33:38'),
(3, 2, 'Anatomy & Physiology', '2024-07-23 20:34:40', '2024-07-23 20:34:40'),
(4, 2, 'Oral Health Care', '2024-07-23 20:35:05', '2024-07-23 20:35:05'),
(5, 3, 'Environmental Health', '2024-07-23 20:35:43', '2024-07-23 20:35:43'),
(6, 3, 'Maternal Health', '2024-07-23 20:36:01', '2024-07-23 20:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `personnel_no` varchar(50) NOT NULL,
  `enabled` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`, `email`, `personnel_no`, `enabled`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$J2kRCMU1NytH6GAY6WS29ecxG4yG2fkXqz4WDyh8gdZBRo3RM4Tsy', 'Super Admin', 'admin@domain.ext', '023456', 1, '', '', '2024-04-20 08:41:59', '2024-04-20 07:50:15'),
(2, 'chprbn-staff', '$2y$12$1HSi6WCao.KxE5VEKxbXquBPz84zMtAyLqOFwBjxyTxKO8FPcVE/O', 'Sylux Endyusa Dimitri', 'endyusa@doamin.ext', '123456', 1, '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '2024-08-17 10:53:57', '2024-08-17 10:53:57'),
(6, 2, 2, '2024-09-10 19:35:35', '2024-09-10 19:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `centre_id` int(11) NOT NULL,
  `host_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `centre_id`, `host_id`, `name`, `location`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'ICT Lab', 'ICT Lab', 250, '2024-09-10 09:44:35', '2024-09-10 09:44:35'),
(2, 2, NULL, 'ICT Lab', 'ICT Lab', 250, '2024-09-10 09:45:19', '2024-09-10 09:45:19'),
(3, 3, NULL, 'ICT Lab', 'ICT Lab', 250, '2024-09-10 09:45:30', '2024-09-10 09:45:30'),
(4, 4, NULL, 'ICT Lab', 'ICT Lab', 250, '2024-09-10 09:45:42', '2024-09-10 09:45:42'),
(5, 5, NULL, 'ICT Lab', 'ICT Lab', 250, '2024-09-10 09:45:42', '2024-09-10 09:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `venue_computers`
--

CREATE TABLE `venue_computers` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `computer_mac_address` varchar(30) NOT NULL,
  `computer_ip` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='store allowed computer in the venue';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answeroptions_temps`
--
ALTER TABLE `answeroptions_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_answer_options_question_bank1` (`question_bank_temp_id`);

--
-- Indexes for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_answer_options_questionbanks1` (`id`),
  ADD KEY `diagram_id` (`correctness`),
  ADD KEY `question_bank_id` (`question_bank_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `graduand_id` (`scheduled_candidate_id`,`paper_id`,`year`);

--
-- Indexes for table `attendance_remarks`
--
ALTER TABLE `attendance_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `degree_plan_id` (`programme_id`,`firstname`,`surname`,`lga_id`,`country_id`,`exam_year`);

--
-- Indexes for table `candidate_subjects`
--
ALTER TABLE `candidate_subjects`
  ADD PRIMARY KEY (`id`,`schedule_id`,`scheduled_candidate_id`,`subject_id`),
  ADD UNIQUE KEY `schedule_id` (`schedule_id`,`scheduled_candidate_id`,`subject_id`);

--
-- Indexes for table `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personnel_no` (`personnel_no`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `endorsements`
--
ALTER TABLE `endorsements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidate_id` (`scheduled_candidate_id`,`test_config_id`),
  ADD KEY `test_id` (`test_config_id`);

--
-- Indexes for table `exams_dates`
--
ALTER TABLE `exams_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_dates_ibfk_1` (`test_config_id`);

--
-- Indexes for table `exams_date_faculty_mappings`
--
ALTER TABLE `exams_date_faculty_mappings`
  ADD KEY `id` (`id`,`faculty_id`),
  ADD KEY `faculty_index` (`faculty_id`),
  ADD KEY `scheduling_id` (`scheduling_id`);

--
-- Indexes for table `exams_date_programme_mappings`
--
ALTER TABLE `exams_date_programme_mappings`
  ADD KEY `programme_id` (`programme_id`),
  ADD KEY `id` (`id`),
  ADD KEY `scheduling_id` (`scheduling_id`);

--
-- Indexes for table `exams_date_state_mappings`
--
ALTER TABLE `exams_date_state_mappings`
  ADD KEY `id` (`id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `scheduling_id` (`scheduling_id`);

--
-- Indexes for table `exam_types`
--
ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_schedule_mappings`
--
ALTER TABLE `faculty_schedule_mappings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `scheduling_id` (`scheduling_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feed_backs`
--
ALTER TABLE `feed_backs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `candidate_id` (`scheduled_candidate_id`);

--
-- Indexes for table `hosts`
--
ALTER TABLE `hosts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jambs`
--
ALTER TABLE `jambs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_number_2` (`reg_number`),
  ADD KEY `reg_number` (`reg_number`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lgas`
--
ALTER TABLE `lgas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `practical_examinations`
--
ALTER TABLE `practical_examinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scheduled_candidate_id` (`scheduled_candidate_id`,`candidate_id`,`practical_question_id`,`paper_id`,`schedule_id`);

--
-- Indexes for table `practical_questions`
--
ALTER TABLE `practical_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practical_sections`
--
ALTER TABLE `practical_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presentations`
--
ALTER TABLE `presentations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scheduled_candidate_id` (`scheduled_candidate_id`,`test_config_id`,`test_section_id`,`question_bank_id`,`answer_option_id`);

--
-- Indexes for table `programmes`
--
ALTER TABLE `programmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programme_type_id` (`programme_type_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `programme_types`
--
ALTER TABLE `programme_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_assessments`
--
ALTER TABLE `project_assessments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scheduled_candidate_id` (`scheduled_candidate_id`,`schedule_id`,`candidate_id`,`paper_id`);

--
-- Indexes for table `pull_statuses`
--
ALTER TABLE `pull_statuses`
  ADD PRIMARY KEY (`⁠ id ⁠`);

--
-- Indexes for table `question_banks`
--
ALTER TABLE `question_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `question_bank_temps`
--
ALTER TABLE `question_bank_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `question_previewers`
--
ALTER TABLE `question_previewers`
  ADD UNIQUE KEY `user_id` (`id`,`user_id`,`test_config_id`,`subject_id`),
  ADD KEY `id` (`id`),
  ADD KEY `test_id` (`test_config_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `scheduled_candidates`
--
ALTER TABLE `scheduled_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_type_id` (`exam_type_id`,`schedule_id`,`candidate_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `schedulings`
--
ALTER TABLE `schedulings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_config_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scheduled_candidate_id` (`scheduled_candidate_id`,`test_config_id`,`question_bank_id`,`answer_option_id`),
  ADD KEY `answer_id` (`answer_option_id`),
  ADD KEY `test_id` (`test_config_id`),
  ADD KEY `candidate_id` (`scheduled_candidate_id`),
  ADD KEY `test_id_2` (`test_config_id`),
  ADD KEY `question_id` (`question_bank_id`),
  ADD KEY `answer_id_2` (`answer_option_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candid_type` (`exam_type_id`);

--
-- Indexes for table `test_codes`
--
ALTER TABLE `test_codes`
  ADD PRIMARY KEY (`id`,`name`);

--
-- Indexes for table `test_compositors`
--
ALTER TABLE `test_compositors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`test_config_id`,`subject_id`),
  ADD KEY `test_id` (`test_config_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `test_configs`
--
ALTER TABLE `test_configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_type_id` (`test_type_id`),
  ADD KEY `test_code_id` (`test_code_id`),
  ADD KEY `initiated_by` (`initiated_by`);

--
-- Indexes for table `test_invigilators`
--
ALTER TABLE `test_invigilators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`test_config_id`,`scheduling_id`),
  ADD KEY `scheduling_id` (`scheduling_id`),
  ADD KEY `id` (`id`),
  ADD KEY `test_id` (`test_config_id`);

--
-- Indexes for table `test_questions`
--
ALTER TABLE `test_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_sections`
--
ALTER TABLE `test_sections`
  ADD PRIMARY KEY (`id`,`test_subject_id`),
  ADD KEY `test_subject_id` (`test_subject_id`);

--
-- Indexes for table `test_subjects`
--
ALTER TABLE `test_subjects`
  ADD PRIMARY KEY (`id`,`test_config_id`,`subject_id`),
  ADD KEY `test_id` (`test_config_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `test_types`
--
ALTER TABLE `test_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_controls`
--
ALTER TABLE `time_controls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_config_id` (`test_config_id`,`scheduled_candidate_id`),
  ADD KEY `candidate_id` (`scheduled_candidate_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venues_hosts1` (`host_id`),
  ADD KEY `fk_venue_centres1` (`centre_id`);

--
-- Indexes for table `venue_computers`
--
ALTER TABLE `venue_computers`
  ADD PRIMARY KEY (`venue_id`,`computer_mac_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answeroptions_temps`
--
ALTER TABLE `answeroptions_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2613;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_remarks`
--
ALTER TABLE `attendance_remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `candidate_subjects`
--
ALTER TABLE `candidate_subjects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `centres`
--
ALTER TABLE `centres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `endorsements`
--
ALTER TABLE `endorsements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams_dates`
--
ALTER TABLE `exams_dates`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_types`
--
ALTER TABLE `exam_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'this table stores types of candidate eg utme, student, employment  applicant, employee promotion', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty_schedule_mappings`
--
ALTER TABLE `faculty_schedule_mappings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feed_backs`
--
ALTER TABLE `feed_backs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hosts`
--
ALTER TABLE `hosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jambs`
--
ALTER TABLE `jambs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `practical_examinations`
--
ALTER TABLE `practical_examinations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practical_questions`
--
ALTER TABLE `practical_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `practical_sections`
--
ALTER TABLE `practical_sections`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `presentations`
--
ALTER TABLE `presentations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=701;

--
-- AUTO_INCREMENT for table `programmes`
--
ALTER TABLE `programmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programme_types`
--
ALTER TABLE `programme_types`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_assessments`
--
ALTER TABLE `project_assessments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pull_statuses`
--
ALTER TABLE `pull_statuses`
  MODIFY `⁠ id ⁠` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_banks`
--
ALTER TABLE `question_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=658;

--
-- AUTO_INCREMENT for table `question_bank_temps`
--
ALTER TABLE `question_bank_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_previewers`
--
ALTER TABLE `question_previewers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `scheduled_candidates`
--
ALTER TABLE `scheduled_candidates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedulings`
--
ALTER TABLE `schedulings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_codes`
--
ALTER TABLE `test_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `test_compositors`
--
ALTER TABLE `test_compositors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_configs`
--
ALTER TABLE `test_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_invigilators`
--
ALTER TABLE `test_invigilators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `test_sections`
--
ALTER TABLE `test_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test_subjects`
--
ALTER TABLE `test_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `test_types`
--
ALTER TABLE `test_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_controls`
--
ALTER TABLE `time_controls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
