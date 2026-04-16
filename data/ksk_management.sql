CREATE DATABASE IF NOT EXISTS ksk_management;
USE ksk_management;

CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `factory_location` varchar(100) DEFAULT NULL,
  `bp` varchar(100) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `national_id` varchar(50) DEFAULT NULL,
  `res_place` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `emp_class` varchar(100) DEFAULT NULL,
  `hire_type` varchar(50) DEFAULT NULL,
  `emp_status` varchar(50) DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `promotion_date` date DEFAULT NULL,
  `re_check1` varchar(50) DEFAULT NULL,
  `re_check2` varchar(50) DEFAULT NULL,
  `remark_original` text DEFAULT NULL,
  `is_received` tinyint(1) DEFAULT 0,
  `received_date` datetime DEFAULT NULL,
  `printed_count` int(11) DEFAULT 0,
  `last_print_date` datetime DEFAULT NULL,
  `is_returned` tinyint(1) DEFAULT 0,
  `returned_date` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_no` (`emp_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;