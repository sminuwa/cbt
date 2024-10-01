-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 01, 2024 at 10:46 PM
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
(401, 'Vitamin A.', 101, 0, '2024-09-10 13:27:52', '2024-09-10 13:27:52'),
(402, 'Vitamin B12.', 101, 0, '2024-09-10 13:27:52', '2024-09-10 13:27:52'),
(403, 'Vitamin C.', 101, 0, '2024-09-10 13:27:52', '2024-09-10 13:27:52'),
(404, 'Vitamin D.', 101, 1, '2024-09-10 13:27:52', '2024-09-10 13:27:52'),
(405, 'Cardiopulmonary Resuscitation.', 102, 1, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(406, 'Critical Patient Response.', 102, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(407, 'Cardiac Pulmonary Recovery.', 102, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(408, 'Chronic Pain Relief.', 102, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(409, 'Transport oxygen.', 103, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(410, 'Fight infections.', 103, 1, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(411, 'Clot blood.', 103, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(412, 'Regulate body temperature.', 103, 0, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(413, 'Cytoplasm.', 104, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(414, 'Nucleus.', 104, 1, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(415, 'Mitochondria.', 104, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(416, 'Ribosome.', 104, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(417, 'Vitamin A.', 105, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(418, 'Vitamin K.', 105, 1, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(419, 'Vitamin C.', 105, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(420, 'Vitamin D.', 105, 0, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(421, '30-40 beats per minute.', 106, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(422, '60-100 beats per minute.', 106, 1, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(423, '120-150 beats per minute.', 106, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(424, '200-250 beats per minute.', 106, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(425, 'Hinge joint.', 107, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(426, 'Ball and socket joint.', 107, 1, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(427, 'Pivot joint.', 107, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(428, 'Gliding joint.', 107, 0, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(429, 'Kidney.', 108, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(430, 'Liver.', 108, 1, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(431, 'Heart.', 108, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(432, 'Stomach.', 108, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(433, 'Hypotension.', 109, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(434, 'Hypertension.', 109, 1, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(435, 'Hyperglycemia.', 109, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(436, 'Hypoglycemia.', 109, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(437, 'Calcium.', 110, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(438, 'Iron.', 110, 1, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(439, 'Magnesium.', 110, 0, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(440, 'Potassium.', 110, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(441, 'Rickets.', 111, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(442, 'Scurvy.', 111, 1, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(443, 'Beriberi.', 111, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(444, 'Pellagra.', 111, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(445, 'Absorb nutrients.', 112, 1, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(446, 'Store bile.', 112, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(447, 'Filter blood.', 112, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(448, 'Produce insulin.', 112, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(449, 'Shortness of breath.', 113, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(450, 'Sudden confusion.', 113, 1, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(451, 'High fever.', 113, 0, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(452, 'Increased appetite.', 113, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(453, '50-70 mg/dL.', 114, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(454, '70-100 mg/dL.', 114, 1, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(455, '100-130 mg/dL.', 114, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(456, '130-160 mg/dL.', 114, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(457, 'Vitamin A.', 115, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(458, 'Vitamin D.', 115, 1, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(459, 'Vitamin E.', 115, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(460, 'Vitamin K.', 115, 0, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(541, 'Produce hormones.', 136, 0, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(542, 'Filter blood.', 136, 1, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(543, 'Store bile.', 136, 0, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(544, 'Absorb nutrients.', 136, 0, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(545, 'Insulin.', 137, 0, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(546, 'Cortisol.', 137, 1, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(547, 'Thyroxine.', 137, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(548, 'Estrogen.', 137, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(549, 'Hyperglycemia.', 138, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(550, 'Hypoglycemia.', 138, 1, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(551, 'Hypotension.', 138, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(552, 'Hypertension.', 138, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(553, 'Joint pain.', 139, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(554, 'Muscle weakness.', 139, 1, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(555, 'High fever.', 139, 0, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(556, 'Increased appetite.', 139, 0, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(557, 'High cholesterol.', 140, 0, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(558, 'Diabetes.', 140, 1, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(559, 'Low blood pressure.', 140, 0, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(560, 'Viral infection.', 140, 0, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(601, 'A system which guides and controls the moral behaviour and manifest in character and mind.', 151, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(602, 'Code of manners behaviours and action', 151, 1, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(603, 'Qualities a person has learned to believe are important and worthwhile.', 151, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(604, 'Occupation which demands a high standard of education as well.', 151, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(605, 'Generally positive attitude towards work with a cheerful personally.', 152, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(606, 'Genuine desire to help to people.', 152, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(607, 'Should offer explanation to patients on charges for services in an honest manner.', 152, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(608, 'Flare up with patients.', 152, 1, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(609, 'Set a high standard.', 153, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(610, 'Use of standing orders.', 153, 1, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(611, 'Knowing your colleague.', 153, 0, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(612, 'Maintaining two way referral systems.', 153, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(613, 'Ethics.', 154, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(614, 'Etiquette.', 154, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(615, 'Values.', 154, 1, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(616, 'Code of professional conduct.', 154, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(617, 'Accreditation of Community Health Programmes.', 155, 1, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(618, 'Establishment of College of Health Technology.', 155, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(619, 'Indexing of Community Health Students.', 155, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(620, 'Certification of qualified Community Health Practitioners.', 155, 0, '2024-09-10 13:28:15', '2024-09-10 13:28:15');

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

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `indexing`, `programme_id`, `firstname`, `surname`, `other_names`, `gender`, `dob`, `lga_id`, `country_id`, `exam_year`, `password`, `nin`, `remember_token`, `api_token`, `enabled`, `created_at`, `updated_at`) VALUES
(145, 'B/066/001/21', 2, 'SULAIMAN', 'AHMAD', 'SULAIMAN', 'Male', '2000-03-02', NULL, 0, 2024, '$2y$12$5K0oUcmzpp7hMXDSpw63wu2u52YgjSm1AKaOmTNX39XnOTY5B/v0G', NULL, NULL, NULL, 'Yes', NULL, '2024-10-01 20:12:39'),
(146, 'B/066/002/21', 2, 'AISHA', 'AHMAD', 'UMAR', 'Female', '2001-05-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(147, 'B/066/004/21', 2, 'ZAINAB', 'AUWAL', 'ABDULLAHI', 'Female', '2001-07-27', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(148, 'B/066/005/21', 2, 'FATIMA', 'AUWAL', 'MUHAMMAD', 'Female', '2004-07-23', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(149, 'B/066/006/21', 2, 'HUSNA', 'ABBA', 'SHARIF', 'Female', '2004-05-17', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(150, 'B/066/007/21', 2, 'AMINA', 'ABDULLAHI', 'YAHYA', 'Female', '2002-09-27', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(151, 'B/066/008/21', 2, 'ZAINAB', 'ABDULLAHI', 'ADAM', 'Female', '2000-04-22', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(152, 'B/066/009/21', 2, 'SHAHARANI', 'ABDULLAHI', 'NULL', 'Male', '1996-04-11', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(153, 'B/066/012/21', 2, 'AISHA', 'ABDULLAHI', 'IS\'HAQ', 'Female', '2002-08-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(154, 'B/066/013/21', 2, 'AISHA', 'ABDULMUDALLIB', 'AHMAD', 'Female', '2001-06-26', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(155, 'B/066/015/21', 2, 'HAFSAT', 'ABUBAKAR', 'ISHAQ', 'Female', '2003-06-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(156, 'B/066/016/21', 2, 'AISHA', 'ABUBAKAR', 'MUHAMMAD', 'Female', '1999-02-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(157, 'B/066/017/21', 2, 'KHADIJA', 'ADAM', 'ABDULLAHI', 'Female', '2003-08-23', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(158, 'B/066/018/21', 2, 'MURTALA', 'ADAMU', 'YAHAYA', 'Male', '2002-01-03', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(159, 'B/066/019/21', 2, 'ABUBAKAR', 'ADAMU', 'AHMADU', 'Male', '1993-05-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(160, 'B/066/020/21', 2, 'YASMIN', 'AHMAD', '', 'Female', '2004-06-06', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(161, 'B/066/023/21', 2, 'AMINA', 'ALIYU', '', 'Female', '1994-05-11', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(162, 'B/066/024/21', 2, 'HARIS', 'AMINU', '', 'Male', '2002-01-10', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(163, 'B/066/025/21', 2, 'KHADIJA', 'AUWAL', 'AMINU', 'Female', '2004-02-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(164, 'B/066/026/21', 2, 'ZAINAB', 'BABA', 'SHARIF', 'Female', '2004-07-27', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(165, 'B/066/027/21', 2, 'ZUBAIDA', 'ALIYU', 'MUHAMMAD', 'Female', '2004-08-15', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(166, 'B/066/029/21', 2, 'IBRAHIM', 'BASIRU', 'IDRIS', 'Male', '2000-07-14', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(167, 'B/066/031/21', 2, 'MAIMUNA', 'FAROUK', 'SAID', 'Female', '2004-10-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(168, 'B/066/032/21', 2, 'FATIMA', 'GAMBO', 'ISAH', 'Female', '2004-05-30', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(169, 'B/066/033/21', 2, 'HAFSAT', 'GHALI', 'RABIU', 'Female', '2000-01-11', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(170, 'B/066/034/21', 2, 'SALMA', 'GWANI', 'YAHUZA', 'Female', '1999-05-07', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(171, 'B/066/035/21', 2, 'AISHA', 'HABIB', 'SALIS', 'Female', '2002-05-07', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(172, 'B/066/036/21', 2, 'AL-SUDAIS', 'HABIB', 'DIKKO', 'Male', '2002-03-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(173, 'B/066/037/21', 2, 'SADIYA', 'HAMISU', 'ABUBAKAR', 'Female', '2004-06-12', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(174, 'B/066/039/21', 2, 'AISHA', 'HARUNA', 'ISAH', 'Female', '2004-07-10', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(175, 'B/066/040/21', 2, 'SADIYA', 'HARUNA', 'AHMAD', 'Female', '2002-08-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(176, 'B/066/041/21', 2, 'RAFI\'A', 'IBRAHIM', 'ALIYU', 'Female', '2003-04-04', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(177, 'B/066/042/21', 2, 'AMINA', 'IBRAHIM', '', 'Female', '1997-11-30', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(178, 'B/066/044/21', 2, 'HUMAIRA', 'IBRAHIM', 'AHMAD', 'Female', '2004-06-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(179, 'B/066/046/21', 2, 'SAIDU', 'ISYAKU', '', 'Male', '2000-01-10', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(180, 'B/066/047/21', 2, 'FATIMA', 'JAFAR', 'MUSA', 'Female', '1990-12-04', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(181, 'B/066/048/21', 2, 'RUFAIDA', 'JAMIL', 'SALISU', 'Female', '2003-05-07', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(182, 'B/066/049/21', 2, 'KHADIJA', 'JIBRIL', 'AHMAD', 'Female', '2004-12-26', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(183, 'B/066/050/21', 2, '', 'JOHN', 'BLESSING', 'Female', '1995-06-10', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(184, 'B/066/051/21', 2, 'MARYAM', 'SALISU', 'JUNAIDU', 'Female', '2002-11-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(185, 'B/066/052/21', 2, 'HALIMA', 'KABIR', 'ISAH', 'Female', '2003-01-10', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(186, 'B/066/053/21', 2, 'FAUZIYYA', 'KABIR', 'BELLO', 'Female', '2006-07-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(187, 'B/066/055/21', 2, 'AISHA', 'LAWAN', '', 'Female', '1995-12-11', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(188, 'B/066/056/21', 2, 'FIRDAUSI', 'LAWAL', 'IDRIS', 'Female', '2002-08-29', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(189, 'B/066/057/21', 2, 'AL-AMIN', 'LAWAL', 'IDRIS', 'Male', '2001-03-25', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(190, 'B/066/061/21', 2, 'HARIRA', 'MUHAMMAD', 'SANI', 'Female', '2000-10-12', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(191, 'B/066/064/21', 2, 'AMINA', 'MUKHTAR', '', 'Female', '1992-02-16', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(192, 'B/066/065/21', 2, 'FATIMA', 'MURTALA', 'HUZAIFA', 'Female', '2004-12-17', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(193, 'B/066/066/21', 2, 'ZAHRA\'U', 'MUSA', 'MUHAMMAD', 'Female', '2003-06-17', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(194, 'B/066/067/21', 2, 'HABIBA', 'MUSA', 'MUHAMMAD', 'Female', '2002-08-28', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(195, 'B/066/068/21', 2, 'MARYAM', 'MUSA', '', 'Female', '2004-09-09', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(196, 'B/066/069/21', 2, 'AHMAD', 'MUSA', 'ISAH', 'Male', '2002-10-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(197, 'B/066/071/21', 2, 'NABILA', 'MUSTAPHA', 'SADAUKI', 'Female', '2002-12-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(198, 'B/066/072/21', 2, 'FATIMA', 'HUSSAIN', 'IBRAHIM', 'Female', '2003-08-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(199, 'B/066/073/21', 2, 'AISHA', 'NASIR', '', 'Female', '2002-08-15', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(200, 'B/066/074/21', 2, 'FATIMA', 'NASIR', 'MUSA', 'Female', '2003-04-12', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(201, 'B/066/075/21', 2, 'FATIMA', 'NURA', 'ADO', 'Female', '2002-12-26', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(202, 'B/066/077/21', 2, 'AISHA', 'NURADDEEN', 'UMAR', 'Female', '2003-01-18', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(203, 'B/066/078/21', 2, 'ZAINAB', 'NURADDEEN', '', 'Female', '2006-02-09', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(204, 'B/066/079/21', 2, 'HAFSAT', 'RABIU', 'YARIMA', 'Female', '1992-10-28', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(205, 'B/066/080/21', 2, 'KHADIJA', 'RABIU', 'ISAH', 'Female', '1998-03-03', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(206, 'B/066/083/21', 2, 'ZAINAB', 'SADIQ', 'IBRAHIM', 'Female', '2000-04-24', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(207, 'B/066/084/21', 2, 'HALIMA', 'SALISU', 'BELLO', 'Female', '1996-07-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(208, 'B/066/085/21', 2, 'HASSAN', 'SALISU', 'MUSA', 'Male', '2000-06-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(209, 'B/066/087/21', 2, 'HAFSAT', 'SALISU', 'TAHIR', 'Female', '2004-01-23', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(210, 'B/066/088/21', 2, 'FIZZA', 'SANI', 'ABUBAKAR', 'Female', '2002-05-05', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(211, 'B/066/089/21', 2, 'MARYAM', 'SANI', 'ALKASIM', 'Female', '2004-01-12', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(212, 'B/066/090/21', 2, 'RAHMA', 'SUFYAN', 'UBALE', 'Female', '2001-02-17', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(213, 'B/066/091/21', 2, 'BASHARIYYA', 'SULAIMAN', '', 'Female', '2003-12-22', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(214, 'B/066/092/21', 2, 'UMMUSSALMA', 'SULAIMAN', 'IBRAHIM', 'Female', '2003-10-24', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(215, 'B/066/093/21', 2, 'AISHA', 'TANIMU', '', 'Female', '2002-10-26', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(216, 'B/066/095/21', 2, 'AMINATU', 'UMAR', 'YUGUDA', 'Female', '1988-02-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(217, 'B/066/100/21', 2, 'RUKAYYA', 'YAKUBU', 'ABDULLAHI', 'Female', '2003-10-01', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(218, 'B/066/101/21', 2, 'REBECCA', 'YANGA', '', 'Female', '2001-07-08', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(219, 'B/066/103/21', 2, 'DAUDA', 'IDRIS', 'NULL', 'Male', '2001-10-05', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(220, 'B/066/104/21', 2, 'SADDIQA', 'ADAM', 'DAUDA', 'Female', '1999-10-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(221, 'B/066/105/21', 2, 'ZAHRAU', 'BALA', 'DALHATU', 'Female', '2001-04-04', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(222, 'B/066/106/21', 2, 'HAFSAT', 'ABDULLAHI', 'YAHAYA', 'Female', '2002-09-12', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(223, 'B/066/107/21', 2, 'AISHA', 'MUHAMMAD', '', 'Female', '1995-04-14', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(224, 'B/066/108/21', 2, 'NAFISA', 'ALIYU', 'ABDULLAHI', 'Male', '2002-08-13', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(254, 'B/066/098/18', 2, 'BAHIJJA', 'SANI', 'SULEIMAN', 'Female', '1999-01-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(255, 'B/066/004/19', 2, 'MAIMUNA', 'ABDURRASHEED', 'BABA', 'Male', '2002-08-02', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(256, 'B/066/006/19', 2, 'KHADIJA', 'MUSTAPHA', 'GAMBO', 'Male', '2003-06-29', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(257, 'B/066/012/19', 2, 'LUBABATU', 'SHUAIB', 'ALIYU', 'Male', '1998-11-09', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(258, 'B/066/016/19', 2, 'FATIMA', 'AUWALU', 'ADAMU', 'Male', '2001-12-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(259, 'B/066/023/19', 2, 'ZAINAB', 'IBRAHIM', 'USMAN', 'Male', '2003-02-20', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(260, 'B/066/029/19', 2, 'MAIMUNA', 'NURA', '', 'Male', '2003-04-04', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(261, 'B/066/035/19', 2, 'NUSAIBA', 'MUHAMMAD', 'ANAS', 'Male', '2002-06-18', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(262, 'B/066/037/19', 2, 'USAINI', 'NASIRU', 'DANKAKATU', 'Male', '1989-04-08', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(263, 'B/066/047/19', 2, 'MAHMUD', 'USMAN', 'HAUWA', 'Male', '2004-04-15', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(264, 'B/066/048/19', 2, 'IHSAN', 'TASIU', 'IDRIS', 'Male', '2000-05-06', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(265, 'B/066/059/19', 2, 'ZAINAB', 'ABDULLAHI', 'ISAH', 'Male', '1993-01-01', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(266, 'B/066/066/20', 2, 'UMAR', 'AISHA', 'MUSA', 'Male', '2002-10-14', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL),
(267, 'B/066/109/21', 2, 'SADIYA', 'ADO', 'MUHAMMAD', 'Male', '1997-06-21', NULL, 0, 2024, '123456', NULL, NULL, NULL, 'Yes', NULL, NULL);

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

--
-- Dumping data for table `candidate_subjects`
--

INSERT INTO `candidate_subjects` (`id`, `schedule_id`, `scheduled_candidate_id`, `subject_id`, `add_index`, `enabled`, `created_at`, `updated_at`) VALUES
(189, 12, 95, 2, NULL, 1, NULL, NULL),
(190, 12, 96, 2, NULL, 1, NULL, NULL),
(191, 12, 97, 2, NULL, 1, NULL, NULL),
(192, 12, 98, 2, NULL, 1, NULL, NULL),
(193, 12, 99, 2, NULL, 1, NULL, NULL),
(194, 12, 100, 2, NULL, 1, NULL, NULL),
(195, 12, 101, 2, NULL, 1, NULL, NULL),
(196, 12, 102, 2, NULL, 1, NULL, NULL),
(197, 12, 103, 2, NULL, 1, NULL, NULL),
(198, 12, 104, 2, NULL, 1, NULL, NULL),
(199, 12, 105, 2, NULL, 1, NULL, NULL),
(200, 12, 106, 2, NULL, 1, NULL, NULL),
(201, 12, 107, 2, NULL, 1, NULL, NULL),
(202, 12, 108, 2, NULL, 1, NULL, NULL),
(203, 12, 109, 2, NULL, 1, NULL, NULL),
(204, 12, 110, 2, NULL, 1, NULL, NULL),
(205, 12, 111, 2, NULL, 1, NULL, NULL),
(206, 12, 112, 2, NULL, 1, NULL, NULL),
(207, 12, 113, 2, NULL, 1, NULL, NULL),
(208, 12, 114, 2, NULL, 1, NULL, NULL),
(209, 12, 115, 2, NULL, 1, NULL, NULL),
(210, 12, 116, 2, NULL, 1, NULL, NULL),
(211, 12, 117, 2, NULL, 1, NULL, NULL),
(212, 12, 118, 2, NULL, 1, NULL, NULL),
(213, 12, 119, 2, NULL, 1, NULL, NULL),
(214, 12, 120, 2, NULL, 1, NULL, NULL),
(215, 12, 121, 2, NULL, 1, NULL, NULL),
(216, 12, 122, 2, NULL, 1, NULL, NULL),
(217, 12, 123, 2, NULL, 1, NULL, NULL),
(218, 12, 124, 2, NULL, 1, NULL, NULL),
(219, 12, 125, 2, NULL, 1, NULL, NULL),
(220, 12, 126, 2, NULL, 1, NULL, NULL),
(221, 12, 127, 2, NULL, 1, NULL, NULL),
(222, 12, 128, 2, NULL, 1, NULL, NULL),
(223, 12, 129, 2, NULL, 1, NULL, NULL),
(224, 12, 130, 2, NULL, 1, NULL, NULL),
(225, 12, 131, 2, NULL, 1, NULL, NULL),
(226, 12, 132, 2, NULL, 1, NULL, NULL),
(227, 12, 133, 2, NULL, 1, NULL, NULL),
(228, 12, 134, 2, NULL, 1, NULL, NULL),
(229, 12, 135, 2, NULL, 1, NULL, NULL),
(230, 12, 136, 2, NULL, 1, NULL, NULL),
(231, 12, 137, 2, NULL, 1, NULL, NULL),
(232, 12, 138, 2, NULL, 1, NULL, NULL),
(233, 12, 139, 2, NULL, 1, NULL, NULL),
(234, 12, 140, 2, NULL, 1, NULL, NULL),
(235, 12, 141, 2, NULL, 1, NULL, NULL),
(236, 12, 142, 2, NULL, 1, NULL, NULL),
(237, 12, 143, 2, NULL, 1, NULL, NULL),
(238, 12, 144, 2, NULL, 1, NULL, NULL),
(239, 12, 145, 2, NULL, 1, NULL, NULL),
(240, 12, 146, 2, NULL, 1, NULL, NULL),
(241, 12, 147, 2, NULL, 1, NULL, NULL),
(242, 12, 148, 2, NULL, 1, NULL, NULL),
(243, 12, 149, 2, NULL, 1, NULL, NULL),
(244, 12, 150, 2, NULL, 1, NULL, NULL),
(245, 12, 151, 2, NULL, 1, NULL, NULL),
(246, 12, 152, 2, NULL, 1, NULL, NULL),
(247, 12, 153, 2, NULL, 1, NULL, NULL),
(248, 12, 154, 2, NULL, 1, NULL, NULL),
(249, 12, 155, 2, NULL, 1, NULL, NULL),
(250, 12, 156, 2, NULL, 1, NULL, NULL),
(251, 12, 157, 2, NULL, 1, NULL, NULL),
(252, 12, 158, 2, NULL, 1, NULL, NULL),
(253, 12, 159, 2, NULL, 1, NULL, NULL),
(254, 12, 160, 2, NULL, 1, NULL, NULL),
(255, 12, 161, 2, NULL, 1, NULL, NULL),
(256, 12, 162, 2, NULL, 1, NULL, NULL),
(257, 12, 163, 2, NULL, 1, NULL, NULL),
(258, 12, 164, 2, NULL, 1, NULL, NULL),
(259, 12, 165, 2, NULL, 1, NULL, NULL),
(260, 12, 166, 2, NULL, 1, NULL, NULL),
(261, 12, 167, 2, NULL, 1, NULL, NULL),
(262, 12, 168, 2, NULL, 1, NULL, NULL),
(263, 12, 169, 2, NULL, 1, NULL, NULL),
(264, 12, 170, 2, NULL, 1, NULL, NULL),
(265, 12, 171, 2, NULL, 1, NULL, NULL),
(266, 12, 172, 2, NULL, 1, NULL, NULL),
(267, 12, 173, 2, NULL, 1, NULL, NULL),
(268, 12, 174, 2, NULL, 1, NULL, NULL),
(269, 12, 175, 2, NULL, 1, NULL, NULL),
(270, 12, 176, 2, NULL, 1, NULL, NULL),
(271, 12, 177, 2, NULL, 1, NULL, NULL),
(272, 12, 178, 2, NULL, 1, NULL, NULL),
(273, 12, 179, 2, NULL, 1, NULL, NULL),
(274, 12, 180, 2, NULL, 1, NULL, NULL),
(275, 12, 181, 2, NULL, 1, NULL, NULL),
(276, 12, 182, 2, NULL, 1, NULL, NULL),
(277, 12, 183, 2, NULL, 1, NULL, NULL),
(278, 12, 184, 2, NULL, 1, NULL, NULL),
(279, 12, 185, 2, NULL, 1, NULL, NULL),
(280, 12, 186, 2, NULL, 1, NULL, NULL),
(281, 12, 187, 2, NULL, 1, NULL, NULL),
(282, 12, 188, 2, NULL, 1, NULL, NULL);

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
(1, '066 - EMIRATE COLLEGE OF HEALTH TECHNOLOGY, KANO (echt66)', '066 - EMIRATE COLLEGE OF HEALTH TECHNOLOGY, KANO (echt66)', 'Active', 'zrchts156', '651sthcrz', '$2y$12$UIE2xv6pPX33XbLh7ksEj.SIw8saLCRhjxBbMRWE5cFFpy66JbAlC', NULL, NULL, '2024-09-10 07:36:51', '2024-09-10 07:36:51', NULL),
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
(1, 'CHPRBN National Examination', '2024-10-01 20:12:08', '2024-10-01 20:12:08');

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
(86, 'App\\Models\\Centre', 18, 'mobile-app-access', '07a12a7ac9c17f963a2e30750a32a8bfaa576e586ba7b298af0d201b4730561d', '[\"server:mobile-app\"]', NULL, '2024-09-20 23:14:51', '2024-09-20 14:57:27', '2024-09-20 23:14:51');

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

--
-- Dumping data for table `practical_examinations`
--

INSERT INTO `practical_examinations` (`id`, `scheduled_candidate_id`, `candidate_id`, `practical_question_id`, `paper_id`, `schedule_id`, `score`, `examiner`, `created_at`, `updated_at`) VALUES
(1, 9349, 1124, 1, 4, 37, '2.00', 0, '2024-09-20 23:14:51', '2024-09-20 23:14:51'),
(2, 9349, 1124, 2, 4, 37, '2.00', 0, '2024-09-20 23:14:51', '2024-09-20 23:14:51'),
(3, 9351, 1125, 15, 4, 37, '1.00', 0, '2024-09-20 23:14:51', '2024-09-20 23:14:51'),
(4, 9351, 1125, 16, 4, 37, '1.00', 0, '2024-09-20 23:14:51', '2024-09-20 23:14:51');

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

--
-- Dumping data for table `presentations`
--

INSERT INTO `presentations` (`id`, `scheduled_candidate_id`, `test_config_id`, `test_section_id`, `question_bank_id`, `answer_option_id`, `pushed`, `created_at`, `updated_at`) VALUES
(601, 95, 3, 5, 107, 428, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(602, 95, 3, 5, 107, 425, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(603, 95, 3, 5, 107, 426, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(604, 95, 3, 5, 107, 427, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(605, 95, 3, 5, 113, 451, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(606, 95, 3, 5, 113, 450, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(607, 95, 3, 5, 113, 449, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(608, 95, 3, 5, 113, 452, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(609, 95, 3, 5, 105, 419, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(610, 95, 3, 5, 105, 420, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(611, 95, 3, 5, 105, 418, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(612, 95, 3, 5, 105, 417, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(613, 95, 3, 5, 112, 448, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(614, 95, 3, 5, 112, 447, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(615, 95, 3, 5, 112, 445, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(616, 95, 3, 5, 112, 446, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(617, 95, 3, 5, 111, 442, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(618, 95, 3, 5, 111, 441, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(619, 95, 3, 5, 111, 444, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(620, 95, 3, 5, 111, 443, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(621, 95, 3, 5, 152, 605, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(622, 95, 3, 5, 152, 607, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(623, 95, 3, 5, 152, 608, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(624, 95, 3, 5, 152, 606, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(625, 95, 3, 5, 102, 407, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(626, 95, 3, 5, 102, 408, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(627, 95, 3, 5, 102, 406, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(628, 95, 3, 5, 102, 405, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(629, 95, 3, 5, 136, 543, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(630, 95, 3, 5, 136, 542, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(631, 95, 3, 5, 136, 544, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(632, 95, 3, 5, 136, 541, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(633, 95, 3, 5, 106, 423, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(634, 95, 3, 5, 106, 422, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(635, 95, 3, 5, 106, 424, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(636, 95, 3, 5, 106, 421, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(637, 95, 3, 5, 110, 440, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(638, 95, 3, 5, 110, 439, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(639, 95, 3, 5, 110, 437, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(640, 95, 3, 5, 110, 438, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(641, 95, 3, 5, 155, 619, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(642, 95, 3, 5, 155, 618, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(643, 95, 3, 5, 155, 617, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(644, 95, 3, 5, 155, 620, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(645, 95, 3, 5, 138, 551, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(646, 95, 3, 5, 138, 550, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(647, 95, 3, 5, 138, 549, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(648, 95, 3, 5, 138, 552, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(649, 95, 3, 5, 108, 432, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(650, 95, 3, 5, 108, 430, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(651, 95, 3, 5, 108, 431, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(652, 95, 3, 5, 108, 429, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(653, 95, 3, 5, 139, 553, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(654, 95, 3, 5, 139, 555, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(655, 95, 3, 5, 139, 556, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(656, 95, 3, 5, 139, 554, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(657, 95, 3, 5, 151, 603, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(658, 95, 3, 5, 151, 604, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(659, 95, 3, 5, 151, 602, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(660, 95, 3, 5, 151, 601, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(661, 95, 3, 5, 137, 545, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(662, 95, 3, 5, 137, 548, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(663, 95, 3, 5, 137, 547, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(664, 95, 3, 5, 137, 546, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(665, 95, 3, 5, 101, 402, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(666, 95, 3, 5, 101, 401, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(667, 95, 3, 5, 101, 404, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(668, 95, 3, 5, 101, 403, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(669, 95, 3, 5, 115, 460, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(670, 95, 3, 5, 115, 458, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(671, 95, 3, 5, 115, 457, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(672, 95, 3, 5, 115, 459, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(673, 95, 3, 5, 109, 433, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(674, 95, 3, 5, 109, 434, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(675, 95, 3, 5, 109, 436, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(676, 95, 3, 5, 109, 435, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(677, 95, 3, 5, 104, 413, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(678, 95, 3, 5, 104, 416, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(679, 95, 3, 5, 104, 414, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(680, 95, 3, 5, 104, 415, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(681, 95, 3, 5, 154, 615, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(682, 95, 3, 5, 154, 616, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(683, 95, 3, 5, 154, 613, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(684, 95, 3, 5, 154, 614, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(685, 95, 3, 5, 140, 557, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(686, 95, 3, 5, 140, 559, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(687, 95, 3, 5, 140, 560, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(688, 95, 3, 5, 140, 558, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(689, 95, 3, 5, 153, 611, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(690, 95, 3, 5, 153, 612, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(691, 95, 3, 5, 153, 609, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(692, 95, 3, 5, 153, 610, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(693, 95, 3, 5, 103, 412, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(694, 95, 3, 5, 103, 411, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(695, 95, 3, 5, 103, 410, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(696, 95, 3, 5, 103, 409, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(697, 95, 3, 5, 114, 453, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(698, 95, 3, 5, 114, 455, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(699, 95, 3, 5, 114, 454, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26'),
(700, 95, 3, 5, 114, 456, 1, '2024-10-01 20:12:40', '2024-10-01 20:33:26');

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

--
-- Dumping data for table `project_assessments`
--

INSERT INTO `project_assessments` (`id`, `scheduled_candidate_id`, `schedule_id`, `candidate_id`, `paper_id`, `score`, `examiner`, `created_at`, `updated_at`) VALUES
(1, 9349, 37, 1124, 5, '17.00', 0, '2024-09-20 13:21:55', '2024-09-20 13:21:56'),
(2, 9351, 37, 1125, 5, '15.50', 0, '2024-09-20 13:21:55', '2024-09-20 13:21:56');

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

--
-- Dumping data for table `pull_statuses`
--

INSERT INTO `pull_statuses` (`⁠ id ⁠`, `resource`, `pull_date`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 'basic-data', '2024-10-01 17:35:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 16:35:18', '2024-10-01 16:35:18'),
(2, 'basic-data', '2024-10-01 17:35:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 16:35:25', '2024-10-01 16:35:25'),
(3, 'test-data', '2024-10-01 17:35:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 16:35:29', '2024-10-01 16:35:29'),
(4, 'candidate-data', '2024-10-01 17:35:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 16:35:32', '2024-10-01 16:35:32'),
(5, 'basic-data', '2024-10-01 20:42:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:42:37', '2024-10-01 19:42:37'),
(6, 'basic-data', '2024-10-01 20:43:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:43:42', '2024-10-01 19:43:42'),
(7, 'test-data', '2024-10-01 20:44:47', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:44:47', '2024-10-01 19:44:47'),
(8, 'test-data', '2024-10-01 20:45:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:45:15', '2024-10-01 19:45:15'),
(9, 'candidate-data', '2024-10-01 20:45:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:45:20', '2024-10-01 19:45:20'),
(10, 'basic-data', '2024-10-01 20:57:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:57:42', '2024-10-01 19:57:42'),
(11, 'test-data', '2024-10-01 20:57:45', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:57:45', '2024-10-01 19:57:45'),
(12, 'candidate-data', '2024-10-01 20:58:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 19:58:09', '2024-10-01 19:58:09'),
(13, 'basic-data', '2024-10-01 21:01:01', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:01:01', '2024-10-01 20:01:01'),
(14, 'test-data', '2024-10-01 21:01:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:01:03', '2024-10-01 20:01:03'),
(15, 'candidate-data', '2024-10-01 21:01:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:01:06', '2024-10-01 20:01:06'),
(16, 'basic-data', '2024-10-01 21:04:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:04:29', '2024-10-01 20:04:29'),
(17, 'test-data', '2024-10-01 21:04:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:04:32', '2024-10-01 20:04:32'),
(18, 'candidate-data', '2024-10-01 21:04:33', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:04:33', '2024-10-01 20:04:33'),
(19, 'basic-data', '2024-10-01 21:12:08', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:12:08', '2024-10-01 20:12:08'),
(20, 'test-data', '2024-10-01 21:12:10', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:12:10', '2024-10-01 20:12:10'),
(21, 'candidate-data', '2024-10-01 21:12:12', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-01 20:12:12', '2024-10-01 20:12:12');

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
(101, 'Which vitamin is produced when the skin is exposed to sunlight? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:52', '2024-09-10 13:27:52'),
(102, 'What does CPR stand for in medical emergencies? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(103, 'What is the function of white blood cells? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:53', '2024-09-10 13:27:53'),
(104, 'Which part of the cell contains genetic material? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(105, 'Which nutrient is essential for blood clotting? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:54', '2024-09-10 13:27:54'),
(106, 'What is the average resting heart rate for adults? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(107, 'Which type of joint is found in the shoulder? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(108, 'Which organ is responsible for detoxifying chemicals and metabolizing drugs? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:55', '2024-09-10 13:27:55'),
(109, 'What is the medical term for high blood pressure? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(110, 'Which mineral is essential for carrying oxygen in the blood? :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:56', '2024-09-10 13:27:56'),
(111, 'Which disease is caused by a deficiency of Vitamin C? :', 'moderate', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(112, 'What is the primary function of the small intestine? :', 'moderate', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(113, 'Which of the following is a symptom of a stroke? :', 'moderate', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:57', '2024-09-10 13:27:57'),
(114, 'What is the normal range for fasting blood glucose levels? :', 'moderate', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(115, 'Which vitamin deficiency causes rickets? :', 'moderate', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:27:58', '2024-09-10 13:27:58'),
(136, 'What is the function of the spleen? :', 'difficult', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(137, 'Which hormone is produced by the adrenal glands? :', 'difficult', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:07', '2024-09-10 13:28:07'),
(138, 'What is the medical term for low blood sugar? :', 'difficult', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(139, 'Which of the following is a symptom of multiple sclerosis? :', 'difficult', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:08', '2024-09-10 13:28:08'),
(140, 'What is the primary cause of chronic kidney disease? :', 'difficult', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:09', '2024-09-10 13:28:09'),
(151, 'Etiquette can be define as :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(152, 'One of the following is NOT an acceptable behaviour a professional should have :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(153, 'Which of the following is NOT a code of conduct of Community Health Practitioner?', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:14', '2024-09-10 13:28:14'),
(154, 'All of these are collection of rules, laws and standard that guide and control the behaviour of the profession :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:15', '2024-09-10 13:28:15'),
(155, 'The function of Community Health Practitioners Registration Board of Nigeria include all EXCEPT :', 'simple', NULL, 'true', 1, 2, NULL, 3, '2024-09-10 13:28:15', '2024-09-10 13:28:15');

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

--
-- Dumping data for table `scheduled_candidates`
--

INSERT INTO `scheduled_candidates` (`id`, `exam_type_id`, `schedule_id`, `candidate_id`, `created_at`, `updated_at`) VALUES
(95, 1, 12, 145, NULL, NULL),
(96, 1, 12, 146, NULL, NULL),
(97, 1, 12, 147, NULL, NULL),
(98, 1, 12, 148, NULL, NULL),
(99, 1, 12, 149, NULL, NULL),
(100, 1, 12, 150, NULL, NULL),
(101, 1, 12, 151, NULL, NULL),
(102, 1, 12, 152, NULL, NULL),
(103, 1, 12, 153, NULL, NULL),
(104, 1, 12, 154, NULL, NULL),
(105, 1, 12, 155, NULL, NULL),
(106, 1, 12, 156, NULL, NULL),
(107, 1, 12, 157, NULL, NULL),
(108, 1, 12, 158, NULL, NULL),
(109, 1, 12, 159, NULL, NULL),
(110, 1, 12, 160, NULL, NULL),
(111, 1, 12, 161, NULL, NULL),
(112, 1, 12, 162, NULL, NULL),
(113, 1, 12, 163, NULL, NULL),
(114, 1, 12, 164, NULL, NULL),
(115, 1, 12, 165, NULL, NULL),
(116, 1, 12, 166, NULL, NULL),
(117, 1, 12, 167, NULL, NULL),
(118, 1, 12, 168, NULL, NULL),
(119, 1, 12, 169, NULL, NULL),
(120, 1, 12, 170, NULL, NULL),
(121, 1, 12, 171, NULL, NULL),
(122, 1, 12, 172, NULL, NULL),
(123, 1, 12, 173, NULL, NULL),
(124, 1, 12, 174, NULL, NULL),
(125, 1, 12, 175, NULL, NULL),
(126, 1, 12, 176, NULL, NULL),
(127, 1, 12, 177, NULL, NULL),
(128, 1, 12, 178, NULL, NULL),
(129, 1, 12, 179, NULL, NULL),
(130, 1, 12, 180, NULL, NULL),
(131, 1, 12, 181, NULL, NULL),
(132, 1, 12, 182, NULL, NULL),
(133, 1, 12, 183, NULL, NULL),
(134, 1, 12, 184, NULL, NULL),
(135, 1, 12, 185, NULL, NULL),
(136, 1, 12, 186, NULL, NULL),
(137, 1, 12, 187, NULL, NULL),
(138, 1, 12, 188, NULL, NULL),
(139, 1, 12, 189, NULL, NULL),
(140, 1, 12, 190, NULL, NULL),
(141, 1, 12, 191, NULL, NULL),
(142, 1, 12, 192, NULL, NULL),
(143, 1, 12, 193, NULL, NULL),
(144, 1, 12, 194, NULL, NULL),
(145, 1, 12, 195, NULL, NULL),
(146, 1, 12, 196, NULL, NULL),
(147, 1, 12, 197, NULL, NULL),
(148, 1, 12, 198, NULL, NULL),
(149, 1, 12, 199, NULL, NULL),
(150, 1, 12, 200, NULL, NULL),
(151, 1, 12, 201, NULL, NULL),
(152, 1, 12, 202, NULL, NULL),
(153, 1, 12, 203, NULL, NULL),
(154, 1, 12, 204, NULL, NULL),
(155, 1, 12, 205, NULL, NULL),
(156, 1, 12, 206, NULL, NULL),
(157, 1, 12, 207, NULL, NULL),
(158, 1, 12, 208, NULL, NULL),
(159, 1, 12, 209, NULL, NULL),
(160, 1, 12, 210, NULL, NULL),
(161, 1, 12, 211, NULL, NULL),
(162, 1, 12, 212, NULL, NULL),
(163, 1, 12, 213, NULL, NULL),
(164, 1, 12, 214, NULL, NULL),
(165, 1, 12, 215, NULL, NULL),
(166, 1, 12, 216, NULL, NULL),
(167, 1, 12, 217, NULL, NULL),
(168, 1, 12, 218, NULL, NULL),
(169, 1, 12, 219, NULL, NULL),
(170, 1, 12, 220, NULL, NULL),
(171, 1, 12, 221, NULL, NULL),
(172, 1, 12, 222, NULL, NULL),
(173, 1, 12, 223, NULL, NULL),
(174, 1, 12, 224, NULL, NULL),
(175, 1, 12, 254, NULL, NULL),
(176, 1, 12, 255, NULL, NULL),
(177, 1, 12, 256, NULL, NULL),
(178, 1, 12, 257, NULL, NULL),
(179, 1, 12, 258, NULL, NULL),
(180, 1, 12, 259, NULL, NULL),
(181, 1, 12, 260, NULL, NULL),
(182, 1, 12, 261, NULL, NULL),
(183, 1, 12, 262, NULL, NULL),
(184, 1, 12, 263, NULL, NULL),
(185, 1, 12, 264, NULL, NULL),
(186, 1, 12, 265, NULL, NULL),
(187, 1, 12, 266, NULL, NULL),
(188, 1, 12, 267, NULL, NULL);

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

--
-- Dumping data for table `schedulings`
--

INSERT INTO `schedulings` (`id`, `test_config_id`, `venue_id`, `date`, `maximum_batch`, `no_per_schedule`, `daily_start_time`, `daily_end_time`, `created_at`, `updated_at`) VALUES
(12, 3, 1, '2024-10-01 00:00:00', 1, 250, '00:00:00', '23:59:00', '2024-10-01 19:09:16', '2024-10-01 19:09:16');

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

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `scheduled_candidate_id`, `test_config_id`, `question_bank_id`, `answer_option_id`, `time_elapse`, `scoring_mode`, `point_scored`, `pushed`, `created_at`, `updated_at`) VALUES
(151, 95, 3, 107, 428, '2024-10-01 21:12:47', 'normal', '0.00', 1, '2024-10-01 20:12:47', '2024-10-01 20:33:26'),
(152, 95, 3, 113, 451, '2024-10-01 21:12:47', 'normal', '0.00', 1, '2024-10-01 20:12:47', '2024-10-01 20:33:26'),
(153, 95, 3, 105, 419, '2024-10-01 21:12:47', 'normal', '0.00', 1, '2024-10-01 20:12:47', '2024-10-01 20:33:26'),
(154, 95, 3, 112, 448, '2024-10-01 21:12:48', 'normal', '0.00', 1, '2024-10-01 20:12:48', '2024-10-01 20:33:26'),
(155, 95, 3, 111, 442, '2024-10-01 21:12:48', 'normal', '4.00', 1, '2024-10-01 20:12:48', '2024-10-01 20:33:26'),
(156, 95, 3, 152, 605, '2024-10-01 21:12:48', 'normal', '0.00', 1, '2024-10-01 20:12:48', '2024-10-01 20:33:26'),
(157, 95, 3, 102, 407, '2024-10-01 21:12:48', 'normal', '0.00', 1, '2024-10-01 20:12:48', '2024-10-01 20:33:26'),
(158, 95, 3, 136, 543, '2024-10-01 21:12:48', 'normal', '0.00', 1, '2024-10-01 20:12:48', '2024-10-01 20:33:26'),
(159, 95, 3, 106, 423, '2024-10-01 21:12:49', 'normal', '0.00', 1, '2024-10-01 20:12:49', '2024-10-01 20:33:26'),
(160, 95, 3, 110, 440, '2024-10-01 21:12:49', 'normal', '0.00', 1, '2024-10-01 20:12:49', '2024-10-01 20:33:26'),
(161, 95, 3, 155, 619, '2024-10-01 21:12:49', 'normal', '0.00', 1, '2024-10-01 20:12:49', '2024-10-01 20:33:26'),
(162, 95, 3, 138, 551, '2024-10-01 21:12:49', 'normal', '0.00', 1, '2024-10-01 20:12:49', '2024-10-01 20:33:26'),
(163, 95, 3, 108, 432, '2024-10-01 21:12:50', 'normal', '0.00', 1, '2024-10-01 20:12:50', '2024-10-01 20:33:26'),
(164, 95, 3, 139, 553, '2024-10-01 21:12:50', 'normal', '0.00', 1, '2024-10-01 20:12:50', '2024-10-01 20:33:26'),
(165, 95, 3, 151, 603, '2024-10-01 21:12:50', 'normal', '0.00', 1, '2024-10-01 20:12:50', '2024-10-01 20:33:26'),
(166, 95, 3, 137, 545, '2024-10-01 21:12:50', 'normal', '0.00', 1, '2024-10-01 20:12:50', '2024-10-01 20:33:26'),
(167, 95, 3, 101, 402, '2024-10-01 21:12:51', 'normal', '0.00', 1, '2024-10-01 20:12:51', '2024-10-01 20:33:26'),
(168, 95, 3, 115, 460, '2024-10-01 21:12:51', 'normal', '0.00', 1, '2024-10-01 20:12:51', '2024-10-01 20:33:26'),
(169, 95, 3, 109, 433, '2024-10-01 21:12:51', 'normal', '0.00', 1, '2024-10-01 20:12:51', '2024-10-01 20:33:26'),
(170, 95, 3, 104, 413, '2024-10-01 21:12:51', 'normal', '0.00', 1, '2024-10-01 20:12:51', '2024-10-01 20:33:26'),
(171, 95, 3, 154, 615, '2024-10-01 21:12:52', 'normal', '4.00', 1, '2024-10-01 20:12:52', '2024-10-01 20:33:26'),
(172, 95, 3, 140, 557, '2024-10-01 21:12:52', 'normal', '0.00', 1, '2024-10-01 20:12:52', '2024-10-01 20:33:26'),
(173, 95, 3, 153, 611, '2024-10-01 21:12:52', 'normal', '0.00', 1, '2024-10-01 20:12:52', '2024-10-01 20:33:26'),
(174, 95, 3, 103, 412, '2024-10-01 21:12:53', 'normal', '0.00', 1, '2024-10-01 20:12:53', '2024-10-01 20:33:26'),
(175, 95, 3, 114, 453, '2024-10-01 21:12:53', 'normal', '0.00', 1, '2024-10-01 20:12:53', '2024-10-01 20:33:26');

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
('iJBpg7ts3GAhXgP1tIutUOkmhieZbhh3y5g2ULEn', 145, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YToxMjp7czo2OiJfdG9rZW4iO3M6NDA6InJQcndLdm1ETUw0aWtkWDRONlFxczNtN3BuZHJ5MFVIUTRwVTVKcTIiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY2FuZGlkYXRlL2F1dGgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9jYW5kaWRhdGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDU7czo5OiJjYW5kaWRhdGUiO086MjA6IkFwcFxNb2RlbHNcQ2FuZGlkYXRlIjozMjp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czoxMDoiY2FuZGlkYXRlcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE4OntzOjI6ImlkIjtpOjE0NTtzOjg6ImluZGV4aW5nIjtzOjEyOiJCLzA2Ni8wMDEvMjEiO3M6MTI6InByb2dyYW1tZV9pZCI7aToyO3M6OToiZmlyc3RuYW1lIjtzOjg6IlNVTEFJTUFOIjtzOjc6InN1cm5hbWUiO3M6NToiQUhNQUQiO3M6MTE6Im90aGVyX25hbWVzIjtzOjg6IlNVTEFJTUFOIjtzOjY6ImdlbmRlciI7czo0OiJNYWxlIjtzOjM6ImRvYiI7czoxMDoiMjAwMC0wMy0wMiI7czo2OiJsZ2FfaWQiO047czoxMDoiY291bnRyeV9pZCI7aTowO3M6OToiZXhhbV95ZWFyIjtpOjIwMjQ7czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEyJDVLMG9VY216cHA3aE1YRFNwdzYzd3UydTUyWWdqU20xQUthT21UTlgzOVhuT1RZNUIvdjBHIjtzOjM6Im5pbiI7TjtzOjE0OiJyZW1lbWJlcl90b2tlbiI7TjtzOjk6ImFwaV90b2tlbiI7TjtzOjc6ImVuYWJsZWQiO3M6MzoiWWVzIjtzOjEwOiJjcmVhdGVkX2F0IjtOO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMTAtMDEgMjE6MTI6MzkiO31zOjExOiIAKgBvcmlnaW5hbCI7YToxODp7czoyOiJpZCI7aToxNDU7czo4OiJpbmRleGluZyI7czoxMjoiQi8wNjYvMDAxLzIxIjtzOjEyOiJwcm9ncmFtbWVfaWQiO2k6MjtzOjk6ImZpcnN0bmFtZSI7czo4OiJTVUxBSU1BTiI7czo3OiJzdXJuYW1lIjtzOjU6IkFITUFEIjtzOjExOiJvdGhlcl9uYW1lcyI7czo4OiJTVUxBSU1BTiI7czo2OiJnZW5kZXIiO3M6NDoiTWFsZSI7czozOiJkb2IiO3M6MTA6IjIwMDAtMDMtMDIiO3M6NjoibGdhX2lkIjtOO3M6MTA6ImNvdW50cnlfaWQiO2k6MDtzOjk6ImV4YW1feWVhciI7aToyMDI0O3M6ODoicGFzc3dvcmQiO3M6NjA6IiQyeSQxMiQ1SzBvVWNtenBwN2hNWERTcHc2M3d1MnU1MllnalNtMUFLYU9tVE5YMzlYbk9UWTVCL3YwRyI7czozOiJuaW4iO047czoxNDoicmVtZW1iZXJfdG9rZW4iO047czo5OiJhcGlfdG9rZW4iO047czo3OiJlbmFibGVkIjtzOjM6IlllcyI7czoxMDoiY3JlYXRlZF9hdCI7TjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAxIDIxOjEyOjM5Ijt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTowOnt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0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IjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6Mjk6e3M6MjoiaWQiO2k6MztzOjEyOiJleGFtX3R5cGVfaWQiO2k6MTtzOjEzOiJ0ZXN0X2NhdGVnb3J5IjtzOjE0OiJTaW5nbGUgU3ViamVjdCI7czoxMDoidG90YWxfbWFyayI7ZDowO3M6MTI6InRlc3RfY29kZV9pZCI7aToyO3M6MTI6InRlc3RfdHlwZV9pZCI7aToxO3M6Nzoic2Vzc2lvbiI7aToyMDI0O3M6ODoic2VtZXN0ZXIiO2k6MjtzOjE2OiJkYWlseV9zdGFydF90aW1lIjtOO3M6MTQ6ImRhaWx5X2VuZF90aW1lIjtOO3M6ODoiZHVyYXRpb24iO2k6NTA7czoxMzoic3RhcnRpbmdfbW9kZSI7czo4OiJvbiBsb2dpbiI7czoxMjoiZGlzcGxheV9tb2RlIjtzOjE1OiJzaW5nbGUgcXVlc3Rpb24iO3M6MjM6InF1ZXN0aW9uX2FkbWluaXN0cmF0aW9uIjtzOjY6InJhbmRvbSI7czoyMToib3B0aW9uX2FkbWluaXN0cmF0aW9uIjtzOjY6InJhbmRvbSI7czo4OiJ2ZXJzaW9ucyI7aToxO3M6MTQ6ImFjdGl2ZV92ZXJzaW9uIjtpOjE7czoxMjoiaW5pdGlhdGVkX2J5IjtpOjE7czoxNDoiZGF0ZV9pbml0aWF0ZWQiO3M6MTA6IjIwMjQtMDktMzAiO3M6Njoic3RhdHVzIjtpOjE7czoxMToiZW5kb3JzZW1lbnQiO3M6Mjoibm8iO3M6ODoicGFzc19rZXkiO3M6MzoiY2J0IjtzOjEyOiJ0aW1lX3BhZGRpbmciO2k6MjtzOjEwOiJhbGxvd19jYWxjIjtpOjA7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNC0xMC0wMSAyMDowNzo0NCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNC0xMC0wMSAyMDowODo1OSI7czo0OiJjb2RlIjtzOjQ6IkNIRVciO3M6NDoidHlwZSI7czo5OiJNb2NrIEV4YW0iO3M6MTE6InNjaGVkdWxlX2lkIjtpOjEyO31zOjExOiIAKgBvcmlnaW5hbCI7YToyOTp7czoyOiJpZCI7aTozO3M6MTI6ImV4YW1fdHlwZV9pZCI7aToxO3M6MTM6InRlc3RfY2F0ZWdvcnkiO3M6MTQ6IlNpbmdsZSBTdWJqZWN0IjtzOjEwOiJ0b3RhbF9tYXJrIjtkOjA7czoxMjoidGVzdF9jb2RlX2lkIjtpOjI7czoxMjoidGVzdF90eXBlX2lkIjtpOjE7czo3OiJzZXNzaW9uIjtpOjIwMjQ7czo4OiJzZW1lc3RlciI7aToyO3M6MTY6ImRhaWx5X3N0YXJ0X3RpbWUiO047czoxNDoiZGFpbHlfZW5kX3RpbWUiO047czo4OiJkdXJhdGlvbiI7aTo1MDtzOjEzOiJzdGFydGluZ19tb2RlIjtzOjg6Im9uIGxvZ2luIjtzOjEyOiJkaXNwbGF5X21vZGUiO3M6MTU6InNpbmdsZSBxdWVzdGlvbiI7czoyMzoicXVlc3Rpb25fYWRtaW5pc3RyYXRpb24iO3M6NjoicmFuZG9tIjtzOjIxOiJvcHRpb25fYWRtaW5pc3RyYXRpb24iO3M6NjoicmFuZG9tIjtzOjg6InZlcnNpb25zIjtpOjE7czoxNDoiYWN0aXZlX3ZlcnNpb24iO2k6MTtzOjEyOiJpbml0aWF0ZWRfYnkiO2k6MTtzOjE0OiJkYXRlX2luaXRpYXRlZCI7czoxMDoiMjAyNC0wOS0zMCI7czo2OiJzdGF0dXMiO2k6MTtzOjExOiJlbmRvcnNlbWVudCI7czoyOiJubyI7czo4OiJwYXNzX2tleSI7czozOiJjYnQiO3M6MTI6InRpbWVfcGFkZGluZyI7aToyO3M6MTA6ImFsbG93X2NhbGMiO2k6MDtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAxIDIwOjA3OjQ0IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAxIDIwOjA4OjU5IjtzOjQ6ImNvZGUiO3M6NDoiQ0hFVyI7czo0OiJ0eXBlIjtzOjk6Ik1vY2sgRXhhbSI7czoxMToic2NoZWR1bGVfaWQiO2k6MTI7fXM6MTA6IgAqAGNoYW5nZXMiO2E6MDp7fXM6ODoiACoAY2FzdHMiO2E6MTg6e2k6MDtzOjI6ImlkIjtzOjEwOiJ0b3RhbF9tYXJrIjtzOjU6ImZsb2F0IjtzOjEyOiJ0ZXN0X2NvZGVfaWQiO3M6MzoiaW50IjtzOjEyOiJ0ZXN0X3R5cGVfaWQiO3M6MzoiaW50IjtzOjc6InNlc3Npb24iO3M6MzoiaW50IjtzOjg6InNlbWVzdGVyIjtzOjM6ImludCI7czoxNjoiZGFpbHlfc3RhcnRfdGltZSI7czo4OiJkYXRldGltZSI7czoxNDoiZGFpbHlfZW5kX3RpbWUiO3M6ODoiZGF0ZXRpbWUiO3M6ODoiZHVyYXRpb24iO3M6MzoiaW50IjtzOjg6InZlcnNpb25zIjtzOjM6ImludCI7czoxNDoiYWN0aXZlX3ZlcnNpb24iO3M6MzoiaW50IjtzOjEyOiJpbml0aWF0ZWRfYnkiO3M6MzoiaW50IjtzOjE0OiJkYXRlX2luaXRpYXRlZCI7czo4OiJkYXRldGltZSI7czo2OiJzdGF0dXMiO3M6NDoiYm9vbCI7czoxMjoidGltZV9wYWRkaW5nIjtzOjM6ImludCI7czoxMDoiYWxsb3dfY2FsYyI7czo0OiJib29sIjtpOjE7czoyOiJpZCI7aToyO3M6MjoiaWQiO31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6Mjp7czo5OiJ0ZXN0X2NvZGUiO086MTk6IkFwcFxNb2RlbHNcVGVzdENvZGUiOjMwOntzOjEzOiIAKgBjb25uZWN0aW9uIjtzOjU6Im15c3FsIjtzOjg6IgAqAHRhYmxlIjtzOjEwOiJ0ZXN0X2NvZGVzIjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTk6InByZXZlbnRzTGF6eUxvYWRpbmciO2I6MDtzOjEwOiIAKgBwZXJQYWdlIjtpOjE1O3M6NjoiZXhpc3RzIjtiOjE7czoxODoid2FzUmVjZW50bHlDcmVhdGVkIjtiOjA7czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6MTM6IgAqAGF0dHJpYnV0ZXMiO2E6NDp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czo0OiJDSEVXIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTA0LTIzIDEzOjM1OjMwIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTA0LTIzIDEzOjM1OjMwIjt9czoxMToiACoAb3JpZ2luYWwiO2E6NDp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czo0OiJDSEVXIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTA0LTIzIDEzOjM1OjMwIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTA0LTIzIDEzOjM1OjMwIjt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTowOnt9czoxNzoiACoAY2xhc3NDYXN0Q2FjaGUiO2E6MDp7fXM6MjE6IgAqAGF0dHJpYnV0ZUNhc3RDYWNoZSI7YTowOnt9czoxMzoiACoAZGF0ZUZvcm1hdCI7TjtzOjEwOiIAKgBhcHBlbmRzIjthOjA6e31zOjE5OiIAKgBkaXNwYXRjaGVzRXZlbnRzIjthOjA6e31zOjE0OiIAKgBvYnNlcnZhYmxlcyI7YTowOnt9czoxMjoiACoAcmVsYXRpb25zIjthOjA6e31zOjEwOiIAKgB0b3VjaGVzIjthOjA6e31zOjEwOiJ0aW1lc3RhbXBzIjtiOjE7czoxMzoidXNlc1VuaXF1ZUlkcyI7YjowO3M6OToiACoAaGlkZGVuIjthOjA6e31zOjEwOiIAKgB2aXNpYmxlIjthOjA6e31zOjExOiIAKgBmaWxsYWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YTowOnt9fXM6OToidGVzdF90eXBlIjtPOjE5OiJBcHBcTW9kZWxzXFRlc3RUeXBlIjozMDp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czoxMDoidGVzdF90eXBlcyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjQ6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6OToiTW9jayBFeGFtIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTA1LTAxIDIwOjQ4OjA0IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTA1LTAxIDIwOjQ4OjA0Ijt9czoxMToiACoAb3JpZ2luYWwiO2E6NDp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo5OiJNb2NrIEV4YW0iO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjQtMDUtMDEgMjA6NDg6MDQiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjQtMDUtMDEgMjA6NDg6MDQiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjE3OiIAKgBjbGFzc0Nhc3RDYWNoZSI7YTowOnt9czoyMToiACoAYXR0cmlidXRlQ2FzdENhY2hlIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjA6e319fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjEzOiJ1c2VzVW5pcXVlSWRzIjtiOjA7czo5OiIAKgBoaWRkZW4iO2E6MDp7fXM6MTA6IgAqAHZpc2libGUiO2E6MDp7fXM6MTE6IgAqAGZpbGxhYmxlIjthOjA6e31zOjEwOiIAKgBndWFyZGVkIjthOjA6e319czoxNToidGltZV9kaWZmZXJlbmNlIjtkOjIxLjc1O3M6MTc6InJlbWFpbmluZ19zZWNvbmRzIjtzOjQ6IjE4MTAiO3M6MTI6InRpbWVfY29udHJvbCI7TzoyMjoiQXBwXE1vZGVsc1xUaW1lQ29udHJvbCI6MzA6e3M6MTM6IgAqAGNvbm5lY3Rpb24iO3M6NToibXlzcWwiO3M6ODoiACoAdGFibGUiO3M6MTM6InRpbWVfY29udHJvbHMiO3M6MTM6IgAqAHByaW1hcnlLZXkiO3M6MjoiaWQiO3M6MTA6IgAqAGtleVR5cGUiO3M6MzoiaW50IjtzOjEyOiJpbmNyZW1lbnRpbmciO2I6MTtzOjc6IgAqAHdpdGgiO2E6MDp7fXM6MTI6IgAqAHdpdGhDb3VudCI7YTowOnt9czoxOToicHJldmVudHNMYXp5TG9hZGluZyI7YjowO3M6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjI4OiIAKgBlc2NhcGVXaGVuQ2FzdGluZ1RvU3RyaW5nIjtiOjA7czoxMzoiACoAYXR0cmlidXRlcyI7YToxMTp7czoyOiJpZCI7aTo0O3M6MTQ6InRlc3RfY29uZmlnX2lkIjtpOjM7czoyMjoic2NoZWR1bGVkX2NhbmRpZGF0ZV9pZCI7aTo5NTtzOjk6ImNvbXBsZXRlZCI7aToxO3M6MTA6InN0YXJ0X3RpbWUiO3M6ODoiMjE6MTI6NDAiO3M6MTI6ImN1cnJlbnRfdGltZSI7czo4OiIyMTozNDoxNSI7czo3OiJlbGFwc2VkIjtpOjExODA7czoyOiJpcCI7czo5OiIxMjcuMC4wLjEiO3M6NjoicHVzaGVkIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAyNC0xMC0wMSAyMToxMjo0MCI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAyNC0xMC0wMSAyMTozNDoxNSI7fXM6MTE6IgAqAG9yaWdpbmFsIjthOjExOntzOjI6ImlkIjtpOjQ7czoxNDoidGVzdF9jb25maWdfaWQiO2k6MztzOjIyOiJzY2hlZHVsZWRfY2FuZGlkYXRlX2lkIjtpOjk1O3M6OToiY29tcGxldGVkIjtpOjE7czoxMDoic3RhcnRfdGltZSI7czo4OiIyMToxMjo0MCI7czoxMjoiY3VycmVudF90aW1lIjtzOjg6IjIxOjM0OjE1IjtzOjc6ImVsYXBzZWQiO2k6MTE4MDtzOjI6ImlwIjtzOjk6IjEyNy4wLjAuMSI7czo2OiJwdXNoZWQiO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAxIDIxOjEyOjQwIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI0LTEwLTAxIDIxOjM0OjE1Ijt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YTo1OntzOjI6ImlkIjtzOjM6ImludCI7czoxNDoidGVzdF9jb25maWdfaWQiO3M6MzoiaW50IjtzOjIyOiJzY2hlZHVsZWRfY2FuZGlkYXRlX2lkIjtzOjM6ImludCI7czo5OiJjb21wbGV0ZWQiO3M6NDoiYm9vbCI7czo3OiJlbGFwc2VkIjtzOjM6ImludCI7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6MTM6IgAqAGRhdGVGb3JtYXQiO047czoxMDoiACoAYXBwZW5kcyI7YTowOnt9czoxOToiACoAZGlzcGF0Y2hlc0V2ZW50cyI7YTowOnt9czoxNDoiACoAb2JzZXJ2YWJsZXMiO2E6MDp7fXM6MTI6IgAqAHJlbGF0aW9ucyI7YTowOnt9czoxMDoiACoAdG91Y2hlcyI7YTowOnt9czoxMDoidGltZXN0YW1wcyI7YjoxO3M6MTM6InVzZXNVbmlxdWVJZHMiO2I6MDtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMToiACoAZmlsbGFibGUiO2E6MDp7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MDp7fX1zOjEyOiJ0aW1lX2VsYXBzZWQiO2k6MDt9', 1727814938),
('RkMUBNhz3WaLKfcA5qfTG9i6T1UKb4t9P2bqqYsn', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzAzTjJOejdHOUpHMHhiSU1kbUhOUEUyaTE2SGxKbG9vVGN3dDlEOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnRzL3N1bW1hcnkvcmVwb3J0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1727815350);

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
(1, 'P1', 1, 'Paper 1', '2024-10-01 20:12:10', '2024-10-01 20:12:10'),
(2, 'P2', 1, 'Paper 2', '2024-10-01 20:12:10', '2024-10-01 20:12:10'),
(3, 'P3', 1, 'Paper 3', '2024-10-01 20:12:10', '2024-10-01 20:12:10'),
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
(3, 'P2', 1, 'Single Subject', 0, 2, 1, 2024, 2, NULL, NULL, 50, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-09-30', 1, 'no', 'cbt', 2, 0, '2024-10-01 19:07:44', '2024-10-01 19:08:59'),
(4, 'P3', 1, 'Single Subject', 0, 2, 1, 2024, 2, NULL, NULL, NULL, 'on login', 'All', 'random', 'random', 1, 1, 1, '2024-10-01', 0, 'no', 'cbt', 0, 0, '2024-10-01 20:27:29', '2024-10-01 20:27:29');

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
(101, 5, 101, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(102, 5, 102, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(103, 5, 103, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(104, 5, 104, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(105, 5, 105, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(106, 5, 106, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(107, 5, 107, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(108, 5, 108, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(109, 5, 109, 1, '2024-10-01 19:10:33', '2024-10-01 19:10:33'),
(110, 5, 110, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(111, 5, 151, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(112, 5, 152, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(113, 5, 153, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(114, 5, 154, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(115, 5, 155, 1, '2024-10-01 19:10:34', '2024-10-01 19:10:34'),
(116, 5, 111, 1, '2024-10-01 19:10:44', '2024-10-01 19:10:44'),
(117, 5, 112, 1, '2024-10-01 19:10:44', '2024-10-01 19:10:44'),
(118, 5, 113, 1, '2024-10-01 19:10:44', '2024-10-01 19:10:44'),
(119, 5, 114, 1, '2024-10-01 19:10:44', '2024-10-01 19:10:44'),
(120, 5, 115, 1, '2024-10-01 19:10:44', '2024-10-01 19:10:44'),
(121, 5, 136, 1, '2024-10-01 19:10:52', '2024-10-01 19:10:52'),
(122, 5, 137, 1, '2024-10-01 19:10:52', '2024-10-01 19:10:52'),
(123, 5, 138, 1, '2024-10-01 19:10:52', '2024-10-01 19:10:52'),
(124, 5, 139, 1, '2024-10-01 19:10:52', '2024-10-01 19:10:52'),
(125, 5, 140, 1, '2024-10-01 19:10:53', '2024-10-01 19:10:53');

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
(5, 7, 'SECTION A', '<p>Answer ALL questions</p>', 4, 25, 15, 5, 5, '2024-10-01 19:10:17', '2024-10-01 19:10:17');

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
(7, 3, 2, NULL, NULL, 100, '2024-10-01 19:09:29', '2024-10-01 19:09:29');

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

--
-- Dumping data for table `time_controls`
--

INSERT INTO `time_controls` (`id`, `test_config_id`, `scheduled_candidate_id`, `completed`, `start_time`, `current_time`, `elapsed`, `ip`, `pushed`, `created_at`, `updated_at`) VALUES
(4, 3, 95, 1, '21:12:40', '21:34:25', 1190, '127.0.0.1', 1, '2024-10-01 20:12:40', '2024-10-01 20:34:25');

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
  ADD PRIMARY KEY (`⁠ id ⁠`),
  ADD UNIQUE KEY `⁠ resource ⁠` (`resource`,`pull_date`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `candidate_subjects`
--
ALTER TABLE `candidate_subjects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `practical_examinations`
--
ALTER TABLE `practical_examinations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `⁠ id ⁠` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `schedulings`
--
ALTER TABLE `schedulings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
