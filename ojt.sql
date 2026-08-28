-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2025 at 07:26 AM
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
-- Database: `ojt`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `forwarded_to_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('midterm','final','certificate','evaluation') NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dtrs`
--

CREATE TABLE `dtrs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_requests`
--

CREATE TABLE `grade_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('Midterm','Final','Certificate','Evaluation Form') NOT NULL,
  `fulfilled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_submissions`
--

CREATE TABLE `grade_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `forwarded_to_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interns`
--

CREATE TABLE `interns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_phone` varchar(255) NOT NULL,
  `supervisor_name` varchar(255) NOT NULL,
  `supervisor_email` varchar(255) NOT NULL,
  `application_letter` varchar(255) NOT NULL,
  `parents_waiver` varchar(255) NOT NULL,
  `acceptance_letter` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `archived_at` timestamp NULL DEFAULT NULL,
  `attendance_released_at` datetime DEFAULT NULL,
  `attendance_status` varchar(255) NOT NULL DEFAULT 'not_released',
  `attendance_time` timestamp NULL DEFAULT NULL,
  `attendance_notes` text DEFAULT NULL,
  `qr_code_scanned` varchar(255) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `medical_certificate` varchar(255) DEFAULT NULL,
  `insurance` varchar(255) DEFAULT NULL,
  `pre_deployment_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `pre_deployment_accepted_at` timestamp NULL DEFAULT NULL,
  `memorandum_of_agreement` varchar(255) DEFAULT NULL,
  `internship_contract` varchar(255) DEFAULT NULL,
  `mid_deployment_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `mid_deployment_accepted_at` timestamp NULL DEFAULT NULL,
  `recommendation_letter` varchar(255) DEFAULT NULL,
  `deployment_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `deployment_accepted_at` timestamp NULL DEFAULT NULL,
  `current_phase` enum('pre_enrollment','pre_deployment','mid_deployment','deployment','completed') DEFAULT 'pre_enrollment',
  `pre_enrollment_status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `pre_enrollment_accepted_at` timestamp NULL DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `supervisor_position` varchar(255) DEFAULT NULL,
  `endorsement_letter` varchar(255) DEFAULT NULL,
  `invited_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interns`
--

