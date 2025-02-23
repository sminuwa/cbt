-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 17, 2025 at 09:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ch_cbt_free`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `registration_id` bigint(20) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams_dates`
--

INSERT INTO `exams_dates` (`id`, `test_config_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-10-07', NULL, NULL),
(2, 4, '2024-10-07', NULL, NULL),
(3, 8, '2024-10-07', NULL, NULL),
(4, 12, '2024-10-07', NULL, NULL),
(8, 2, '2024-10-08', NULL, NULL),
(9, 5, '2024-10-08', NULL, NULL),
(10, 9, '2024-10-08', NULL, NULL),
(11, 13, '2024-10-08', NULL, NULL),
(15, 6, '2024-10-09', NULL, NULL),
(16, 10, '2024-10-09', NULL, NULL),
(17, 14, '2024-10-09', NULL, NULL),
(18, 3, '2024-10-10', NULL, NULL),
(19, 7, '2024-10-10', NULL, NULL),
(20, 11, '2024-10-10', NULL, NULL),
(21, 15, '2024-10-10', NULL, NULL),
(25, 16, '2024-10-09', '2024-10-09 20:28:23', '2024-10-09 20:28:23');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_types`
--

CREATE TABLE `exam_types` (
  `id` int(11) NOT NULL COMMENT 'this table stores types of candidate eg utme, student, employment  applicant, employee promotion',
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_types`
--

INSERT INTO `exam_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'CHPRBN National Examination', '2024-10-04 15:09:06', '2024-10-04 15:09:06');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(88, 'App\\Models\\Centre', 1, 'mobile-app-access', '8bc3ffbce3b131c9216b8c6c3376e4bf142f568a0fcbd99c8f8d7d2d709106ce', '[\"server:mobile-app\"]', NULL, '2024-10-05 14:16:19', '2024-10-02 16:32:31', '2024-10-05 14:16:19');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `practical_examinations`
--

INSERT INTO `practical_examinations` (`id`, `scheduled_candidate_id`, `candidate_id`, `practical_question_id`, `paper_id`, `schedule_id`, `score`, `examiner`, `created_at`, `updated_at`) VALUES
(1, 95, 1, 1, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(2, 253, 209, 1, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(3, 95, 1, 2, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(4, 253, 209, 2, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(5, 95, 1, 3, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(6, 253, 209, 3, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(7, 95, 1, 4, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(8, 253, 209, 4, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(9, 95, 1, 5, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(10, 253, 209, 5, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(11, 95, 1, 6, 4, 13, 5.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(12, 253, 209, 6, 4, 13, 4.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(13, 95, 1, 7, 4, 13, 4.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(14, 253, 209, 7, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(15, 95, 1, 8, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(16, 253, 209, 8, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(17, 95, 1, 9, 4, 13, 4.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(18, 253, 209, 9, 4, 13, 5.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(19, 95, 1, 10, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(20, 253, 209, 10, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(21, 95, 1, 11, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(22, 253, 209, 11, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(23, 95, 1, 12, 4, 13, 3.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(24, 253, 209, 12, 4, 13, 2.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(25, 95, 1, 13, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(26, 253, 209, 13, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(27, 95, 1, 14, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19'),
(28, 253, 209, 14, 4, 13, 1.00, 0, '2024-10-05 14:16:19', '2024-10-05 14:16:19');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programme_types`
--

CREATE TABLE `programme_types` (
  `id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pull_statuses`
--

INSERT INTO `pull_statuses` (`⁠ id ⁠`, `resource`, `pull_date`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 'basic-data', '2024-10-04 19:06:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:06:59', '2024-10-04 18:06:59'),
(2, 'test-data', '2024-10-04 19:07:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:07:04', '2024-10-04 18:07:04'),
(3, 'candidate-data', '2024-10-04 19:07:07', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:07:07', '2024-10-04 18:07:07'),
(4, 'basic-data', '2024-10-04 19:07:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:07:44', '2024-10-04 18:07:44'),
(5, 'test-data', '2024-10-04 19:07:49', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:07:49', '2024-10-04 18:07:49'),
(6, 'candidate-data', '2024-10-04 19:07:50', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:07:50', '2024-10-04 18:07:50'),
(7, 'basic-data', '2024-10-04 19:09:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:09:06', '2024-10-04 18:09:06'),
(8, 'test-data', '2024-10-04 19:09:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:09:09', '2024-10-04 18:09:09'),
(9, 'candidate-data', '2024-10-04 19:09:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-04 18:09:16', '2024-10-04 18:09:16'),
(10, 'basic-data', '2024-10-07 08:57:28', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 07:57:28', '2024-10-07 07:57:28'),
(11, 'test-data', '2024-10-07 08:57:55', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 07:57:55', '2024-10-07 07:57:55'),
(12, 'candidate-data', '2024-10-07 08:58:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 07:58:16', '2024-10-07 07:58:16'),
(13, 'basic-data', '2024-10-07 09:06:55', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:06:55', '2024-10-07 08:06:55'),
(14, 'test-data', '2024-10-07 09:07:02', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:07:02', '2024-10-07 08:07:02'),
(15, 'candidate-data', '2024-10-07 09:07:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:07:09', '2024-10-07 08:07:09'),
(16, 'basic-data', '2024-10-07 09:25:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:25:51', '2024-10-07 08:25:51'),
(17, 'basic-data', '2024-10-07 09:27:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:27:20', '2024-10-07 08:27:20'),
(18, 'test-data', '2024-10-07 09:29:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:29:04', '2024-10-07 08:29:04'),
(19, 'candidate-data', '2024-10-07 09:29:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 08:29:09', '2024-10-07 08:29:09'),
(20, 'basic-data', '2024-10-07 10:20:57', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:20:57', '2024-10-07 09:20:57'),
(21, 'test-data', '2024-10-07 10:21:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:21:04', '2024-10-07 09:21:04'),
(22, 'candidate-data', '2024-10-07 10:21:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:21:09', '2024-10-07 09:21:09'),
(23, 'basic-data', '2024-10-07 10:30:07', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:30:07', '2024-10-07 09:30:07'),
(24, 'test-data', '2024-10-07 10:30:14', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:30:14', '2024-10-07 09:30:14'),
(25, 'candidate-data', '2024-10-07 10:30:19', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:30:19', '2024-10-07 09:30:19'),
(26, 'basic-data', '2024-10-07 10:32:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:32:18', '2024-10-07 09:32:18'),
(27, 'test-data', '2024-10-07 10:32:21', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:32:21', '2024-10-07 09:32:21'),
(28, 'candidate-data', '2024-10-07 10:32:23', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:32:23', '2024-10-07 09:32:23'),
(29, 'basic-data', '2024-10-07 10:44:00', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:44:00', '2024-10-07 09:44:00'),
(30, 'test-data', '2024-10-07 10:46:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:46:15', '2024-10-07 09:46:15'),
(31, 'candidate-data', '2024-10-07 10:46:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:46:20', '2024-10-07 09:46:20'),
(32, 'basic-data', '2024-10-07 10:54:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:54:06', '2024-10-07 09:54:06'),
(33, 'test-data', '2024-10-07 10:54:14', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:54:14', '2024-10-07 09:54:14'),
(34, 'candidate-data', '2024-10-07 10:54:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:54:18', '2024-10-07 09:54:18'),
(35, 'test-data', '2024-10-07 10:55:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:55:13', '2024-10-07 09:55:13'),
(36, 'candidate-data', '2024-10-07 10:55:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:55:15', '2024-10-07 09:55:15'),
(37, 'basic-data', '2024-10-07 10:55:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 09:55:32', '2024-10-07 09:55:32'),
(38, 'basic-data', '2024-10-07 11:55:12', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 10:55:12', '2024-10-07 10:55:12'),
(39, 'test-data', '2024-10-07 11:55:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 10:55:16', '2024-10-07 10:55:16'),
(40, 'candidate-data', '2024-10-07 11:55:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 10:55:20', '2024-10-07 10:55:20'),
(41, 'basic-data', '2024-10-07 12:09:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:09:20', '2024-10-07 11:09:20'),
(42, 'test-data', '2024-10-07 12:09:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:09:26', '2024-10-07 11:09:26'),
(43, 'candidate-data', '2024-10-07 12:09:30', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:09:30', '2024-10-07 11:09:30'),
(44, 'basic-data', '2024-10-07 12:55:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:55:15', '2024-10-07 11:55:15'),
(45, 'test-data', '2024-10-07 12:55:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:55:59', '2024-10-07 11:55:59'),
(46, 'candidate-data', '2024-10-07 12:56:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 11:56:11', '2024-10-07 11:56:11'),
(47, 'basic-data', '2024-10-07 13:03:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:03:42', '2024-10-07 12:03:42'),
(48, 'test-data', '2024-10-07 13:03:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:03:59', '2024-10-07 12:03:59'),
(49, 'basic-data', '2024-10-07 13:09:57', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:09:57', '2024-10-07 12:09:57'),
(50, 'test-data', '2024-10-07 13:10:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:10:25', '2024-10-07 12:10:25'),
(51, 'candidate-data', '2024-10-07 13:11:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:11:11', '2024-10-07 12:11:11'),
(52, 'candidate-data', '2024-10-07 13:16:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:16:13', '2024-10-07 12:16:13'),
(53, 'candidate-data', '2024-10-07 13:16:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:16:29', '2024-10-07 12:16:29'),
(54, 'basic-data', '2024-10-07 13:35:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:35:06', '2024-10-07 12:35:06'),
(55, 'test-data', '2024-10-07 13:35:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:35:54', '2024-10-07 12:35:54'),
(56, 'candidate-data', '2024-10-07 13:36:02', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:36:02', '2024-10-07 12:36:02'),
(57, 'basic-data', '2024-10-07 13:38:45', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:38:45', '2024-10-07 12:38:45'),
(58, 'test-data', '2024-10-07 13:38:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:38:51', '2024-10-07 12:38:51'),
(59, 'candidate-data', '2024-10-07 13:38:56', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:38:56', '2024-10-07 12:38:56'),
(60, 'test-data', '2024-10-07 13:39:41', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:39:41', '2024-10-07 12:39:41'),
(61, 'test-data', '2024-10-07 13:39:48', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:39:48', '2024-10-07 12:39:48'),
(62, 'candidate-data', '2024-10-07 13:39:52', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:39:52', '2024-10-07 12:39:52'),
(63, 'basic-data', '2024-10-07 13:41:02', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:41:02', '2024-10-07 12:41:02'),
(64, 'test-data', '2024-10-07 13:41:07', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:41:07', '2024-10-07 12:41:07'),
(65, 'candidate-data', '2024-10-07 13:41:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 12:41:11', '2024-10-07 12:41:11'),
(66, 'basic-data', '2024-10-07 14:02:01', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:02:01', '2024-10-07 13:02:01'),
(67, 'test-data', '2024-10-07 14:02:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:02:04', '2024-10-07 13:02:04'),
(68, 'candidate-data', '2024-10-07 14:02:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:02:09', '2024-10-07 13:02:09'),
(69, 'candidate-data', '2024-10-07 14:03:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:03:15', '2024-10-07 13:03:15'),
(70, 'basic-data', '2024-10-07 14:07:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:07:25', '2024-10-07 13:07:25'),
(71, 'test-data', '2024-10-07 14:07:30', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:07:30', '2024-10-07 13:07:30'),
(72, 'candidate-data', '2024-10-07 14:07:34', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:07:34', '2024-10-07 13:07:34'),
(73, 'basic-data', '2024-10-07 14:13:36', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:13:36', '2024-10-07 13:13:36'),
(74, 'test-data', '2024-10-07 14:13:40', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:13:40', '2024-10-07 13:13:40'),
(75, 'candidate-data', '2024-10-07 14:13:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:13:44', '2024-10-07 13:13:44'),
(76, 'basic-data', '2024-10-07 14:17:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:17:06', '2024-10-07 13:17:06'),
(77, 'test-data', '2024-10-07 14:17:14', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:17:14', '2024-10-07 13:17:14'),
(78, 'candidate-data', '2024-10-07 14:17:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:17:25', '2024-10-07 13:17:25'),
(79, 'basic-data', '2024-10-07 14:20:49', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:20:49', '2024-10-07 13:20:49'),
(80, 'test-data', '2024-10-07 14:20:55', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:20:55', '2024-10-07 13:20:55'),
(81, 'candidate-data', '2024-10-07 14:20:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:20:59', '2024-10-07 13:20:59'),
(82, 'basic-data', '2024-10-07 14:25:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:25:24', '2024-10-07 13:25:24'),
(83, 'test-data', '2024-10-07 14:25:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:25:26', '2024-10-07 13:25:26'),
(84, 'candidate-data', '2024-10-07 14:25:28', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:25:28', '2024-10-07 13:25:28'),
(85, 'basic-data', '2024-10-07 14:27:36', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:27:36', '2024-10-07 13:27:36'),
(86, 'test-data', '2024-10-07 14:27:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:27:39', '2024-10-07 13:27:39'),
(87, 'candidate-data', '2024-10-07 14:27:41', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:27:41', '2024-10-07 13:27:41'),
(88, 'basic-data', '2024-10-07 14:34:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:34:09', '2024-10-07 13:34:09'),
(89, 'test-data', '2024-10-07 14:34:12', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:34:12', '2024-10-07 13:34:12'),
(90, 'candidate-data', '2024-10-07 14:34:17', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:34:17', '2024-10-07 13:34:17'),
(91, 'basic-data', '2024-10-07 14:39:34', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:39:34', '2024-10-07 13:39:34'),
(92, 'test-data', '2024-10-07 14:39:36', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:39:36', '2024-10-07 13:39:36'),
(93, 'candidate-data', '2024-10-07 14:39:38', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:39:38', '2024-10-07 13:39:38'),
(94, 'basic-data', '2024-10-07 14:42:58', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:42:58', '2024-10-07 13:42:58'),
(95, 'test-data', '2024-10-07 14:43:01', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:43:01', '2024-10-07 13:43:01'),
(96, 'candidate-data', '2024-10-07 14:43:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:43:04', '2024-10-07 13:43:04'),
(97, 'basic-data', '2024-10-07 14:48:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:48:11', '2024-10-07 13:48:11'),
(98, 'test-data', '2024-10-07 14:48:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:48:13', '2024-10-07 13:48:13'),
(99, 'candidate-data', '2024-10-07 14:48:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:48:15', '2024-10-07 13:48:15'),
(100, 'basic-data', '2024-10-07 14:54:46', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:54:46', '2024-10-07 13:54:46'),
(101, 'test-data', '2024-10-07 14:54:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:54:51', '2024-10-07 13:54:51'),
(102, 'candidate-data', '2024-10-07 14:54:56', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 13:54:56', '2024-10-07 13:54:56'),
(103, 'basic-data', '2024-10-07 15:01:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:01:16', '2024-10-07 14:01:16'),
(104, 'test-data', '2024-10-07 15:01:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:01:20', '2024-10-07 14:01:20'),
(105, 'candidate-data', '2024-10-07 15:01:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:01:26', '2024-10-07 14:01:26'),
(106, 'basic-data', '2024-10-07 15:08:34', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:08:34', '2024-10-07 14:08:34'),
(107, 'test-data', '2024-10-07 15:08:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:08:37', '2024-10-07 14:08:37'),
(108, 'candidate-data', '2024-10-07 15:08:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:08:39', '2024-10-07 14:08:39'),
(109, 'basic-data', '2024-10-07 15:44:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:44:11', '2024-10-07 14:44:11'),
(110, 'test-data', '2024-10-07 15:44:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:44:13', '2024-10-07 14:44:13'),
(111, 'candidate-data', '2024-10-07 15:44:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:44:15', '2024-10-07 14:44:15'),
(112, 'basic-data', '2024-10-07 15:46:19', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:46:19', '2024-10-07 14:46:19'),
(113, 'test-data', '2024-10-07 15:46:21', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:46:21', '2024-10-07 14:46:21'),
(114, 'candidate-data', '2024-10-07 15:46:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:46:26', '2024-10-07 14:46:26'),
(115, 'basic-data', '2024-10-07 15:50:27', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:50:27', '2024-10-07 14:50:27'),
(116, 'test-data', '2024-10-07 15:50:30', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:50:30', '2024-10-07 14:50:30'),
(117, 'candidate-data', '2024-10-07 15:50:35', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:50:35', '2024-10-07 14:50:35'),
(118, 'basic-data', '2024-10-07 15:54:47', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:54:47', '2024-10-07 14:54:47'),
(119, 'test-data', '2024-10-07 15:54:53', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:54:53', '2024-10-07 14:54:53'),
(120, 'candidate-data', '2024-10-07 15:54:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:54:54', '2024-10-07 14:54:54'),
(121, 'basic-data', '2024-10-07 15:57:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:57:15', '2024-10-07 14:57:15'),
(122, 'test-data', '2024-10-07 15:57:19', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:57:19', '2024-10-07 14:57:19'),
(123, 'candidate-data', '2024-10-07 15:57:21', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:57:21', '2024-10-07 14:57:21'),
(124, 'basic-data', '2024-10-07 15:59:52', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:59:52', '2024-10-07 14:59:52'),
(125, 'test-data', '2024-10-07 15:59:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 14:59:59', '2024-10-07 14:59:59'),
(126, 'candidate-data', '2024-10-07 16:00:00', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:00:00', '2024-10-07 15:00:00'),
(127, 'basic-data', '2024-10-07 16:11:40', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:11:40', '2024-10-07 15:11:40'),
(128, 'basic-data', '2024-10-07 16:12:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:12:03', '2024-10-07 15:12:03'),
(129, 'basic-data', '2024-10-07 16:12:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:12:39', '2024-10-07 15:12:39'),
(130, 'test-data', '2024-10-07 16:12:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:12:44', '2024-10-07 15:12:44'),
(131, 'candidate-data', '2024-10-07 16:12:46', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:12:46', '2024-10-07 15:12:46'),
(132, 'basic-data', '2024-10-07 16:17:14', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:17:14', '2024-10-07 15:17:14'),
(133, 'test-data', '2024-10-07 16:17:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:17:16', '2024-10-07 15:17:16'),
(134, 'candidate-data', '2024-10-07 16:17:17', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:17:17', '2024-10-07 15:17:17'),
(135, 'basic-data', '2024-10-07 16:21:01', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:21:01', '2024-10-07 15:21:01'),
(136, 'test-data', '2024-10-07 16:21:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:21:03', '2024-10-07 15:21:03'),
(137, 'candidate-data', '2024-10-07 16:21:05', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:21:05', '2024-10-07 15:21:05'),
(138, 'basic-data', '2024-10-07 16:29:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:29:24', '2024-10-07 15:29:24'),
(139, 'test-data', '2024-10-07 16:29:27', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:29:27', '2024-10-07 15:29:27'),
(140, 'candidate-data', '2024-10-07 16:29:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:29:29', '2024-10-07 15:29:29'),
(141, 'basic-data', '2024-10-07 16:40:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:40:13', '2024-10-07 15:40:13'),
(142, 'test-data', '2024-10-07 16:40:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:40:15', '2024-10-07 15:40:15'),
(143, 'candidate-data', '2024-10-07 16:40:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:40:16', '2024-10-07 15:40:16'),
(144, 'basic-data', '2024-10-07 16:49:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:49:04', '2024-10-07 15:49:04'),
(145, 'test-data', '2024-10-07 16:49:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:49:06', '2024-10-07 15:49:06'),
(146, 'candidate-data', '2024-10-07 16:49:08', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 15:49:08', '2024-10-07 15:49:08'),
(147, 'basic-data', '2024-10-07 17:02:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:02:51', '2024-10-07 16:02:51'),
(148, 'test-data', '2024-10-07 17:02:52', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:02:52', '2024-10-07 16:02:52'),
(149, 'candidate-data', '2024-10-07 17:02:53', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:02:53', '2024-10-07 16:02:53'),
(150, 'basic-data', '2024-10-07 17:14:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:14:25', '2024-10-07 16:14:25'),
(151, 'test-data', '2024-10-07 17:14:27', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:14:27', '2024-10-07 16:14:27'),
(152, 'candidate-data', '2024-10-07 17:14:31', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:14:31', '2024-10-07 16:14:31'),
(153, 'basic-data', '2024-10-07 17:17:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:17:15', '2024-10-07 16:17:15'),
(154, 'test-data', '2024-10-07 17:17:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:17:20', '2024-10-07 16:17:20'),
(155, 'candidate-data', '2024-10-07 17:17:23', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:17:23', '2024-10-07 16:17:23'),
(156, 'basic-data', '2024-10-07 17:29:45', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:29:45', '2024-10-07 16:29:45'),
(157, 'test-data', '2024-10-07 17:29:50', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:29:50', '2024-10-07 16:29:50'),
(158, 'candidate-data', '2024-10-07 17:29:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:29:51', '2024-10-07 16:29:51'),
(159, 'basic-data', '2024-10-07 17:43:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:43:18', '2024-10-07 16:43:18'),
(160, 'test-data', '2024-10-07 17:43:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:43:24', '2024-10-07 16:43:24'),
(161, 'candidate-data', '2024-10-07 17:43:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:43:26', '2024-10-07 16:43:26'),
(162, 'basic-data', '2024-10-07 17:44:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:44:37', '2024-10-07 16:44:37'),
(163, 'test-data', '2024-10-07 17:44:41', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:44:41', '2024-10-07 16:44:41'),
(164, 'candidate-data', '2024-10-07 17:44:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:44:44', '2024-10-07 16:44:44'),
(165, 'basic-data', '2024-10-07 17:45:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:45:39', '2024-10-07 16:45:39'),
(166, 'test-data', '2024-10-07 17:45:43', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:45:43', '2024-10-07 16:45:43'),
(167, 'candidate-data', '2024-10-07 17:45:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:45:44', '2024-10-07 16:45:44'),
(168, 'basic-data', '2024-10-07 17:54:31', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:54:31', '2024-10-07 16:54:31'),
(169, 'test-data', '2024-10-07 17:54:33', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:54:33', '2024-10-07 16:54:33'),
(170, 'candidate-data', '2024-10-07 17:54:35', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 16:54:35', '2024-10-07 16:54:35'),
(171, 'basic-data', '2024-10-07 18:02:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:02:24', '2024-10-07 17:02:24'),
(172, 'test-data', '2024-10-07 18:02:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:02:25', '2024-10-07 17:02:25'),
(173, 'candidate-data', '2024-10-07 18:02:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:02:26', '2024-10-07 17:02:26'),
(174, 'basic-data', '2024-10-07 18:14:46', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:14:46', '2024-10-07 17:14:46'),
(175, 'test-data', '2024-10-07 18:14:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:14:51', '2024-10-07 17:14:51'),
(176, 'candidate-data', '2024-10-07 18:14:53', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:14:53', '2024-10-07 17:14:53'),
(177, 'basic-data', '2024-10-07 18:25:57', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:25:57', '2024-10-07 17:25:57'),
(178, 'test-data', '2024-10-07 18:26:00', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:26:00', '2024-10-07 17:26:00'),
(179, 'candidate-data', '2024-10-07 18:26:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:26:03', '2024-10-07 17:26:03'),
(180, 'basic-data', '2024-10-07 18:36:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:36:20', '2024-10-07 17:36:20'),
(181, 'test-data', '2024-10-07 18:36:21', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:36:21', '2024-10-07 17:36:21'),
(182, 'candidate-data', '2024-10-07 18:36:22', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:36:22', '2024-10-07 17:36:22'),
(183, 'basic-data', '2024-10-07 18:50:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:50:32', '2024-10-07 17:50:32'),
(184, 'test-data', '2024-10-07 18:50:36', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:50:36', '2024-10-07 17:50:36'),
(185, 'candidate-data', '2024-10-07 18:50:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 17:50:39', '2024-10-07 17:50:39'),
(186, 'basic-data', '2024-10-07 00:00:00', 'FAILURE', 'Failed to fetch data from API', '2024-10-07 18:57:24', '2024-10-07 18:57:24'),
(187, 'basic-data', '2024-10-07 00:00:00', 'FAILURE', 'Failed to fetch data from API', '2024-10-07 18:58:01', '2024-10-07 18:58:01'),
(188, 'basic-data', '2024-10-07 00:00:00', 'FAILURE', 'Failed to fetch data from API', '2024-10-07 18:58:09', '2024-10-07 18:58:09'),
(189, 'basic-data', '2024-10-07 00:00:00', 'FAILURE', 'Failed to fetch data from API', '2024-10-07 18:58:23', '2024-10-07 18:58:23'),
(190, 'basic-data', '2024-10-07 00:00:00', 'FAILURE', 'Failed to fetch data from API', '2024-10-07 18:58:50', '2024-10-07 18:58:50'),
(191, 'basic-data', '2024-10-07 20:00:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:00:44', '2024-10-07 19:00:44'),
(192, 'test-data', '2024-10-07 20:00:50', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:00:50', '2024-10-07 19:00:50'),
(193, 'basic-data', '2024-10-07 20:01:04', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:01:04', '2024-10-07 19:01:04'),
(194, 'test-data', '2024-10-07 20:01:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:01:09', '2024-10-07 19:01:09'),
(195, 'candidate-data', '2024-10-07 20:01:12', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:01:12', '2024-10-07 19:01:12'),
(196, 'basic-data', '2024-10-07 20:02:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:02:39', '2024-10-07 19:02:39'),
(197, 'test-data', '2024-10-07 20:02:43', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:02:43', '2024-10-07 19:02:43'),
(198, 'candidate-data', '2024-10-07 20:02:49', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:02:49', '2024-10-07 19:02:49'),
(199, 'basic-data', '2024-10-07 20:05:33', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:05:33', '2024-10-07 19:05:33'),
(200, 'test-data', '2024-10-07 20:05:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:05:37', '2024-10-07 19:05:37'),
(201, 'candidate-data', '2024-10-07 20:05:39', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-07 19:05:39', '2024-10-07 19:05:39'),
(202, 'basic-data', '2024-10-08 07:05:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 06:05:26', '2024-10-08 06:05:26'),
(203, 'test-data', '2024-10-08 07:05:28', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 06:05:28', '2024-10-08 06:05:28'),
(204, 'candidate-data', '2024-10-08 07:05:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 06:05:29', '2024-10-08 06:05:29'),
(205, 'basic-data', '2024-10-08 13:39:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:39:54', '2024-10-08 12:39:54'),
(206, 'test-data', '2024-10-08 13:39:57', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:39:57', '2024-10-08 12:39:57'),
(207, 'candidate-data', '2024-10-08 13:39:58', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:39:58', '2024-10-08 12:39:58'),
(208, 'basic-data', '2024-10-08 13:46:33', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:46:33', '2024-10-08 12:46:33'),
(209, 'test-data', '2024-10-08 13:46:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:46:37', '2024-10-08 12:46:37'),
(210, 'candidate-data', '2024-10-08 13:46:40', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 12:46:40', '2024-10-08 12:46:40'),
(211, 'basic-data', '2024-10-08 14:04:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:20', '2024-10-08 13:04:20'),
(212, 'test-data', '2024-10-08 14:04:22', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:22', '2024-10-08 13:04:22'),
(213, 'candidate-data', '2024-10-08 14:04:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:24', '2024-10-08 13:04:24'),
(214, 'basic-data', '2024-10-08 14:04:51', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:51', '2024-10-08 13:04:51'),
(215, 'test-data', '2024-10-08 14:04:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:54', '2024-10-08 13:04:54'),
(216, 'candidate-data', '2024-10-08 14:04:55', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:04:55', '2024-10-08 13:04:55'),
(217, 'basic-data', '2024-10-08 14:06:22', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:06:22', '2024-10-08 13:06:22'),
(218, 'test-data', '2024-10-08 14:06:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:06:25', '2024-10-08 13:06:25'),
(219, 'candidate-data', '2024-10-08 14:06:26', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:06:26', '2024-10-08 13:06:26'),
(220, 'basic-data', '2024-10-08 14:08:05', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:08:05', '2024-10-08 13:08:05'),
(221, 'test-data', '2024-10-08 14:08:08', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:08:08', '2024-10-08 13:08:08'),
(222, 'candidate-data', '2024-10-08 14:08:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:08:09', '2024-10-08 13:08:09'),
(223, 'basic-data', '2024-10-08 14:21:31', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:21:31', '2024-10-08 13:21:31'),
(224, 'test-data', '2024-10-08 14:21:35', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:21:35', '2024-10-08 13:21:35'),
(225, 'candidate-data', '2024-10-08 14:21:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:21:37', '2024-10-08 13:21:37'),
(226, 'basic-data', '2024-10-08 14:24:14', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:24:14', '2024-10-08 13:24:14'),
(227, 'test-data', '2024-10-08 14:24:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:24:16', '2024-10-08 13:24:16'),
(228, 'candidate-data', '2024-10-08 14:24:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:24:18', '2024-10-08 13:24:18'),
(229, 'basic-data', '2024-10-08 14:26:52', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:26:52', '2024-10-08 13:26:52'),
(230, 'test-data', '2024-10-08 14:26:58', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:26:58', '2024-10-08 13:26:58'),
(231, 'candidate-data', '2024-10-08 14:27:00', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:27:00', '2024-10-08 13:27:00'),
(232, 'basic-data', '2024-10-08 14:51:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:51:25', '2024-10-08 13:51:25'),
(233, 'test-data', '2024-10-08 14:51:28', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:51:28', '2024-10-08 13:51:28'),
(234, 'candidate-data', '2024-10-08 14:51:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:51:29', '2024-10-08 13:51:29'),
(235, 'basic-data', '2024-10-08 14:53:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:53:13', '2024-10-08 13:53:13'),
(236, 'test-data', '2024-10-08 14:53:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:53:16', '2024-10-08 13:53:16'),
(237, 'candidate-data', '2024-10-08 14:53:18', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:53:18', '2024-10-08 13:53:18'),
(238, 'basic-data', '2024-10-08 14:55:38', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:55:38', '2024-10-08 13:55:38'),
(239, 'test-data', '2024-10-08 14:55:40', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:55:40', '2024-10-08 13:55:40'),
(240, 'candidate-data', '2024-10-08 14:55:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 13:55:42', '2024-10-08 13:55:42'),
(241, 'basic-data', '2024-10-08 15:10:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:10:03', '2024-10-08 14:10:03'),
(242, 'test-data', '2024-10-08 15:10:06', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:10:06', '2024-10-08 14:10:06'),
(243, 'candidate-data', '2024-10-08 15:10:07', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:10:07', '2024-10-08 14:10:07'),
(244, 'basic-data', '2024-10-08 15:26:09', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:26:09', '2024-10-08 14:26:09'),
(245, 'test-data', '2024-10-08 15:26:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:26:11', '2024-10-08 14:26:11'),
(246, 'candidate-data', '2024-10-08 15:26:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 14:26:13', '2024-10-08 14:26:13'),
(247, 'basic-data', '2024-10-08 16:31:23', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:31:23', '2024-10-08 15:31:23'),
(248, 'test-data', '2024-10-08 16:31:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:31:25', '2024-10-08 15:31:25'),
(249, 'candidate-data', '2024-10-08 16:31:27', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:31:27', '2024-10-08 15:31:27'),
(250, 'basic-data', '2024-10-08 16:32:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:32:13', '2024-10-08 15:32:13'),
(251, 'test-data', '2024-10-08 16:32:16', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:32:16', '2024-10-08 15:32:16'),
(252, 'candidate-data', '2024-10-08 16:32:17', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-08 15:32:17', '2024-10-08 15:32:17'),
(253, 'basic-data', '2024-10-09 07:51:28', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 06:51:28', '2024-10-09 06:51:28'),
(254, 'test-data', '2024-10-09 07:51:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 06:51:29', '2024-10-09 06:51:29'),
(255, 'candidate-data', '2024-10-09 07:51:31', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 06:51:31', '2024-10-09 06:51:31'),
(256, 'basic-data', '2024-10-09 09:34:15', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:34:15', '2024-10-09 08:34:15'),
(257, 'test-data', '2024-10-09 09:34:34', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:34:34', '2024-10-09 08:34:34'),
(258, 'candidate-data', '2024-10-09 09:34:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:34:42', '2024-10-09 08:34:42'),
(259, 'basic-data', '2024-10-09 09:37:23', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:37:23', '2024-10-09 08:37:23'),
(260, 'test-data', '2024-10-09 09:37:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:37:29', '2024-10-09 08:37:29'),
(261, 'candidate-data', '2024-10-09 09:37:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:37:32', '2024-10-09 08:37:32'),
(262, 'basic-data', '2024-10-09 09:38:56', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:38:56', '2024-10-09 08:38:56'),
(263, 'test-data', '2024-10-09 09:39:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:39:03', '2024-10-09 08:39:03'),
(264, 'candidate-data', '2024-10-09 09:39:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:39:11', '2024-10-09 08:39:11'),
(265, 'basic-data', '2024-10-09 09:43:58', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:43:58', '2024-10-09 08:43:58'),
(266, 'test-data', '2024-10-09 09:44:01', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:44:01', '2024-10-09 08:44:01'),
(267, 'candidate-data', '2024-10-09 09:44:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-09 08:44:03', '2024-10-09 08:44:03'),
(268, 'basic-data', '2024-10-21 18:32:21', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:32:21', '2024-10-21 17:32:21'),
(269, 'test-data', '2024-10-21 18:32:29', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:32:29', '2024-10-21 17:32:29'),
(270, 'candidate-data', '2024-10-21 18:32:32', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:32:32', '2024-10-21 17:32:32'),
(271, 'basic-data', '2024-10-21 18:43:48', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:43:48', '2024-10-21 17:43:48'),
(272, 'test-data', '2024-10-21 18:43:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:43:54', '2024-10-21 17:43:54'),
(273, 'candidate-data', '2024-10-21 18:43:59', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 17:43:59', '2024-10-21 17:43:59'),
(274, 'basic-data', '2024-10-21 20:43:00', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 19:43:00', '2024-10-21 19:43:00'),
(275, 'test-data', '2024-10-21 20:43:10', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 19:43:10', '2024-10-21 19:43:10'),
(276, 'candidate-data', '2024-10-21 20:43:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-21 19:43:24', '2024-10-21 19:43:24'),
(277, 'basic-data', '2024-10-22 11:10:13', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:10:13', '2024-10-22 10:10:13'),
(278, 'test-data', '2024-10-22 11:10:20', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:10:20', '2024-10-22 10:10:20'),
(279, 'candidate-data', '2024-10-22 11:10:23', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:10:23', '2024-10-22 10:10:23'),
(280, 'basic-data', '2024-10-22 11:54:25', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:54:25', '2024-10-22 10:54:25'),
(281, 'test-data', '2024-10-22 11:54:37', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:54:37', '2024-10-22 10:54:37'),
(282, 'candidate-data', '2024-10-22 11:54:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 10:54:44', '2024-10-22 10:54:44'),
(283, 'basic-data', '2024-10-22 12:08:31', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:08:31', '2024-10-22 11:08:31'),
(284, 'test-data', '2024-10-22 12:08:38', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:08:38', '2024-10-22 11:08:38'),
(285, 'candidate-data', '2024-10-22 12:08:42', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:08:42', '2024-10-22 11:08:42'),
(286, 'basic-data', '2024-10-22 12:12:48', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:12:48', '2024-10-22 11:12:48'),
(287, 'test-data', '2024-10-22 12:12:58', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:12:58', '2024-10-22 11:12:58'),
(288, 'candidate-data', '2024-10-22 12:13:03', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:13:03', '2024-10-22 11:13:03'),
(289, 'basic-data', '2024-10-22 12:17:11', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:17:11', '2024-10-22 11:17:11'),
(290, 'test-data', '2024-10-22 12:17:19', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:17:19', '2024-10-22 11:17:19'),
(291, 'candidate-data', '2024-10-22 12:17:24', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-22 11:17:24', '2024-10-22 11:17:24'),
(292, 'basic-data', '2024-10-23 16:29:44', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 15:29:44', '2024-10-23 15:29:44'),
(293, 'test-data', '2024-10-23 16:29:50', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 15:29:50', '2024-10-23 15:29:50'),
(294, 'candidate-data', '2024-10-23 16:29:54', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 15:29:54', '2024-10-23 15:29:54'),
(295, 'basic-data', '2024-10-23 17:08:12', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 16:08:12', '2024-10-23 16:08:12'),
(296, 'test-data', '2024-10-23 17:08:22', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 16:08:22', '2024-10-23 16:08:22'),
(297, 'candidate-data', '2024-10-23 17:08:30', 'SUCCESS', 'Data pulled and inserted successfully', '2024-10-23 16:08:30', '2024-10-23 16:08:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_banks`
--

INSERT INTO `question_banks` (`id`, `title`, `difficulty_level`, `questiontime`, `active`, `author`, `subject_id`, `topic`, `topic_id`, `created_at`, `updated_at`) VALUES
(5, 'The conference that led to the birth of primary health care as the key to health for all was held on ---------------------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(35, 'The cells are made up of:', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(38, 'One of the following blood vessels carry oxygenated blood', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(39, 'The thoracic cage contains mainly the following', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(54, 'One of these is not a part of the innominate bone', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(58, 'One of the functions of liver is', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(66, 'One of the following is not the type of emergency conditions', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(69, 'One of the these is not an aim of first AID', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(70, 'One of the following is not a cause of acute abdominal pain', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:07', '2024-10-07 03:59:07'),
(91, 'One of the following is not a method of artificial respiration', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(112, 'In addition to assessment of APGAR score of a new born ------------------------ must be checked and proper referral made if found in a male baby', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(114, 'A condition that occurs when a baby does not get adequate oxygen before, during or just after birth, is referred to as;', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(122, 'A new born should be given ----------------', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(125, '---------------------- is used for newborn cord care', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(126, 'The gradual introduction of adult or family foods in semi solid forms to babies without stopping breastfeeding is called ----------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(137, 'A lactating mother produces about ----------- amount of breast milk per day', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(141, 'One of the following is not a direct method of nutritional assessment', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(142, 'One of the following is not a factor that affects the nutritional status of a child', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(165, 'The process of finding out the actual health status of a given community is called', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(171, 'All are principles of health education except one', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(172, 'The process of encouraging, inspiring and arousing the interest of people to make them aware of their health problem is called -----------------------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(175, 'Strategies of health education includes all except one', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(176, 'Select the correct answer of visual aids', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:08', '2024-10-07 03:59:08'),
(185, '--------------------- is a corner stone of primary health care and its element', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(188, '---------------------- is the transfer of ideas from the sender to the receiver', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(198, 'Increase in respiratory rate can be caused by one of the following', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(201, 'All except one is vital sign', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(202, 'Abnormal chest/heartbeat are as follows but one', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(204, 'Component of blood pressure include one of the following', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(215, 'Signs and symptoms of snake bite includes all except one', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(222, 'One of the following is not among graphical representation of data', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(240, 'The proportion of a score interval multiplied by 100 is?', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(244, 'A data that represents an order series of relationships or rank order is referred to as;', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(257, 'Ante natal is given to:', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(261, 'Successful implementation of the zygote in the uterus is called', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(266, 'Which of these is true about the pelvic bone?', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(272, 'All except one is benefit of safe motherhood initiatives', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(274, 'The acronym &ldquo;MIYCF&rdquo; means', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(276, 'One among is the appropriate steps of conducting health education talk on reproductive health services.', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:09', '2024-10-07 03:59:09'),
(289, 'The special x ray technique used to determine the structure of the breast is known as ----------', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(296, 'What is the most common symptom of peptic ulcer', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(301, 'Which symptom is indicative of a urinary tract infection (UTI) in older adults', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(311, 'Which of the following is a symptom of migraine headache', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(312, 'All except one is probable signs of pregnancy', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(313, 'One of this is a positive signs of pregnancy', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(316, '------------------ is a condition in pregnancy characterized by proteinuria, hypertension and generalized Oedema.', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(321, 'One of these is not a sign of 3rd stage of labour', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(322, 'This is not a component of maternal health', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(324, '---------------- is a fairly common white mucoid non irritating discharge occurring in pregnancy and caused by a chronic infection of low virulence?', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(339, 'A placenta that lies partially or wholly in the lower uterine segment is referred to as ---------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(340, 'One of these is a danger of placenta praevia', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(355, 'These group of persons but one is at risk of deliberate self-harm', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(359, 'This is a type of mental disorders', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(363, 'Which approach emphasizes the importance of addressing social determinants of health in promoting mental well being', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(364, 'In the context of community mental health, what does the term stigma refers to?', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(369, 'One of these does not trigger mental issues', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(379, '---------------- Disease that occur frequently and irregularly is called', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(386, '----------------------- is the causative agent of ANTHRAX', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(391, 'Host is an organism that harbors ------------------', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:10', '2024-10-07 03:59:10'),
(394, 'Select the incorrect answer in the list of four strategies for the control of Tuberculosis and leprosy', 'difficult', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(399, 'The number of cases of a disease that are present in a particular population at a given period of time is called ------------------------', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(403, 'Which of the following is not a preventable disease', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(422, 'One of the following is not at risk of possible occupational hazard or infection from blood fluid and aerosols', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(426, 'One of the following is not an occupational hazard of farming', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(427, 'One of this is a zoonotic disease', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(428, '-------------------- is an occupational disease caused by the inhalation of finely divided silicon dioxide (silica).', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(433, 'Real needs refer to:', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(438, 'Form &ldquo;F&rdquo; is used during situation analysis for collection of -----------------------', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(443, 'Which of the following statement is true about community diagnosis?', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(452, 'A good map in community diagnosis has the characteristics but one;', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(454, '--------------------- is a means of encouraging, influencing and arousing the interest of people to make them actively involved in finding out solutions to their problems', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:11', '2024-10-07 03:59:11'),
(469, 'The process by which a person is made immune or resistant to a specific infection, typically by the administration of vaccine is called ---------------------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(471, 'IPV stands for ------------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(474, 'Individuals who started the immunization process but for one reason or the other have stopped or refused to continue and complete the required doses is best defined as ----------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(482, '---------------------------- is the percentage of eligible fully immunized infants compared to the total number of surviving infants in the target population', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(492, 'All but one is contra-indication to oral route temperature taking', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(524, 'The aspect of laboratory services that is responsible for analyzing the presence of antibodies in a patient&rsquo;s blood to detect diseases such as HIV and Hepatitis is', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(533, 'One of these is not a rationale for urine collection', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(537, '----------------- is the process of collecting blood from donors for the purpose of transfusion, diagnosis or experiment', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:12', '2024-10-07 03:59:12'),
(547, 'The hazards commonly found in human environment are all except', 'moderate', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:13', '2024-10-07 03:59:13'),
(550, 'The broad objectives of a waste disposal system comprise of all except', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:13', '2024-10-07 03:59:13'),
(557, 'Personal health is not usually promoted and maintained through ----------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:13', '2024-10-07 03:59:13'),
(570, 'The key to zero waste management includes all but one', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:13', '2024-10-07 03:59:13'),
(586, 'The regulatory body that serves as a link between the government and CHP is -----------------', 'simple', NULL, 'true', 1, 1, NULL, 1, '2024-10-07 03:59:13', '2024-10-07 03:59:13'),
(613, 'The medium through which message is transmitted is:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(618, 'A combination of one or more channel in communication of health information to the community members is referred to as:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(619, 'The process of health communication exclude:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(637, 'PHCUOR was necessitated and introduced as a result of the following rationale', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(655, 'One the following is not among the basic component of community', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(660, 'One of the following is not a step-in community mobilization', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(661, 'One of the following is not a member of Local Government Health Development Committee', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(670, 'One the following is among the steps involves in advocacy:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:50', '2024-10-07 04:04:50'),
(689, 'A non-registered community health practitioner can work in:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(691, 'One of the following is not a behaviour expected of a community health practitioner towards his employer:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(703, 'One of the following best defines essential medicines in the current contest:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(706, 'The use of drugs refers to the appropriate and judicious use of medications in health care, based on scientific evidence, clinical guidelines, and individual patient&rsquo;s needs is:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(707, 'Steps in the management of essential medicines does not take into cognisance of the following', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(714, 'Rifampin, Isoniazid, Pyrazinamide and Ethambutol belong to which class of drugs', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(718, 'Drug quantification method that is based on outbreak of disease during the period of study or ordering interval is:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(727, 'One of the following medicines is contraindicated in individuals suffering from hepatic disorders', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(730, 'The acronym NAFDAC connotes:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(731, 'A system implored continuously to monitor the safety and efficacy of drugs thereby addressing problems associated with drug use is termed', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(733, 'Tablet praziquanted is 600mg available, and a patient diagnosed with schistosomiasis is placed on 2.4g start. How many tablets would the patient take?', 'difficult', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(736, 'One of the following statements best explains pharmacovigilance:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(755, 'One of the following is not a sign of drugs addiction:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(757, 'The signs of drugs spoilage do not includes:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:51', '2024-10-07 04:04:51'),
(763, 'The chemical substances use for treatment, prevention or diagnosis of diseases is refers to as:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(765, 'A situation whereby one or more health facility is bye-pass into another higher institution during the course of transferring a responsibility by health worker is:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(770, 'Identifying the highest level of referral in the followings', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(772, 'For cases presenting in the health centre but are not covered by the standing orders, CHEW can:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(782, 'Services that is crucial for tracking progress, assessing effectiveness and ensuring accountability is called:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(784, 'Outreach services can be supported by the community members through one of the following areas:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(794, 'One of the following is an example of nutritional disorder:', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(797, 'The art of passing nutritional knowledge to an individual in order to improve health is:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(805, 'One of these is a major nutritional disorder during pregnancy', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(811, 'About half of your diet should be made up of', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(817, 'Availability of food stuff at all times in enough quantity and quality to everybody in the household is referred to as:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(818, 'The statement of objectives, priorities and decision taken on a food is:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(819, 'The continues monitoring of factors or conditions that impede on nutritional status of individua/ groups is known as:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:52', '2024-10-07 04:04:52'),
(826, 'One of the following is not a complication of wounds:', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(837, 'One of the following is not a measure for preventing accident in the community', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(843, 'Which of the following is not a type of shock', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(850, 'The wound which is as a result of accidental injury where there are pathogenic organisms and foreign bodies in the wound is', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(860, 'In a cement factory one of these is not peculiar disease condition among the worker', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(871, 'The objectives of factory inspection do not include one of the followings', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(874, 'The positive effect of work on health does not include one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(875, 'A generic name for the group of health problems arising from inhalation of respirable dusts is', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(876, 'An official visit by a designated team of professionals to carry out a scientific examination of a work place where more people are gainfully employed in manual work is referred to as', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(886, 'One of the following is not among the methods used in food preservation', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(887, 'One of these is not a component of Environmental Health', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:53', '2024-10-07 04:04:53'),
(892, 'One of the major problems confronting effective solid waste management is', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(894, 'The physical environmental health hazard includes one of the following', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(901, 'How does climate change leads to conflicts in vulnerable region', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(910, 'In symptomatology, diagnosis refers to', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(911, 'All the following is not true about the general signs and symptoms of disease in an individual', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(926, 'One of the following is not a cause of duodenal ulcer', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(937, 'A condition in which elimination of faeces from the bowel is difficult or painful is clinically known as', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(940, 'The act enacted to protect the right and dignity of people with mental illness in Nigeria is', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(946, 'Experiences such as living in a war zone can increase the risk of one of the following mental health conditions \r\na. Phobia\r\nb. Alcoholism\r\nc. Irritability ==\r\nd. Post traumatic stress disorder', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(947, 'Some trait perfectionism or low self-esteem could predispose an individual to', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(948, 'Schizophrenia is best managed using one of the following classes of medicine', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(950, 'The predisposing factors of mental health illnesses does not include one of the following', 'simple', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(956, 'Common forms of stigma and stereotypes associated with mental illness does not include one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 2, '2024-10-07 04:04:54', '2024-10-07 04:04:54'),
(974, 'One of the following is not a type of learning', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(976, 'One of the following is not a factor underlying human behaviour', 'simple', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(984, 'Which of the following is true on factors that motivate an individual best performance in an organization', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(985, 'One of the following is not among the learning theories', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(989, 'An individual&rsquo;s positive or negative view and evaluation of something with a \r\n tendency to response is____________________________________________________', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(995, 'Which of the following is not an underlying factor for human behaviour', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:19', '2024-10-07 04:08:19'),
(999, 'One of the following defined Sociology as the science of institution', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1004, 'The psychoanalytic theory of disease suggests that illness can result from one of the following', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1026, 'Which of the following represent the origin of Nigeria health System', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1046, 'The first hospital in Nigeria was established in the year', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1060, 'One of these is not a merit of integration of services', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1063, 'Responsibilities of Primary Health care Development Committee does not include one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:20', '2024-10-07 04:08:20'),
(1081, 'The Primary Health Care approach which emphasis on high quality care given at a required standard is known as____________________________________________', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1082, 'After Alma-Ata declaration in 1978, Primary Health Care was fully implemented in Nigeria in the year________________________________', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1086, 'One of the following is not a pillar of Primary Health Care Under One Roof', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1088, 'The criteria for someone to be considered as a Community Health Practitioner does not include one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1089, 'One of these is not the duty of a Community Health Practitioner', 'simple', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1094, 'The rights of a client/patient exclude one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1098, 'The classification professional ethics exclude one of these', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1110, 'One of the following is not a tool used in organization and delivery of health promotion activities', 'simple', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1112, 'One of these is not among the principles of health education', 'simple', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1125, 'One of the following is not a step in carrying out health education', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1130, 'Behaviour change is a broad range of activities and approaches which focus on the individual, community and environment which is', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1141, 'Misoprostol is contraindicated to pregnant woman because it causes', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1142, 'Pharmacokinetics parameter of a drug involves all the following excluding', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1144, 'One of the following is not an example of vitamin', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1145, 'One of the following is not among steps for stocking of drugs', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1146, 'The best drug of choice for the treatment of bilharziasis is', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:21', '2024-10-07 04:08:21'),
(1163, 'One of the following does not promote rational use of drugs', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1166, '____________________________________. can be viewed as the use of drugs for the right diagnosis, dosage duration', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1170, 'One of the following is not a constraint to outreach services', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1182, 'The assets that can be converted into cash within a short period are known as', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1184, 'Written evidence in support of a business transaction is called', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1193, 'The debts which are to be paid within a short period (a year or less) are referred to as', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:22', '2024-10-07 04:08:22'),
(1204, 'A document that is produced each time a supplier sale goods and services to his/her customer is', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1206, 'The posting of debit entry to one account and a corresponding credit entry to another is known as________________________________________________', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1218, 'One of the following is not an element of Management by objective (MOB)', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1220, 'One of the following is not a cause of poor service coverage', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1223, 'The style of leadership that a leader manages the organization through sharing of ideas/opinions with staff is', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1224, 'Which of these is not a quality of good supervisor', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1225, 'All of these, excluding one, are workers needs to be satisfied in order to improve efficiency of work and services', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1229, 'The fundamental thinking that preceded the formulation of management science was introduced by', 'difficult', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1238, 'One of the following is not among the main components of motivation', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1239, 'A type of supervision in which the supervisor is present at all time is____________________________________', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1246, 'One of the following is not among the importance of human resource training', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1256, 'The study of adult learning is known as', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1258, 'The primary role of human resource management includes one of the following', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:23', '2024-10-07 04:08:23'),
(1270, 'The primary prevention for HIV/AIDS excludes', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:24', '2024-10-07 04:08:24'),
(1272, 'The first ever instance of AIDS was reported in one of the following countries', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:24', '2024-10-07 04:08:24'),
(1278, 'Nigeria has adopted the &ldquo;opt-out strategy&rdquo; to boost access to HIV testing services for the following except', 'moderate', NULL, 'true', 1, 1, NULL, 3, '2024-10-07 04:08:24', '2024-10-07 04:08:24'),
(1289, 'The black part of the eye is best described as --------------------', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:41', '2024-10-07 04:14:41'),
(1290, 'The nerve that connects the eye to the brain is --------------------', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:41', '2024-10-07 04:14:41'),
(1302, 'The organ of the eye that controls the amount of light entering the eye is called', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1303, 'The photo sensitive portion of the eye that is responsible for vision is called', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1304, 'Which instrument is used for testing the sight at a distance is called', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1306, 'The only solid part of the eye is --------------------------', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1308, 'The disease process of dental caries stands in the', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1316, 'Decalcification of a tooth means', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1319, 'Which one of these options is not a cause of dental caries', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1323, 'Which of the following is not a benefit of regular dental check up', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1338, 'One of the following should not be considered when communicating with a sensorineural hearing loss person', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1370, 'One of the following is not a major cause of morbidity and mortality among Nigerian children', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1371, '------------------- is a strategy adopted by IMCI', 'difficult', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:42', '2024-10-07 04:14:42'),
(1382, 'The rationale for school meal service includes all except one', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1386, 'One of the genetic causes of mental handicap is', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1392, 'Which of the following best defined first aid', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1407, 'Preterm babies born before ---------------- weeks of gestation', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1408, 'In community based newborn care, home visit for birth preparedness is seen as;', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1410, 'Intervention packages in community based newborn care, does not include;', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1418, 'The small baby encounters all except one of these possible complications except', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1431, 'Which of these interventions will not prevent neonatal mortality in Nigeria?', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1433, 'One of the following is not a communicable disease', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1450, 'The primary cause of sickle cell disease is', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1452, 'One of the following is a characteristics symptom of anemia', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1453, 'The following complication can occur as a result of severe Anaemia', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1455, '--------------- can be defined as a decrease in the haemoglobin level of an individual', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:43', '2024-10-07 04:14:43'),
(1456, 'A disease that cannot be transferred from one person to another is ----------------', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1461, 'Which of the following is a symptom of chronic obstructive pulmonary disease (COPD)', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1468, '----------------- is an advantage of family planning to the child', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1472, 'The criteria for assessing the appropriateness of a contraceptive method does not include;', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1473, '--------------- is not a hormonal method of contraception', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1474, 'A side effect of oral contraceptive does not include', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1490, 'This is not a cause of infertility in males', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1491, '---------------- and ------------- are permanent methods of family planning', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1493, 'Factors affecting the utilization of family planning services are ---------------', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1502, 'Information system used for accessing, monitoring, organizing and visualizing reports of disease outbreaks according to geography, time and infectious disease agent, is best described as ---------------', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1504, 'The role of community mobilization in PHC includes all except one ---------------', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1514, 'Which of the following is a rationale of community mobilization', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1518, 'ethods used in community diagnosis includes;', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1524, 'One of the following is not among the phases of community needs assessment', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1530, 'In middle adolescence (age 15-17 years), the child starts to', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1539, 'These are all types of STIs except', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1551, 'The AYFHS, as an acronym in adolescent means', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:44', '2024-10-07 04:14:44'),
(1580, 'Which of these is not among the job factors affecting choice of style of supervision', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1583, 'The principle of management which state that responsibility, authority and accountability should be shared with subordinates, while the manager still maintains control is called', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1604, 'The type of diarrhea commonly associated with HIV infection and is characterized by persistent watery diarrhea', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1618, 'All except one describes a good school environment', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1619, 'Which of the following best defines first Aider does not', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1629, '---------------------- is a non-inflammatory determination of articular cartilages', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1636, 'One of the ways to promote social interaction among the elderly is', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1637, 'Which of the following disease is not a common cause of blindness among the elderly', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1638, 'One of the following options is not a remedy for the aged muscular skeletal problem', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:45', '2024-10-07 04:14:45'),
(1651, 'One of these is not among the services available for the aged in the community', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1652, 'Risk factors associated with cardiac disease among the elderly is', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1655, 'In selection of essential drugs for PHC, all are correct except one', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1679, 'The process of packaging drugs in dispensing materials prior to the outpatient session is refer to as', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1680, 'Which of the listed drugs is a major anti-convulsant used under the PAC level essential drug list', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1686, 'HIV is a transmissible ---------------- that affects or weakens the immune system', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1696, 'Factors that cannot influence the spread of HIV/AIDs ---------------', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1698, '------------------- is seen as world AIDs day', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1719, 'Identification of handicap and disability will be best carried out during all except one', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1721, 'The causes of mental subnormality include all except one', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1724, 'The two major rehabilitation services in primary health care are?', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1738, 'All except one is instruments used during outreach services', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1739, 'Emergency preferred pathway means', 'simple', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:46', '2024-10-07 04:14:46'),
(1745, 'Which of the following is not a component of HMIS', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:47', '2024-10-07 04:14:47'),
(1747, 'In PHC system, data collection management scales of management used all except one', 'difficult', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:47', '2024-10-07 04:14:47'),
(1748, 'The number of people who lives in a specified geographical area during a defined time e.g. state, country and town is', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:47', '2024-10-07 04:14:47'),
(1751, 'The causes of population growth includes', 'moderate', NULL, 'true', 1, 2, NULL, 5, '2024-10-07 04:14:47', '2024-10-07 04:14:47'),
(1758, 'One of the following is a cause for changes in respiratory system', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:16', '2024-10-07 04:24:16'),
(1760, 'If a patient&rsquo;s respiratory rate is 10 breaths per minute, then it is', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:16', '2024-10-07 04:24:16'),
(1762, 'central cyanosis is seen in', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:16', '2024-10-07 04:24:16'),
(1764, 'All except one is not a factor affecting blood pressure estimation', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:16', '2024-10-07 04:24:16'),
(1768, 'Which of the following is not a cause to increase in respiratory rate', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:16', '2024-10-07 04:24:16'),
(1778, 'One is a cause to the variation in pulse rate', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1791, 'One of these is not a component of standing orders', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1812, 'A sudden onset of symptoms or illness that typically has a short duration and often severe is called', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1817, 'One of following is not concepts use in anatomy and physiology', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1822, 'One of the following is not type of muscle tissue', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1827, 'The muscular tissue that divides the thoracic cavity from the abdominal cavity is called', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1832, 'The homeostatic control mechanism is classified as', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1835, 'The biological catalyst that accelerates bio-chemical reaction during food digestion and remain unchanged at the end of the process is called', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:17', '2024-10-07 04:24:17'),
(1852, 'The classification of leucocytes that are capable of engulfing and destructing of foreign bodies are the', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1861, 'One of the following is not among the component of maintaining the efficacy of vaccines', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1866, 'One of the following is a contraindication to vaccination in children', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1868, 'The acronyms AEFI connotes', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1870, 'All the following are challenges of immunization coverage except one', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1876, 'BCG, Measles, Oral polio are examples of which type of vaccine', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1887, 'Health status indicators does not include one of the following', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1895, 'The attributes of a good objectives include all the following except one', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1898, 'The disease to be reported to disease notification officer (DSNO) at the LGA level as soon a diagnosed at the health facility does not includes', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1907, 'Statistics in the contemporary health system is best described as', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1914, 'The formular for calculating Maternal Mortality Rate (MMR) is:', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:18', '2024-10-07 04:24:18'),
(1928, 'Typology of variables does not include one of the following', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1929, 'One of the following is not a measure of central tendency', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19');
INSERT INTO `question_banks` (`id`, `title`, `difficulty_level`, `questiontime`, `active`, `author`, `subject_id`, `topic`, `topic_id`, `created_at`, `updated_at`) VALUES
(1934, 'A type of probability sampling method where each member of the population has an equal chance of being selected as part of the sample is called', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1946, 'Components of focus antenatal care does not include one of this', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1949, 'In fertilized ovum is known as', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1954, 'Complications during puerperium stage does not include one of these', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1969, 'The inner most part of the meninges otherwise refers to as intimate or delicate mother is known as', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1972, 'The largest part of the brain is known as', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1977, 'The thyroid gland is the largest endocrine gland situated in', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1991, 'A condition characterized by excessive bleeding during menstruation is medically referred to as', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1994, 'Pulmonary ventilation is the process of movement of air from the atmosphere to lungs and vice versa, brought about by changes in the size of', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1995, 'The undigested parts of food matter which include cellulose, hemicellulose, pectin and lignin is called', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(1996, 'The anatomical and functional unit of the kidney is called', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:19', '2024-10-07 04:24:19'),
(2003, 'Which test is used to check whether freeze sensitive vaccines have been damaged by exposure to temperature below 00c', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2006, 'The best immediate treatment for a chemical splash to the eye is', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2007, 'The most commonly used instrument for accurate measure of visual acuity is', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2010, 'In history taking, one of the following areas can be ignores', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2018, 'In the procedure for tepid sponging, a child should be', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2025, 'One of this is not included in the principles of management', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2028, 'One of these bests described the quality of a good manager', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2031, 'The purpose of supervision in Primary Health Care includes', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2041, 'One of these is correct about the principle of motivation', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2042, 'Purpose of motivation in Primary Health Care does not include', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2065, 'Which of the following is not an importance of financial reporting', 'difficult', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:20', '2024-10-07 04:24:20'),
(2072, 'Which of the following is not a quality and characteristics of money', 'moderate', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:21', '2024-10-07 04:24:21'),
(2073, 'One of the following is a visible money', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:21', '2024-10-07 04:24:21'),
(2075, 'The type of accounts book that record cash is', 'simple', NULL, 'true', 1, 2, NULL, 6, '2024-10-07 04:24:21', '2024-10-07 04:24:21'),
(2086, 'One of the following is not among the functions of kidney:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:27', '2024-10-07 04:28:27'),
(2094, 'One of the following is not a function of blood:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:27', '2024-10-07 04:28:27'),
(2095, 'Peristalsis is:', 'difficult', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:27', '2024-10-07 04:28:27'),
(2102, 'Two types of cell division are_________ and ___________', 'simple', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2105, 'Manifestation of anaemia does not include one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2123, 'Biochemical tests exclude one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2124, 'One of the following test strips is not commonly used in ANC clinic', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2126, 'One of the following is not among the Universal Precautions for Laboratory safety:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2137, 'One of the following is not a Gram-positive bacterium:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2138, 'The scientific method of finding out by investigation and analysis the cause of disease and how to manage it appropriately is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2144, 'The killing of all forms of life that may be present in a specimen or environment is____________________________________________________________________________________________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2146, 'The measure used to compare one variable and the other is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2152, 'Population could not be affected by one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2155, 'The joining of mid-point of a histogram result to:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2160, 'Inferential statistics excludes:', 'difficult', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:28', '2024-10-07 04:28:28'),
(2168, 'Measures of morbidity does not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2171, 'The statistic or science of human population is best referred to as____________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2180, 'The commonest virus linked to the development of cervical cancer is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2184, 'The WHO clinical classification of diabetes mellitus does not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2202, 'The first line of drug for the treatment of hypertension is________________________..', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2206, 'The basic types of analytical (observational) epidemiology studies include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2210, 'Which of the following do the time, place and person characteristics of disease in epidemiology refer to?', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2215, 'An infectious disease which occurs only infrequently or occasionally is called____________________________________________________________________________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:29', '2024-10-07 04:28:29'),
(2223, 'One of the following has no direct effects on population dynamics', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2230, 'One of the following is a danger sign of oral contraceptive pills', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2233, 'National Population Policy was revised in the year:', 'difficult', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2235, 'One of the following is not a benefit of oral contraception:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2237, 'What are the two hormones combined in oral contraceptive pills', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2244, 'The study of the factors that influence the size, form and fluctuation is____________________________________________________________________________________. M', 'simple', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2246, 'The measure of incidence of death within a population is________________________.', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2248, 'The most effective form of birth control is____________________________________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2261, 'One of the following is not a cause of psychosis', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2262, 'Psychotic disorder exclude:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2263, 'The features of a mentally healthy individual do not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2265, 'One of the following is not among the role of CHO in mental health Care:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2267, 'The aimless, wandering, hoarding of rubbish and the likes are symptoms of one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2269, 'The characteristics of a mentally retarded person does not include', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2273, 'The type of obsessive-compulsive disorder excludes', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2282, 'The pulse is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2288, 'Abnormal breath sounds exclude:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:30', '2024-10-07 04:28:30'),
(2294, 'Urinary bladder and sigmoid colon are located at which region of the abdomen', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2297, 'The clinical manifestation of disease condition reported by the patient to the health care provider is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2299, 'Post medical history is necessary to gather information about the patients&rsquo; _________ and ___________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2320, 'One of the causes of acute renal failure in obstetrics is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2321, 'One of the following is not a component of Focused Antenatal Care:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2332, 'No. of maternal deaths due to pregnancy, childbirth, labour and puerperium \r\n No. of women of child bearing age x 100,000 is:', 'difficult', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2335, 'The process whereby the reproductive organs return to their pre-gravid stage is called____________________________________________________________________________________________________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2337, '____________________________________________..are the signs found exclusively in pregnancy and they are confirmatory signs.', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2354, 'Neonatal infection does not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2357, 'According to the body weight, newborn are grouped into the following except one:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2365, 'A depression of the anterior fontanelle of newborn is commonly as a result of________________________________________________________________________________________________________________________..', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:31', '2024-10-07 04:28:31'),
(2369, 'The congenital abnormality resulting from short bone development is called________________________________________________________________________________________________________________________________________________M', 'simple', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2370, 'The guidelines for proper practice of first aid does not include one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2375, 'One of the following is not a sign of gangrene', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2379, 'Causes of domestic accident does not include one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2383, 'Poisoning can result from all the following except:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2385, 'Characteristics of first-degree burns excludes:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2389, 'The type of wound that affects tissues and skin making the wound irregular is:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2396, 'The involvement of a number of people in an accident, causing varying degree of injury and sometimes death is________________________________________________________', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2411, 'The age of a child in the community can be determine by the following ways except one:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2421, 'The sources of health data and information in PHC does not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2422, 'The methods of health data collection does not include:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:32', '2024-10-07 04:28:32'),
(2432, 'One of these is not true about communicable diseases:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2435, 'Amoebic dysentery is not characterised by one of the following:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2439, 'One of the following is not a component of communicable diseases:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2441, 'A disease where the signs and symptoms occur suddenly and last for a relative short period is termed:', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2446, 'One of the following is not a viral disease', 'moderate', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2449, 'Condition not covered by the Standing Orders should be:', 'simple', NULL, 'true', 1, 2, NULL, 7, '2024-10-07 04:28:33', '2024-10-07 04:28:33'),
(2458, 'Which among the cranial nerves supplies the nasal cavity', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2459, 'The major sinuses within the bones surrounding the nasal cavity includes all except:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2462, 'One of the following is not among the unsafe practices associated with Ear, Nose and Throat', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2463, 'Prevention and control of ear, nose and throat problems does not include:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2465, 'Otomycosis is a disease of the ear caused by:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2467, 'The pinna as one of the structures of the outer ear consist of:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2468, 'All except one is not an instrument used in ear examination:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2470, 'One of the following is not a condition affecting the nose:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2471, 'The pharynx is divided into three parts which includes:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2472, 'One of the following is a process of mobilizing the community against unsafe ENT practices:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2473, 'All except one is not a method of prevention and control measures of ear problems', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2475, 'One of the following is not a symptom of ear infection:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2477, 'Which of the following is a common symptoms of throat infection:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2478, 'One of the following does not include the functions of eustachian tube:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2492, 'Which of these is not a cause of periodontal disease: \r\na. Calculus formation\r\nb. Periodontal abscess ==\r\nc. Formation of plaque and gingivitis\r\nd. Poor oral hygiene', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2494, 'The dietary habit in oral health that does not contribute to good oral health is:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2505, 'One of the following is complication of periodontal disease', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2506, 'Saliva protects the oral cavity against micro-organisms because it has', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2508, 'One of the steps of removing dental plaque is:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2511, 'The surgical removal of all or part of the voice box in the throat is called:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2515, 'The means of bringing life-saving care in mothers and newborns at the community level is best described as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:30', '2024-10-07 04:32:30'),
(2516, 'The healthcare services provided to women during pregnancy, child birth, and the postpartum period, as well as to their newborn infants encompasses a range of services aimed at ensuring the health and wellbeing of both mother and baby before, during and after child birth depicts:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2518, 'The major causes of perinatal mortality in Nigeria does not include:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2519, 'The WHO defined neonatal mortality as the death of a newborn:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2528, 'Merits of home visits in community-based newborn does not take into cognisance one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2533, 'Typology of underweight babies at birth does not include one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2534, 'Types of KMC tailored to the specific needs of the newborn and their caregiver does not consider one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2538, 'Neonate or newborn infants are susceptible to various diseases and conditions which does not include one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2540, 'The acronym KMC as a package for essential newborn care at the community level means:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2543, 'A medical condition characterised by an abnormally small head size compared to other infants is refers to as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2547, 'A serious and deadly disease caused by virus that attacks and destroys the body&rsquo;s defensive system is known as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2560, 'The opportunistic infections associated with HIV/AIDS are all except one of the following:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2565, 'One of the following is not a fact about the qualities of good counsellor:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2566, 'One of the following is not a pre-requisite for successful counselling:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2569, 'The multisectoral approach to HIV/AIDS prevention do not include one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2572, 'Prevention and control measures of HIV/AIDS in the community does not include one of the followings:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2574, 'The confidential dialogue between patient and health worker to enable client make informed decision related to HIV is known as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2576, 'One of these is not among non-communicable diseases', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2581, 'From the list of the following, one of these is not a risk factor for hypertension', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2590, 'One of these best described cardio-vascular disease', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2592, 'The thickening and hardening of walls of the arteries in the body resulting in the narrowing of the arterial channels', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2596, 'The cause of asthmatic attack includes one of the following:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2601, 'A type of cancer that affects the blood and bone marrow where abnormal white blood cells are produced and then enter the blood stream is known as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2602, 'NCDs as an acronym stands for:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2604, 'A sore or lesion that develops on the lining of the stomach, small intestine or oesophagus which caused by a combination of factors is known known as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2608, 'One of the following best defined the term ENDEMIC:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2610, 'The control of communicable diseases does not include one of the following:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2613, 'Resistance is best described as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:31', '2024-10-07 04:32:31'),
(2619, 'All of the following are respiratory diseases of bacterial origin except:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2622, 'The incubation period of measles infection is:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2623, 'Complications of measles infection does not include one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2627, 'Strategies for polio eradication in Nigeria does not include one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2641, 'There are two major types of rehabilitation basic and vocational. Which of the following is not among the basic rehabilitation of the handicapped persons?', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2642, 'Record keeping is an important aspect in managing persons with special needs. One of the following is a record to be kept for those victims:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2646, 'One of the following is not among the facility used for rehabilitation of disabled persons:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2649, 'The term used to describe the environment designed to accommodate the needs of individuals with special needs', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2654, 'The method for identification of persons with special needs in the community is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2665, 'Child health can best be defined as', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2668, 'One of the following is not among the objectives of child health care services:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2669, 'At risk children can be best defined as', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2675, 'One of the following is not an intervention for integrated case management of childhood illness:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2684, 'Classification of childhood diseases excludes one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2687, 'Causes of convulsion in children does not include one of the following:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2695, 'Genda based violence is best describe as:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2697, 'The organs commonly affected by cancer in females are:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2698, 'All except one is not a predisposing factor to breast cancer:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2699, 'One of the following is not a procedure for breast self-examination', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2700, 'In relation to cancer case, the Community Health Extension Worker is oblique to:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:32', '2024-10-07 04:32:32'),
(2703, 'Which of the following is not among the complications of female genital mutilation?', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2704, 'The methods used to prevent FGM in the community includes all except one:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2706, 'The type of menopause include:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2707, 'Cervical cancer can be best prevented through:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2709, 'One of the following best define Reproductive Health:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2711, 'The following are primary organs of female reproductive system except:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2714, 'Which of the following hormones provides the hormonal trigger to cause ovulation and the release of eggs from the ovary:', 'difficult', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2715, 'The onset of menstruation in female is called:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2718, 'Infertility is when a couple fails to conceive after:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2741, 'The psychological problem of the older person excludes one of the followings:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2743, 'One of the following is not an environmental factor that speed up ageing process', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2747, 'Preventive measure of failing sight in the care of the older persons is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2748, 'One of the physical health benefits of exercise in the elderly is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2749, 'Malnutrition of the aged can be prevented by:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2752, 'The places that are constructed and equipped by government in order to train handicapped or aged people on simple vocational entrepreneurship in order to support their living is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2757, 'One of the following is not a method of evaluation of school health services:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2758, 'The type of services rendered during school health programme includes all except:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2761, 'The objective of school meal services include:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2764, 'Common health conditions among school children do not include:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2769, 'The benefit of school health services does not include:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2770, 'During the school meal inspection, the health worker pays surprise visit to see that the vendors carry out all except one of the following:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2771, 'The provision of wholesome surroundings for students and teachers, this refers to:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:33', '2024-10-07 04:32:33'),
(2780, 'A day set aside annually to create awareness on health-related issues in the school is termed:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2782, 'The services aimed at providing an adequate meal a day to all children enrolled in schools nationwide is:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2783, 'Preventive and curative services provided for the promotion of the health status of learners and staff is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2806, 'Which of the following is not a primary objective in community eye care?', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2807, 'What is the primary purpose of vision screening programme in community eye care?', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2810, 'CEC acronyms means:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2811, 'A medical condition characterized by a growth of a fleshy triangular-shape tissue on the conjunctiva is termed:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2812, 'One of the instruments in diagnostic set used for eye examination is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2813, 'Numerical recording of a normal vision is:', 'simple', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34'),
(2814, 'A refractive error of the eye where distant objects appear blurry while close objects can be seen clearly is:', 'moderate', NULL, 'true', 1, 3, NULL, 9, '2024-10-07 04:32:34', '2024-10-07 04:32:34');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_pull_statuses`
--

CREATE TABLE `schedule_pull_statuses` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `total_candidate` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `schedule_pull_statuses`
--

INSERT INTO `schedule_pull_statuses` (`id`, `schedule_id`, `total_candidate`, `created_at`, `updated_at`) VALUES
(1, 666, 54, '2024-10-09 06:17:15', '2024-10-09 06:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_push_statuses`
--

CREATE TABLE `schedule_push_statuses` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) NOT NULL,
  `total_candidate` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `schedule_push_statuses`
--

INSERT INTO `schedule_push_statuses` (`id`, `schedule_id`, `total_candidate`, `created_at`, `updated_at`) VALUES
(1, 666, 54, '2024-10-09 06:17:15', '2024-10-09 06:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `schedulings`
--

CREATE TABLE `schedulings` (
  `id` int(11) NOT NULL,
  `test_config_id` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `maximum_batch` int(11) NOT NULL DEFAULT -1,
  `no_per_schedule` int(11) DEFAULT NULL,
  `daily_start_time` varchar(50) DEFAULT NULL,
  `daily_end_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('QvkOq0lzF6sjKU4WtiPaElibkuuJgSpRJKhLwDYw', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTlyNmVvMTVZUkhRTUcxa1VSMmpDVUoxSUZnNEpzV1RFcVBRa1o0UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1731175665);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `exam_type_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'P1', 1, 'Paper 1', '2024-10-04 16:09:09', '2024-10-04 16:09:09'),
(2, 'P2', 1, 'Paper 2', '2024-10-04 16:09:09', '2024-10-04 16:09:09'),
(3, 'P3', 1, 'Paper 3', '2024-10-04 16:09:09', '2024-10-04 16:09:09'),
(4, 'PE', 1, 'Practical Examination', '2024-09-19 14:49:29', '2024-09-19 14:49:29'),
(5, 'PA', 1, 'Project Assessment', '2024-09-19 14:49:47', '2024-09-19 14:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `test_codes`
--

CREATE TABLE `test_codes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL COMMENT 'describe the code for the exams. eg PUTME, COSC101,MATH105',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_codes`
--

INSERT INTO `test_codes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'JCHEW', '2024-04-23 09:35:30', '2024-04-23 09:35:30'),
(2, 'CHEW', '2024-04-23 09:35:30', '2024-04-23 09:35:30'),
(3, 'CHO', '2024-04-23 09:35:30', '2024-04-23 09:35:30'),
(4, 'BCHS', '2024-04-23 09:35:30', '2024-04-23 09:35:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_configs`
--

INSERT INTO `test_configs` (`id`, `title`, `exam_type_id`, `test_category`, `total_mark`, `test_code_id`, `test_type_id`, `session`, `semester`, `daily_start_time`, `daily_end_time`, `duration`, `starting_mode`, `display_mode`, `question_administration`, `option_administration`, `versions`, `active_version`, `initiated_by`, `date_initiated`, `status`, `endorsement`, `pass_key`, `time_padding`, `allow_calc`, `created_at`, `updated_at`) VALUES
(1, 'P1', 1, 'Single Subject', 100, 1, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:17:44', '2024-10-05 18:17:44'),
(2, 'P2', 1, 'Single Subject', 100, 1, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:17:57', '2024-10-05 18:17:57'),
(3, 'PE', 1, 'Single Subject', 100, 1, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:18:18', '2024-10-05 18:18:18'),
(4, 'P1', 1, 'Single Subject', 100, 2, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:18:40', '2024-10-05 18:18:40'),
(5, 'P2', 1, 'Single Subject', 100, 2, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:18:52', '2024-10-05 18:18:52'),
(6, 'P3', 1, 'Single Subject', 100, 2, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:19:03', '2024-10-05 18:19:03'),
(7, 'PE', 1, 'Single Subject', 100, 2, 2, 2024, 2, NULL, NULL, 80, 'on login', 'single question', 'random', 'random', 1, 1, 1, '2024-10-04', 1, 'no', 'cbt', 0, 0, '2024-10-05 18:19:38', '2024-10-05 18:19:38');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_questions`
--

INSERT INTO `test_questions` (`id`, `test_section_id`, `question_bank_id`, `version`, `created_at`, `updated_at`) VALUES
(1, 1, 198, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(2, 1, 730, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(3, 1, 937, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(4, 1, 427, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(5, 1, 91, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(6, 1, 142, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(7, 1, 322, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(8, 1, 586, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(9, 1, 661, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(10, 1, 240, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(11, 1, 887, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(12, 1, 570, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(13, 1, 276, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(14, 1, 613, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(15, 1, 261, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(16, 1, 1110, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(17, 1, 321, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(18, 1, 772, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(19, 1, 550, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(20, 1, 1112, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(21, 1, 266, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(22, 1, 204, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(23, 1, 474, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(24, 1, 125, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(25, 1, 171, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(26, 1, 765, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(27, 1, 114, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(28, 1, 976, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(29, 1, 755, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(30, 1, 428, 1, '2024-10-07 05:10:13', '2024-10-07 05:10:13'),
(32, 4, 894, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(33, 4, 860, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(34, 4, 452, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(35, 4, 301, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(36, 4, 471, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(37, 4, 165, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(38, 4, 691, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(39, 4, 557, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(40, 4, 469, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(41, 4, 886, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(42, 4, 244, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(43, 4, 782, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(44, 4, 1089, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(45, 4, 202, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(46, 4, 176, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(47, 4, 172, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(48, 4, 125, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(49, 4, 257, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(50, 4, 201, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(51, 4, 794, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(52, 4, 950, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(53, 4, 274, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(54, 4, 454, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(55, 4, 313, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(56, 4, 126, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(57, 4, 188, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(58, 4, 339, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(59, 4, 5, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(60, 4, 312, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(61, 4, 482, 1, '2024-10-07 05:20:37', '2024-10-07 05:20:37'),
(125, 2, 2073, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(126, 2, 2369, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(127, 2, 1450, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(128, 2, 1392, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(129, 2, 2244, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(130, 2, 1319, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(131, 2, 2028, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(132, 2, 1386, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(133, 2, 1618, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(134, 2, 1382, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(135, 2, 1303, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(136, 2, 1433, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(137, 2, 1370, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(138, 2, 1407, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(139, 2, 1764, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(140, 2, 1514, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(141, 2, 2075, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(142, 2, 1472, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(143, 2, 1474, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(144, 2, 1468, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(145, 2, 1530, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(146, 2, 1304, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(147, 2, 1504, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(148, 2, 1323, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(149, 2, 2007, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(150, 2, 1698, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(151, 2, 1461, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(152, 2, 1868, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(153, 2, 1604, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(154, 2, 1308, 1, '2024-10-07 05:23:31', '2024-10-07 05:23:31'),
(156, 5, 1551, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(157, 5, 1539, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(158, 5, 2010, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(159, 5, 1929, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(160, 5, 1870, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(161, 5, 1680, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(162, 5, 1316, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(163, 5, 1604, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(164, 5, 1655, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(165, 5, 1491, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(166, 5, 1629, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(167, 5, 1686, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(168, 5, 1696, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(169, 5, 1450, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(170, 5, 1456, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(171, 5, 1679, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(172, 5, 1453, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(173, 5, 2018, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(174, 5, 1493, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(175, 5, 2102, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(176, 5, 1580, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(177, 5, 1724, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(178, 5, 1407, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(179, 5, 1907, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(180, 5, 1290, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(181, 5, 1791, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(182, 5, 2449, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(183, 5, 1583, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(184, 5, 1452, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(185, 5, 1739, 1, '2024-10-07 05:24:05', '2024-10-07 05:24:05'),
(249, 1, 137, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(250, 1, 1170, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(251, 1, 141, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(252, 1, 1145, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(253, 1, 707, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(254, 1, 770, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(255, 1, 58, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(256, 1, 874, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(257, 1, 875, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(258, 1, 122, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(259, 1, 871, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(260, 1, 926, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(261, 1, 1272, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(262, 1, 660, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(263, 1, 355, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(264, 1, 1088, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(265, 1, 843, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(266, 1, 876, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(267, 1, 1141, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(268, 1, 185, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(269, 1, 718, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(270, 1, 547, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(271, 1, 35, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(272, 1, 727, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(273, 1, 524, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(274, 1, 1224, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(275, 1, 1166, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(276, 1, 1225, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(277, 1, 1258, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(278, 1, 1239, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(279, 1, 1223, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(280, 1, 1278, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(281, 1, 69, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(282, 1, 433, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(283, 1, 537, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(284, 1, 1270, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(285, 1, 670, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(286, 1, 850, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(287, 1, 391, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(288, 1, 947, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(289, 1, 619, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(290, 1, 443, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(291, 1, 422, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(292, 1, 946, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(293, 1, 974, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(294, 1, 805, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(295, 1, 399, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(296, 1, 819, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(297, 1, 316, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(298, 1, 1063, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(299, 1, 296, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(300, 1, 757, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(301, 1, 533, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(302, 1, 956, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(303, 1, 892, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(304, 1, 811, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(305, 1, 1125, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(306, 1, 637, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(307, 1, 379, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(308, 1, 1204, 1, '2024-10-07 05:28:36', '2024-10-07 05:28:36'),
(312, 4, 426, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(313, 4, 763, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(314, 4, 324, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(315, 4, 714, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(316, 4, 1206, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(317, 4, 818, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(318, 4, 618, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(319, 4, 1144, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(320, 4, 112, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(321, 4, 984, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(322, 4, 995, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(323, 4, 1094, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(324, 4, 422, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(325, 4, 655, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(326, 4, 940, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(327, 4, 948, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(328, 4, 215, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(329, 4, 797, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(330, 4, 1086, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(331, 4, 1163, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(332, 4, 731, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(333, 4, 355, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(334, 4, 703, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(335, 4, 1246, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(336, 4, 817, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(337, 4, 38, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(338, 4, 837, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(339, 4, 369, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(340, 4, 39, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(341, 4, 492, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(342, 4, 533, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(343, 4, 1098, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(344, 4, 175, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(345, 4, 1256, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(346, 4, 689, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(347, 4, 911, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(348, 4, 784, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(349, 4, 910, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(350, 4, 54, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(351, 4, 1060, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(352, 4, 1170, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(353, 4, 1220, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(354, 4, 1130, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(355, 4, 66, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(356, 4, 1184, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(357, 4, 1026, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(358, 4, 736, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(359, 4, 901, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(360, 4, 1218, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(361, 4, 289, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(362, 4, 1193, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(363, 4, 826, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(364, 4, 706, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(365, 4, 403, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(366, 4, 438, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(367, 4, 1063, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(368, 4, 1238, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(369, 4, 272, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(370, 4, 1081, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(371, 4, 707, 1, '2024-10-07 05:29:40', '2024-10-07 05:29:40'),
(501, 2, 2267, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(502, 2, 2337, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(503, 2, 1473, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(504, 2, 1490, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(505, 2, 2441, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(506, 2, 2171, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(507, 2, 2137, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(508, 2, 1954, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(509, 2, 1524, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(510, 2, 1431, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(511, 2, 2294, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(512, 2, 2396, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(513, 2, 2072, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(514, 2, 2146, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(515, 2, 2152, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(516, 2, 1778, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(517, 2, 2439, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(518, 2, 1762, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(519, 2, 2321, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(520, 2, 1721, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(521, 2, 2422, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(522, 2, 1651, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(523, 2, 2435, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(524, 2, 1949, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(525, 2, 2385, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(526, 2, 2223, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(527, 2, 1866, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(528, 2, 1302, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(529, 2, 2389, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(530, 2, 1760, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(531, 2, 2041, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(532, 2, 1895, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(533, 2, 1289, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(534, 2, 2335, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(535, 2, 2411, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(536, 2, 1768, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(537, 2, 2105, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(538, 2, 2003, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(539, 2, 2370, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(540, 2, 2237, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(541, 2, 1887, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(542, 2, 1636, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(543, 2, 2215, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(544, 2, 1408, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(545, 2, 1928, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(546, 2, 2123, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(547, 2, 2248, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(548, 2, 1876, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(549, 2, 2206, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(550, 2, 2086, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(551, 2, 2354, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(552, 2, 2365, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(553, 2, 2263, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(554, 2, 2184, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(555, 2, 2144, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(556, 2, 2261, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(557, 2, 2357, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(558, 2, 2297, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(559, 2, 1338, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(560, 2, 2421, 1, '2024-10-07 05:32:20', '2024-10-07 05:32:20'),
(564, 5, 1861, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(565, 5, 2320, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(566, 5, 2273, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(567, 5, 2094, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(568, 5, 2146, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(569, 5, 1652, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(570, 5, 1946, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(571, 5, 1991, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(572, 5, 2180, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(573, 5, 2168, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(574, 5, 1410, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(575, 5, 2288, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(576, 5, 2042, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(577, 5, 2265, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(578, 5, 1751, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(579, 5, 1934, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(580, 5, 2375, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(581, 5, 1289, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(582, 5, 2365, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(583, 5, 1418, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(584, 5, 2210, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(585, 5, 2235, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(586, 5, 1638, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(587, 5, 2006, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(588, 5, 1518, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(589, 5, 1817, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(590, 5, 2105, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(591, 5, 2230, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(592, 5, 1748, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(593, 5, 1408, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(594, 5, 1738, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(595, 5, 2282, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(596, 5, 1619, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(597, 5, 1812, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(598, 5, 2138, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(599, 5, 2379, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(600, 5, 1524, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(601, 5, 2299, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(602, 5, 2432, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(603, 5, 1306, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(604, 5, 2446, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(605, 5, 2126, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(606, 5, 2269, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(607, 5, 2124, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(608, 5, 1455, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(609, 5, 2202, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(610, 5, 2294, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(611, 5, 1745, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(612, 5, 1637, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(613, 5, 2262, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(614, 5, 2155, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(615, 5, 1338, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(616, 5, 2246, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(617, 5, 2025, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(618, 5, 2031, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(619, 5, 1502, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(620, 5, 1719, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(621, 5, 2383, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(622, 5, 1898, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(623, 5, 2441, 1, '2024-10-07 05:32:41', '2024-10-07 05:32:41'),
(753, 1, 340, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(754, 1, 1182, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(755, 1, 985, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(756, 1, 1004, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(757, 1, 1229, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(758, 1, 386, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(759, 1, 733, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(760, 1, 364, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(761, 1, 1082, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(762, 1, 989, 1, '2024-10-07 05:38:11', '2024-10-07 05:38:11'),
(768, 4, 363, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(769, 4, 999, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(770, 4, 1046, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(771, 4, 1142, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(772, 4, 311, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(773, 4, 1146, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(774, 4, 70, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(775, 4, 222, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(776, 4, 394, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(777, 4, 359, 1, '2024-10-07 05:38:44', '2024-10-07 05:38:44'),
(813, 2, 1827, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(814, 2, 1969, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(815, 2, 1994, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(816, 2, 1835, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(817, 2, 1832, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(818, 2, 2233, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(819, 2, 1371, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(820, 2, 1995, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(821, 2, 2332, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(822, 2, 2095, 1, '2024-10-07 05:41:35', '2024-10-07 05:41:35'),
(828, 5, 1747, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(829, 5, 1914, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(830, 5, 1972, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(831, 5, 1977, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(832, 5, 2065, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(833, 5, 1996, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(834, 5, 1852, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(835, 5, 2160, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(836, 5, 1758, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(837, 5, 1822, 1, '2024-10-07 05:42:00', '2024-10-07 05:42:00'),
(868, 6, 2610, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(869, 6, 2596, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(870, 6, 2519, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(871, 6, 2540, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(872, 6, 2463, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(873, 6, 2508, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(874, 6, 2758, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(875, 6, 2699, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(876, 6, 2470, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(877, 6, 2560, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(878, 6, 2494, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(879, 6, 2602, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(880, 6, 2709, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(881, 6, 2462, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(882, 6, 2715, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(883, 6, 2703, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(884, 6, 2810, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(885, 6, 2665, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(886, 6, 2572, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(887, 6, 2576, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(888, 6, 2757, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(889, 6, 2764, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(890, 6, 2475, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(891, 6, 2700, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(892, 6, 2718, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(893, 6, 2687, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(894, 6, 2782, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(895, 6, 2813, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(896, 6, 2780, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(897, 6, 2711, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(899, 6, 2528, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(900, 6, 2642, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(901, 6, 2515, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(902, 6, 2590, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(903, 6, 2743, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(904, 6, 2613, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(905, 6, 2783, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(906, 6, 2511, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(907, 6, 2811, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(908, 6, 2641, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(909, 6, 2695, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(910, 6, 2684, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(911, 6, 2812, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(912, 6, 2706, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(913, 6, 2569, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(914, 6, 2534, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(915, 6, 2654, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(916, 6, 2627, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(917, 6, 2623, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(918, 6, 2741, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(919, 6, 2518, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(920, 6, 2675, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(921, 6, 2592, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(922, 6, 2770, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(923, 6, 2505, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(924, 6, 2769, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(925, 6, 2697, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(926, 6, 2533, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(927, 6, 2566, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(928, 6, 2807, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(929, 6, 2601, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(930, 6, 2707, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(931, 6, 2752, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(932, 6, 2748, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(933, 6, 2478, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(934, 6, 2492, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(935, 6, 2538, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(936, 6, 2472, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(937, 6, 2646, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(938, 6, 2608, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(939, 6, 2814, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(940, 6, 2574, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(941, 6, 2747, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(942, 6, 2669, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(943, 6, 2761, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(944, 6, 2506, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(945, 6, 2668, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(946, 6, 2604, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(947, 6, 2704, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(948, 6, 2698, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(949, 6, 2619, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(950, 6, 2771, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(951, 6, 2581, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(952, 6, 2565, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(953, 6, 2516, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(954, 6, 2649, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(955, 6, 2749, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(956, 6, 2543, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(957, 6, 2806, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(958, 6, 2547, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(962, 6, 2714, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(963, 6, 2477, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(964, 6, 2473, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(965, 6, 2459, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(966, 6, 2468, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(967, 6, 2465, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(968, 6, 2467, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(969, 6, 2622, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(970, 6, 2471, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(971, 6, 2458, 1, '2024-10-23 16:08:21', '2024-10-23 16:08:21');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_sections`
--

INSERT INTO `test_sections` (`id`, `test_subject_id`, `title`, `instruction`, `mark_per_question`, `num_to_answer`, `num_of_easy`, `num_of_moderate`, `num_of_difficult`, `created_at`, `updated_at`) VALUES
(1, 1, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(2, 2, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(3, 3, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(4, 4, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(5, 5, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(6, 6, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(7, 7, 'SECTION A', 'Answer ALL questions', 1, 100, 30, 60, 10, '2024-10-23 16:08:21', '2024-10-23 16:08:21');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_subjects`
--

INSERT INTO `test_subjects` (`id`, `test_config_id`, `subject_id`, `title`, `instruction`, `total_mark`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'P1', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(2, 2, 2, 'P2', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(3, 3, 4, 'P4', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(4, 4, 1, 'P1', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(5, 5, 2, 'P2', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(6, 6, 3, 'P3', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21'),
(7, 7, 4, 'P4', NULL, 100, '2024-10-23 16:08:21', '2024-10-23 16:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `test_types`
--

CREATE TABLE `test_types` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT 'describe the type of test such as exam, test1, test2, labtest1, labtest2,studiotest....',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_types`
--

INSERT INTO `test_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mock Exam', '2024-05-01 16:48:04', '2024-05-01 16:48:04'),
(2, 'Regular Exam', '2024-05-01 16:48:04', '2024-05-01 16:48:04'),
(3, 'Resit Exam', '2024-05-01 16:48:04', '2024-05-01 16:48:04');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `subject_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Paper 1 (JCHEW)', '2024-10-06 16:12:00', '2024-10-06 16:12:02'),
(2, 1, 'Paper 1 (CHEW)', '2024-10-06 16:11:54', '2024-10-06 16:11:57'),
(3, 1, 'Paper 1 (CHO)', '2024-10-06 16:10:37', '2024-10-06 16:10:37'),
(4, 1, 'Paper 1 (BCHS)', '2024-10-06 16:10:45', '2024-10-06 16:10:45'),
(5, 2, 'Paper 2 (JCHEW)', '2024-10-06 16:11:02', '2024-10-06 16:11:02'),
(6, 2, 'Paper 2 (CHEW)', '2024-10-06 16:11:10', '2024-10-06 16:11:10'),
(7, 2, 'Paper 2 (CHO)', '2024-10-06 16:11:17', '2024-10-06 16:11:17'),
(8, 2, 'Paper 2 (BCHS)', '2024-10-06 16:11:24', '2024-10-06 16:11:24'),
(9, 3, 'Paper 3 (CHEW)', '2024-10-06 16:11:39', '2024-10-06 16:11:39'),
(10, 3, 'Paper 3 (CHO)', '2024-10-06 16:11:45', '2024-10-06 16:11:45'),
(11, 3, 'Paper 3 (BCHS)', '2024-10-06 16:11:51', '2024-10-06 16:11:51');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `host_id` varchar(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='store allowed computer in the venue';

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
  ADD UNIQUE KEY `indexing` (`indexing`,`exam_year`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`,`indexing`);

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
-- Indexes for table `schedule_pull_statuses`
--
ALTER TABLE `schedule_pull_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schedule_push_statuses`
--
ALTER TABLE `schedule_push_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schedule_id` (`schedule_id`);

--
-- Indexes for table `schedulings`
--
ALTER TABLE `schedulings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_config_id` (`test_config_id`,`venue_id`,`date`);

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
  ADD KEY `initiated_by` (`initiated_by`),
  ADD KEY `id` (`id`,`exam_type_id`,`test_code_id`,`test_type_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15152;

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

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
  MODIFY `⁠ id ⁠` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT for table `question_banks`
--
ALTER TABLE `question_banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3133;

--
-- AUTO_INCREMENT for table `question_bank_temps`
--
ALTER TABLE `question_bank_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3794;

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
-- AUTO_INCREMENT for table `schedule_pull_statuses`
--
ALTER TABLE `schedule_pull_statuses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedule_push_statuses`
--
ALTER TABLE `schedule_push_statuses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_compositors`
--
ALTER TABLE `test_compositors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `test_configs`
--
ALTER TABLE `test_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `test_invigilators`
--
ALTER TABLE `test_invigilators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `test_questions`
--
ALTER TABLE `test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1081;

--
-- AUTO_INCREMENT for table `test_sections`
--
ALTER TABLE `test_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `test_subjects`
--
ALTER TABLE `test_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
