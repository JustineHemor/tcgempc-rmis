-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2022 at 06:44 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tcgempcrmis`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comaker`
--

CREATE TABLE `tbl_comaker` (
  `comaker_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_comaker`
--

INSERT INTO `tbl_comaker` (`comaker_id`, `member_id`) VALUES
(1, 1),
(2, 28),
(3, 59),
(7, 65),
(8, 66),
(9, 67),
(10, 68),
(11, 69),
(12, 70),
(13, 71),
(14, 72),
(17, 75),
(18, 76);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `department_id` int(11) NOT NULL,
  `department` varchar(200) NOT NULL,
  `dept_acronym` varchar(200) NOT NULL,
  `dept_status` enum('activated','deactivated') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `department`, `dept_acronym`, `dept_status`) VALUES
(95, 'Department of Marketing and Sales Management', 'DMSM', 'activated'),
(96, 'Department of Human Resources Management', 'DHRM', 'activated'),
(97, 'Management Information System', 'MIS', 'activated'),
(98, 'Finance And Accounting Management', 'FAM', 'activated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan_approval`
--

CREATE TABLE `tbl_loan_approval` (
  `approval_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL,
  `approval_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_loan_approval`
--

INSERT INTO `tbl_loan_approval` (`approval_id`, `loan_id`, `manager_id`, `approval_date`) VALUES
(20, 38, 1, '2022-02-11'),
(21, 38, 69, '2022-02-11'),
(22, 39, 69, '2022-02-15'),
(23, 39, 67, '2022-02-15'),
(28, 45, 69, '2022-02-19'),
(38, 45, 67, '2022-02-19'),
(39, 47, 1, '2022-04-29'),
(40, 47, 67, '2022-04-29'),
(41, 56, 67, '2022-05-01'),
(42, 56, 1, '2022-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan_list`
--

CREATE TABLE `tbl_loan_list` (
  `loan_id` int(11) NOT NULL,
  `application_number` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_type_id` int(11) NOT NULL,
  `loan_amount` decimal(10,2) NOT NULL,
  `total_interest` decimal(10,2) NOT NULL,
  `total_payable_amount` decimal(10,2) NOT NULL,
  `monthly_payable_amount` decimal(10,2) NOT NULL,
  `total_service_fee` decimal(10,2) NOT NULL,
  `total_share_capital` decimal(10,2) NOT NULL,
  `loan_balance` decimal(10,5) NOT NULL,
  `status` enum('for approval','approved','declined','renewed','complete','cancelled') NOT NULL,
  `payment_term` varchar(255) NOT NULL,
  `comaker_id` int(11) NOT NULL,
  `comaker_confirmation` enum('pending','accepted','rejected') NOT NULL,
  `approval_date` varchar(100) NOT NULL,
  `application_date` date NOT NULL,
  `renewed` varchar(11) NOT NULL,
  `notification_1` int(11) NOT NULL,
  `check_number` varchar(255) NOT NULL,
  `renewed_to` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_loan_list`
--

INSERT INTO `tbl_loan_list` (`loan_id`, `application_number`, `member_id`, `loan_type_id`, `loan_amount`, `total_interest`, `total_payable_amount`, `monthly_payable_amount`, `total_service_fee`, `total_share_capital`, `loan_balance`, `status`, `payment_term`, `comaker_id`, `comaker_confirmation`, `approval_date`, `application_date`, `renewed`, `notification_1`, `check_number`, `renewed_to`) VALUES
(1, 2021001, 59, 2, '10000.00', '199.67', '10199.67', '3433.33', '0.00', '0.00', '0.00000', 'complete', '3 months', 2, 'accepted', '2021-09-28', '2021-09-28', '', 0, '231-231-327', ''),
(38, 2022001, 1, 1, '25000.00', '3546.95', '28546.95', '3187.50', '500.00', '500.00', '0.00299', 'complete', '10 months', 2, 'accepted', '2022-02-11', '2022-02-10', '', 0, '231-231-328', ''),
(39, 2022002, 66, 1, '20000.00', '2602.85', '22602.85', '2772.22', '400.00', '400.00', '0.00000', 'renewed', '9 months', 9, 'accepted', '2022-02-15', '2022-02-15', '', 0, '231-231-329', ''),
(45, 2022003, 28, 1, '20000.00', '2602.85', '22602.85', '2772.22', '400.00', '400.00', '3673.78919', 'approved', '9 months', 8, 'accepted', '2022-02-19', '2022-02-19', '', 0, '', ''),
(56, 2022004, 66, 1, '20000.00', '2602.85', '22602.85', '2772.22', '400.00', '400.00', '20000.00000', 'approved', '9 months', 1, 'accepted', '2022-05-01', '2022-05-01', '39', 1, '', ''),
(57, 2022005, 28, 1, '20000.00', '2602.85', '22602.85', '2772.22', '400.00', '400.00', '20000.00000', 'for approval', '9 months', 9, 'pending', '0000-00-00', '2022-05-01', '45', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_loan_type`
--

CREATE TABLE `tbl_loan_type` (
  `loan_type_id` int(11) NOT NULL,
  `loan_type` varchar(255) NOT NULL,
  `loan_interest` float NOT NULL,
  `service_fee` float NOT NULL,
  `share_capital` float NOT NULL,
  `loan_type_status` enum('activated','deactivated') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_loan_type`
--

INSERT INTO `tbl_loan_type` (`loan_type_id`, `loan_type`, `loan_interest`, `service_fee`, `share_capital`, `loan_type_status`) VALUES
(1, 'Salary Loan', 0.0275, 0.02, 0.02, 'activated'),
(2, 'Emergency Loan', 0.01, 0, 0, 'activated'),
(3, 'Business Loan', 0.0275, 0.02, 0, 'activated'),
(19, 'Educational Loan', 0.015, 0, 0, 'activated'),
(20, 'Motorcycle Loan', 0.01, 0, 0.01, 'deactivated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members_info`
--

CREATE TABLE `tbl_members_info` (
  `member_id` int(11) NOT NULL,
  `member_number` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `civil_status` enum('Single','Married','Separated','Divorced','Widowed') NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(200) NOT NULL,
  `birth_place` varchar(200) NOT NULL,
  `phone_num` varchar(100) NOT NULL,
  `position_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `other_income_source` varchar(100) NOT NULL,
  `annual_income` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `tin` varchar(100) NOT NULL,
  `spouse_name` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `beneficiary` varchar(100) NOT NULL,
  `relation` varchar(100) NOT NULL,
  `dependents_num` varchar(100) NOT NULL,
  `employment_status` enum('Active','Retired','Resigned','Terminated') NOT NULL,
  `membership_date` date NOT NULL,
  `share_capital` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_members_info`
--

INSERT INTO `tbl_members_info` (`member_id`, `member_number`, `firstname`, `lastname`, `middlename`, `gender`, `civil_status`, `birth_date`, `address`, `birth_place`, `phone_num`, `position_id`, `department_id`, `salary`, `other_income_source`, `annual_income`, `religion`, `tin`, `spouse_name`, `occupation`, `beneficiary`, `relation`, `dependents_num`, `employment_status`, `membership_date`, `share_capital`) VALUES
(1, 202101001, 'Justine', 'Hemor', 'Romero', 'male', 'Married', '1999-11-22', 'Calamba City', 'Alabang City', '09887654565', 3, 97, '35000', '-', '420000', 'Catholic', '-', 'Marielle Hemor', 'Housewife', 'Cai Hemor', 'Son', '3', 'Active', '2021-01-01', '30000.00'),
(28, 202101002, 'Miles', 'Smith', 'Doe', 'male', 'Single', '1992-07-15', 'Southwoods, Alabang', 'Southwoods, Alabang', '09272635263', 3, 97, '35000', '-', '420000', 'Roman Catholic', '-', 'Jane Doe', 'Housewife', 'Dave Smith', 'Son', '3', 'Active', '2021-01-01', '18000.00'),
(59, 202101003, 'Renniel', 'Gomez', 'Gutierrez', 'male', 'Separated', '2021-09-09', 'Batangas City', 'Batangas City', '09824758637', 14, 98, '35000', '-', '420000', 'Christian', '-', 'Angela Yu', 'Housewife', 'Leo Mord', 'Son', '2', 'Active', '2021-01-01', '18000.00'),
(65, 202101004, 'Angel Jade', 'Banario', 'Neon', 'male', 'Divorced', '2021-10-10', 'Tagaytay City', 'Tagaytay City', '09625172534', 2, 96, '30000', '-', '420000', '-', '-', '-', '-', '-', '-', '-', 'Active', '2021-01-01', '24000.00'),
(66, 202101005, 'Margielyn', 'Cuadra', 'Sarmiento', 'female', 'Married', '2021-10-20', 'Tagaytay City', 'Tagaytay City', '09876545654', 14, 98, '40000', '-', '420000', 'Roman Catholic', '-', 'Alden Richard', 'Engineer', '-', '-', '-', 'Active', '2021-01-01', '12000.00'),
(67, 202101006, 'Marielle', 'Bicog', 'Rodriguez', 'female', 'Single', '2021-10-21', 'Tagaytay City', 'Dasmariñas City', '094482726262', 14, 95, '40000', '-', '420000', 'Roman Catholic', '-', '-', '-', 'Jeffrey Bicog', 'Sibling', '1', 'Active', '2021-01-01', '12000.00'),
(68, 202101007, 'Lott', 'Lance', 'Cee', 'male', 'Single', '1999-06-16', 'Silang, Cavite', 'Silang, Cavite', '098786343554', 3, 97, '40000', '-', '420000', 'Roman Catholic', '-', '-', '-', 'Lou Yi', 'Sibling', '0', 'Active', '2021-01-09', '24000.00'),
(69, 202110008, 'Juan', 'Cruz', 'Simon', 'male', 'Single', '1992-03-11', 'Amadeo, Cavite', 'Amadeo, Cavite', '09824758232', 14, 98, '40000', '-', '420000', 'Roman Catholic', '-', '-', '-', 'Junnie Cruz', 'Sibling', '0', 'Active', '2021-10-27', '18000.00'),
(70, 202112009, 'Stephen', 'Strange', 'Vincents', 'male', '', '2021-11-09', 'New York', 'New York', '09282726232', 3, 97, '30000', '-', '400000', 'Roman Catholoc', '-', '-', '-', '-', '-', '0', 'Retired', '2021-11-09', '12000.00'),
(71, 202112010, 'Peter', 'Parkers', 'Jim', 'male', '', '2021-11-10', 'New York', 'New York', '0927362632323', 2, 96, '40000', '-', '400000', 'Roman Catholoc', '-', '-', '-', '-', '-', '0', 'Resigned', '2021-11-10', '12000.00'),
(72, 202112011, 'Anthony Edward', 'Stark', 'Collins', 'male', 'Married', '2021-12-07', 'New York', 'New York', '097746253112', 2, 96, '50000', '-', '500000', 'Roman Catholic', '-', 'Pepper Pots', 'Secretary', 'Morgan Stark', 'Daughter', '1', 'Active', '2021-12-07', '18000.00'),
(75, 202201012, 'Jhon', 'Dela Cruz', 'Tamad', 'male', 'Married', '2022-01-26', 'Calamba, Laguna, Philippines', 'Calamba, Laguna, Philippines', '097746253445', 2, 96, '35000', '-', '420000', 'Roman Catholic', '-', 'Jane Doe', 'Housewife', 'John Smith', 'Son', '1', 'Active', '2022-01-26', '12000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `payment_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `principal` decimal(10,5) NOT NULL,
  `interest` decimal(10,5) NOT NULL,
  `payment_amount` decimal(10,5) NOT NULL,
  `balance` decimal(10,5) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`payment_id`, `loan_id`, `principal`, `interest`, `payment_amount`, `balance`, `payment_date`) VALUES
(211, 1, '6900.00000', '100.00000', '7000.00000', '3100.00000', '2021-12-25'),
(212, 1, '3100.00000', '31.00000', '3131.00000', '0.00000', '2022-01-15'),
(303, 39, '2222.22000', '550.00000', '2772.22000', '17777.78000', '2022-02-15'),
(304, 39, '1811.11000', '488.89000', '2300.00000', '15966.67000', '2022-02-15'),
(349, 39, '1860.92000', '439.08000', '2300.00000', '14105.75000', '2022-02-16'),
(359, 38, '2500.00000', '687.50000', '3187.50000', '22500.00000', '2022-06-16'),
(360, 38, '2568.75000', '618.75000', '3187.50000', '19931.25000', '2021-07-16'),
(361, 38, '2639.39063', '548.10938', '3187.50000', '17291.85938', '2021-08-16'),
(362, 38, '2711.97387', '475.52613', '3187.50000', '14579.88551', '2021-09-16'),
(363, 38, '2786.55315', '400.94685', '3187.50000', '11793.33236', '2021-10-16'),
(364, 38, '2863.18336', '324.31664', '3187.50000', '8930.14900', '2021-11-16'),
(365, 38, '2941.92090', '245.57910', '3187.50000', '5988.22810', '2021-12-16'),
(366, 38, '3022.82373', '164.67627', '3187.50000', '2965.40437', '2022-01-16'),
(367, 38, '2965.40138', '81.54862', '3046.95000', '0.00299', '2022-02-16'),
(368, 39, '2384.31188', '387.90813', '2772.22000', '11721.43813', '2022-03-29'),
(369, 39, '2449.88045', '322.33955', '2772.22000', '9271.55768', '2022-04-29'),
(370, 45, '2222.22000', '550.00000', '2772.22000', '17777.78000', '2022-01-01'),
(371, 45, '2283.33105', '488.88895', '2772.22000', '15494.44895', '2022-02-01'),
(372, 45, '2346.12265', '426.09735', '2772.22000', '13148.32630', '2022-03-01'),
(373, 45, '2410.64103', '361.57897', '2772.22000', '10737.68527', '2022-04-01'),
(374, 45, '2476.93366', '295.28634', '2772.22000', '8260.75161', '2022-05-01'),
(375, 45, '4586.96242', '413.03758', '5000.00000', '3673.78919', '2022-05-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `position_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `position` varchar(200) NOT NULL,
  `monthly_salary` varchar(50) NOT NULL,
  `position_status` enum('activated','deactivated') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`position_id`, `department_id`, `position`, `monthly_salary`, `position_status`) VALUES
(2, 96, 'HR Staff', '25000', 'activated'),
(3, 97, 'IT Staff', '30000', 'activated'),
(14, 98, 'Accounting Staff', '25000', 'activated'),
(19, 97, 'Database Administrator', '40000', 'activated'),
(20, 95, 'Marketing Staff', '30000', 'deactivated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_fees`
--

CREATE TABLE `tbl_service_fees` (
  `service_fee_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `service_fee_amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_service_fees`
--

INSERT INTO `tbl_service_fees` (`service_fee_id`, `loan_id`, `service_fee_amount`, `date`) VALUES
(3, 45, '400.00', '2022-02-19'),
(5, 56, '400.00', '2022-05-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shares`
--

CREATE TABLE `tbl_shares` (
  `shares_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `remittance` decimal(10,2) NOT NULL,
  `retention` decimal(10,2) NOT NULL,
  `floatOR` decimal(10,2) NOT NULL,
  `withdrawal` decimal(10,2) NOT NULL,
  `dividend` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_shares`
--

INSERT INTO `tbl_shares` (`shares_id`, `member_id`, `remittance`, `retention`, `floatOR`, `withdrawal`, `dividend`, `date`) VALUES
(1, 1, '600.00', '0.00', '0.00', '0.00', '500.00', '2021-09-26'),
(3, 59, '500.00', '0.00', '0.00', '0.00', '0.00', '2021-09-26'),
(9, 65, '1500.00', '0.00', '0.00', '0.00', '0.00', '2021-10-04'),
(10, 66, '1600.00', '0.00', '0.00', '0.00', '0.00', '2021-10-04'),
(11, 67, '1500.00', '0.00', '0.00', '0.00', '1234.00', '2021-10-05'),
(12, 1, '500.00', '0.00', '0.00', '0.00', '0.00', '2021-10-05'),
(13, 1, '200.00', '0.00', '0.00', '0.00', '0.00', '2021-10-05'),
(14, 1, '400.00', '0.00', '0.00', '0.00', '0.00', '2021-10-05'),
(15, 59, '300.00', '0.00', '0.00', '0.00', '0.00', '2021-10-06'),
(16, 59, '1000.00', '0.00', '0.00', '0.00', '0.00', '2021-10-06'),
(17, 68, '1500.00', '0.00', '0.00', '0.00', '0.00', '2021-10-09'),
(18, 69, '500.00', '0.00', '0.00', '0.00', '0.00', '2021-10-27'),
(19, 28, '1500.00', '0.00', '0.00', '0.00', '0.00', '2021-10-30'),
(42, 1, '200.00', '0.00', '0.00', '0.00', '0.00', '2022-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_accounts`
--

CREATE TABLE `tbl_user_accounts` (
  `user_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` enum('member','secretary','manager','credit committee','system administrator') NOT NULL,
  `change_pass_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_accounts`
--

INSERT INTO `tbl_user_accounts` (`user_id`, `member_id`, `username`, `password`, `user_type`, `change_pass_date`) VALUES
(2, 1, 'adminjus', 'qwe123', 'system administrator', '2022-05-05'),
(19, 28, 'msmith', 'Sm252501', 'member', ''),
(54, 59, 'rgomez', '123qwe', 'member', ''),
(60, 65, 'ajbanario', 'ba123', 'secretary', ''),
(61, 66, 'mcuadra', 'qwe123', 'member', ''),
(62, 67, 'mbicog', 'Bi548650', 'manager', ''),
(63, 68, 'llott', 'Lo838282', 'member', ''),
(64, 69, 'jcruz', 'Cr681713', 'credit committee', ''),
(65, 70, 'sstrange', 'St518167', 'member', ''),
(66, 71, 'pparker', 'Pa278191', 'member', ''),
(67, 72, 'aestark', 'St873543', 'member', ''),
(70, 75, 'jdelacruz', 'De143898', 'member', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_comaker`
--
ALTER TABLE `tbl_comaker`
  ADD PRIMARY KEY (`comaker_id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbl_loan_approval`
--
ALTER TABLE `tbl_loan_approval`
  ADD PRIMARY KEY (`approval_id`);

--
-- Indexes for table `tbl_loan_list`
--
ALTER TABLE `tbl_loan_list`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `tbl_loan_type`
--
ALTER TABLE `tbl_loan_type`
  ADD PRIMARY KEY (`loan_type_id`);

--
-- Indexes for table `tbl_members_info`
--
ALTER TABLE `tbl_members_info`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tbl_position`
--
ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `tbl_service_fees`
--
ALTER TABLE `tbl_service_fees`
  ADD PRIMARY KEY (`service_fee_id`);

--
-- Indexes for table `tbl_shares`
--
ALTER TABLE `tbl_shares`
  ADD PRIMARY KEY (`shares_id`);

--
-- Indexes for table `tbl_user_accounts`
--
ALTER TABLE `tbl_user_accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_comaker`
--
ALTER TABLE `tbl_comaker`
  MODIFY `comaker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `tbl_loan_approval`
--
ALTER TABLE `tbl_loan_approval`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_loan_list`
--
ALTER TABLE `tbl_loan_list`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_loan_type`
--
ALTER TABLE `tbl_loan_type`
  MODIFY `loan_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_members_info`
--
ALTER TABLE `tbl_members_info`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_service_fees`
--
ALTER TABLE `tbl_service_fees`
  MODIFY `service_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_shares`
--
ALTER TABLE `tbl_shares`
  MODIFY `shares_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `tbl_user_accounts`
--
ALTER TABLE `tbl_user_accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