INSERT INTO `interns` (`id`, `supervisor_id`, `email`, `password`, `first_name`, `last_name`, `course`, `section`, `phone`, `company_name`, `company_phone`, `supervisor_name`, `supervisor_email`, `application_letter`, `parents_waiver`, `acceptance_letter`, `created_at`, `updated_at`, `status`, `archived_at`, `attendance_released_at`, `attendance_status`, `attendance_time`, `attendance_notes`, `qr_code_scanned`, `resume`, `medical_certificate`, `insurance`, `pre_deployment_status`, `pre_deployment_accepted_at`, `memorandum_of_agreement`, `internship_contract`, `mid_deployment_status`, `mid_deployment_accepted_at`, `recommendation_letter`, `deployment_status`, `deployment_accepted_at`, `current_phase`, `pre_enrollment_status`, `pre_enrollment_accepted_at`, `company_address`, `supervisor_position`, `endorsement_letter`, `invited_by_user_id`, `otp_code`, `otp_expires_at`, `otp_verified`) VALUES
(4, 1, 'cho@gmail.com', '$2y$12$i5p3HCBX12J.vh.rgGaaqOlvn5DnwsZ5ostiMRDnUST3pNrUfxc8.', 'cho', 'to', 'BSIT', 'west', '0912345123', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/HkLvaMoVK79B3YzUpl2fFsJ2VZ6p5nmxBMlNeMBm.png', 'documents/gCGIO7YAOIl2rkQHc1H3WYUvhCVFNlfjODz4cZI4.png', 'documents/7nzs5RwrMiblyXyzKZ2hQymVV2qnBsvHqTdraD5V.png', '2025-07-02 23:21:52', '2025-08-13 19:18:36', 'rejected', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(6, NULL, 'aa@gmail.com', '$2y$12$7AOAj7Laf9g.vrfZubAJ.e28Wnx/xo1L0GihNgkhWSz84ejHUNuaa', 'dsfasdfa', 'assdlfadsfl', 'BSIT', 'North', '40503429', 'KJFdkdlsjfksld', '1223423423', 'dfklsalfkadsjkl', 'jdfk@gmail.com', 'documents/RdEsEU23l8wDhNUxuoleefEpudqHBNYAJo5zjUjc.png', 'documents/oFr3IFAj9SflEoTqoDuqjoEdXYKZQtwyq0e9EtAQ.png', 'documents/1HCx0vpuY6Oj1O5uFVgK1KcAwhwKhLHcFkS6ROOj.png', '2025-07-03 05:28:15', '2025-07-03 05:28:25', 'rejected', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(29, NULL, 'sj@gmail.com', '$2y$12$aMYeia2XBBP5w5JyzKXuhuJPauGQUlED4BmkQwR1FWwN/N3V04Fr6', 'Sj', 'Js', 'BSIT', 'North', '04539593', 'plss lang Inc.', '34534524', 'dfklsalfkadsjkl', 'pss@gmail.com', 'documents/YdCfkgUuqkZZnZvdPXtjDsPwHol9ViMcqOgWzhsF.png', 'documents/khEae3QSnreZgSTPu4q1RYj9G9oi705hw08XrpKN.png', 'documents/9p9xfo9JHh5i8YTrknaFiNd1JWVYsk4Yp5vRZjJX.png', '2025-08-08 06:46:34', '2025-08-12 23:26:30', 'accepted', NULL, '2025-08-13 07:26:30', 'released', '2025-08-12 23:05:22', NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(32, NULL, 'kh@gmail.com', '$2y$12$JGc3oXgJWWO0k1f3tvowhOzNS1vTBDHRN5HGteqFZBDmezJCB4n1m', 'Kj', 'jk', 'BSIT', 'North', '09223232', 'adfads', 'asdfasdf', 'asdfdsf', 'adfadsf@gmail.com', 'documents/JjgZzsTgRvhOcLOFuYqJRG7lS4TeMlDDVHfeT3a7.pdf', 'documents/lvrt0XBHbPD66MEsDvbG9zuUBGvGPxllJmkFW4C7.pdf', 'documents/X4h4qezJ8Dfx4UBBLeB3GAzKRr2t5SUCQtIVM30x.pdf', '2025-08-09 06:33:42', '2025-08-13 16:54:40', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(33, NULL, 'g@gmail.com', '$2y$12$zywbAgJwckxfvVSYpicAyuM8TDZ5fQ9XJQBGM08rM1dn8.dfZX/G.', 'geno', 'colambot', 'BSIT', 'South', '09123456782', 'plss lang Inc.', '09123456789', 'hehsh', 'h@gmail.com', 'documents/W1mrcbzc0HiO4D7S1PgO9vGwsTTuqSPQOLOP1xOi.docx', 'documents/Q5rmLtMT0OYRT2GrBscrM58LUa0MkYUEQzNpfiZW.docx', 'documents/MASPg6T2fuF6TH0ZVTlTGrKZZzIcYuM0QdFre7bs.docx', '2025-08-12 23:38:18', '2025-08-12 23:38:59', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(34, NULL, 'y@gmail.com', '$2y$12$vondWIE7QpdBR0vS1ZgO5ed0Tde.UOZeRTGbCCCumia6Br8aeAVxi', 'yawe', 'kho', 'BSIT', 'North', '09123456782', 'grehnj', '09123456789', 'hfgj', 'r@gmail.com', 'documents/Dc5rlYMjrLQiOsBczOxxFhZxzjeiU3AltUFy3Srp.png', 'documents/gIHmq5kF0HDIyu7icIK0bRbfozXkkBKed2Atxe3u.png', 'documents/hRit9snGuiR295oZayK6KoZjtKKIoWnOII4GXu8H.docx', '2025-08-13 16:39:42', '2025-08-13 16:54:46', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(35, NULL, 'f@gmail.com', '$2y$12$CmztLCKL19bUvMBKxszoae9jqAr1IYfsDOVAnk.onJLNdv1TFikNu', 'fat', 'mas', 'BSIT', 'North', '09162960264', 'fwgsevr', '09123456789', 'gsdfh', 'a@gmail.com', 'documents/RzsWPFTodQ7Vby6XciqYR1c4xjJLYwlM4bhhE06n.pdf', 'documents/V0qpHCeSZHt61vGdkV5jggnXFueLHFnNzKsUVrmP.docx', 'documents/q6pmbjxmSsrmBWcFZN9JumGCbRhyGwoRR2RWRFtB.docx', '2025-08-13 16:41:38', '2025-08-13 16:54:50', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(36, NULL, 'j@gmail.com', '$2y$12$gwviWnR55GUhaR.3Bs7gz.HBwZRkKhob3g4GWbz.g2C9XbBPHZ77W', 'd', 'asasa', 'BSIT', 'North', '09123456782', 'egrhreh', '09220056798', 'gsdfhgdfh', 'm@gmail.com', 'documents/J3NxSzteOBhNXV4tbTilWuVo5VJxOoK5TA9HvUAP.pdf', 'documents/dZ9unZT9zrzdO86ZlWBOvB4QofJbPxgC9QX4Zigw.pdf', 'documents/nhDMc44WDjrNLphLR6keaiQD1PeVXk8HpNm6vsGM.pdf', '2025-08-13 16:43:07', '2025-08-13 16:54:56', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(37, NULL, 'l@gmail.com', '$2y$12$oBUjEy8FAegk4Ma0Vi2z5e6HJje/Lo/sAJ/iFnVbIujPbg8D9fow6', 'u', 'd', 'BSIT', 'North', '09123456782', 'lasdflasf', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/72r1rYL0hDslgH7N1a9p1Ol1UbCargsCUkGYFmgj.pdf', 'documents/4sDSM9BSGjc50yqD6nuoFSqmiC2B3JrUgOyOtHcs.pdf', 'documents/8WJzvlydA2jhPjI6eBUC9NpaFrL7YVOOGBTHFl57.pdf', '2025-08-13 16:44:47', '2025-08-13 16:55:03', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(38, NULL, 'q@gmail.com', '$2y$12$BJuw7EE2o.s2CXdE98ILCu.eWa1BfO1zn3Fw.6id6hkbDIUDxP0Qq', 'r', 'inso', 'BSIT', 'North', '09123456782', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/YVbyd8W43r0iGNnRwfJEfk7MYWD1gH8K5BE7N5E5.pdf', 'documents/oBB7e9kIa5G0vruJL0llhD0qlOenkDpJH4otkb6y.pdf', 'documents/sa2bD57mBZIGTPxq2DUlw5LEFVnk4XfSb2sn4Arq.pdf', '2025-08-13 16:46:03', '2025-08-13 16:55:08', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(39, NULL, 'en@gmail.com', '$2y$12$XPMl4czurkYkbIwtO.OJf..4eB3tJIIHneKeDfGkWNYNH6H8EkrtC', 'd', 'k', 'BSIT', 'North', '09123456782', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/0yeSLzAhYMRIMp6aXpUxY4cXXGLDzUJfdkF3WBQa.pdf', 'documents/gbxsoJNv627KxBi5ygcYvL8BZUcRtHjmTPYqJY9C.pdf', 'documents/qXUy3pcXhyFFJXAMj9AwY4tLeRE05HIj1vdC9Dnr.pdf', '2025-08-13 16:47:29', '2025-08-13 16:55:13', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(40, NULL, 'i@gmail.com', '$2y$12$JzFEaFf7WLL2UXtgSEg2k./M2vGZ646nz6LN6eNoAt1eVnoZo9LvK', 'i', 'i', 'BSIT', 'West', '09123456782', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/HRrCCXfkSTIYrOzrtpsVQvvxtCgJgufcZI6B4TnW.pdf', 'documents/n8eaQjw9BelUqynCU6ssJSqZCf8AXrTdh5FNdlyf.pdf', 'documents/oOCNjjwpycU42DpaWCltBnpHOfJGHXgREA158koS.pdf', '2025-08-13 16:49:03', '2025-08-13 16:55:27', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(41, NULL, 'v@gmail.com', '$2y$12$DGMFCYXhBW3nOxajxv1DhelH4AeXuNJV/72ewmkEky6C7/YS5WyTS', 'aasd', 'fgh', 'BSIT', 'North', '09123456782', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/4oBWBdccJVHpDXadWEOw4BPD9ASRjbk0HmQ3aegI.pdf', 'documents/xImRtfIzEJXGMhTVTnqIpCeS2zLEbezfhQGSccOo.pdf', 'documents/ldvpmCapZPlz0EKLcvcy3iRf6hUGhViiuGd8j2A7.pdf', '2025-08-13 16:50:39', '2025-08-13 16:55:18', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(42, NULL, 'z@gmail.com', '$2y$12$fDDHD0OQtxg4ePw/4fBECOSlE9ziAhfPBMM817Ok3j3FV.WhvubNu', 'asd', 'cvb', 'BSIT', 'West', '09123456782', 'plss lang Inc.', '09123456789', 'ajiosdjfaksdfa', 'revesco@gmail.com', 'documents/lHzUNd14sR7kmGWzPzSOac7wyT1pxRvuL18LjFiN.png', 'documents/Wm07BY4Rq5Ds9U5cHALrg1QLVkO2RclKMuLlGGBG.png', 'documents/dWKbVTdn5QoIrA54ZxSWAeeXKTdyHdCgXoqRB6rb.png', '2025-08-13 16:52:11', '2025-08-13 16:55:31', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(43, NULL, 'e@gmail.com', '$2y$12$lSg1qtllABQIgLXcpllxpeH7i0ifWgQq..N6uEiRK/rOLinAm.1vy', 'd', 'f', 'BSIT', 'North', '09123456782', 'plss lang Inc.', '09123456789', 'rebesco', 'revesco@gmail.com', 'documents/87Li3KQHitkLrKe4BdmbzRJBV0YUVAil0s7b9f4z.png', 'documents/ml2WMvn5yqWTWAGfWkJLI66tWsF1S0yUip0nIKSE.png', 'documents/a13Yiy39f7I3roEDIX0qGu5zUhMnox9zBuGjQnk4.png', '2025-08-13 16:54:19', '2025-08-13 16:55:22', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_enrollment', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(55, NULL, 'a@gmail.com', '$2y$12$Nkcxf.Gfuo8aFkBK4/sVAeJ52gHuL0.jJYoNXZV3zn4IeAED29tmi', 'annial', 'ss', 'BSIT', 'North', '09956231538', 'sdfg', '', 'fdgsdffg', 'sdgsdf@gmail.com', '', '', '', '2025-10-21 14:16:37', '2025-10-21 14:21:43', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, 'pending', NULL, NULL, 'pending', NULL, 'pre_deployment', 'pending', NULL, 'dfsgsdfg', 'dfgdsgf', NULL, 17, '028622', '2025-10-21 14:26:37', 0),
(56, NULL, 'jkr.grande@gmail.com', '$2y$12$bBkZPHdFnPS00ydelnQ.jOXC/Sl0QCsK67d6QYhUdW6cTglvdZvDu', 'John Kenneth', 'Grande', 'BSIT', 'North', '095836436', 'sdfg', '', 'fdgsdffg', 'sdgsdf@gmail.com', 'documents/P8vxXWmroQg35tS5KccBoGqwH4UweR7xXSq01F7d.pdf', 'documents/RTvxQPZHbapm8MEGXFrao7vDf2bcBVKOc2Ts2bD1.pdf', 'documents/acceptance_letter_intern_56.html', '2025-10-21 14:18:28', '2025-10-21 14:28:11', 'accepted', NULL, NULL, 'not_released', NULL, NULL, NULL, 'documents/Wul95MnQcaLGE8W51p2135r6ZnEkAD7Rg518bMBL.pdf', 'documents/B1zKKOJORdvwj4QW6QLwr4kMXcf5obLa72z7rvKn.pdf', 'documents/tkrGDMpYC3HxlRTVTebc7MZRijhC8Az7XjknXYCl.pdf', 'accepted', '2025-10-21 14:26:59', 'documents/memorandum_intern_56.html', 'documents/internship_contract_intern_56.html', 'accepted', '2025-10-21 14:27:47', 'documents/zvAER62JbPrT9XC106jRZOou5o9CdB0LFMTYVDux.pdf', 'accepted', '2025-10-21 14:28:11', 'completed', 'pending', NULL, 'dfsgsdfg', 'dfgdsgf', NULL, 17, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `entry` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('admin','intern','supervisor') DEFAULT NULL,
  `receiver_type` enum('admin','intern','supervisor') DEFAULT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `sender_type`, `receiver_type`, `content`, `is_read`, `created_at`, `updated_at`) VALUES
(19, 1, 1, 'admin', 'intern', 'Mga Burikat', 1, '2025-07-03 22:50:28', '2025-07-04 07:47:47'),
(21, 1, 3, 'admin', 'intern', 'Mga Burikat', 1, '2025-07-03 22:50:28', '2025-07-14 06:18:03'),
(22, 1, 5, 'admin', 'intern', 'Mga Burikat', 0, '2025-07-03 22:50:28', '2025-07-03 22:50:28'),
(23, 1, 7, 'admin', 'intern', 'Mga Burikat', 0, '2025-07-03 22:50:28', '2025-07-03 22:50:28'),
(25, 1, 1, 'admin', 'intern', 'Mga Burikat mag kita kta sara', 1, '2025-07-03 22:51:04', '2025-07-04 07:47:47'),
(27, 1, 3, 'admin', 'intern', 'Mga Burikat mag kita kta sara', 1, '2025-07-03 22:51:04', '2025-07-14 06:18:03'),
(28, 1, 5, 'admin', 'intern', 'Mga Burikat mag kita kta sara', 0, '2025-07-03 22:51:04', '2025-07-03 22:51:04'),
(29, 1, 7, 'admin', 'intern', 'Mga Burikat mag kita kta sara', 0, '2025-07-03 22:51:04', '2025-07-03 22:51:04'),
(30, 1, 1, 'admin', 'intern', 'hoy mga burikat', 1, '2025-07-03 23:14:19', '2025-07-04 07:47:47'),
(32, 1, 3, 'admin', 'intern', 'hoy mga burikat', 1, '2025-07-03 23:14:19', '2025-07-14 06:18:03'),
(33, 1, 5, 'admin', 'intern', 'hoy mga burikat', 0, '2025-07-03 23:14:19', '2025-07-03 23:14:19'),
(34, 1, 7, 'admin', 'intern', 'hoy mga burikat', 0, '2025-07-03 23:14:19', '2025-07-03 23:14:19'),
(37, 1, 1, 'admin', 'intern', 'dong', 1, '2025-07-03 23:41:57', '2025-07-04 07:47:47'),
(39, 1, 1, 'admin', 'intern', 'hoy', 1, '2025-07-03 23:57:52', '2025-07-04 07:47:47'),
(40, 1, 1, 'admin', 'intern', 'boyet', 1, '2025-07-03 23:59:11', '2025-07-04 07:47:47'),
(41, 1, 1, 'admin', 'intern', 'dfd', 1, '2025-07-03 23:59:18', '2025-07-04 07:47:47'),
(42, 1, 1, 'admin', 'intern', 'hoy', 1, '2025-07-03 23:59:44', '2025-07-04 07:47:47'),
(46, 1, 2, 'admin', 'intern', 'hi jorge lubton ko kamo sara ni Kenneth ah', 1, '2025-07-04 00:09:42', '2025-07-04 00:09:48'),
(47, 2, 1, 'intern', 'admin', 'sige sir', 1, '2025-07-04 00:09:58', '2025-07-04 00:10:00'),
(48, 1, 2, 'admin', 'intern', 'edibloan ko ang lubot ni Inso kay mo apil', 1, '2025-07-04 00:10:23', '2025-07-04 00:12:25'),
(49, 1, 2, 'admin', 'intern', 'www', 1, '2025-07-04 00:10:52', '2025-07-04 00:12:25'),
(50, 1, 2, 'admin', 'intern', 'tuwad sara kamo ah', 1, '2025-07-04 00:12:40', '2025-07-04 00:12:44'),
(51, 1, 2, 'admin', 'intern', 'AyLabyo Jorge', 1, '2025-07-04 00:20:52', '2025-07-04 00:20:55'),
(52, 2, 1, 'intern', 'admin', 'gubaa amon lubot sir', 1, '2025-07-04 00:21:51', '2025-07-04 00:22:06'),
(59, 3, 9, 'admin', 'intern', 'ytrde', 0, '2025-07-06 03:34:44', '2025-07-06 03:34:44'),
(63, 2, 1, 'intern', 'admin', 'sir alvin where na you', 1, '2025-07-06 06:45:57', '2025-07-06 06:46:11'),
(64, 8, 1, 'admin', 'intern', 'yoo', 0, '2025-07-07 22:27:11', '2025-07-07 22:27:11'),
(66, 2, 1, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(67, 2, 2, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(68, 2, 3, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(69, 2, 5, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(70, 2, 7, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(71, 2, 8, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(72, 2, 9, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(73, 2, 10, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(74, 2, 12, 'admin', 'intern', 'jhh', 0, '2025-07-09 19:55:28', '2025-07-09 19:55:28'),
(82, 3, 1, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(83, 3, 2, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(84, 3, 3, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(85, 3, 5, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(86, 3, 7, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(87, 3, 8, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(88, 3, 9, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(89, 3, 10, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(90, 3, 12, 'admin', 'intern', 'jghjhg', 0, '2025-07-10 16:30:44', '2025-07-10 16:30:44'),
(95, 3, 1, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(96, 3, 2, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(97, 3, 3, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(98, 3, 5, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(99, 3, 7, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(100, 3, 8, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(101, 3, 9, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(102, 3, 10, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(103, 3, 12, 'admin', 'intern', 'jhdsf', 0, '2025-07-10 17:07:33', '2025-07-10 17:07:33'),
(110, 17, 1, 'intern', 'admin', 'hi admin', 0, '2025-07-10 17:24:01', '2025-07-10 17:24:01'),
(111, 3, 17, 'admin', 'intern', 'hashd', 0, '2025-07-10 17:26:31', '2025-07-10 17:26:31'),
(112, 1, 1, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(113, 1, 2, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(114, 1, 3, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(115, 1, 5, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(116, 1, 7, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(117, 1, 8, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(118, 1, 9, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(119, 1, 10, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(120, 1, 11, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(121, 1, 12, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(126, 1, 17, 'admin', 'intern', 'huuy mga burykath', 0, '2025-07-18 03:56:12', '2025-07-18 03:56:12'),
(128, 1, 1, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:10', '2025-07-20 07:44:10'),
(129, 1, 2, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:10', '2025-07-20 07:44:10'),
(130, 1, 3, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:10', '2025-07-20 07:44:10'),
(131, 1, 5, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(132, 1, 7, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(133, 1, 8, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(134, 1, 9, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(135, 1, 10, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(136, 1, 11, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(137, 1, 12, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(142, 1, 17, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:44:11', '2025-07-20 07:44:11'),
(144, 1, 1, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(145, 1, 2, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(146, 1, 3, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(147, 1, 5, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(148, 1, 7, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(149, 1, 8, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(150, 1, 9, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(151, 1, 10, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(152, 1, 11, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(153, 1, 12, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(158, 1, 17, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-07-20 07:46:10', '2025-07-20 07:46:10'),
(160, 2, 1, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(161, 2, 2, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(162, 2, 3, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(163, 2, 5, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(164, 2, 7, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(165, 2, 8, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(166, 2, 9, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(167, 2, 10, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(168, 2, 11, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(169, 2, 12, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(174, 2, 17, 'supervisor', 'intern', 'Attendance is now available. You may time in for today.', 0, '2025-08-03 23:40:55', '2025-08-03 23:40:55'),
(188, 4, 29, 'supervisor', 'intern', 'Time In is now available! Click \"Time In\" to mark your attendance. (Expires in 5 minutes)', 0, '2025-08-12 16:12:27', '2025-08-12 16:12:27'),
(189, 29, 4, 'intern', 'supervisor', 'Sj Js has marked attendance.', 0, '2025-08-12 16:12:38', '2025-08-12 16:12:38'),
(190, 4, 29, 'supervisor', 'intern', 'Time In is now available! Click \"Time In\" to mark your attendance. (Expires in 5 minutes)', 0, '2025-08-12 23:05:02', '2025-08-12 23:05:02'),
(191, 29, 4, 'intern', 'supervisor', 'Sj Js has marked attendance.', 0, '2025-08-12 23:05:22', '2025-08-12 23:05:22'),
(192, 4, 29, 'supervisor', 'intern', 'Time In is now available! Click \"Time In\" to mark your attendance. (Expires in 5 minutes)', 0, '2025-08-12 23:26:30', '2025-08-12 23:26:30'),
(193, 56, 17, 'intern', 'admin', 'Heeeeey', 1, '2025-10-21 14:28:27', '2025-10-21 14:28:37'),
(194, 17, 56, 'admin', 'intern', 'bayot', 1, '2025-10-21 14:33:54', '2025-10-21 14:34:01'),
(195, 56, 17, 'intern', 'admin', 'dako akoy lagay', 1, '2025-10-21 14:34:40', '2025-10-21 14:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_01_154507_create_interns_table', 2),
(5, '2025_07_02_141534_add_status_to_interns_table', 3),
(6, '2025_07_02_150019_create_messages_table', 4),
(7, '2025_07_02_153854_add_sender_type_to_messages_table', 5),
(8, '2025_07_02_154103_drop_sender_id_foreign_from_messages_table', 6),
(11, '2025_07_02_160850_create_messages_table', 7),
(12, '2025_07_03_055712_add_is_read_to_messages_table', 7),
(13, '2025_07_03_061216_create_messages_table', 8),
(14, '2025_07_03_061843_create_messages_table', 9),
(15, '2025_07_03_153658_create_time_logs_table', 10),
(16, '2025_07_04_070804_add_is_read_to_messages_table', 11),
(17, '2025_07_04_161110_create_journals_table', 12),
(18, '2025_07_04_163603_add_day_to_journals_table', 13),
(19, '2025_07_04_172841_create_documents_table', 14),
(20, '2025_07_05_083038_create_grade_requests_table', 15),
(21, '2025_07_05_083937_create_document_requests_table', 16),
(22, '2025_07_06_151758_create_grade_submissions_table', 17),
(23, '2025_07_10_154954_add_duration_to_time_logs_table', 18),
(24, '2025_07_20_145156_create_supervisors_table', 19),
(25, '2025_07_20_154034_add_attendance_released_at_to_interns_table', 20),
(26, '2025_07_20_154342_update_sender_receiver_type_in_messages_table', 21),
(27, '2024_07_21_000001_add_supervisor_and_forwarded_fields', 22),
(28, '2025_08_08_153559_add_otp_fields_to_supervisors_table', 23),
(29, '2025_08_08_160327_remove_otp_fields_from_supervisors_table', 24),
(30, '2025_08_09_101010_add_archived_at_to_interns_table', 25),
(32, '2025_08_09_121200_add_otp_back_to_supervisors_table', 26),
(35, '2025_01_15_000000_create_attendances_table', 27),
(36, '2025_08_12_154632_add_attendance_tracking_to_interns_table', 27),
(37, '2025_08_13_052957_create_dtrs_table', 28),
(38, '2025_08_16_062424_add_phase_tracking_to_interns_table', 28),
(39, '2025_08_16_081426_add_missing_phase_fields_to_interns_table', 28),
(40, '2025_09_08_000001_add_endorsement_and_recommendation_columns_to_interns_table', 28),
(41, '2025_09_08_194758_add_endorsement_letter_to_interns_table', 28),
(42, '2025_09_13_135919_add_company_address_to_interns_table', 29),
(43, '2025_10_12_203343_add_current_phase_to_interns_table', 29),
(44, '2025_10_13_000001_add_invited_by_to_interns_table', 29),
(45, '2025_10_16_222522_create_password_reset_tokens_table', 30),
(46, '2025_10_17_000001_add_otp_fields_to_users_table', 30),
(47, '2025_10_19_160935_add_otp_fields_to_interns_table', 31),
(48, '2025_10_23_140305_create_cache_table', 32);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('khamyrbautista@gmail.com', '$2y$12$pSj8yl2p./nb8T.kiEvtteBQU9BFCNGQmjKVnmiJnR/8.NBd3LVSa', '2025-10-19 08:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `name`, `email`, `password`, `otp_code`, `otp_expires_at`, `is_accepted`, `created_at`, `updated_at`) VALUES
(1, 'dasf', 's@gmail.com', '$2y$12$WrfFTGlBbB4rxP5.vVho0O913WULtb7nR7tnwXNsZ2/zcRkTXvFW2', NULL, NULL, 1, '2025-07-20 07:32:00', '2025-07-20 07:35:06'),
(2, 'rey', 'rey@gmail.com', '$2y$12$tM9w.XkNfdlzvk965J0tAOvul4hQJ9knAQ77xl4YXK7/C9rNiSKU6', NULL, NULL, 1, '2025-08-03 23:37:30', '2025-08-03 23:39:12'),
(3, 'itotoijo', 'kgkndslnjk@gmail.com', '$2y$12$MmseqB63M0kkzNLDMLjEhuhsWTgah7UDavsq69oNUjOcm30/AKBSW', NULL, NULL, 0, '2025-08-07 02:42:11', '2025-08-07 02:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

CREATE TABLE `time_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intern_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `duration` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `otp_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `otp_code`, `otp_expires_at`, `otp_verified`, `created_at`, `updated_at`) VALUES
(1, 'mark', 'm@gmail.com', NULL, '$2y$12$D61kUI95eHpWhknNnfaWEOLlpum2XdF../S5ELlpOhp.J8gQzIs62', NULL, NULL, NULL, 0, '2025-07-01 07:33:34', '2025-07-01 07:33:34'),
(2, 'tyron c. inso', 'tyron@gmail.com', NULL, '$2y$12$o5Hr3HHwYJkLq27ngGz3SepuT.hLolY6eZqNs01xtAp/vLbMVqydW', NULL, NULL, NULL, 0, '2025-07-02 22:30:28', '2025-07-02 22:30:28'),
(3, 'mark', 'ken@gmail.com', NULL, '$2y$12$mpdnX.hkCtwaIDmaVGzhheFp0JPHM/aPpXT7YMhKVopFbClztAx2e', NULL, NULL, NULL, 0, '2025-07-02 23:14:31', '2025-07-02 23:14:31'),
(4, 'truy c.inso', 'de@gmail.com', NULL, '$2y$12$bd2yLHGUfsgiLFeytgCmjOfW1FFzrwkdXyJeeR67UgFmXji3blRxC', NULL, NULL, NULL, 0, '2025-07-02 23:29:38', '2025-07-02 23:29:38'),
(5, 'mark', 'geno@gmail.com', NULL, '$2y$12$h7XW1u7zzDAz0/biL3OjD.B95ftLtYHTp82ctS3.ikr6uR3yHkid2', NULL, NULL, NULL, 0, '2025-07-06 02:19:56', '2025-07-06 02:19:56'),
(6, 'dong inso', 'dong@gmail.com', NULL, '$2y$12$xBU1qaTYwuiLpmOvnkFO/e.bnnPphAk29u6twEVaCzVtFkOYct9k.', NULL, NULL, NULL, 0, '2025-07-06 02:45:41', '2025-07-06 02:45:41'),
(7, 'jade', 'leira@gmail.com', NULL, '$2y$12$csrnI/TGvfz3asZWWU7mnerkMpFiVLYgYaMoVQCLub8AX9ZhcA9ay', NULL, NULL, NULL, 0, '2025-07-07 00:23:51', '2025-07-07 00:23:51'),
(8, 'tintin', 'tintin@gmail.com', NULL, '$2y$12$ohkrVukdCSdqIwF0jUy9MOPHCJyfXfKN9pC5pkSsyTCTY/bEL409O', NULL, NULL, NULL, 0, '2025-07-07 05:18:17', '2025-07-07 05:18:17'),
(9, 'joerge', 'joerge@gmail.com', NULL, '$2y$12$Il17FiLLMNNCdNNA2G8qcOtPv0IJgTlT6MEl9Iq3pS5L0aqrEJJuK', NULL, NULL, NULL, 0, '2025-07-10 08:24:46', '2025-07-10 08:24:46'),
(10, 'mark', 'gwapo@gmail.com', NULL, '$2y$12$liCx77BnBSieWuYA8tjQduGdx702l3F4duhMCZOZRjz/IUBIWgVme', NULL, NULL, NULL, 0, '2025-07-10 17:21:04', '2025-07-10 17:21:04'),
(11, 'mark', 'ff@gmail.com', NULL, '$2y$12$PvIC.ELb3MamAeYQlBnS5eEHdC.e1/3F2bfyxRK6ea3e.LCvFJ5dO', NULL, NULL, NULL, 0, '2025-07-20 06:46:23', '2025-07-20 06:46:23'),
(12, 'adfads', 'kk@gmail.com', NULL, '$2y$12$w3RIx5r4CtxjOWfsAk.76eS/Mzovn8KMQYImSIcMz13QNO2JqxtA6', NULL, NULL, NULL, 0, '2025-07-20 07:32:24', '2025-07-20 07:32:24'),
(13, 'BSBA', 'r@gmail.com', NULL, '$2y$12$.SoeQmEzRrTS9FwHIoq0h.ZSqCpJ4tw9a2JbiZBcpgaiT6LL.8Sxa', NULL, NULL, NULL, 0, '2025-07-20 08:09:16', '2025-07-20 08:09:16'),
(14, 'Ryan C. INSO', 'ryan@gmail.com', NULL, '$2y$12$TjzsM/qmufNlT4OCmEVRTu4Gy2DHb/JnOAr6PEZpK5P22uzOHYUGi', NULL, NULL, NULL, 0, '2025-08-03 16:12:31', '2025-08-03 16:12:31'),
(15, 'mark', 'm@gmai.com', NULL, '$2y$12$474HyHjxMB2zVAYtJUb0MOmvqTS.z6IJ6skZD3iRkrDWixm669j6K', NULL, NULL, NULL, 0, '2025-08-04 06:43:44', '2025-08-04 06:43:44'),
(16, 'bodd', 'bodd@gmail.com', NULL, '$2y$12$mOz71vva5.v0643oSY8UPOtXPYXaxCoNw2.fEqLDK7qVUxcbm/GpO', NULL, NULL, NULL, 0, '2025-08-04 06:46:01', '2025-08-04 06:46:01'),
(17, 'Khamyr Araño', 'khamyrbautista@gmail.com', '2025-10-17 13:29:06', '$2y$12$OyMcO4iIcydbdYd5E90RPeUCX7pF1e3ZhP.Z.eK.UPllYLnDd5rVu', NULL, NULL, NULL, 1, '2025-10-17 09:07:10', '2025-10-21 14:05:15'),
(18, 'Inso Mark Geno', 'inosmarkgeno406@gmail.com', NULL, '$2y$12$W5rJni6DJ1lXQGyjeMf26.FQO7HfbefLDqxXClQozl6qOHQsBGfSe', NULL, '219752', '2025-10-22 06:46:16', 0, '2025-10-22 06:36:16', '2025-10-22 06:36:16'),
(19, 'Inso Mark Geno', 'insomarkgeno406@gmail.com', '2025-10-22 06:37:44', '$2y$12$yzk9W/97l9TTm2PoAHNeTeHPRS9bijXxUoj2gLcZ7tSBMGO1Rwldm', NULL, NULL, NULL, 1, '2025-10-22 06:37:21', '2025-10-22 06:39:31'),
(20, 'Mark Geno', 'insomarkgeno59@gmail.com', NULL, '$2y$12$b9reG0M6SvfF/LtMzDsUx.zja5kZLeA4QAXXSkp4HQAs7DwVRD7mW', NULL, '900963', '2025-10-23 06:13:42', 0, '2025-10-23 06:03:42', '2025-10-23 06:03:42'),
(21, 'John Kenneth Grande', 'jkr.grande@gmail.com', '2025-10-25 05:17:23', '$2y$12$TOzCmLl9.CHD5BSDcDZxKeWlHnha1BL.Xi4VmRvIipa3bxgZFFfC6', NULL, NULL, NULL, 1, '2025-10-25 05:03:43', '2025-10-25 05:17:23'),
(22, 'Rjay', 'rjay@gmail.com', '2026-05-23 18:16:36', '$2y$12$nqvTa3Xga9S9pjlUP6uMa.6PslYdiQ.8I6BIiFYhhIo...', NULL, NULL, NULL, 1, NULL, '2026-05-26 09:37:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_supervisor_id_foreign` (`supervisor_id`);

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
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_intern_id_foreign` (`intern_id`),
  ADD KEY `documents_supervisor_id_foreign` (`supervisor_id`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_requests_intern_id_foreign` (`intern_id`);

--
-- Indexes for table `dtrs`
--
ALTER TABLE `dtrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_requests`
--
ALTER TABLE `grade_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_requests_intern_id_foreign` (`intern_id`);

--
-- Indexes for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grade_submissions_intern_id_foreign` (`intern_id`),
  ADD KEY `grade_submissions_supervisor_id_foreign` (`supervisor_id`);

--
-- Indexes for table `interns`
--
ALTER TABLE `interns`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `interns_email_unique` (`email`),
  ADD KEY `interns_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `interns_invited_by_user_id_foreign` (`invited_by_user_id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journals_intern_id_foreign` (`intern_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supervisors_email_unique` (`email`);

--
-- Indexes for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_logs_intern_id_foreign` (`intern_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dtrs`
--
ALTER TABLE `dtrs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_requests`
--
ALTER TABLE `grade_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `interns`
--
ALTER TABLE `interns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD CONSTRAINT `document_requests_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_requests`
--
ALTER TABLE `grade_requests`
  ADD CONSTRAINT `grade_requests_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grade_submissions`
--
ALTER TABLE `grade_submissions`
  ADD CONSTRAINT `grade_submissions_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grade_submissions_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `interns`
--
ALTER TABLE `interns`
  ADD CONSTRAINT `interns_invited_by_user_id_foreign` FOREIGN KEY (`invited_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `interns_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD CONSTRAINT `time_logs_intern_id_foreign` FOREIGN KEY (`intern_id`) REFERENCES `interns` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
